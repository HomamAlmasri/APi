<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Services\ResourceFilterService;

class TicketController extends Controller
{
    public function __construct(protected ResourceFilterService $filterService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        if($this->action->include('author')){
//            return TicketResource::collection(Ticket::with('user')->paginate(1));
//        }
//      return TicketResource::collection(Ticket::paginate(1));
        return  $this->filterService->filter(
            'index',
            'author',
            TicketResource::class,
            new Ticket,
            'user',
            'paginate',
            '5',
        );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $validated = $request->validated();
        $ticket =  Ticket::create($validated);
        return 'ok' ;
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
            'user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
            //
    }
}
