<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseRegister extends Model
{
    // Nombre de la tabla real en la base de datos
    protected $table = 'RegistrosCasos';
    // Conexión SQL Server
    protected $connection = 'sqlsrv_cilindros';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombres_apellidos',
        'ciudad',
        'contacto',
        'nombre_negocio',
        'razon_social',
        'direccion_negocio',
        'distrito',
        'acepto_politicas',
        'codigo_alfanumerico',
        'fecha_registro',
        'ip_origen',
        'dispositivo',
        'exito'
    ];
}
