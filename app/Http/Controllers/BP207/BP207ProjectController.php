<?php

namespace App\Http\Controllers\BP207;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BP207ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $nav = activeNav('bp207_project');

        $data = [
                    "nav" => $nav
                ];

        return view('bp207.project')->with('data',$data);
    }

    public function summary()
    {
        $nav = activeNav('bp207_summary');

        $data = [
                    "nav" => $nav
                ];

        return view('bp207.summary')->with('data',$data);
    }
}
