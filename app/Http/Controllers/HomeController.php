<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $nav = activeNav('dashboard');

        $data = [
                    "nav" => $nav
                ];
        return view('index')->with('data',$data);
    }

    public function pass()
    {
        // $user = App\Models\User::get();
        // foreach ($user as $key => $value) {
        //     App\Models\User::where('id',$value->id)
        //             ->update([
        //                 "password" => bcrypt($value->username)
        //             ]);
        // }

        return bcrypt('MISD002');
    }


    public function balance()
    {
        
        $row = "";
        foreach (getDivision() as $divs)
        {
            $proj = App\Models\BP202\View_project::where('created_by_division',$divs->division_id)->get();
                foreach ($proj as $projs) 
                {
                    $costcomp = 0;
                    $costimp = 0;
                    //$totalprojcount++;

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
                    $pap_exp = App\Models\BP202\BP202_pap_attribution::where('project_id',$projs->id)->where('yr',2024)->get();
                    $yr1_cost = 0;
                    if(count($pap_exp) > 0)
                        {
                            foreach ($pap_exp as $key => $pap_exps) {
                                $yr1_cost += $pap_exps->val;
                                //$totalyear1 += convertAmount($pap_exps->val);
                            }
                            $yr1_cost = convertAmount($yr1_cost);
                        }


                    //12.5
                    $proj_comp = App\Models\BP202\BP202_cost_by_comp::where('project_id',$projs->id)->get();
                    if(count($proj_comp) > 0)
                        {
                            foreach ($proj_comp as $key => $proj_comps) {
                                $costcomp += $proj_comps->ps + $proj_comps->mooe + $proj_comps->co + $proj_comps->finex;
                                //$totalyear1 += convertAmount($pap_exps->val);
                            }
                            $costcomp = convertAmount($costcomp);
                        }
                    
                    //12.6
                    $proj_loc = App\Models\BP202\BP202_loc_by_imp::where('project_id',$projs->id)->get();
                    if(count($proj_loc) > 0)
                        {
                            foreach ($proj_loc as $key => $proj_locs) {
                                $costimp += $proj_locs->ps + $proj_locs->mooe + $proj_locs->co + $proj_locs->finex;
                            }
                            $costimp = convertAmount($costimp);
                        }

                

                    //UPDATE PROJECT COST
                    App\Models\BP202\BP202_Project::where('id',$projs->id)
                                        ->update([
                                            'project_cost' => $yr1_cost
                                        ]);

                    //$proj_project_cost = $yr1_cost;

                    //$totalprojcost += $proj_project_cost;

                    $stylecomp = null;
                    $styleloc = null;

                    if($yr1_cost != $costcomp)
                    {
                        $stylecomp = ";color:red";
                    }

                    if($yr1_cost != $costimp)
                    {
                        $styleloc = ";color:red";
                    }
                    
                    if($stylecomp != null || $styleloc != null)
                    {
                        //USER
                        $user = App\Models\User::where('id',$projs->created_by_userid)->first();
                        $username = null;
                        if(isset($user))
                        {
                            $username = ' / '.$user['name'];
                        }
                        $row .= '<tr>
                                <td style="vertical-align: top" align="center">'.getLibraryDesc('division',$projs->created_by_division,'acronym').''.$username .'</td>
                                <td style="vertical-align: top">'.strtoupper($projs->project_title).'</td>
                                <td style="vertical-align: top" align="right">'.number_format($yr1_cost).'</td>
                                <td style="vertical-align: top'.$stylecomp.'" align="right">'.number_format($costcomp).'</td>
                                <td style="vertical-align: top'.$styleloc.'" align="right">'.number_format($costimp).'</td>
                            </tr>';
                    }
                    
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
        <center><h3>Summary BP Form 202 (2024 Budget Tier 2)</h3></center>
        <table width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed">
            <tr>
               <td style="font-size:8px;" align="center"><b>DIVISION<b></td>
               <td style="font-size:8px;" align="center"><b>PROJECT TITLE<b></td>
               <td style="font-size:8px;" align="center"><b>TIER 2<br>2024<b></td>
               <td style="font-size:8px;" align="center"><b>12.5<b></td>
               <td style="font-size:8px;" align="center"><b>12.6<b></td>
            </tr>
            '.$row.'
            </table>
        </body>
        </html>')
        ->setPaper('A4', 'portrait');
        return $pdf->stream();
    }


    public function overview($type,$division,$yr = null)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);

        $row = "";
        //GET 3 YEAR
        $yrs = explode('-',request()->period);
        $y1 = 2024;
        $y2 = 2025;
        $y3 = 20256;

        $totalprojcount = 0;

        $totalprojcost = 0;
        $totalyear1 = 0;
        $totalyear2 = 0;
        $totalyear3 = 0;

        if($type == 'ALL')
        {
            $proj = App\Models\BP202\View_project::where('created_by_division',$division)->orderBy('program_title','DESC')->orderBy('project_title')->get();
            
            if($division == 'ALL')
                $proj = App\Models\BP202\View_project::get();
        }
        else
        {
            $proj = App\Models\BP202\View_project::where('proposal_type',$type)->where('created_by_division',$division)->orderBy('program_title','DESC')->orderBy('project_title')->get();

            if($division == 'ALL')
                $proj = App\Models\BP202\View_project::where('proposal_type',$type)->orderBy('program_title','DESC')->orderBy('project_title')->get();
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
            $descpart1 = "";
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

            // $totalprojcost += $proj_project_cost;

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

            //USER
            $user = App\Models\User::where('id',$projs->created_by_userid)->first();
            $username = null;
            if(isset($user))
            {
                $username = ' / '.$user['name'];
            }
            
            $row .= '<tr>
                    <td style="vertical-align: top" align="center">'.getLibraryDesc('division',$projs->created_by_division,'acronym').''.$username.'</td>
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
        <center><span style="font-size:12px"><b>Department of Science and Technology<b></span><br/><span style="font-size:15px"><b>The Philippine Council for Agriculture, Aquatic and Natural Resources Research and Development (PCAARRD)</b></span><br/><span style="font-size:18px"><b>LIST OF GRANTS-IN-AID PROJECTS - Tier 2</b></span><br><br></center><center>

        <table width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed" page-break-inside: auto;>
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

        $font = 'helvetica';
        $size = 6;
        $style = '';

        $t = 590;
        for ($i = 1; $i <= $pageCount; $i++) {
            $pdf->getDomPDF()->get_canvas()->page_text(480, $t, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, $size, array(0, 0, 0));

            $t += 590;
        }
    

        return $pdf->stream();
    }

       
}
