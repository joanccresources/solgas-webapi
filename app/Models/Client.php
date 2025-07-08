<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'Clientes';
    protected $connection = 'sqlsrv_cilindros';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombres_apellidos',
        'documento_identidad',
        'telefono',
        'correo_electronico',
        'direccion',
        'ciudad',
        'acepto_politicas',
        'fecha_registro',
    ];
}
