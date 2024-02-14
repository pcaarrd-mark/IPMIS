<?php

namespace App\Http\Controllers\OSEP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Collection;

class OSEPLibController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth']);
    // }

    public function test()
    {
        $lib = App\Models\LIB::where('project_id',1)->where('budget_yr',1)->where('object_class','ps')->where('cost','dc')->where('counterpart','No')->get();
        return count($lib);
    }

    public function index($id)
    {
        $nav = activeNav('osep_project');

        $proj = App\Models\Project::where('id',$id)->first();
        $budgets = App\Models\LIBYear::where('project_id',$id)->get();

        $data = [
                    "nav" => $nav,
                    "title" => $proj['title'],
                    "project_id" => $proj['id'],
                    "budgetlist" => $budgets,
                    "created_by" => $proj['created_by'],
                ];

        return view('osep.lib')->with('data',$data);
    }

    public function add($id,$budgetid,$budgettype)
    {
        $nav = activeNav('osep_project');

        $proj = App\Models\Project::where('id',$id)->first();

        $budget = App\Models\LIBYear::where('id',$budgetid)->first();

        switch ($budgettype) {
            case 'PS':
                    $budget_type_desc = 'Personal Services (PS)';
                break;
            case 'MOOE':
                    $budget_type_desc = 'Maintenance and Other Operating Expenses (MOOE)';
                break;
            case 'CO':
                    $budget_type_desc = 'Capital Outlays (CO)';
                break;
        }

        $data = [
                    "nav" => $nav,
                    "title" => $proj['title'],
                    "project_id" => $proj['id'],
                    "budget_id" => $budget['id'],
                    "budget_yr" => $budget['year'],
                    "budget_type" => $budget_type_desc,
                    "budget_code" => $budgettype,
                ];
        
        return view('osep.add-lib2')->with('data',$data);
    }


    public function createback(Request $request)
    {
        $lib = new App\Models\OSEP\LIB;

        //DELETE MUNA ANG PREVIOUS WAG NA UPDATE
        App\Models\OSEP\LIB::where('project_id',request()->project_id)->where('budget_id',request()->budget_id)->where('lib_type',request()->budget_code)->update(['deleted_at' => date('Y-m-d H:i:s'),'deleted_by' => Auth::user()->id]);

        // $data = collect([]);

        // foreach (request()->lib_desc as $key => $value)
        // {
        //     $data->push([
        //                     'lib_desc' => $value,
        //                     'project_id' => request()->project_id,
        //                     'budget_id' => request()->budget_id,
        //                     'lib_type' => request()->budget_code,
        //                     'lib_year' => request()->budget_yr,
        //                     'jan' => request()->lib_mon_jan[$key],
        //                     'feb' => request()->lib_mon_feb[$key],
        //                     'mar' => request()->lib_mon_mar[$key],
        //                     'apr' => request()->lib_mon_apr[$key],
        //                     'may' => request()->lib_mon_may[$key],
        //                     'jun' => request()->lib_mon_jun[$key],
        //                     'jul' => request()->lib_mon_jul[$key],
        //                     'aug' => request()->lib_mon_aug[$key],
        //                     'sep' => request()->lib_mon_sep[$key],
        //                     'oct' => request()->lib_mon_oct[$key],
        //                     'nov' => request()->lib_mon_nov[$key],
        //                     'dec' => request()->lib_mon_dec[$key],
        //                     'created_by' => Auth::user()->id,
        //                     'created_at' => date('Y-m-d H:i:s')
        //                 ]);
        // }
        

        // $lib::insert($data->all());

        $data = collect([]);

        foreach (request()->row_id as $key => $value) {
            
            $expenditure = 'expenditure_'.$value;
            $expenditure_sub = 'expenditure_sub_'.$value;
            $lib_mon_jan = 'lib_mon_jan_'.$value;
            $lib_mon_feb = 'lib_mon_feb_'.$value;
            $lib_mon_mar = 'lib_mon_mar_'.$value;
            $lib_mon_apr = 'lib_mon_apr_'.$value;
            $lib_mon_may = 'lib_mon_may_'.$value;
            $lib_mon_jun = 'lib_mon_jun_'.$value;
            $lib_mon_jul = 'lib_mon_jul_'.$value;
            $lib_mon_aug = 'lib_mon_aug_'.$value;
            $lib_mon_sep = 'lib_mon_sep_'.$value;
            $lib_mon_oct = 'lib_mon_oct_'.$value;
            $lib_mon_nov = 'lib_mon_nov_'.$value;
            $lib_mon_dec = 'lib_mon_dec_'.$value;


            //ALLOTMENT
            foreach ($request[$expenditure] as $k => $val) {

                //SUB
                foreach ($request[$expenditure_sub] as $k2 => $val2) {
                    $data->push([
                        'budget_id' => request()->budget_id,
                        'lib_type' => request()->budget_code,
                        'expenditure_id' => $val,
                        'expenditure_sub' => $val2,
                        'jan' => $request[$lib_mon_jan][$k2],
                        'feb' => $request[$lib_mon_feb][$k2],
                        'mar' => $request[$lib_mon_mar][$k2],
                        'apr' => $request[$lib_mon_apr][$k2],
                        'may' => $request[$lib_mon_may][$k2],
                        'jun' => $request[$lib_mon_jun][$k2],
                        'jul' => $request[$lib_mon_jul][$k2],
                        'aug' => $request[$lib_mon_aug][$k2],
                        'sep' => $request[$lib_mon_sep][$k2],
                        'oct' => $request[$lib_mon_oct][$k2],
                        'nov' => $request[$lib_mon_nov][$k2],
                        'dec' => $request[$lib_mon_dec][$k2],
                        'project_id' => request()->project_id,
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
            
                }
            }
        }


        switch (request()->budget_code) {
            case 'PS':
                    $budget_type_desc = 'Personal Services (PS)';
                break;
            case 'MOOE':
                    $budget_type_desc = 'Maintenance and Other Operating Expenses (MOOE)';
                break;
            case 'CO':
                    $budget_type_desc = 'Capital Outlays (CO)';
                break;
        }

        addHistoryLog('LIB '.$budget_type_desc.' Updated','Project',request()->project_id);
        $lib::insert($data->all());

    }

    public function create_back(Request $request)
    {
        $lib = new App\Models\OSEP\LIB;

        //DELETE MUNA ANG PREVIOUS WAG NA UPDATE
        // App\Models\OSEP\LIB::where('project_id',request()->project_id)->where('lib_year_id',request()->budget_id)->where('lib_type',request()->budget_code)->update(['deleted_at' => date('Y-m-d H:i:s'),'deleted_by' => Auth::user()->id]);

        $mon[0] = 0;
        $mon[1] = 0;
        $mon[2] = 0;
        $mon[3] = 0;
        $mon[4] = 0;
        $mon[5] = 0;
        $mon[6] = 0;
        $mon[7] = 0;
        $mon[8] = 0;
        $mon[9] = 0;
        $mon[10] = 0;
        $mon[11] = 0;

        if(isset(request()->mon))
        {
            foreach (request()->mon as $key => $value) {
                if(request()->budget_code == 'PS')
                    $mon[$key] = request()->amt;
                else
                    $mon[$key] = $value;
            }
        }

        $agency = explode('-',request()->agency_id);

        $lib->cost_type = request()->cost_type;
        $lib->project_id = request()->project_id;
        $lib->lib_year_id = request()->lib_year_id;
        $lib->lib_type = request()->budget_code;
        $lib->expenditure_id = request()->object_expenditure;
        $lib->expenditure_sub = request()->object_expenditure_remarks;
        $lib->num_items = request()->num_items;
        $lib->agency_id =  $agency[0];
        $lib->agency_type =  $agency[1];
        $lib->jan = $mon[0];
        $lib->feb = $mon[1];
        $lib->mar = $mon[2];
        $lib->apr = $mon[3];
        $lib->may = $mon[4];
        $lib->jun = $mon[5];
        $lib->jul = $mon[6];
        $lib->aug = $mon[7];
        $lib->sep = $mon[8];
        $lib->oct = $mon[9];
        $lib->nov = $mon[10];
        $lib->dec = $mon[11];
        $lib->created_by = Auth::user()->id;
        $lib->save();


        switch (request()->budget_code) {
            case 'PS':
                    $budget_type_desc = 'Personal Services (PS)';
                break;
            case 'MOOE':
                    $budget_type_desc = 'Maintenance and Other Operating Expenses (MOOE)';
                break;
            case 'CO':
                    $budget_type_desc = 'Capital Outlays (CO)';
                break;
        }

        addHistoryLog('LIB '.$budget_type_desc.' Updated','Project',request()->project_id);

    }

    public function create(Request $request)
    {

        //DELETE PREVIOUS DATA THEN INSERT PARA WALANG UPDATE
        $list = App\Models\LIB::where('project_id',$request->project_id)->where('agency_id',$request->agency_id)->get();
            
        foreach ($list as $value) {
            App\Models\LIBMons::where('lib_id',$value->id)->delete();
        }
                    
        App\Models\LIB::where('project_id',$request->project_id)->where('agency_id',$request->agency_id)->delete();
        
        $project = App\Models\OSEP\View_OSEPProject::where('id',$request->project_id)->first();
        //END DELETING

        // $data = [];
        $budget_yr_ctr = 0;
        if($request->budget_row)
        {
            foreach($request->budget_row AS $item)
            {   
                $arr = explode('-',$item);
                // echo $item."|".$request->$item."|".$request[$item."_remarks"]."|Counterpart=".$request[$arr[5]."_counterpart"]."<br>";
                
                
                // //DELETE PREVIOUS DATA THEN INSERT PARA WALANG UPDATE
                // $list = App\Models\LIB::where('project_id',$request->project_id)->where('agency_id',$request->agency_id)->where('object_class',$arr[3])->where('cost',$arr[4])->where('budget_yr',$arr[2])->get();
                
                // foreach ($list as $value) {
                //     App\Models\LIBMons::where('lib_id',$value->id)->delete();
                // }
                
                // App\Models\LIB::where('project_id',$request->project_id)->where('agency_id',$request->agency_id)->where('object_class',$arr[3])->where('cost',$arr[4])->where('budget_yr',$arr[2])->delete();
    
                // $project = App\Models\OSEP\View_OSEPProject::where('id',$request->project_id)->first();
                // //END DELETING
    
                if($budget_yr_ctr == 0)
                {
                    $budget_yr_ctr = $arr[2];
                    addHistoryLog('LIB updated for YEAR '.$budget_yr_ctr,'Project',$request->project_id);
                }
                    
    
                if($budget_yr_ctr != $arr[2])
                {
                    $budget_yr_ctr = $arr[2];
                    addHistoryLog('LIB updated for YEAR '.$budget_yr_ctr,'Project',$request->project_id);
                }
                    
                    
    
                $lib = new App\Models\LIB;
    
                $lib->project_id = $request->project_id;
                $lib->agency_id = $request->agency_id;
                $lib->budget_yr = $arr[2];
                $lib->cost = $arr[4];
                $lib->object_class = $arr[3];
                $lib->object_expenditure = $request->$item;
                $lib->object_remarks = $request[$item."_remarks"];
                $lib->counterpart = $request[$arr[5]."_counterpart"];
                $lib->save();
                $lib_id =  $lib->id; 
    
                //MONTHS
                $mon = $project['duration_from_month'];
                $totalmons = getLibMonths($request->project_id,$arr[2]);
    
                // echo "<br>YEAR : ".$arr[2]." TOTAL MONTHS : ".$totalmons."<br><br>";
                $datamon = [];
                $libmon = new App\Models\LIBMons;
                $i = 0;
                // for($y = 1; $y <= $totalmons; $y++)
                // {
                    
                //     if($mon >= 13)
                //     {
                //         $mon -= 12;
                //         $datamon[] = [
                //             'lib_id' => $lib_id,
                //             'mons' => $mon,
                //             'amt'=> $request[$item."_mon"][$i],
                //           ];
                //     }
                //     else
                //     {
                //         $datamon[] = [
                //             'lib_id' => $lib_id,
                //             'mons' => $mon,
                //             'amt'=> $request[$item."_mon"][$i],
                //           ];
                //     }
    
                //     // echo "<br>YEAR : ".$arr[2]." MONTH : ".$mon."<br>";
    
                //     $mon++;
                //     $i++;
                // }

                foreach ($request[$item."_mon"] as $key => $value) {
                    $datamon[] = [
                        'lib_id' => $lib_id,
                        'mons' => 1,
                        'amt'=> $value,
                      ];
                }
                $libmon::insert($datamon);
                                    
    
                
    
                // $data[] = [
                //             'project_id' => $request->project_id,
                //             'agency_id' => $request->agency_id,
                //             'budget_yr' => $arr[2],
                //             'cost' => $arr[4],
                //             'object_class' => $arr[3],
                //             'object_expenditure' => $request->$item,
                //             'object_remarks' => $request[$item."_remarks"],
                //             'counterpart' => $request[$arr[5]."_counterpart"],
                //           ];
            }
        }
        

        // $lib::insert($data);

        return redirect('project/lib-edit/'.$request->project_id.'/'.$request->agency_id);
    }

    public function edit($projectid,$agencyid)
    {
        $proj = App\Models\OSEP\View_OSEPProject::where('id',$projectid)->first();
        $yrs = App\Models\LIBYear::where('project_id',$projectid)->count();
        
        $agency = App\Models\Library\Agency::where('id',$agencyid)->first();
        

        if(isset($proj['duration_from_month']))
            {
                $start_mon = date('F',mktime(0, 0, 0, $proj['duration_from_month'], 10));
                $start_year = $proj['duration_from_year'];
                $end_mon = date('F',mktime(0, 0, 0, $proj['duration_to_month'], 10));
                $end_year = $proj['duration_to_year'];

                //MONTHS
                $d1 = $start_year."-". $proj['duration_from_month']."-01";
                $d2 = $end_year."-". $proj['duration_to_month']."-01";
                $mon = countMonths($d1,$d2);

                $duration = $start_mon." ".$start_year." - ".$end_mon." ".$end_year." (".$mon." months)";
            }
            else
            {
                $duration = "N/A";
            }

        $data = [
            'project' => $proj,
            'duration' => $duration,
            'yrs' => $yrs,
            "agency_id" => $agencyid,
            "agency" => $agency['desc']." (".$agency['acronym'].")",
        ];

        return view('osep.add-lib3')->with('data',$data);
    }


    public function print()
    {
        $proj = App\Models\Project::where('id',request()->project_id)->first();
        $totalprojectcost = 0;
        
        $duration = formatDuration($proj['duration_from_month'],$proj['duration_from_year'],$proj['duration_to_month'],$proj['duration_to_year']);

        if(request()->project_year == 0)
            $currentProjDuration = "";
        else
        {
            $currentDuration = formatCurrentDuration(request()->project_id,request()->project_year,$proj['duration_from_month'],$proj['duration_from_year'],$proj['duration_to_month'],$proj['duration_to_year']);
            $currentProjDuration = $currentDuration['from_mon'].' '.$currentDuration['from_year'].' - '.$currentDuration['to_mon'].' '.$currentDuration['to_year'].' ('.$currentDuration['total_mons'].' months)';
        }
            


        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);

        //GET ALL LIB Implementing Agency
        if(request()->project_year == 0)
            $projagencylib = App\Models\LIB::where('project_id',request()->project_id)->where('counterpart','No')->groupBy('agency_id')->get();
        else
            $projagencylib = App\Models\LIB::where('project_id',request()->project_id)->where('budget_yr',request()->project_year)->where('counterpart','No')->groupBy('agency_id')->get();

        $td = "";
        foreach ($projagencylib as $key => $agencies) {
            $agency = App\Models\Library\Agency::getDetailsAcro($agencies->agency_id);

            $addtd = '<td style="border:1px solid #FFF;width:20%"></td>';

            $td .= '
                    <td style="border:1px solid #FFF;width:20%" align="right">
                        <b>'.$agency.'</b> 
                    </td>';
        }

        $tr = '<tr valign="top">
                    <td  style="border:1px solid #FFF;width:3%">
                    </td><td style="border:1px solid #FFF;">
                    </td>
                    '.$td.'
                </tr>';

        //GET IMPLENTING AND CO-IMPLEMENT AGENCY ONLY
        $projagency = App\Models\Project_agency::where('project_id',request()->project_id)->whereIn('agency_type',['Implementing','Co-implementing'])->get();
        $projagencylist = "";
        foreach ($projagency as $key => $value) {
            $projagencylist .= App\Models\Library\Agency::getDetailsAcro($value->agency_id).", ";
        }

        $tr2 = '<tr valign="top">
                    <td  style="border:1px solid #FFF;width:3%">
                        <b>I</b>
                    </td>
                    <td style="border:1px solid #FFF;">
                        <b>Personal Services</b>
                    </td>
                </tr>

                <tr valign="top">
                    <td  style="border:1px solid #FFF;width:3%">
                        
                    </td>
                    <td style="border:1px solid #FFF;">
                        <u>Direct Cost</u>
                    </td>
                </tr>
                ';
        $trArr = explode('|',getValueByClassCost(request()->project_id,request()->project_year,'ps','dc'));
        $tr2 .= $trArr[0];
        $totalprojectcost += $trArr[1];

        $tr2 .=  '<tr valign="top">
                    <td  style="border:1px solid #FFF;width:3%">
                        
                    </td>
                    <td style="border:1px solid #FFF;">
                        <u>Indirect Cost</u>
                    </td>
                </tr>';
                
        
        // foreach ($projagencylib as $projlibs) {
        //             $tr2 .= getValueByClassCost(request()->project_id,$projlibs->agency_id,request()->project_year,'ps','ic');
        //         }
        $tr2 .= '<tr valign="top">
                    <td  style="border:1px solid #FFF;width:3%">
                        
                    </td>
                    <td style="border:1px solid #FFF;">
                        <b>Sub-total for PS</b>
                    </td>';
        $tr2 .= getValueByClassCost(request()->project_id,request()->project_year,'ps','total');  
        
        $tr2 .= '</tr>';
        
              

        $tr2 .= '<tr valign="top">
                <td  style="border:1px solid #FFF;width:3%">
                    <b>II</b>
                </td>
                <td style="border:1px solid #FFF;">
                    <b>Maintenance and Other Operating Expenses</b>
                </td>
            </tr>';

        $tr2 .= '<tr valign="top">
                <td  style="border:1px solid #FFF;width:3%">
                    
                </td>
                <td style="border:1px solid #FFF;">
                    <u>Direct Cost</u>
                </td>
            </tr>';
        
        //$tr2 .= getValueByClassCost(request()->project_id,request()->project_year,'mooe','dc');
        $trArr = explode('|',getValueByClassCost(request()->project_id,request()->project_year,'mooe','dc'));
        $tr2 .= $trArr[0];
        $totalprojectcost += $trArr[1];
        
        
        $tr2 .= '<tr valign="top">
                <td  style="border:1px solid #FFF;width:3%">
                    
                </td>
                <td style="border:1px solid #FFF;">
                    <u>Indirect Cost</u>
                </td>
                '.$addtd.'
            </tr>';
            // foreach ($projagencylib as $projlibs) {
            //             $tr2 .= getValueByClassCost(request()->project_id,$projlibs->agency_id,request()->project_year,'mooe','ic');
            //         }
            $tr2 .= '<tr valign="top">
            <td  style="border:1px solid #FFF;width:3%">
                
            </td>
            <td style="border:1px solid #FFF;">
                <b>Sub-total for MOOE</b>
            </td>';
            $tr2 .= getValueByClassCost(request()->project_id,request()->project_year,'mooe','total');  

            $tr2 .= '</tr>';

            $tr2 .= '<tr valign="top">
                <td  style="border:1px solid #FFF;width:3%">
                    <b>III</b>
                </td>
                <td style="border:1px solid #FFF;">
                    <b>Equipment Outlay</b>
                </td>
                '.$addtd.'
            </tr>

            <tr valign="top">
                <td  style="border:1px solid #FFF;width:3%">
                    
                </td>
                <td style="border:1px solid #FFF;">
                    <u>Direct Cost</u>
                </td>
                '.$addtd.'
            </tr>';

            //$tr2 .= getValueByClassCost(request()->project_id,request()->project_year,'eo','dc');
            $trArr = explode('|',getValueByClassCost(request()->project_id,request()->project_year,'eo','dc'));
            $tr2 .= $trArr[0];
            $totalprojectcost += $trArr[1];

            $tr2 .= '<tr valign="top">
                <td  style="border:1px solid #FFF;width:3%">
                    
                </td>
                <td style="border:1px solid #FFF;">
                    <u>Indirect Cost</u>
                </td>
                '.$addtd.'
            </tr>';
            // foreach ($projagencylib as $projlibs) {
            //             $tr2 .= getValueByClassCost(request()->project_id,$projlibs->agency_id,request()->project_year,'eo','ic');
            //         }

            $tr2 .= '<tr valign="top">
            <td  style="border:1px solid #FFF;width:3%">
                
            </td>
            <td style="border:1px solid #FFF;">
                <b>Sub-total for EO</b>
            </td>';
            $tr2 .= getValueByClassCost(request()->project_id,request()->project_year,'eo','total');  

            $tr2 .= '</tr>';

            $tr2 .= '<tr valign="top">';

            $tr2 .= '<tr valign="top">
            <td  style="border:1px solid #FFF;width:3%;">
                
            </td>
            <td style="border:1px solid #FFF;">
                <b>GRAND TOTAL</b>
            </td>';

            $tr2 .= getValueByClassCost(request()->project_id,request()->project_year,'all','total');     

            $tr2 .= '</tr>';

        


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<!DOCTYPE html>
        <html>
        <head>
          <title>DOST FORM 4</title>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        </head>
        <style type="text/css">
            @page {
                  margin: 30;
                }
            body
            {
                font-family:DejaVu Sans;
            }
            th,td
            {
                border:1px solid #555;
                font-size:11px;
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
        
        <table style="border:1px solid #FFF" width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed" page-break-inside: auto;>
            <tr>
                <td  style="border:1px solid #FFF">
                </td>
                <td style="width:80%;border:1px solid #FFF">
                    <center><span style="font-size:12px"><b>DOST Form 4<b></span><br/><span style="font-size:15px"><b>The Philippine Council for Agriculture, Aquatic and Natural Resources Research and Development (PCAARRD)</b></span><br/><span style="font-size:15px"><b>Project Line-Item Budget</b></span><br><br></center><center>
                </td>
                <td style="border:1px solid #FFF">
                </td>
            </tr>
        </table>

        <table style="border:1px solid #FFF" width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed" page-break-inside: auto;>
            <tr valign="top">
                <td  style="border:1px solid #FFF;width:20%">
                    Program Title
                </td>
                <td style="border:1px solid #FFF;width:1%">
                    :
                </td>
                <td style="border:1px solid #FFF">
                '.getProgramDetails($proj['program_id'],'title').'
                </td>
            </tr>
            <tr valign="top">
                <td  style="border:1px solid #FFF;width:20%">
                    Project Title
                </td>
                <td style="border:1px solid #FFF;width:1%">
                    :
                </td>
                <td style="border:1px solid #FFF">
                '.strtoupper($proj['title']).'
                </td>
            </tr>
            <tr valign="top">
                <td  style="border:1px solid #FFF;width:20%">
                    Implementing Agency
                </td>
                <td style="border:1px solid #FFF;width:1%">
                    :
                </td>
                <td style="border:1px solid #FFF">
                    '.$projagencylist.'
                </td>
            </tr>
            <tr valign="top">
                <td  style="border:1px solid #FFF;width:20%">
                    Total Duration
                </td>
                <td style="border:1px solid #FFF;width:1%">
                    :
                </td>
                <td style="border:1px solid #FFF">
                '.$duration.'
                </td>
            </tr>
            <tr valign="top">
                <td  style="border:1px solid #FFF;width:20%">
                    Current Duration
                </td>
                <td style="border:1px solid #FFF;width:1%">
                    :
                </td>
                <td style="border:1px solid #FFF">
                '.$currentProjDuration.'
                </td>
            </tr>
            <tr valign="top">
                <td  style="border:1px solid #FFF;width:20%">
                    Total Project Cost
                </td>
                <td style="border:1px solid #FFF;width:1%">
                    :
                </td>
                <td style="border:1px solid #FFF">
                '.formatCash($totalprojectcost,2).'
                </td>
            </tr>
            <tr valign="top">
                <td  style="border:1px solid #FFF;width:20%">
                    Cooperating Agency
                </td>
                <td style="border:1px solid #FFF;width:1%">
                    :
                </td>
                <td style="border:1px solid #FFF">
                </td>
            </tr>
            <tr valign="top">
                <td  style="border:1px solid #FFF;width:20%">
                    Program Leader
                </td>
                <td style="border:1px solid #FFF;width:1%">
                    :
                </td>
                <td style="border:1px solid #FFF">
                
                </td>
            </tr>
            <tr valign="top">
                <td  style="border:1px solid #FFF;width:20%">
                    Project Leader
                </td>
                <td style="border:1px solid #FFF;width:1%">
                    :
                </td>
                <td style="border:1px solid #FFF">
                </td>
            </tr>
            <tr valign="top">
                <td  style="border:1px solid #FFF;width:20%">
                    Monitoring Agency
                </td>
                <td style="border:1px solid #FFF;width:1%">
                    :
                </td>
                <td style="border:1px solid #FFF">
                The Philippine Council for Agriculture, Aquatic and Natural Resources Research and Development (PCAARRD)
                </td>
            </tr>
        </table>

        <table style="border:1px solid #FFF" width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed" page-break-inside: auto;>
            '.$tr.'
            '.$tr2.'

        </table>

        <div class="page-break"></div>

        <table style="border:1px solid #FFF" width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed" page-break-inside: auto;>
            <tr>
                <td  style="border:1px solid #FFF">
                </td>
                <td style="width:80%;border:1px solid #FFF">
                    <center><span style="font-size:12px"><b>DOST Form 4<b></span><br/><span style="font-size:15px"><b>Project Line-Item Budget</b></span><br><br></center><center>
                </td>
                <td style="border:1px solid #FFF">
                </td>
            </tr>

            <tr valign="top">
            <td  style="border:1px solid #FFF" colspan="3">
                <b>I. General Instruction:</b> Submit through the DOST Project Management Information System (DPMIS), http://dpmis.dost.gov.ph, the project line-item budget (LIB) for the component project.  Also, submit four (4) copies of the LIB. Use Arial font, 11 font size.
            </td>
            </tr>

            <tr valign="top">
            <td  style="border:1px solid #FFF" colspan="3">
                <b>II. Specific Instructions:</b>
                <br>1. Itemize MOOE expense items above ₱100,000.00.  Expense items under the GAM may be allowed.
                <br>2. For Equipment, attach quotations and justification.
            </td>
            </tr>

        </table>
        </body>
        </html>');

        $pdf->setOptions([
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
        ]);

        $pdf->setPaper('legal', 'portrait');
        $pdf->render();

        $pageCount = $pdf->getDomPDF()->get_canvas()->get_page_count();

        $font = 'helvetica';
        $size = 6;
        $style = '';

        $t = 990;
        for ($i = 1; $i <= $pageCount; $i++) {
            $pdf->getDomPDF()->get_canvas()->page_text(300, $t, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, $size, array(0, 0, 0));

            $t += 990;
        }
    

        return $pdf->stream();
    }

    public function update()
    {
        $startmon = request()->slct_mon_orig_start;
        $startyear = request()->slct_year_orig;
        $endmon = request()->slct_mon_orig_end;
        $endyear = request()->slct_year_orig_end;

        //SAVE HISTORY OF PROJECT DURATION
        App\Models\ProjectDuration::where('project_id',request()->edit_project_id)->delete();
        
        $dur = new App\Models\ProjectDuration;
        $dur->project_id = request()->edit_project_id;
        $dur->duration_from_month = request()->slct_mon_orig_start;
        $dur->duration_from_year = request()->slct_year_orig;
        $dur->duration_to_month = request()->slct_mon_orig_end;
        $dur->duration_to_year = request()->slct_year_orig_end;
        $dur->save();

        //UPDATE 
        App\Models\Project::where('id',request()->edit_project_id)->update([
            'duration_from_month' => request()->slct_mon_orig_start,
            'duration_from_year' => request()->slct_year_orig,
            'duration_to_month' => request()->slct_mon_orig_end,
            'duration_to_year' => request()->slct_year_orig_end
        ]);
        

        //COUNT DURATION
        $yr1 = request()->slct_year_orig;
        $yr2 = request()->slct_year_orig_end;

        //MONTHS
        $start_mon = date('F',mktime(0, 0, 0, request()->slct_mon_orig_start, 10));
        $start_year = request()->slct_year_orig;
        $end_mon = date('F',mktime(0, 0, 0, request()->slct_mon_orig_end, 10));
        $end_year = request()->slct_year_orig_end;

        //MONTHS
        $d1 = $start_year."-". request()->slct_mon_orig_start."-01";
        $daysMon = Carbon::createFromFormat('Y-m-d', request()->slct_year_orig_end.'-'.request()->slct_mon_orig_end.'-01')->daysInMonth;
        $d2 = $end_year."-". request()->slct_mon_orig_end."-".$daysMon;
        $yr = count_date($d1,$d2,'y');
        $mon = (count_date($d1,$d2,'m')) + 1;

        // return $mon;

        // $mons = round(($mon / 12),1);
        // $mons = explode(".",$mons);
        // $monsctr = count($mons);
        
        //DELETE PREVIOUS YEAR
        App\Models\LIBYear::where('project_id',request()->edit_project_id)->delete();
        for ($i=1; $i <= $yr; $i++){ 
            $budget = new App\Models\LIBYear;
            $budget->project_id = request()->edit_project_id;
            $budget->year = $i;
            $budget->months = 12;
            $budget->save();
        }
        
        if($mon == 12)
        {
            $budget = new App\Models\LIBYear;
            $budget->project_id = request()->edit_project_id;
            $budget->year = $i;
            $budget->months = 12;
            $budget->save();
        }
        else
        {
            $budget = new App\Models\LIBYear;
            $budget->project_id = request()->edit_project_id;
            $budget->year = $i;
            $budget->months = $mon;
            $budget->save();
        }



        //return $startmon . ' - ' . $startyear . ' - ' . $endmon . ' - ' . $endyear;

        // if(request()->matching == 'true')
        // {
        //     return "MATCH";
        // }
        // else
        // {
        //     return "NOT MATCH";
        //     //$lib = App\Models\LIB::where('project_id',request()->project_edit_duration_id)->first();
        //     //$libmons = App\Models\LIB::where('lib_id',$lib['id'])->delete();
        // }
        
    }
}
