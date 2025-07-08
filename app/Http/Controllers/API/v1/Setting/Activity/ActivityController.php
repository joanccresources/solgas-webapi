<?php

namespace App\Http\Controllers\API\v1\Setting\Activity;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ActivityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Activity::class, 'activity');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResource
    {
        $q = $request->q;
        $elements = new Activity();
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('log_name', 'LIKE', '%' . $q . '%');
                $query->orWhere('description', 'LIKE', '%' . $q . '%');
                $query->orWhere('subject_type', 'LIKE', '%' . $q . '%');
                $query->orWhere('event', 'LIKE', '%' . $q . '%');
                $query->orWhere('causer_type', 'LIKE', '%' . $q . '%');
                $query->orWhere('causer_type', 'LIKE', '%' . $q . '%');
            });
        }
        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending)->paginate((int) $request->per_page);
        } else {
            $elements = $elements->paginate((int) $request->per_page);
        }

        return ActivityResource::collection($elements);
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
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Activity $activity): JsonResource
    {
        $activity->load(['subject', 'causer']);

        return new ActivityResource($activity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
