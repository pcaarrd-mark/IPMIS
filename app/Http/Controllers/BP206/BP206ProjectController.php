<?php

namespace App\Http\Controllers\BP206;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BP206ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $nav = activeNav('bp206_project');

        $data = [
                    "nav" => $nav
                ];

        return view('bp206.project')->with('data',$data);
    }

    public function summary()
    {
        $nav = activeNav('bp206_summary');

        $data = [
                    "nav" => $nav
                ];

        return view('bp206.summary')->with('data',$data);
    }
}
