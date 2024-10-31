<?php

namespace App\Services\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class ApiService
{
    public function include(String $relationship ,Request $request , Model $model ):bool
    {
        $param = $request->get('include');
        if(!isset($param))
        {
            return false;
        }
        $include = explode(',' ,strtolower($param)) ;
        return in_array(strtolower($relationship),$include);
    }
}
