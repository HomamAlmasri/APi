<?php
namespace App\Http\Filters\V1;

class AuthorFilter extends QueryFilter{
    protected $sortable=[
        'name','email', 'updatedAt'=>'updated_at', 'createdAt'=>'created_at'
    ];

    public function include ($value)
    {
        return $this->builder->with($value);
    }

    public function createdAt($value)
    {
        $dates = explode(',', $value);
        if(count($dates) > 1)
        {
            return $this->builder->whereBetween('created_at', $value);
        }
        return $this->builder->whereDate('created_at',$value);
    }
    public function id($value){
        return $this->builder->whereIn('id',explode(',',$value));
    }

    public function email($value)
    {
        return $this->builder->where('email','LIKE','%'.  $value . '%');
    }
    public function name($value)
    {
        return $this->builder->where('name','LIKE','%'.  $value . '%');
    }

}
