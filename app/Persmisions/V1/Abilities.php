<?php
namespace App\Persmisions\V1;

use App\Models\User;

final class Abilities {
    public const CreateTicket = "Ticket:create";
    public const UpdateTicket = "Ticket:update";
    public const ReplaceTicket = "Ticket:replace";
    public const DestroyTicket = "Ticket:Destroy";

    public const CreateOwnTicket = "Ticket:own:create";
    public const UpdateOwnTicket = "Ticket:own:update";
    public const ReplaceOwnTicket = "Ticket:own:replace";
    public const DestroyOwnTicket = "Ticket:own:destroy";

    public const CreateUser = "user:create";
    public const UpdateUser = "user:update";
    public const ReplaceUser = "user:replace";
    public const DestroyUser = "user:Destroy";

    public static function  getAbilities(User $user){
        if($user->is_manager){

            return [
                self::CreateTicket,
                self::UpdateTicket,
                self::ReplaceTicket,
                self::DestroyTicket,
                self::CreateUser,
                self::UpdateUser,
                self::ReplaceUser,
                self::DestroyUser,
            ];
        }else{
            return [
                self::CreateOwnTicket,
                self::UpdateOwnTicket,
                self::ReplaceOwnTicket,
                self::DestroyOwnTicket,
            ];
        }
    }
}
