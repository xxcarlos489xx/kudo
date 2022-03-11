<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Reglas;
use App\Tableros;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
                                ->select('id','titulo','usuario_id','usuario_send_id','created_at')
                                ->orderBy('created_at','desc')
                                ->get();
            foreach ($tableros as $t) {
                unset($t->autor->id);
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
        if ($reglas) {
            $tablero->rules()->sync($reglas);
        }

        DB::commit();

        return response()->json(["message"=>'Tablero guardado con éxito']);
    }
}