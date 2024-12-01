<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

abstract class QueryFilter{

    protected $builder;
    protected $request;
    protected $sortable = [];
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder) {
        $this->builder = $builder;
//        dd($this->request->all(),$this->request->query);
        foreach($this->request->all() as $key => $value){
            if(method_exists($this,$key))
            {
                $this->$key($value);
            }
        }
        return $builder;
    }
    protected function filter($arr)
    {

//        dd($arr);
        if($arr === null)
        {
            return $this->builder;
        }

        foreach ($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }
        return $this->builder;
    }

    protected function sort($value){
        $sortAttributes = explode(',',$value);
        foreach ($sortAttributes as $sortAttribute){
        $direction = 'asc';
            if(str_starts_with($sortAttribute, '-' )) {
                $direction='desc';

                $sortAttribute = substr($sortAttribute , 1);
            }
            if (!in_array($sortAttribute,$this->sortable)  && !array_key_exists($sortAttribute,$this->sortable)){
                continue;
            }

            $columnName = $this->sortable[$sortAttribute] ?? $sortAttribute;

            $this->builder->orderBy($columnName ,$direction);
        }
    }
}
