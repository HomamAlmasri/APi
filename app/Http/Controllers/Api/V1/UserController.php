<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Services\ResourceFilterService;

class UserController extends Controller
{
    public function __construct(Protected ResourceFilterService $action)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        if($this->action->include('tickets'))
//        {
//            return UserResource::collection(User::with('tickets')->get());
//        }
//        return  UserResource::collection(User::paginate());
      return  $this->action->filter(
        'index',
        'tickets',
      UserResource::class,
         new User,
        'tickets',
      );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
//        if($this->action->include('tickets'))
//        {
//            return UserResource::make($user->load('tickets'));
//        }
//        return new UserResource($user);
        return $this->action->filter('show', 'tickets', UserResource::class, $user, 'tickets');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
