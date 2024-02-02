<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allotment_class extends Model
{
    use HasFactory;
    
    protected $connection = "fms";
    protected $table = "library_allotment_class";
}
