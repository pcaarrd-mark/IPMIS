<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SDGA extends Model
{
    use HasFactory;
    protected $connection = "library";
    protected $table = "sdgas";
}
