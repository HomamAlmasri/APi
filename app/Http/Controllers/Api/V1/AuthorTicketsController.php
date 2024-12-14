<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\Ticket\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\Ticket\StoreTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Policies\V1\TicketPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorTicketsController extends Controller
{

    protected $policyClass = TicketPolicy::class ;
    public function index($author_id,TicketFilter $filter)
    {
        return TicketResource::collection(Ticket::where('user_id', $author_id)->filter($filter)->paginate());
    }
    public function store(StoreTicketRequest $request,$author_id)

    {
        try {
            $this->isAble('store',Ticket::class);
            return new TicketResource(Ticket::create($request->mappedAttributes([
                'author' => 'user_id'
            ])));
        }catch (AuthorizationException $e){
            return $this->error('You are not a  authorized to perform this action',401);
        }
            }

    public function replace($author_id,$ticket_id, ReplaceTicketRequest $request)
    {
        try{
            $ticket = Ticket::findOrFail($ticket_id);

            if($author_id == $ticket->user_id){

            $model = [
                'title' => $request->input('data.attributes.title'),
                'description' => $request->input('data.attributes.description'),
                'status' => $request->input('data.attributes.status'),
                'user_id' => $request->input('data.relationships.author.data.id'),
            ];
            $ticket->update($model);
            return new TicketResource($ticket);
            }
            // TODO:TICKET DON'T BELONGS TO THE USER
        } catch (ModelNotFoundException $e){
            return $this->ok('User not Found', [
                'error' => 'This Ticket is not found '
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($author_id,$ticket_id)
    {
        try {
           $ticket= Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {
                $ticket->delete();
            return $this->ok('Ticket Deleted');
            }
            return $this->error("Ticket not found", 404);
        } catch (ModelNotFoundException $e){
            return $this->ok('User not Found', );
        }
    }
}
