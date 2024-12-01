<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\Ticket\StoreTicketRequest;
use App\Http\Requests\Api\V1\Ticket\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Services\ResourceFilterService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketController extends Controller
{

    public function __construct(protected ResourceFilterService $filterService){}

    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filter)
    {

        return TicketResource::collection(Ticket::Filter($filter->get()));
//        if($this->action->include('author')){
//            return TicketResource::collection(Ticket::with('user')->paginate(1));
//        }
//      return TicketResource::collection(Ticket::paginate(1));
//        return  $this->filterService->filter`
//        (
//            'index',
//            'author',
//            TicketResource::class,
//            new Ticket,
//            'user',
//        );
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreTicketRequest $request)
    {

        try{
        $user = User::findOrFail($request->input('data.relationships.author.data.id'));
        } catch (ModelNotFoundException $e){
        return $this->ok('User not Found', [
            'error' => 'This User Id is not found '
        ]);
        }
//dd($request->validated(), $model);
        return new TicketResource($request->mappedAttributes());

    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return $this->filterService->filter('show',
            'author',
            TicketResource::class,
            $ticket,
            'author');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        try{
            $ticket = Ticket::findOrFail($ticket_id);

            $ticket->update($request->mappedAttributes());
            return new TicketResource($ticket);
        } catch (ModelNotFoundException $e){
            return $this->ok('User not Found', [
                'error' => 'This Ticket is not found '
            ]);
        }
    }
    public function replace(UpdateTicketRequest $request, $ticket_id)
    {
        try{
            $ticket = Ticket::findOrFail($ticket_id);
            $ticket->update($request->mappedAttributes());
            return new TicketResource($ticket);
        } catch (ModelNotFoundException $e){
            return $this->ok('User not Found', [
                'error' => 'This Ticket is not found '
            ]);
        }
//dd($request->validated(), $model);
    }
        //

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticket_id)
    {
        try{
            Ticket::findOrFail($ticket_id)->delete();
            return $this->ok('Ticket Deleted');
        } catch (ModelNotFoundException $e){
            return $this->ok('User not Found', );
        }
    }
}
