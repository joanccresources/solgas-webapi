<?php

namespace App\Http\Controllers\API\v1\Setting\CookieConsent;

use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CookieConsentResource;
use App\Models\CookieConsent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CookieConsentController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(CookieConsent::class, 'cookie_consent');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $q = $request->q;
        $elements = new CookieConsent();
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('ip_address', 'LIKE', '%' . $q . '%');
                $query->orWhere('user_agent', 'LIKE', '%' . $q . '%');
            });
        }
        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending)->paginate((int) $request->per_page);
        } else {
            $elements = $elements->paginate((int) $request->per_page);
        }

        return CookieConsentResource::collection($elements);
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
     */
    public function show(CookieConsent $cookieConsent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CookieConsent $cookieConsent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CookieConsent  $cookieConsent
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CookieConsent $cookieConsent): JsonResponse
    {
        $cookieConsent->delete();

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.cookie_consent')]))
            ->build();
    }
}
