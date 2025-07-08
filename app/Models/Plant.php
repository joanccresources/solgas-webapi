<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $table = 'Plantas';
    protected $connection = 'sqlsrv_cilindros'; // o el nombre de conexión que uses
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre_planta',
        'fecha_creacion',
    ];
    // Relación con Precintos
    public function seals()
    {
        return $this->hasMany(Seal::class, 'id_planta');
    }
}
