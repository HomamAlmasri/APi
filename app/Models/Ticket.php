<?php

namespace App\Models;

use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Ticket extends Model
{

    protected $guarded=[];
    use HasFactory;
    public function user():BelongsTo
    {
        return  $this->belongsTo(User::class);
    }
    public function scopeFilter(Builder $builder, QueryFilter $filters){
        return $filters->apply($builder);
    }


    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model){
            $model->user_id = auth()->id();
        });
    }

}
