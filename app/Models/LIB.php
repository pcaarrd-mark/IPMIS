<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LIB extends Model
{
    use HasFactory,SoftDeletes;

    public function scopeTotalYear($query,$id)
    {
        return $query->where('project_id',$id)->groupBy('budget_yr')->get();
    }

    public function scopeProjectYear($query,$projectid,$yr)
    {
        return $query->select('id')->where('project_id',$projectid)->where('budget_yr',$yr)->first();
    }
}
