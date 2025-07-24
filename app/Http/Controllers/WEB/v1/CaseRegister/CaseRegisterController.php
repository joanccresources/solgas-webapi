<?php

namespace App\Http\Controllers\WEB\v1\CaseRegister;

use App\Models\CaseRegister;
use App\Http\Controllers\Controller;
use App\Http\Requests\WEB\v1\CaseRegister\StoreCaseRegisterRequest;

class CaseRegisterController extends Controller
{
    public function __invoke(StoreCaseRegisterRequest $request)
    {
        try {
            $status = $request->input('status_validacion');
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

            $case = CaseRegister::create([
                ...$request->safe()->except('q_recaptcha'),
                'fecha_registro' => now(),
                'ip_origen' => $request->input('ip_origen') ?? $request->ip(),
                'dispositivo' => $request->input('dispositivo'),
                'exito' => $exito,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Caso registrado con éxito.',
                'data' => [
                    'case_id' => $case->id
                ],
            ], 201)->header("Cache-Control", "no-store")
                ->header("X-Content-Type-Options", "nosniff");

        } catch (\Throwable $e) {
            // Podés registrar el error si querés
            \Log::error('Error registrando caso', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'No se pudo registrar el caso. Intente más tarde.',
            ], 500);
        }
    }
}
