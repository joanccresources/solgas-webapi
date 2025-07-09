<?php

namespace App\Http\Controllers\WEB\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\WEB\v1\Client\RegisterClientRequest;
use App\Models\Client;
use App\Models\Seal;
use App\Models\ValidationLog;
use Illuminate\Support\Carbon;

class ClientRegistrationController extends Controller
{
    public function __invoke(RegisterClientRequest $request)
    {
        // Validar header personalizado
        // if ($request->header('X-SOLGAS-TOKEN') !== 'solgas-public-access') {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Acceso no autorizado.',
        //     ], 401);
        // }
        $validated = $request->validated();
        $validated['fecha_registro'] = Carbon::now();

        $client = Client::create($validated);

        // Obtener código y estado desde frontend Precintos
        $code = $request->input('codigo_alfanumerico');
        $status = $request->input('status_validacion');
        $id_log = $request->input("id_log");

        if ($code && $status) {
            // Si el codigo es (original o revisado), actualizar "id_cliente" de Precintos
            // if (in_array($status, ['original', 'revisado'])) {
            if (in_array($status, ['original'])) {
                // Ubicamos el precinto por su código alfanumérico
                $seal = Seal::where('codigo_alfanumerico', $code)->first();
                // Si el precinto existe, actualizamos su id_cliente
                if ($seal) {
                    $seal->id_cliente = $client->id;
                    $seal->save();
                }
            }
            // Determinar valor del campo exito
            // original = 1, no-original = 2, revisado=3
            $statusMap = [
                'original' => 1,
                'no-original' => 2,
                'revisado' => 3,
            ];
            // Validamos que $status sea un valor valido
            if (!array_key_exists($status, $statusMap)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estado de validación inválido.',
                ], 422);
            }
            $exito = $statusMap[$status];

            //
            $data_log = [
                'codigo_alfanumerico' => $code,
                'fecha_validacion' => now(),
                'documento_identidad' => $client->documento_identidad,
                'ip_origen' => $request->input("ip_origen") ?? $request->ip(),
                'dispositivo' => $request->input('dispositivo'),
                'exito' => $exito,
            ];
            if ($id_log && $log = ValidationLog::find($id_log)) {
                $log->update($data_log);
            } else {
                ValidationLog::create($data_log);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Cliente registrado correctamente',
            'data' => [
                'client_id' => $client->id
            ],
        ])->header("Cache-Control", "no-store")
            ->header("X-Content-Type-Options", "nosniff");
    }
}
