<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;


class Kudos extends Model
{
    use Uuids;

    protected $table = 'kudos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'usuario_id',
        'tablero_id',
        'descripcion',
        'imagen',
    ];

    public function autor(){
        return $this->belongsTo(User::class,'usuario_id');
    }
}
