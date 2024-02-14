<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;
    protected $connection = "library";

    public function scopeGetDetails($query,$id)
    {
        $lib = $query->where('id',$id)->first();
        return $lib->desc." (".$lib->acronym.")";
    }

    public function scopeGetDetailsAcro($query,$id)
    {
        $lib = $query->where('id',$id)->first();
        return $lib['acronym'];
    }
}
