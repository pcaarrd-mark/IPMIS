<?php

namespace App\Models\OSEP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class View_OSEPByDivisionProgram extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "view_osep_project_by_division";
}
