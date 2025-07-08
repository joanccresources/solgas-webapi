<?php

declare(strict_types=1);

namespace App\Http\Controllers\WEB\v1;

use App\Actions\v1\Helpers\Storage\GenerateFileAction;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Lead\LeadDistributorRequest;
use App\Http\Requests\API\v1\Lead\LeadRequest;
use App\Http\Requests\API\v1\Lead\LeadServiceStationRequest;
use App\Http\Requests\API\v1\Lead\LeadWorkWithUsRequest;
use App\Http\Requests\API\v1\Setting\CookieConsent\CookieConsentRequest;
use App\Models\CookieConsent;
use App\Models\Lead;
use App\Models\LeadDistributor;
use App\Models\LeadServiceStation;
use App\Models\LeadWorkWithUs;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    const FOLDER_PRINCIPAL = 'private' . DIRECTORY_SEPARATOR;
    const FOLDER_DOCUMENT = 'documentos' . DIRECTORY_SEPARATOR . 'work_with_us';

    /**
     * Get page content
     *
     * @param Request $request
     * @param Page $page
     * @return JsonResponse
     */

    public function createLead(LeadRequest $request): JsonResponse
    {
        $lead = new Lead();
        $lead->full_name = $request->input('full_name');
        $lead->email = $request->input('email');
        $lead->message = $request->input('message');
        $lead->save();

        return ApiResponse::createResponse()
            ->withMessage('¡Gracias por escribirnos! Te responderemos pronto.')
            ->build();
    }

    public function createLeadWorkWithUs(LeadWorkWithUsRequest $request): JsonResponse
    {
        $cv_path_file = $request->file("cv_path");
        $imageDto = GenerateFileDto::fromArray(['file' => $cv_path_file]);
        $generate = new GenerateFileAction(Storage::disk('s3'));
        $fileName = $generate->execute(
            $imageDto->file,
            self::FOLDER_PRINCIPAL . self::FOLDER_DOCUMENT
        );


        $lead = new LeadWorkWithUs();
        $lead->cv_path = $fileName;
        $lead->full_name = $request->input('full_name');
        $lead->dni = $request->input('dni');
        $lead->phone = $request->input('phone');
        $lead->address = $request->input('address');
        $lead->email = $request->input('email');
        $lead->birth_date = Carbon::createFromFormat('d-m-Y', $request->input('birth_date'));
        $lead->employment_id = $request->input('employment_id');
        $lead->save();

        return ApiResponse::createResponse()
            ->withMessage('Lead registrado correctamente')
            ->build();
    }

    public function createLeadServiceStation(LeadServiceStationRequest $request): JsonResponse
    {
        $lead = new LeadServiceStation();
        $lead->full_name = $request->input('full_name');
        $lead->company = $request->input('company');
        $lead->ruc = $request->input('ruc');
        $lead->phone = $request->input('phone');
        $lead->email = $request->input('email');
        $lead->region = $request->input('region');
        $lead->message = $request->input('message');
        $lead->save();

        return ApiResponse::createResponse()
            ->withMessage('Lead registrado correctamente')
            ->build();
    }

    public function createLeadDistributor(LeadDistributorRequest $request): JsonResponse
    {
        $lead = new LeadDistributor();
        $lead->full_name = $request->input('full_name');
        $lead->dni_or_ruc = $request->input('dni_or_ruc');
        $lead->phone_1 = $request->input('phone_1');
        $lead->phone_2 = $request->input('phone_2');
        $lead->email = $request->input('email');
        $lead->address = $request->input('address');
        $lead->code_ubigeo = $request->input('code_ubigeo');
        $lead->has_store = $request->input('has_store');
        $lead->sells_gas_cylinders = $request->input('sells_gas_cylinders');
        $lead->brands_sold = $request->input('brands_sold');
        $lead->selling_time = $request->input('selling_time');
        $lead->monthly_sales = $request->input('monthly_sales');
        $lead->accepts_data_policy = $request->input('accepts_data_policy');
        $lead->save();

        return ApiResponse::createResponse()
            ->withMessage('¡Gracias por tu interés! Pronto nos pondremos en contacto contigo.')
            ->build();
    }

    public function createCookieConsent(CookieConsentRequest $request): JsonResponse
    {
        $cookieConsent = new CookieConsent();
        $cookieConsent->ip_address = $request->ip();
        $cookieConsent->user_agent = $request->header('User-Agent');
        $cookieConsent->cookie_preferences = json_encode($request->input('cookie_preferences'));
        $cookieConsent->accepted_at = Carbon::now();
        $cookieConsent->save();

        return ApiResponse::createResponse()
            ->withMessage('Consentimiento de cookies guardado exitosamente')
            ->build();
    }
}
