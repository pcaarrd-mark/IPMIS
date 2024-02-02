<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function summary()
    {
        $nav = activeNav('bp202summary');

        $data = [
                    "nav" => $nav
                ];

        return view('bp202.summary')->with('data',$data);
    }

    public function agency()
    {
        $nav = activeNav('bp202summary');

        $data = [
                    "nav" => $nav
                ];

        return view('bp202.agency-add')->with('data',$data);
    }

    public function agencyadd()
    {
        $lib = new App\Models\Library\Agency;
        $lib->acronym = request()->agency_acro;
        $lib->desc = request()->agency_desc;
        $lib->save();
        
        return redirect('/bp202/agency');
    }

    public function priority()
    {
        $nav = activeNav('bp202_priority');

        $data = [
                    "nav" => $nav
                ];

        return view('bp202.priority')->with('data',$data);
    }

    public function summaryprint()
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);
        
        if(request()->division == "0")
        {
            $div = NULL;
        }
        else
        {
            $div = App\Models\Library\Division::where('id',request()->division)->first();
            $div = $div['division_id'];
        }
        

        //GET 3 YEAR
        $yrs = explode('-',request()->period);
        $y1 = $yrs[0];
        $y2 = $yrs[0] + 1;
        $y3 = $yrs[1];

        $totalprojcount = 0;

        $row = "";
        $totalprojcost = 0;
        $totalyear1 = 0;
        $totalyear2 = 0;
        $totalyear3 = 0;

        //GET UNIQUE PROGRAM
        if($div == null)
        {
            $prog = App\Models\BP202\View_project::groupBy('program_title')->orderBy('division')->get();
        }
        else
        {
            $prog = App\Models\BP202\View_project::groupBy('program_title')->where('created_by_division',$div)->get();
        }

        foreach ($prog as $key => $value) {

            $progtitle = strtoupper($value->program_title);
            if($progtitle != null && $progtitle != "" && $progtitle != "NONE" )
            {
                // $row .= '<tr>
                //         <td style="vertical-align: top" align="center">'.getLibraryDesc('division',$value->created_by_division,'acronym').'</td>
                //         <td style="vertical-align: top">'.$progtitle.'</td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //     </tr>';
            }
            
            
            //GET PROJECT UNDER PROGRAM
            if($div == null)
            {
                $proj = App\Models\BP202\View_project::where('program_title',$value->program_title)->get();
            }
            else
            {
                $proj = App\Models\BP202\View_project::where('program_title',$value->program_title)->where('created_by_division',$div)->get();
            }
            
            
            foreach ($proj as $projs) {

                $totalprojcount++;

                // $totalprojcost += $projs->project_cost;

                //LOCATION
                $projloc_comp = App\Models\BP202\BP202_loc_by_imp::where('project_id',$projs->id)->get();
                $locs = "";
                if(count($projloc_comp) > 0)
                {
                    foreach ($projloc_comp as $projlocs) {
                        $locs .= getLibraryDesc('region',$projlocs->locs,'desc').',';
                    }   
                }
                $locs = substr($locs, 0, -1);

                //DURATION
                if($projs->project_dur_rev == null && $projs->project_dur_orig)
                {
                    if($projs->project_dur_rev == null)
                    {
                        $dur1 = explode('|',$projs->project_dur_orig);
                    }
                    else
                    {
                        $dur1 = explode('|',$projs->project_dur_rev);
                    }

                    $dr1 = explode('-',$dur1[0]);
                    $start_dur = date('F',mktime(0, 0, 0, $dr1[0], 10))." ".$dr1[1];
                    $dr2 = explode('-',$dur1[1]);
                    $end_dur = date('F',mktime(0, 0, 0, $dr2[0], 10))." ".$dr2[1];
                }
                else
                {
                    $start_dur = null;
                    $end_dur = null;
                }
                
                
                

                //IMPLEMENTING AGENCY
                $empagency = getLibraryDesc('agency',$projs->implementing_agency,'acronym').',';
                //CO IMPLEMENTING
                if($projs->coimplementing_agency != null)
                { 
                    $coemp = explode(',',$projs->coimplementing_agency);
                    foreach ($coemp as $coemps) {
                        $empagency .= getLibraryDesc('agency',$coemps,'acronym').',';
                    }
                }

                $empagency = substr($empagency, 0, -1);

                //GET YEAR
                //YEAR1
                $pap_exp = App\Models\BP202\BP202_pap_attribution::where('project_id',$projs->id)->where('yr',$y1)->get();
                $yr1_cost = 0;
                if(count($pap_exp) > 0)
                    {
                        foreach ($pap_exp as $key => $pap_exps) {
                            $yr1_cost += $pap_exps->val;
                            $totalyear1 += convertAmount($pap_exps->val);
                        }
                        $yr1_cost = convertAmount($yr1_cost);
                    }
                //YEAR2
                $pap_exp = App\Models\BP202\BP202_pap_attribution::where('project_id',$projs->id)->where('yr',$y2)->get();
                $yr2_cost = 0;
                if(count($pap_exp) > 0)
                    {
                        foreach ($pap_exp as $key => $pap_exps) {
                            $yr2_cost += $pap_exps->val;
                            $totalyear2 += convertAmount($pap_exps->val);
                        }
                        $yr2_cost = convertAmount($yr2_cost);
                    }
                //YEAR3
                $pap_exp = App\Models\BP202\BP202_pap_attribution::where('project_id',$projs->id)->where('yr',$y3)->get();
                $yr3_cost = 0;
                if(count($pap_exp) > 0)
                    {
                        foreach ($pap_exp as $key => $pap_exps) {
                            $yr3_cost += $pap_exps->val;
                            $totalyear3 += convertAmount($pap_exps->val);
                        }
                        $yr3_cost = convertAmount($yr3_cost);
                    }
                
                //ETO YUNG SOBRANG HABANG DESCRIPTION
                $countprojdesc = str_word_count($projs->project_desc);
                if($countprojdesc >= 100)
                {
                    //CHECK HOW MANY SPLIT
                    $countprojdescloop = ceil($countprojdesc / 100);
                    $projdesc = "";
                        for ($i=1; $i <= $countprojdescloop; $i++) { 
                            $descpart = explode(" ",$projs->project_desc);

                            foreach($descpart as $desckey => $descparts) {
                                if($desckey <= 100)
                                {
                                    $descpart1 .=  $descparts." ";
                                }
                            }
                        }
                }
                



                $spitdesc = false;
                $descpart1 = "";
                if(str_word_count($projs->project_desc) > 50)
                {
                   $spitdesc = true;
                   $descpart = explode(" ",$projs->project_desc);
                   foreach($descpart as $desckey => $descparts) {
                        if($desckey <= 50)
                        {
                            $descpart1 .=  $descparts." ";
                        }
                   }

                   $descpart1 .= "...";
               }
                else
                {
                    $descpart1 = $projs->project_desc;
                }

                //UPDATE PROJECT COST
                App\Models\BP202\BP202_Project::where('id',$projs->id)
                                    ->update([
                                        'project_cost' => $yr1_cost
                                    ]);

                $proj_project_cost = $yr1_cost;

                //$totalprojcost += $proj_project_cost;

                //PROJECT COST
                $total_projcost = App\Models\BP202\BP202_total_proj_cost::where('project_id',$projs->id)->get();
                $totalproj_cost = 0;
                if(count($total_projcost) > 0)
                    {
                        foreach ($total_projcost as $key => $total_projcosts) {
                            $totalproj_cost += $total_projcosts->val;
                        }
                        $totalproj_cost = convertAmount($totalproj_cost);

                        $totalprojcost += $totalproj_cost;
                    }

                
                $row .= '<tr>
                        <td style="vertical-align: top" align="center">'.getLibraryDesc('division',$projs->created_by_division,'acronym').'</td>
                        <td style="vertical-align: top">'.strtoupper($projs->program_title).'</td>
                        <td style="vertical-align: top">'.strtoupper($projs->project_title).'</td>
                        <td style="vertical-align: top" align="center">'.$locs.'</td>
                        <td style="vertical-align: top">'.strtoupper($projs->project_benificiaries).'</td>
                        <td style="vertical-align: top">'.strtoupper($descpart1).'</td>
                        <td style="vertical-align: top" align="center">'.strtoupper($start_dur).'</td>
                        <td style="vertical-align: top" align="center">'.strtoupper($end_dur).'</td>
                        <td style="vertical-align: top" align="right">'.number_format($totalproj_cost).'</td>
                        <td style="vertical-align: top" align="center">'.$empagency.'</td>
                        <td style="vertical-align: top" align="center">PCAARRD</td>
                        <td style="vertical-align: top" align="right">'.number_format($yr1_cost).'</td>
                        <td style="vertical-align: top" align="right">'.number_format($yr2_cost).'</td>
                        <td style="vertical-align: top" align="right">'.number_format($yr3_cost).'</td>
                    </tr>';
            }
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<!DOCTYPE html>
        <html>
        <head>
          <title>BP202</title>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        </head>
        <style type="text/css">
                @page {
                  margin: 20;
                }
            body
            {
                font-family:DejaVu Sans;
            }
            th,td
            {
                border:1px solid #555;
                font-size:8px;
                word-wrap: break-word;
            }
            .tr-space,.td-space
            {
                border:1px solid #FFF;
                font-size:8px;
            }
            .page-break {
                page-break-after: always;
               }
        </style>
        <body>
        <center><span style="font-size:12px"><b>Department of Science and Technology<b></span><br/><span style="font-size:15px"><b>The Philippine Council for Agriculture, Aquatic and Natural Resources Research and Development (PCAARRD)</b></span><br/><span style="font-size:18px"><b>LIST OF GRANTS-IN-AID PROJECTS - Tier 2</b></span><br><br></center>

        <table width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed;" page-break-inside: auto;>
        <thead>
            <tr>
               <th style="font-size:8px;" align="center" rowspan="2"><b>DIVISION<b></th>
               <th style="font-size:8px;" align="center" rowspan="2"><b>PROGRAM TITLE<b></th>
               <th style="font-size:8px;" align="center" rowspan="2"><b>PROJECT TITLE<b></th>
               <th style="font-size:8px;" align="center" rowspan="2"><b>LOCATION<b></th>
               <th style="font-size:8px;" align="center" rowspan="2"><b>BENEFICIARIES<b></th>
               <th style="font-size:8px;" align="center" rowspan="2"><b>DESCRIPTION<b></th>
               <th style="font-size:8px;" align="center" colspan="2"><b>PROJECT DURATION<b></th>
               <th style="font-size:8px;" align="center" rowspan="2"><b>TOTAL PROJECT COST<b></th>
               <th style="font-size:8px;" align="center" rowspan="2"><b>IMPLEMENTING AGENCY<b></th>
               <th style="font-size:8px;" align="center" rowspan="2"><b>MONITORING AGENCY<b></th>
               <th style="font-size:8px;" align="center" colspan="3"><b>Fund Allocation by Year<b></th>
            </tr>
        
            <tr>
               <th style="font-size:8px;" align="center"><b>START<b></th>
               <th style="font-size:8px;" align="center"><b>END<b></th>
               <th style="font-size:8px;" align="center"><b>TIER 2<br>2024<b></th>
               <th style="font-size:8px;" align="center"><b>2025<b></th>
               <th style="font-size:8px;" align="center"><b>2026<b></th>
            </tr>
        </thead> 
            '.$row.'
            <tr>
                        <td><b>GRAND TOTAL</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right"><b>'.number_format($totalprojcost).'</b></td>
                        <td></td>
                        <td></td>
                        <td align="right"><b>'.number_format($totalyear1).'</b></td>
                        <td align="right"><b>'.number_format($totalyear2).'</b></td>
                        <td align="right"><b>'.number_format($totalyear3).'</b></td>
                    </tr>
        </body>
        </html>');

        $pdf->setOptions([
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
        ]);

        $pdf->setPaper('legal', 'landscape');
        $pdf->render();

        $pageCount = $pdf->getDomPDF()->get_canvas()->get_page_count();

        $font = 'Arial';
        $size = 6;
        $style = 'font-size:italic;';

        $t = 590;
        for ($i = 1; $i <= $pageCount; $i++) {
            $pdf->getDomPDF()->get_canvas()->page_text(480, $t, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, $size, array(0, 0, 0));

            $t += 590;
        }
    
        return $pdf->stream();
    }

    public function summaryprint2()
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);
        
        if(request()->division == "0")
        {
            $div = NULL;
        }
        else
        {
            $div = App\Models\Library\Division::where('id',request()->division)->first();
            $div = $div['division_id'];
        }
        

        //GET 3 YEAR
        $yrs = explode('-',request()->period);
        $y1 = $yrs[0];
        $y2 = $yrs[0] + 1;
        $y3 = $yrs[1];

        $totalprojcount = 0;

        $row = "";
        $totalprojcost = 0;
        $totalyear1 = 0;
        $totalyear2 = 0;
        $totalyear3 = 0;

        //GET UNIQUE PROGRAM
        if($div == null)
        {
            $prog = App\Models\BP202\View_project::groupBy('program_title')->orderBy('division')->get();
        }
        else
        {
            $prog = App\Models\BP202\View_project::groupBy('program_title')->where('created_by_division',$div)->get();
        }

        foreach ($prog as $key => $value) {

            $progtitle = strtoupper($value->program_title);
            if($progtitle != null && $progtitle != "" && $progtitle != "NONE" )
            {
                // $row .= '<tr>
                //         <td style="vertical-align: top" align="center">'.getLibraryDesc('division',$value->created_by_division,'acronym').'</td>
                //         <td style="vertical-align: top">'.$progtitle.'</td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //         <td></td>
                //     </tr>';
            }
            
            
            //GET PROJECT UNDER PROGRAM
            if($div == null)
            {
                $proj = App\Models\BP202\View_project::where('program_title',$value->program_title)->get();
            }
            else
            {
                $proj = App\Models\BP202\View_project::where('program_title',$value->program_title)->where('created_by_division',$div)->get();
            }
            
            
            foreach ($proj as $projs) {

                $totalprojcount++;

                // $totalprojcost += $projs->project_cost;

                //LOCATION
                $projloc_comp = App\Models\BP202\BP202_loc_by_imp::where('project_id',$projs->id)->get();
                $locs = "";
                if(count($projloc_comp) > 0)
                {
                    foreach ($projloc_comp as $projlocs) {
                        $locs .= getLibraryDesc('region',$projlocs->locs,'desc').',';
                    }   
                }
                $locs = substr($locs, 0, -1);

                //DURATION
                if($projs->project_dur_rev == null && $projs->project_dur_orig)
                {
                    if($projs->project_dur_rev == null)
                    {
                        $dur1 = explode('|',$projs->project_dur_orig);
                    }
                    else
                    {
                        $dur1 = explode('|',$projs->project_dur_rev);
                    }

                    $dr1 = explode('-',$dur1[0]);
                    $start_dur = date('F',mktime(0, 0, 0, $dr1[0], 10))." ".$dr1[1];
                    $dr2 = explode('-',$dur1[1]);
                    $end_dur = date('F',mktime(0, 0, 0, $dr2[0], 10))." ".$dr2[1];
                }
                else
                {
                    $start_dur = null;
                    $end_dur = null;
                }
                
                
                

                //IMPLEMENTING AGENCY
                $empagency = getLibraryDesc('agency',$projs->implementing_agency,'acronym').',';
                //CO IMPLEMENTING
                if($projs->coimplementing_agency != null)
                { 
                    $coemp = explode(',',$projs->coimplementing_agency);
                    foreach ($coemp as $coemps) {
                        $empagency .= getLibraryDesc('agency',$coemps,'acronym').',';
                    }
                }

                $empagency = substr($empagency, 0, -1);

                //GET YEAR
                //YEAR1
                $pap_exp = App\Models\BP202\BP202_pap_attribution::where('project_id',$projs->id)->where('yr',$y1)->get();
                $yr1_cost = 0;
                if(count($pap_exp) > 0)
                    {
                        foreach ($pap_exp as $key => $pap_exps) {
                            $yr1_cost += $pap_exps->val;
                            $totalyear1 += convertAmount($pap_exps->val);
                        }
                        $yr1_cost = convertAmount($yr1_cost);
                    }
                //YEAR2
                $pap_exp = App\Models\BP202\BP202_pap_attribution::where('project_id',$projs->id)->where('yr',$y2)->get();
                $yr2_cost = 0;
                if(count($pap_exp) > 0)
                    {
                        foreach ($pap_exp as $key => $pap_exps) {
                            $yr2_cost += $pap_exps->val;
                            $totalyear2 += convertAmount($pap_exps->val);
                        }
                        $yr2_cost = convertAmount($yr2_cost);
                    }
                //YEAR3
                $pap_exp = App\Models\BP202\BP202_pap_attribution::where('project_id',$projs->id)->where('yr',$y3)->get();
                $yr3_cost = 0;
                if(count($pap_exp) > 0)
                    {
                        foreach ($pap_exp as $key => $pap_exps) {
                            $yr3_cost += $pap_exps->val;
                            $totalyear3 += convertAmount($pap_exps->val);
                        }
                        $yr3_cost = convertAmount($yr3_cost);
                    }
                
                //ETO YUNG SOBRANG HABANG DESCRIPTION
                $countprojdesc = str_word_count($projs->project_desc);
                if($countprojdesc >= 100)
                {
                    //CHECK HOW MANY SPLIT
                    $countprojdescloop = ceil($countprojdesc / 100);
                    $projdesc = "";
                        for ($i=1; $i <= $countprojdescloop; $i++) { 
                            $descpart = explode(" ",$projs->project_desc);

                            foreach($descpart as $desckey => $descparts) {
                                if($desckey <= 100)
                                {
                                    $descpart1 .=  $descparts." ";
                                }
                            }
                        }
                }
                



                $spitdesc = false;
                $descpart1 = "";
                if(str_word_count($projs->project_desc) > 50)
                {
                   $spitdesc = true;
                   $descpart = explode(" ",$projs->project_desc);
                   foreach($descpart as $desckey => $descparts) {
                        if($desckey <= 50)
                        {
                            $descpart1 .=  $descparts." ";
                        }
                   }

                   $descpart1 .= "...";
               }
                else
                {
                    $descpart1 = $projs->project_desc;
                }

                //UPDATE PROJECT COST
                App\Models\BP202\BP202_Project::where('id',$projs->id)
                                    ->update([
                                        'project_cost' => $yr1_cost
                                    ]);

                $proj_project_cost = $yr1_cost;

                //$totalprojcost += $proj_project_cost;
                
                //PROJECT COST
                $total_projcost = App\Models\BP202\BP202_total_proj_cost::where('project_id',$projs->id)->get();
                $totalproj_cost = 0;
                if(count($total_projcost) > 0)
                    {
                        foreach ($total_projcost as $key => $total_projcosts) {
                            $totalproj_cost += $total_projcosts->val;
                        }
                        $totalproj_cost = convertAmount($totalproj_cost);

                        $totalprojcost += $totalproj_cost;
                    }

                
                $row .= '<tr>
                        <td style="vertical-align: top" align="center">'.getLibraryDesc('division',$projs->created_by_division,'acronym').'</td>
                        <td>'.strtoupper($projs->program_title).'</td>
                        <td style="vertical-align: top">'.strtoupper($projs->project_title).'</td>
                        <td style="vertical-align: top" align="center">'.$locs.'</td>
                        <td style="vertical-align: top">'.strtoupper($projs->project_benificiaries).'</td>
                        <td style="vertical-align: top">'.strtoupper($descpart1).'</td>
                        <td style="vertical-align: top" align="center">'.strtoupper($start_dur).'</td>
                        <td style="vertical-align: top" align="center">'.strtoupper($end_dur).'</td>
                        <td style="vertical-align: top" align="right">'.number_format($totalproj_cost).'</td>
                        <td style="vertical-align: top" align="center">'.$empagency.'</td>
                        <td style="vertical-align: top" align="center">PCAARRD</td>
                        <td style="vertical-align: top" align="right">'.number_format($yr1_cost).'</td>
                        <td style="vertical-align: top" align="right">'.number_format($yr2_cost).'</td>
                        <td style="vertical-align: top" align="right">'.number_format($yr3_cost).'</td>
                    </tr>';
            }
        }

        echo '
        <center><h3>Summary BP Form 202 ('.$y1.' Budget Tier 2)</h3><h5><b>TOTAL PROJECT : '.$totalprojcount.'</b></h5></center>
        <table width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed">
            <tr>
               <td style="font-size:8px;" align="center" rowspan="2"><b>DIVISION<b></td>
               <td style="font-size:8px;" align="center" rowspan="2"><b>PROGRAM TITLE<b></td>
               <td style="font-size:8px;" align="center" rowspan="2"><b>PROJECT TITLE<b></td>
               <td style="font-size:8px;" align="center" rowspan="2"><b>LOCATION<b></td>
               <td style="font-size:8px;" align="center" rowspan="2"><b>BENEFICIARIES<b></td>
               <td style="font-size:8px;" align="center" rowspan="2"><b>DESCRIPTION<b></td>
               <td style="font-size:8px;" align="center" colspan="2"><b>PROJECT DURATION<b></td>
               <td style="font-size:8px;" align="center" rowspan="2"><b>TOTAL PROJECT COST<b></td>
               <td style="font-size:8px;" align="center" rowspan="2"><b>IMPLEMENTING AGENCY<b></td>
               <td style="font-size:8px;" align="center" rowspan="2"><b>MONITORING AGENCY<b></td>
               <td style="font-size:8px;" align="center" colspan="3"><b>Fund Allocation by Year<b></td>
            </tr>
            <tr>
               <td style="font-size:8px;" align="center"><b>START<b></td>
               <td style="font-size:8px;" align="center"><b>END<b></td>
               <td style="font-size:8px;" align="center"><b>TIER 2<br>2024<b></td>
               <td style="font-size:8px;" align="center"><b>2025<b></td>
               <td style="font-size:8px;" align="center"><b>2026<b></td>
            </tr>
            '.$row.'
            <tr>
                        <td><b>GRAND TOTAL</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right"><b>'.number_format($totalprojcost).'</b></td>
                        <td></td>
                        <td></td>
                        <td align="right"><b>'.number_format($totalyear1).'</b></td>
                        <td align="right"><b>'.number_format($totalyear2).'</b></td>
                        <td align="right"><b>'.number_format($totalyear3).'</b></td>
                    </tr></table>';
    }

    public function updateranking()
    {
        $ranking = request()->project_ranking;
        if(request()->project_ranking == 'x')
        {
            $ranking = null;
        }

        $proj = App\Models\BP202\BP202_Project::where('id',request()->project_id)
                ->update([
                        "project_ranking" => $ranking
                ]);
        
        return redirect('bp202/priority');
    }
}
