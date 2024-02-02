<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class LibraryController extends Controller
{
    public function agency()
    {
        $tbl = App\Models\Library\Agency::orderBy('acronym')->get();
        return $tbl->toJson();
    }

    public function division()
    {
        $tbl = App\Models\Library\Division::orderBy('acronym')->get();
        return $tbl->toJson();
    }

    public function pap()
    {
        $tbl = App\Models\Library\PAP::whereIn('id',[1,7])->get();
        return $tbl->toJson();
    }

    public function expense()
    {
        $tbl = App\Models\Library\Expense::get();
        return $tbl->toJson();
    }

    public function region()
    {
        $tbl = App\Models\Library\Region::get();
        return $tbl->toJson();
    }

    public function approving_authority()
    {
        $tbl = App\Models\Library\Approving_authority::get();
        return $tbl->toJson();
    }

    public function allotment()
    {
        $tbl = App\Models\Library\Allotment_class::get();
        return $tbl->toJson();
    }
}
