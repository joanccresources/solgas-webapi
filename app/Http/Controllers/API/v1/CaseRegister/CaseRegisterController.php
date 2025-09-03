<?php
// CMS
namespace App\Http\Controllers\API\v1\CaseRegister;

use App\Models\CaseRegister;
use App\Http\Controllers\Controller;
use Exception;

class CaseRegisterController extends Controller
{
    public function __invoke()
    {
        try {
            // Traer todos los registros
            $caseRegisters = CaseRegister::all();

            // Retornar respuesta JSON
            return response()->json([
                'success' => true,
                'message' => 'Registros obtenidos exitosamente',
                'data' => $caseRegisters,
            ], 200);

        } catch (Exception $e) {
            // En caso de error, retornar mensaje y código 500
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los registros',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
