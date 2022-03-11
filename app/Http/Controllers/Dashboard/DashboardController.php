<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\TableroCreatedEvent;
use App\Http\Controllers\Controller;
use App\Kudos;
use App\Reglas;
use App\Tableros;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DashboardController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $auth = Auth::user();
        $users = User::where('id', '!=', $auth->id)->select('id','nombres')->get();
        $reglas = Reglas::select('id','name','descripcion')->get();

        return view('dashboard.index',[
            'auth'    =>  json_encode($auth),
            'users'    =>  json_encode($users),
            'reglas'    =>  json_encode($reglas)
        ]);
    }
    public function getTableros(Request $request){
        $data = $request->all();
        $all = isset($data['all']) ? true : false;
        $user = Auth::user();
        if ($all) {

            $tableros = Tableros::with(['autor:id,nombres','user_send:id,nombres'])
                                ->whereNotIn('usuario_send_id',[$user->id])
                                ->select('id','titulo','usuario_id','usuario_send_id','date_send','created_at')
                                ->orderBy('created_at','desc')
                                ->get();
            foreach ($tableros as $t) {
                unset($t->user_send->id);
                unset($t->usuario_id);
                $kudo = $t->kudos()->orderBy('created_at','desc')->first();
                $t->img = !empty($kudo) ? $kudo->imagen : null;
                $t->kudos = $t->kudos()->count();
            }
            return response()->json(array('tableros' => $tableros));
        }else{
            
            $tableros = Tableros::with(['autor:id,nombres'])
                                ->where('usuario_send_id',$user->id)
                                ->where('date_send','!=',null)
                                ->select('id','titulo','usuario_id','date_send','created_at')
                                ->orderBy('created_at','desc')
                                ->get();
            
            foreach ($tableros as $t) {
                unset($t->autor->id);
                unset($t->usuario_id);
                $kudo = $t->kudos()->orderBy('created_at','desc')->first();
                $t->img = !empty($kudo) ? $kudo->imagen : null;
                $t->kudos = $t->kudos()->count();
            }

            return response()->json(array('tableros' => $tableros));
        }
        
    }
    public function getTablero($id){
        
        $user = Auth::user();

        $tablero = Tableros::with(['autor:id,nombres','user_send:id,nombres','kudos.autor:id,nombres'])
                            ->whereId($id)
                            ->select('id','titulo','usuario_id','usuario_send_id','date_send','created_at')
                            ->first();
        if (empty($tablero)) {
            return response()->json(array('message' => 'Tablero no existe'),404);
        }
        $user_send_id = $tablero->user_send->id;
        $date_send = $tablero->date_send;

        if ($user_send_id == $user->id && is_null($date_send)) {
            return response()->json(array('message' => 'No autorizado'),401);
        }
        

        return response()->json(array('tablero' => $tablero));
        
        
    }
    public function saveKudo(Request $request){
        $messages = [
            'required'          =>  'La :attribute es requerida',
            'descripcion.min'   =>  'La :attribute debe tener como mínimo :min caracteres',
            'descripcion.max'   =>  'La :attribute debe tener como máximo :max caracteres',

       ];
        $validator = Validator::make($request->all(), [
            'imagen'        => 'required',
            'descripcion'   => 'required|min:15|max:300',
        ],$messages);

        if ($validator->fails()) {
            
            $message = count($validator->errors()) > 0 ? implode(', ',$validator->errors()->all()) : '';
            
            return response()->json([   "message" =>$message], 401);
        }
        $data = $request->all();
        $tablero = Tableros::find($data['tablero_id']);

        if (empty($tablero)) {
            return response()->json(["message"=>'Tablero no existe'],404);
        }

        DB::beginTransaction();
        $user = $request->user();

        Kudos::create([ "usuario_id"    => $user->id,
                        "tablero_id"    => $tablero->id,
                        "descripcion"   => $data['descripcion'],
                        "imagen"        => $this->processBase64One($data['imagen'], public_path('assets/kudos/'), $tablero->id)
                    ]);
        DB::commit();
        return response()->json(["message"=>'Kudo creado con éxito']);

    }

    public function eliminar($id){
        if ($id) {
            $tablero = Tableros::find($id);
            DB::beginTransaction();
            if (!empty($tablero)) {
                if ($tablero->delete()) {
                    DB::commit();
                    return response()->json(["message"=>'Tablero eliminado con éxito']);
                }            
            }else{
                return response()->json(["message"=>'Tablero no encontrado'],401);
            }
        }
        
        
    }

    public function saveTablero(Request $request){
        
        
        $messages = [
            'usuario.required'  => 'El :attribute es requerido',
            'descripcion.required'  =>  'La :attribute es requerida',
            'descripcion.min'       =>  'La :attribute debe tener como mínimo :min caracteres',
            'descripcion.max'       =>  'La :attribute debe tener como máximo :max caracteres',

       ];
        $validator = Validator::make($request->all(), [
            'usuario' => 'required',
            'descripcion' => 'required|min:15|max:50',
        ],$messages);

        if ($validator->fails()) {
            
            $message = count($validator->errors()) > 0 ? implode(', ',$validator->errors()->all()) : '';
            
            return response()->json([   "message" =>$message], 401);
        }
        $data = $request->all();
        $user = $request->user();

        $reglas = isset($data['rules']) ? json_decode($data['rules']) : null;

        DB::beginTransaction();
        $tablero = Tableros::create([   "titulo"            => $data['descripcion'],
                                        "slug"              => Str::slug($data['descripcion']),
                                        "usuario_id"        => $user->id,
                                        "usuario_send_id"   => $data['usuario'],
                                    ]);
        event(new TableroCreatedEvent($user,$tablero));
        if ($reglas) {
            $tablero->rules()->sync($reglas);
        }

        DB::commit();

        return response()->json(["message"=>'Tablero guardado con éxito']);
    }

    public function enviar($id){
        if ($id) {
            DB::beginTransaction();

            $tablero = Tableros::find($id);
            $tablero->date_send = date('Y-m-d');

            
            $reglas = $tablero->rules()->pluck('cod')->toArray();

            if (in_array('HB',$reglas)) {

                $date_nac = strtotime($tablero->user_send->fecha_nacimiento);
                $date_nac = date('m-d',$date_nac);
                $date_now = date('m-d');
                
                if ($date_nac > $date_now) {
                    $dt = Carbon::createFromDate(($tablero->user_send->fecha_nacimiento));
                    $fecha_format = $dt->day." de ".ucfirst($dt->localeMonth);
                    return response()->json(["message"=>'Este tablero solo puede ser enviado el día de cumpleaños '.$fecha_format],401);
                }
            }
            
            if (!empty($tablero)) {
                if ($tablero->save()) {
                    DB::commit();
                    return response()->json(["message"=>'Tablero enviado con éxito']);
                }            
            }else{
                return response()->json(["message"=>'Tablero no encontrado'],401);
            }
        }
        
        
    }
}