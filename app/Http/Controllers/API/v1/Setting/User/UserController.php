<?php

namespace App\Http\Controllers\API\v1\Setting\User;

use App\DTOs\v1\Setting\User\CreateUserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Setting\User\UserRequest;
use App\Models\User;
use App\Actions\v1\Setting\User\CreateUserAction;
use App\Actions\v1\Setting\User\UpdateUserAction;
use App\Actions\v1\Profile\UpdatePasswordAction;
use App\Actions\v1\Profile\UpdateImageAction;
use App\Actions\v1\Profile\UpdatePersonalInformationAction;
use App\DTOs\v1\Setting\User\UpdateUserDto;
use App\DTOs\v1\Profile\UpdatePasswordDto;
use App\DTOs\v1\Profile\UpdateImageDto;
use App\DTOs\v1\Profile\UpdatePersonalInformationDto;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Requests\API\v1\Profile\UpdatePasswordRequest;
use App\Http\Requests\API\v1\Profile\UpdateImageRequest;
use App\Http\Requests\API\v1\Profile\UpdatePersonalInformationRequest;
use App\Http\Resources\v1\UserResource;
use App\Traits\ModulesTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use ModulesTrait;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(): JsonResponse
    {
        //$notifications = DatabaseNotification::where('notifiable_id', auth()->user()->id)->where('created_at', '>', Carbon::now()->subDays(7))->orderBy('created_at', 'DESC')->get();
        $user = auth()->user();
        $notifications = DatabaseNotification::where('notifiable_id', $user->id)->where('created_at', '>', Carbon::now()->subDays(7))->orderBy('created_at', 'DESC')->get();

        $user->notifications = $notifications;

        return ApiResponse::createResponse()
            ->withData(new UserResource($user))
            ->build();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page =  $request->per_page ?  $request->per_page : 10;
        $q = $request->q;
        $elements = User::where('id', '<>', auth()->user()->id);
        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
                $query->orWhere('email', 'LIKE', '%' . $q . '%');
                $query->orWhereHas('roles', function ($query) use ($q) {
                    $query->where('name', 'LIKE', '%' . $q . '%');
                });
            });
        }

        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending ? $request->descending : 'ASC')->paginate((int) $per_page);
        } else {
            $elements = $elements->paginate((int) $per_page);
        }
        return UserResource::collection($elements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Setting\User\UserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $dto = CreateUserDto::fromRequest($request);

        $element = new CreateUserAction(new User(), Storage::disk('s3'));

        return $element->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Setting\User\UserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $dto = UpdateUserDto::fromRequest($request);
        if (!$request->hasFile('image')) {
            $dto->image = null;
        }

        $action = new UpdateUserAction($user, Storage::disk('s3'));

        return $action->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $image = $user->image;
        $delete = $user->delete();

        if ($delete) {
            Storage::disk('s3')->delete('private/' . '/images/users/' . $image);
        }

        return ApiResponse::createResponse()
            ->withMessage(trans('custom.message.delete.success', ['name' => trans('custom.attribute.user')]))
            ->build();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Profile\UpdatePersonalInformationRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profileUserPersonalInformationUpdate(UpdatePersonalInformationRequest $request): JsonResponse
    {
        $dto = UpdatePersonalInformationDto::fromRequest($request);
        $action = new UpdatePersonalInformationAction(auth()->user());
        return $action->execute($dto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Profile\UpdatePasswordRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profileUserPasswordUpdate(UpdatePasswordRequest $request): JsonResponse
    {
        $dto = UpdatePasswordDto::fromRequest($request);
        $action = new UpdatePasswordAction(auth()->user());
        return $action->execute($dto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\v1\Profile\UpdateImageRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profileImageUpdate(UpdateImageRequest $request): JsonResponse
    {
        $dto = UpdateImageDto::fromRequest($request);
        if (!$request->hasFile('image')) {
            $dto->image = null;
        }
        $action = new UpdateImageAction(auth()->user(), Storage::disk('s3'));
        return $action->execute($dto);
    }

    public function markAsRead($notifications): JsonResponse
    {
        $update = auth()->user()->unreadNotifications->where('id', $notifications)->first();
        $update->markAsRead();

        return ApiResponse::createResponse()
            ->withData($update)
            ->withMessage('Actualizado correctamente')
            ->build();
    }
}
