<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Tableros extends Model
{
    use Uuids;

    protected $table = 'tableros';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'titulo',
        'slug',
        'usuario_id',
        'usuario_send_id',
        'descripcion',
        'date_send',
    ];

    public function autor(){
        return $this->belongsTo(User::class,'usuario_id');
    }

    public function user_send(){
        return $this->belongsTo(User::class,'usuario_send_id');
    }

    public function kudos(){
        return $this->hasMany(Kudos::class,'tablero_id');
    }

    public function rules(){
        return $this->belongsToMany(Reglas::class, 'tablero_reglas', 'tablero_id', 'regla_id');
    }

}
