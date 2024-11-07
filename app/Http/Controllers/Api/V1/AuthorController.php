<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\AuthorFilter;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Filters\V1\UserFilter;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\TicketResource;
use App\Http\Resources\V1\UserResource;
use App\Models\Ticket;
use App\Models\User;
use App\Services\ResourceFilterService;
use function Symfony\Component\String\s;

class AuthorController extends Controller
{
    public function __construct(Protected ResourceFilterService $action)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(AuthorFilter $filter)
    {
        return UserResource::collection(User::filter($filter)->paginate());
//        if($this->action->include('tickets'))
//        {
//            return UserResource::collection(User::with('tickets')->get());
//        }
//        return  UserResource::collection(User::paginate());
//      return  $this->action->filter(
//        'index',
//        'tickets',
//      UserResource::class,
//         new User,
//        'tickets',
//      );
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
        public function show(User $author , AuthorFilter $filter)
    {

            $filteredTicket = User::filter($filter)->find($author->id);
            return UserResource::make($filteredTicket);
//        if($this->action->include('tickets'))
//        {
//            return UserResource::make($user->load('tickets'));
//        }
//        return new UserResource($user);
//        return $this->action->filter('show', 'tickets', UserResource::class, $author, 'tickets');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $author)
    {
        //
    }
    public function authorTickets($author_id,TicketFilter $filter)
    {
        return TicketResource::collection(Ticket::where('user_id', $author_id)->filter($filter)->paginate());
    }
}
