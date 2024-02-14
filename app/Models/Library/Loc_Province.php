<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loc_Province extends Model
{
    use HasFactory;
    protected $table = "location_province";
    protected $connection = "comlibrary";
}
