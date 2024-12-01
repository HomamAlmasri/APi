<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\Ticket\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\Ticket\StoreTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorTicketsController extends Controller
{
    public function index($author_id,TicketFilter $filter)
    {
        return TicketResource::collection(Ticket::where('user_id', $author_id)->filter($filter)->paginate());
    }
    public function store($author_id, StoreTicketRequest $request)
    {
        $model = [
            'title'          => $request->input('data.attributes.title'),
            'description'    => $request->input('data.attributes.description'),
            'status'         => $request->input('data.attributes.status'),
            'user_id'        => $author_id,
        ];
//dd($request->validated(), $model);
        return new TicketResource(Ticket::create($model));

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
