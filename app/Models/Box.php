<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $table = 'Cajas';
    protected $connection = 'sqlsrv_cilindros';
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'codigo_de_barras_caja',
        'fecha_activacion',
        'flag_activacion',
        'registrador',
    ];

    // Relación con Precintos
    public function seals()
    {
        return $this->hasMany(Seal::class, 'id_caja');
    }
}
