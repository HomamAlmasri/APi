<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\Ticket\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\Ticket\StoreTicketRequest;
use App\Http\Requests\Api\V1\Ticket\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\V1\TicketPolicy;
use App\Services\ResourceFilterService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use function Pest\Laravel\get;

class TicketController extends Controller
{

    protected $policyClass = TicketPolicy::class;

//    public function __construct(protected ResourceFilterService $filterService){}

    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filter)
    {
        return TicketResource::collection(Ticket::Filter($filter)->where('user_id',12)->get());
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
        try {
            $this->isAble('store',Ticket::class);
        }catch (AuthorizationException $e){
            return $this->error('You are not a  authorized to perform this action',401);
        }
        return new TicketResource(Ticket::create($request->mappedAttributes()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
//        dd(Auth::user()->id);
       return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, $ticket_id)
    {

        try{
            $ticket = Ticket::findOrFail($ticket_id);
            //policy
            if($this->isAble('update',$ticket)){
                $ticket->update($request->mappedAttributes());
                return new TicketResource($ticket);
            }
            return $this->error('You are not a  authorized to perform this action',401);
        }
        catch (ModelNotFoundException $e){
            return $this->error('Ticket Not Found',401);
        }

    }
    public function replace(ReplaceTicketRequest $request, $ticket_id)
    {
        try{
            $ticket = Ticket::findOrFail($ticket_id);
            $this->isAble('replace', $ticket);
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
            $ticket = Ticket::findOrFail($ticket_id);
            $this->isAble('destroy',$ticket);
            $ticket->delete();
            return $this->ok('Ticket Deleted');
        } catch (ModelNotFoundException $e){
            return $this->ok('Ticket not Found', );
        }
    }
}
