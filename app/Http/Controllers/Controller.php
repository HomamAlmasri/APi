<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use ApiResponses, AuthorizesRequests;

    protected $policyClass;
    public function isAble($ability,$targetModel){
        try {
          $this->authorize($ability,[$targetModel, $this->policyClass]);
          return true;
        }catch (AuthorizationException $ex){
            return false ;
        }
    }
}
