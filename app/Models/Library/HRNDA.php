<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HRNDA extends Model
{
    use HasFactory;
    protected $connection = "library";
    protected $table = "hnrda_items";
}
