<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PAP extends Model
{
    use HasFactory;
    protected $connection = "fms";
    protected $table = "library_pap";
}
