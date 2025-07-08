<?php

namespace App\Http\Controllers\API\v1\Setting\GeneralInformation;

use App\Actions\v1\Setting\GeneralInformation\UpdateGeneralInformationAction;
use App\Actions\v1\Setting\GeneralInformation\UpdateGeneralInformationCookieAction;
use App\Actions\v1\Setting\GeneralInformation\UpdateGeneralInformationRecaptchaAction;
use App\Actions\v1\Setting\GeneralInformation\UpdateGeneralInformationTagManagerAction;
use App\Actions\v1\Setting\GeneralInformation\UpdateGeneralInformationTokenMapAction;
use App\DTOs\v1\Setting\GeneralInformation\UpdateGeneralInformationCookieDto;
use App\DTOs\v1\Setting\GeneralInformation\UpdateGeneralInformationDto;
use App\DTOs\v1\Setting\GeneralInformation\UpdateGeneralInformationRecaptchaDto;
use App\DTOs\v1\Setting\GeneralInformation\UpdateGeneralInformationTagManagerDto;
use App\DTOs\v1\Setting\GeneralInformation\UpdateGeneralInformationTokenMapDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationCookieRequest;
use App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationRecaptchaRequest;
use App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationRequest;
use App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationTagManagerRequest;
use App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationTokenMapRequest;
use App\Http\Resources\v1\GeneralInformationResource;
use App\Models\GeneralInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GeneralInformationController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(GeneralInformation::class, 'general_information');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(): JsonResource
    {
        $elements =  GeneralInformation::orderBy('created_at', 'ASC')->first();

        return new GeneralInformationResource($elements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GeneralInformation  $generalInformation
     * @return \Illuminate\Http\Response
     */
    public function show(GeneralInformation $generalInformation)
    {
        return new GeneralInformationResource($generalInformation);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationRequest  $request
     * @param  \App\Models\GeneralInformation  $generalInformation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GeneralInformationRequest $request, GeneralInformation $generalInformation): JsonResponse
    {
        $dto = UpdateGeneralInformationDto::fromRequest($request);

        if (!$request->hasFile('logo_principal')) {
            $dto->logo_principal = null;
        }
        if (!$request->hasFile('logo_footer')) {
            $dto->logo_footer = null;
        }
        if (!$request->hasFile('logo_icon')) {
            $dto->logo_icon = null;
        }
        if (!$request->hasFile('logo_email')) {
            $dto->logo_email = null;
        }

        $action = new UpdateGeneralInformationAction($generalInformation, Storage::disk('s3'));

        return $action->execute($dto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationRecaptchaRequest  $request
     * @param  \App\Models\GeneralInformation  $generalInformation
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRecaptcha(GeneralInformationRecaptchaRequest $request, GeneralInformation $generalInformation): JsonResponse
    {
        $this->authorize('update', $generalInformation);

        $dto = UpdateGeneralInformationRecaptchaDto::fromRequest($request);

        $action = new UpdateGeneralInformationRecaptchaAction($generalInformation);

        return $action->execute($dto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationTagManagerRequest  $request
     * @param  \App\Models\GeneralInformation  $generalInformation
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTagManager(GeneralInformationTagManagerRequest $request, GeneralInformation $generalInformation): JsonResponse
    {
        $this->authorize('update', $generalInformation);

        $dto = UpdateGeneralInformationTagManagerDto::fromRequest($request);

        $action = new UpdateGeneralInformationTagManagerAction($generalInformation);

        return $action->execute($dto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationTokenMapRequest  $request
     * @param  \App\Models\GeneralInformation  $generalInformation
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTokenMap(GeneralInformationTokenMapRequest $request, GeneralInformation $generalInformation): JsonResponse
    {
        $this->authorize('update', $generalInformation);

        $dto = UpdateGeneralInformationTokenMapDto::fromRequest($request);

        $action = new UpdateGeneralInformationTokenMapAction($generalInformation);

        return $action->execute($dto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationCookieRequest  $request
     * @param  \App\Models\GeneralInformation  $generalInformation
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCookie(GeneralInformationCookieRequest $request, GeneralInformation $generalInformation): JsonResponse
    {
        $this->authorize('update', $generalInformation);

        $dto = UpdateGeneralInformationCookieDto::fromRequest($request);

        if (!$request->hasFile('more_information_cookie')) {
            $dto->more_information_cookie = null;
        }

        $action = new UpdateGeneralInformationCookieAction($generalInformation, Storage::disk('s3'));

        return $action->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GeneralInformation $generalInformation)
    {
        //
    }
}
