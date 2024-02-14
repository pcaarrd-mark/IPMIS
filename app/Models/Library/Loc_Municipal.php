<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loc_Municipal extends Model
{
    use HasFactory;
    protected $table = "location_municipality";
    protected $connection = "comlibrary";
}
