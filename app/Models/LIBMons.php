<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LIBMons extends Model
{
    use HasFactory,SoftDeletes;

    public function scopeMons($query,$id)
    {
        return $query->where('lib_id',$id)->get();
    }

}
