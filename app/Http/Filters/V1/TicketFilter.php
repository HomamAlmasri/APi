<?php

namespace App\Http\Filters\V1;

class TicketFilter extends QueryFilter
{
    protected $sortable=[
      'title',
      'createdAt'=>'created_at'
    ];
    public function include($value)
    {
        return $this->builder->with($value);
    }
    public function status($value)
    {
        return $this->builder->whereIn('status',explode(',',$value));
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
    public function userId($value)
    {
        return $this->builder->where('user_id',$value);
    }

}
