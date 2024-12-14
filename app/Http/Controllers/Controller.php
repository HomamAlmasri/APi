<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use ApiResponses, AuthorizesRequests;

    protected $policyClass;
    public function isAble($ability,$targetModel){
        return $this->authorize($ability,[$targetModel, $this->policyClass]);
    }
}
