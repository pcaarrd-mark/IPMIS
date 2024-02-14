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

    public function program()
    {
        $tbl = App\Models\Library\OSEPProgram::get();
        return $tbl->toJson();
    }

    public function hnrda()
    {
        $tbl = App\Models\Library\HRNDA::get();
        return $tbl->toJson();
    }

    public function sdga()
    {
        $tbl = App\Models\Library\SDGA::get();
        return $tbl->toJson();
    }

    public function locregion()
    {
        $tbl = App\Models\Library\Loc_Region::get();
        return $tbl->toJson();
    }

    public function locprovince($id)
    {
        $tbl = App\Models\Library\Loc_Province::where('region_id',$id)->get();
        return $tbl->toJson();
    }

    public function locmunicipal($id)
    {
        $tbl = App\Models\Library\Loc_Municipal::where('province_id',$id)->get();
        return $tbl->toJson();
    }

    public function locbarangay($id)
    {
        $tbl = App\Models\Library\Loc_Barangay::where('municipality_id',$id)->get();
        return $tbl->toJson();
    }

    public function lib($id,$arr = null)
    {
        switch ($id) {
            case 'PS':
                    $id = 1;
                break;
            case 'MOOE':
                    $id = 2;
                break;
            case 'CO':
                    $id = 3;
                break;
        }
        $tbl = App\Models\Library\LIB::where('allotment_class_id',$id)->get();
        return $tbl->toJson();
    }

    public function agencyinfo($id)
    {
        $add = "";
        $tbl = App\Models\Library\Agency::where('id',$id)->first();

        //GET MUNICIPAL
        $mun = "";
        $mun = getLibraryDesc('municipal',$tbl['munprovcode'],'municipality');
        if($mun)
        {
            $provid = getLibraryDesc('municipal',$tbl['munprovcode'],'province_id');
            $prov = getLibraryDesc('province',$provid ,'province');
            $mun .= ', '.$prov;
            $add .= $tbl['street'].' '.$tbl['barangay'].' '.$mun;
        }
        else
        {
            $add .= $tbl['street'].' '.$tbl['barangay'];
        }

        

        $data = collect([]);
        $data->push([
            'address' =>  ifNull($add),
            'telno' => ifNull($tbl['telno']),
            'email' =>  ifNull($tbl['email']),
        ]);

        return json_encode($data->all());
    }
}
