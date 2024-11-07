<?php
namespace App\Http\Filters\V1;

class UserFilter extends QueryFilter{


    public function include ($value)
    {
        return $this->builder->with($value);
    }

}
