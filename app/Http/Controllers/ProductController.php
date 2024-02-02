<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function json($barcode)
    {
        $product = App\Models\Product::where('product_barcode',$barcode)->first()->toJson();
        return $product;
    }
}
