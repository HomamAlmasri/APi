<?php

namespace App\Services;


use Illuminate\Database\Eloquent\Model;

class ResourceFilterService
{
    public function include(String $relationship  ) : bool
    {
            $param = request()->get('include');
        if(!isset($param))
        {
            return false;
        }
        $include = explode(',' ,strtolower($param)) ;
        return in_array(strtolower($relationship),$include);
    }
    public function filter(String $functionType , $param, $resource , Model $model , $relationship , $fetching = 'get' ,$key = Null)
    {
//        dd($key == Null ? $fetching.'()' : $fetching.'('.$key.')');
        // Check if the specified relationship exists on the model
        if (!method_exists($model, $relationship)) {
            return response()->json([
                'error' => "Relationship '$relationship' not found on " . get_class($model),
            ], 404);
        }
        if($this->include($param)) {
            if ($functionType == 'index') {
                    return $resource::collection($model::with($relationship)->$key ? $fetching.'()' : $fetching.'('.$key.')');
            }
            return $resource::make($model->load($relationship));
        }
        else
        {
            if ($functionType == 'index')
            {
                return $resource::collection($model::get());
            }
            return $resource::make($model);
        }
    }
}
