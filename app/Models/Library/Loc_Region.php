<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loc_Region extends Model
{
    use HasFactory;
    protected $table = "location_region";
    protected $connection = "comlibrary";
}
