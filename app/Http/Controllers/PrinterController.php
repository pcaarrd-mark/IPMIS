<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;

class PrinterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
    }
}
