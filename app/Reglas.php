<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Reglas extends Model
{
    use Uuids;

    protected $table = 'reglas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $incrementing = false;
}
