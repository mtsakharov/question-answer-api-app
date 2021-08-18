<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|object
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return response()
            ->json(UserResource::collection($users))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return JsonResponse|Response|object
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        return response()
            ->json(new UserResource($user))
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return JsonResponse|object
     */
    public function show(User $user)
    {
        return response()
            ->json(new UserResource($user))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return JsonResponse|object
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user = $user->update($request->all());
        return response()
            ->json(new UserResource($user))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return JsonResponse|object
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()
            ->json('User successfully deleted')
            ->setStatusCode(Response::HTTP_OK);
    }
}
