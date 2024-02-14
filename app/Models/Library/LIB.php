<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LIB extends Model
{
    use HasFactory;
    protected $table = "library_object_expenditure";
    protected $connection = "comlibrary";

    public function scopeGetDetail($query,$id)
    {
        $lib = $query->where('id',$id)->first();
        return $lib['object_expenditure'];
    }
}
