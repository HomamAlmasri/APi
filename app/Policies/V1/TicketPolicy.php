<?php

namespace App\Policies\V1;

use App\Models\Ticket;
use App\Models\User;
use App\Persmisions\V1\Abilities;

class TicketPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function store(User $user){
        return $user->tokenCan(Abilities::CreateTicket) ||
               $user->tokenCan(Abilities::CreateOwnTicket);
    }
    public function update(User $user, Ticket $ticket){
        if($user->tokenCan(Abilities::UpdateTicket))
        {
            return true;
        }elseif ($user->tokenCan(Abilities::UpdateOwnTicket)){
        return $user->id === $ticket->user_id;
        }
        return false;
    }

    public function replace(User $user, Ticket $ticket){
        if($user->tokenCan(Abilities::UpdateTicket))
        {
            return true;
        }elseif ($user->tokenCan(Abilities::UpdateOwnTicket)){
            return $user->id === $ticket->user_id;
        }
        return false;

    }

    public function destroy(User $user, Ticket $ticket){

        if($user->tokenCan(Abilities::DestroyTicket))
        {
            return true;
        }elseif ($user->tokenCan(Abilities::DestroyOwnTicket)){
            return $user->id === $ticket->user_id;
        }
        return false;    }

}

