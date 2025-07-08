<?php

namespace App\Http\Controllers\API\v1\Dashboard;

use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Dashboard\FilterDataDashboardRequest;
use App\Models\Lead;
use App\Models\LeadDistributor;
use App\Models\LeadServiceStation;
use App\Models\LeadWorkWithUs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $end_range_date_card = Carbon::now();
        $start_range_date_card = Carbon::now()->subMonth()->subDay();

        //range dates card
        $data_range = array(
            'end' => $end_range_date_card->format('d-m-Y'),
            'start' =>  $start_range_date_card->format('d-m-Y'),
        );

        /************************************************************************************** */
        $start_date_filter = Carbon::now()->subMonth()->subDay();
        $end_date_filter = Carbon::now();

        //Inicio Data Cards
        $data_card = $this->getDataCard($start_date_filter, $end_date_filter);
        //Fin Data Card

        /***************************************************************************************** */


        /********************************************************************************************** */
        //COLUMN
        $data_column_1 = $this->getGraphColumn1();
        //FIN COLUMN

        /************************************************************************************************ */

        $data_retornar = [
            'data_range' => $data_range,
            'data_card' => $data_card,

            'data_column_1' => $data_column_1,
        ];

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataFilterCards(FilterDataDashboardRequest $request): JsonResponse
    {
        $end = Carbon::createFromFormat('d-m-Y', $request->end);
        $start = Carbon::createFromFormat('d-m-Y', $request->start)->subDay();

        $data_card = $this->getDataCard($start, $end);

        $data_retornar = [
            'data_card' => $data_card,
        ];

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @return array
     */
    public function getDataCard($start_date, $end_date)
    {
        $contacts = Lead::whereBetween('created_at', [$start_date, $end_date])->count();
        $distributors = LeadDistributor::whereBetween('created_at', [$start_date, $end_date])->count();
        $service_stations = LeadServiceStation::whereBetween('created_at', [$start_date, $end_date])->count();
        //$works = LeadWorkWithUs::whereBetween('created_at', [$start_date, $end_date])->count();

        $data_card = array(
            'total_contacts' => $contacts,
            'total_distributors' => $distributors,
            'total_service_stations' => $service_stations,
            'total_works' => 0,
        );

        return $data_card;
    }

    /**
     * Obtiene los datos para el gráfico de los últimos 7 días
     * @return array
     */
    public function getGraphColumn1()
    {
        // Obtener fechas y días de los últimos 7 días
        $lastSevenDaysDates = collect();
        $lastSevenDaysNames = collect();

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays($i);
            $lastSevenDaysDates->push($date->toDateString()); // Formato YYYY-MM-DD
            $lastSevenDaysNames->push($date->isoFormat('dddd')); // Nombre del día
        }

        $lastSevenDaysDates = $lastSevenDaysDates->reverse()->values();
        $lastSevenDaysNames = $lastSevenDaysNames->reverse()->values();

        // Obtener datos de diferentes tipos de Leads en los últimos 7 días
        $contacts = Lead::select('created_at')->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])->get();
        $distributors = LeadDistributor::select('created_at')->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])->get();
        $service_stations = LeadServiceStation::select('created_at')->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])->get();
        //$works = LeadWorkWithUs::select('created_at')->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])->get();

        // Recursos para construir las series
        $resources = [
            ['id' => 0, 'name' => 'Contactos'],
            ['id' => 1, 'name' => 'Distribuidores'],
            ['id' => 2, 'name' => 'Estación de servicio'],/*
            ['id' => 3, 'name' => 'Trabaja con nosotros'], */
        ];

        $seriesData = collect();

        foreach ($resources as $resource) {
            $dailyData = $lastSevenDaysDates->map(function ($date) use ($resource, $contacts, $distributors, $service_stations) {
                $count = 0;

                if ($resource['name'] === 'Contactos') {
                    $count = $contacts->where('created_at', '>=', $date . ' 00:00:00')
                        ->where('created_at', '<=', $date . ' 23:59:59')
                        ->count();
                } elseif ($resource['name'] === 'Distribuidores') {
                    $count = $distributors->where('created_at', '>=', $date . ' 00:00:00')
                        ->where('created_at', '<=', $date . ' 23:59:59')
                        ->count();
                } elseif ($resource['name'] === 'Estación de servicio') {
                    $count = $service_stations->where('created_at', '>=', $date . ' 00:00:00')
                        ->where('created_at', '<=', $date . ' 23:59:59')
                        ->count();
                } /* elseif ($resource['name'] === 'Trabaja con nosotros') {
                    $count = $works->where('created_at', '>=', $date . ' 00:00:00')
                        ->where('created_at', '<=', $date . ' 23:59:59')
                        ->count();
                } */

                return $count;
            });

            $seriesData->push([
                'name' => $resource['name'],
                'data' => $dailyData->values(),
            ]);
        }

        // Datos a retornar
        return [
            'array_dates_back' => $lastSevenDaysDates,
            'array_days_back' => $lastSevenDaysNames,
            'series' => $seriesData,
        ];
    }
}
