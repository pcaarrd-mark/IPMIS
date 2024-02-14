<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LIBYear extends Model
{
    protected $table = 'l_i_b_years';
    use HasFactory;

    public function scopeTotalYear($query,$id)
    {
        return $query->where('project_id',$id)->get();
    }

    public function scopeTotalMons($query,$projid,$yr)
    {
        return $query->where('project_id',$projid)->where('yr',$yr)->get();
    }
}
