<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidationLog extends Model
{
    protected $connection = 'sqlsrv_cilindros';
    protected $table = 'Validaciones';
    public $timestamps = false;
    protected $primaryKey = 'id';

    // Campos permitidos para inserción
    protected $fillable = [
        'codigo_alfanumerico',
        'fecha_validacion',
        'documento_identidad',
        'ip_origen',
        'dispositivo',
        'exito',
    ];
}
