<?php

namespace App\Http\Controllers\WEB\v1\Seal;

use App\Http\Controllers\Controller;
use App\Http\Requests\WEB\v1\Seal\VerifySealRequest;
use App\Models\Seal;
use App\Models\ValidationLog;
use Illuminate\Support\Carbon;

class SealVerificationController extends Controller
{
    public function __invoke(VerifySealRequest $request)
    {
        // Validar header personalizado
        // if ($request->header('X-SOLGAS-TOKEN') !== 'solgas-public-access') {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Acceso no autorizado.',
        //     ], 401);
        // }
        $code = $request->validated()['code'];
        // Carga con relaciones necesarias
        // $seal = Seal::where('codigo_alfanumerico', $code)->first();
        $seal = Seal::with(["plant", "box"])
            ->where("codigo_alfanumerico", $code)
            ->first();

        if (!$seal) {
            //
            $log = ValidationLog::create([
                'codigo_alfanumerico' => $code,
                'fecha_validacion' => now(),
                'documento_identidad' => null,
                'ip_origen' => $request->input("ip_origen") ?? $request->ip(),
                'dispositivo' => $request->input('dispositivo'), // opcional desde el frontend
                'exito' => 2,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'El código no pertenece a un precinto válido.',
                'data' => [
                    'codigo_alfanumerico' => $code,
                    'status' => 'no-original',
                    'id_log' => $log->id,
                ]
            ]);
        }

        //
        $nombre_planta = optional($seal->plant)->nombre_planta;
        $fecha_envasado = optional($seal->box)->fecha_activacion;

        if ((int) $seal->flag_validacion === 0) {
            // Si el precinto no ha sido validado, se actualiza el estado
            $seal->flag_validacion = 1;
            $seal->fecha_validacion = Carbon::now();
            $seal->save();

            // Creamos un registro para Insertar en Validaciones
            $log = ValidationLog::create([
                'codigo_alfanumerico' => $code,
                'fecha_validacion' => now(),
                'documento_identidad' => null,
                'ip_origen' => $request->input("ip_origen") ?? $request->ip(),
                'dispositivo' => $request->input('dispositivo'), // opcional desde el frontend
                'exito' => 1,
            ]);

            // Retorna el estado como original
            return response()->json([
                'success' => true,
                'message' => 'Precinto válido y registrado',
                'data' => [
                    'codigo_alfanumerico' => $seal->codigo_alfanumerico,
                    'status' => 'original',
                    'nombre_planta' => $nombre_planta,
                    'fecha_envasado' => $fecha_envasado,
                    'id_log' => $log->id,
                ]
            ]);
        }


        // Creamos un registro para Insertar en Validaciones
        $log = ValidationLog::create([
            'codigo_alfanumerico' => $code,
            'fecha_validacion' => now(),
            'documento_identidad' => null,
            'ip_origen' => $request->input("ip_origen") ?? $request->ip(),
            'dispositivo' => $request->input('dispositivo'), // opcional desde el frontend
            'exito' => 3,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Precinto ya fue revisado previamente',
            'data' => [
                'codigo_alfanumerico' => $seal->codigo_alfanumerico,
                'status' => 'revisado',
                'nombre_planta' => $nombre_planta,
                'fecha_envasado' => $fecha_envasado,
                'id_log' => $log->id,
            ]
        ]);
    }
}
