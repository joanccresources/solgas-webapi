<?php
// CMS
namespace App\Http\Controllers\API\v1\Client;

use App\Models\Client;
use App\Http\Controllers\Controller;
use Exception;

class ClientRegistrationController extends Controller
{
    public function __invoke()
    {
        try {
            // Traer todos los registros
            $clients = Client::all();

            // Retornar respuesta JSON
            return response()->json([
                'success' => true,
                'message' => 'Registros obtenidos exitosamente',
                'data' => $clients,
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
