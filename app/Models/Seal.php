<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seal extends Model
{
    protected $table = 'Precintos';
    protected $connection = 'sqlsrv_cilindros';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'codigo_alfanumerico',
        'id_caja',
        'id_planta',
        'id_tipo_precinto',
        'id_tipo_cilindro',
        'fecha_envasado',
        'flag_validacion',
        'fecha_validacion',
        'dni_persona',
        'fecha_creacion_codigo_alfanumerico',
    ];

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'id_planta');
    }

    public function box()
    {
        return $this->belongsTo(Box::class, 'id_caja');
    }
}
