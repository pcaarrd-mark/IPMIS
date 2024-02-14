<?php

namespace App\Http\Controllers\OSEP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class OSEPProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function dashboard()
    {
        $nav = activeNav('osep_dashboard');

        $data = [
                    "nav" => $nav
                ];

        return view('osep.dashboard')->with('data',$data);
    }
    
    public function index()
    {
        $nav = activeNav('osep_project');

        $data = [
                    "nav" => $nav
                ];

        return view('osep.proponent.project')->with('data',$data);
    }

    public function index2($progid)
    {
        $nav = activeNav('osep_project');
        $programdata = getProgramDetails($progid,'title');

        $data = [
                    "nav" => $nav,
                    "progid" => $progid,
                    "program_title" => $programdata
                ];

        return view('osep.program-project')->with('data',$data);
    }


    public function updatestatus()
    {
        addHistoryLog(getStatus(request()->update_project_status),'Project',request()->update_project_id);
        App\Models\Project::where('id',request()->update_project_id)->update(['status' => request()->update_project_status]);
    }


    public function add($form,$programid)
    {
        $nav = activeNav('osep_project');
        $type = 'RD';
        switch ($form) {
            case 'option1':
                    $title = 'DOST Form 2 Detailed Project Proposal (for Basic or Applied Research)';
                    $view = view('osep.add-project');
                break;
            case 'option2':
                    $title = 'DOST Form 3. Non-R&D Project Proposal</br><small>Technology Transfer, S&T Promotion and Linkages, Policy Advocacy,
                    Provision of S&T Services, Human Resource Development and Capacity-Building</small>';
                    $type = 'NON-RD';
                    $view = view('osep.add-project-nonrd');
                break;
            case 'option3':
                    $title = 'DOST Form 2 Detailed Project Proposal (for Startups)';
                break;
        }

        $data = [
                    "nav" => $nav,
                    "title" =>  $title,
                    "program_id" => $programid,
                    "proposal_type" => $type
                ];

        return $view->with('data',$data);
    }
    public function create()
    {
        switch (request()->proposal_type) {
            case 'RD':
                    $projid = $this->createRD();
                break;
            
            case 'NON-RD':
                    $projid = $this->createNONRD();
                break;
        }

        return redirect('/osep/project/edit-view/'.$projid);
    }

    public function createRD()
    {
        $proj = new App\Models\Project;
        $proj->program_id = request()->program_title;
        $proj->title = request()->title;
        $proj->proposal_type = request()->proposal_type;
        $proj->duration_from_month = request()->slct_mon_orig_start;
        $proj->duration_from_year = request()->slct_year_orig;
        $proj->duration_to_month = request()->slct_mon_orig_end;
        $proj->duration_to_year = request()->slct_year_orig_end;
        $proj->created_by = Auth::user()->id;
        $proj->save();
        $projid = $proj->id;

        //SAVE DURATION HISTORY
        $dur = new App\Models\ProjectDuration;
        $dur->project_id = $projid;
        $dur->duration_from_month = request()->slct_mon_orig_start;
        $dur->duration_from_year = request()->slct_year_orig;
        $dur->duration_to_month = request()->slct_mon_orig_end;
        $dur->duration_to_year = request()->slct_year_orig_end;
        $dur->save();


        //PROJECT SECTION
        // $projsection = new App\Models\ProjectSection;
        // $projsection->proj_id = $projid;
        // $projsection->exec_summary = request()->exec_summary;
        // $projsection->save();

        //AGENCY
        $data = collect([]);
        $data->push([
            'project_id' => $projid,
            'agency_type' => "Implementing",
            'agency_id' => request()->implementing_agency,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if(isset(request()->coimplementing_agency))
        {
            foreach (request()->coimplementing_agency as $key => $value) {
                $data->push([
                    'project_id' => $projid,
                    'agency_type' => "Co-implementing",
                    'agency_id' => $value,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // if(isset(request()->counterpart_agency))
        // {
        //     foreach (request()->counterpart_agency as $key => $value) {
        //         $data->push([
        //             'project_id' => $projid,
        //             'agency_type' => "Counterpart",
        //             'agency_id' => $value,
        //             'created_at' => date('Y-m-d H:i:s')
        //         ]);
        //     }
        // }

        $agency = new App\Models\Project_agency;
        $agency::insert($data->all());

        
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
        $d2 = $end_year."-". request()->slct_mon_orig_end."-01";
        $yr = count_date($d1,$d2,'y');
        $mon = (count_date($d1,$d2,'m')) + 1;

        // return $mon;

        // $mons = round(($mon / 12),1);
        // $mons = explode(".",$mons);
        // $monsctr = count($mons);
        

        for ($i=1; $i <= $yr; $i++){ 
            $budget = new App\Models\LIBYear;
            $budget->project_id = $projid;
            $budget->year = $i;
            $budget->months = 12;
            $budget->save();
        }
        
        if($mon == 12)
        {
            $budget = new App\Models\LIBYear;
            $budget->project_id = $projid;
            $budget->year = $i;
            $budget->months = 12;
            $budget->save();
        }
        else
        {
            $budget = new App\Models\LIBYear;
            $budget->project_id = $projid;
            $budget->year = $i;
            $budget->months = $mon;
            $budget->save();
        }

        //HNRDA
        if(request()->project_commodity)
        {
            $sites = new App\Models\ProjectHNRDA;
            $data = collect([]);
            foreach (request()->project_commodity as $key => $value) {
                $data->push([
                                'project_id' => $projid,
                                'hnrda_id' => $value,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
            }
            $sites::insert($data->all());
        }

        if(request()->project_sdg)
        {
            $sites = new App\Models\ProjectSDGA;
            $data = collect([]);
            foreach (request()->project_sdg as $key => $value) {
                $data->push([
                                'project_id' => $projid,
                                'sdga_id' => $value,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
            }
            $sites::insert($data->all());
        }

        //ADDITIONAL DETAILS
        $otherinfo = new App\Models\ProjectSection;
        $otherinfo->project_id = $projid;
        $otherinfo->type_of_research = request()->project_type_of_research;
        //$otherinfo->sdg = request()->project_sdg;
        //$otherinfo->commodity = request()->project_commodity;
        $otherinfo->executive_summary = request()->executive_summary_content;
        $otherinfo->rationale = request()->rationale_content;
        $otherinfo->framework = request()->framework_content;
        $otherinfo->obj_general = request()->obj_general_content;
        $otherinfo->obj_specific = request()->obj_specific_content;
        $otherinfo->literature = request()->literature_content;
        $otherinfo->methodology = request()->methodology_content;
        $otherinfo->roadmap = request()->roadmap_content;
        $otherinfo->output	 = request()->output_content;
        $otherinfo->outcome = request()->outcome_content;
        $otherinfo->impact = request()->impact_content;
        $otherinfo->beneficiaries = request()->beneficiaries_content;
        $otherinfo->sustain_plan = request()->sustain_plan_content;
        $otherinfo->gad_score = request()->gad_score_content;
        $otherinfo->limitation = request()->limitation_content;
        $otherinfo->risk_management = request()->risk_management_content;
        $otherinfo->lit_cited = request()->lit_cited_content;
        $otherinfo->save();

        //PROJECT SITES
        if(request()->region_id)
        {
            $sites = new App\Models\ProjectSite;
            $data = collect([]);
            foreach (request()->region_id as $key => $value) {
                $data->push([
                                'project_id' => $projid,
                                'region_id' => $value,
                                'province_id' => request()->province_id[$key],
                                'municipal_id' => request()->municipal_id[$key],
                                'brgy_id' => request()->brgy_id[$key],
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);
            }
            $sites::insert($data->all());
        }
        


        //PROJECT PERSONNEL
        if(request()->personnel_position)
        {
            $sites = new App\Models\ProjectPersonnel;
            $data = collect([]);
            foreach (request()->personnel_position as $key => $value) {
                $data->push([
                                'project_id' => $projid,
                                'position' => $value,
                                'percent_work' => request()->personnel_percent[$key],
                                'responsibility' => request()->personnel_responsibility[$key],
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);
            }
            $sites::insert($data->all());
        }
        


        //PROJECT PERSONNEL PROJECT
        if(request()->leader_project)
        {
            $othersproject = new App\Models\ProjectOthers;
            $others = collect([]);
            foreach (request()->leader_project as $key => $value) {
                $others->push([
                                'project_id' => $projid,
                                'leader_project' => $value,
                                'leader_funding' => request()->leader_funding[$key],
                                'leader_involvement' => request()->leader_involvement[$key],
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);
            }
            $othersproject::insert($others->all());
        }   

        addHistoryLog('Project Created','Project',$projid);
        
        // if($yr1 == $yr2)
        // {
        //     $total_yr = 1;
        // }
        // else
        // {
        //     // $yr_start = \Carbon\Carbon::parse($yr1."-01-".request()->slct_mon_orig_start);
        //     // $yr_end = \Carbon\Carbon::parse($yr2."-01-".request()->slct_mon_orig_end);
        //     // $total_yr = $yr_start->diffInYears($yr_end) + 1;
        //     //return $total_yr;
        //     for ($i=$yr1; $i <= $yr2 ; $i++) { 
        //         $budget = new App\Models\LIBYear;
        //         $budget->project_id = $projid;
        //         $budget->year = $i;
        //         $budget->save();
        //     }
        // }
        
        return $projid;
    }

    public function createNONRD()
    {
        $proj = new App\Models\Project;
        $proj->program_id = request()->program_title;
        $proj->title = request()->title;
        $proj->proposal_type = request()->proposal_type;
        $proj->duration_from_month = request()->slct_mon_orig_start;
        $proj->duration_from_year = request()->slct_year_orig;
        $proj->duration_to_month = request()->slct_mon_orig_end;
        $proj->duration_to_year = request()->slct_year_orig_end;
        $proj->created_by = Auth::user()->id;
        $proj->save();
        $projid = $proj->id;


        //AGENCY
        $data = collect([]);
        $data->push([
            'project_id' => $projid,
            'agency_type' => "Implementing",
            'agency_id' => request()->implementing_agency,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if(isset(request()->coimplementing_agency))
        {
            foreach (request()->coimplementing_agency as $key => $value) {
                $data->push([
                    'project_id' => $projid,
                    'agency_type' => "Co-implementing",
                    'agency_id' => $value,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // if(isset(request()->counterpart_agency))
        // {
        //     foreach (request()->counterpart_agency as $key => $value) {
        //         $data->push([
        //             'project_id' => $projid,
        //             'agency_type' => "Counterpart",
        //             'agency_id' => $value,
        //             'created_at' => date('Y-m-d H:i:s')
        //         ]);
        //     }
        // }

        $agency = new App\Models\Project_agency;
        $agency::insert($data->all());

        
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
        $d2 = $end_year."-". request()->slct_mon_orig_end."-01";
        $yr = count_date($d1,$d2,'y');
        $mon = (count_date($d1,$d2,'m')) + 1;

        // return $mon;

        $mons = round(($mon / 12),1);
        $mons = explode(".",$mons);
        $monsctr = count($mons);
        

        for ($i=1; $i <= $yr; $i++){ 
            $budget = new App\Models\LIBYear;
            $budget->project_id = $projid;
            $budget->year = $i;
            $budget->months = 12;
            $budget->save();
        }
        
        if($mon == 12)
        {
            $budget = new App\Models\LIBYear;
            $budget->project_id = $projid;
            $budget->year = $i;
            $budget->months = 12;
            $budget->save();
        }
        else
        {
            $budget = new App\Models\LIBYear;
            $budget->project_id = $projid;
            $budget->year = $i;
            $budget->months = $mon;
            $budget->save();
        }

        // //ADDITIONAL DETAILS
        $otherinfo = new App\Models\ProjectSection;
        $otherinfo->project_id = $projid;

        foreach (getAllProjectSection([42,43,44,45,46]) as $item)
        {
            $col1 = $item->col;
            $col2 = $item->col."_content";
            $otherinfo->$col1 = request()->$col2;
        }

        $otherinfo->save();

        // $otherinfo->executive_summary = request()->executive_summary_content;
        // $otherinfo->rationale = request()->rationale_content;
        // $otherinfo->framework = request()->framework_content;
        // $otherinfo->objectives = request()->objectives_content;
        // $otherinfo->literature = request()->literature_content;
        // $otherinfo->methodology = request()->methodology_content;
        // $otherinfo->roadmap = request()->roadmap_content;
        // $otherinfo->output	 = request()->output_content;
        // $otherinfo->outcome = request()->outcome_content;
        // $otherinfo->impact = request()->impact_content;
        // $otherinfo->beneficiaries = request()->beneficiaries_content;
        // $otherinfo->sustain_plan = request()->sustain_plan_content;
        // $otherinfo->gad_score = request()->gad_score_content;
        // $otherinfo->limitation = request()->limitation_content;
        // $otherinfo->risk_management = request()->risk_management_content;
        // $otherinfo->lit_cited = request()->lit_cited_content;
        // $otherinfo->save();

        // addHistoryLog('Project Created','Project',$projid);
        
        // return redirect('/project/lib/'.$projid);
    }

    public function json(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records


        switch (Auth::user()->usertype) {
                    case 'System Administrator':
                        $totalRecords = App\Models\OSEP\View_OSEPProject::count();
                        $totalRecordswithFilter = App\Models\OSEP\View_OSEPProject::select('count(*) as allcount')
                        ->where('title', 'like', '%' .$searchValue . '%')
                        // ->where('status','<',9)
                        ->count();
            
                        // Fetch records
                        $records =  App\Models\OSEP\View_OSEPProject::orderBy($columnName,$columnSortOrder)
                            ->where('title', 'like', '%' .$searchValue . '%')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();
                    
                        break;
                    case 'ISP Manager':
                        
                        $totalRecords = App\Models\OSEP\View_OSEPProject::count();
                        $totalRecordswithFilter = App\Models\OSEP\View_OSEPProject::select('count(*) as allcount')
                        ->where('title', 'like', '%' .$searchValue . '%')
                        // ->where('status','<',9)
                        ->count();
            
                        // Fetch records
                        $records =  App\Models\OSEP\View_OSEPProject::orderBy($columnName,$columnSortOrder)
                            ->where('title', 'like', '%' .$searchValue . '%')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();
                    
                        break;
                    case 'Proponent':
                        $totalRecords = App\Models\OSEP\View_OSEPProject::count();
                        $totalRecordswithFilter = App\Models\OSEP\View_OSEPProject::select('count(*) as allcount')
                        ->where('title', 'like', '%' .$searchValue . '%')
                        // ->where('status','<',9)
                        ->where('created_by', Auth::user()->id)
                        ->count();
            
                        // Fetch records
                        $records =  App\Models\OSEP\View_OSEPProject::orderBy($columnName,$columnSortOrder)
                            ->where('title', 'like', '%' .$searchValue . '%')
                            ->where('created_by', Auth::user()->id)
                            // ->where('status','<',9)
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();
                    
                        break;
                    
            }
        

        $data_arr = array();

        foreach($records as $record){
            
            if(isset($record->duration_from_month))
            {
                $start_mon = date('F',mktime(0, 0, 0, $record->duration_from_month, 10));
                $start_year = $record->duration_from_year;
                $end_mon = date('F',mktime(0, 0, 0, $record->duration_to_month, 10));
                $end_year = $record->duration_to_year;

            
                $mon = totalmonths($record->duration_from_month,$record->duration_from_year,$record->duration_to_month,$record->duration_to_year);

                $duration = $start_mon." ".$start_year." - ".$end_mon." ".$end_year." (".$mon." months)";
            }
            else
            {
                $duration = "N/A";
            }

           

            $id = $record->id;
            $program_title = $record->program_title;
            $proposal_type = $record->proposal_type;
            $project_full_title = "<b>Program:</b> ".$record->program_title."<br><b>Project:</b> ".$record->title;
            $title = $record->title;
            $cost = number_format(getLIBDetails('total',$record->id),2);
            $duration = $duration;
            $status = getStatus($record->status);

            $button_h = '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu">';  

            $button = '<a class="dropdown-item" href="'.url("osep/project/print/".$id).'" target="_blank">Print</a><a class="dropdown-item" href="'.url("osep/history/print/Project/".$id).'" target="_blank">View History</a>';  

            $button_f = '</div></center>';   
            //$total = $record->total;

            switch (Auth::user()->usertype) {
                case 'System Administrator':
                    switch ($record->status) {
                        case 1:
                                $button = '<a class="dropdown-item" href="javascript:void(0)" onclick="approve('.$id.')">Approve</a><a class="dropdown-item" href="'.url('/project/edit/'.$id).'">Disapprove</a><a class="dropdown-item" href="'.url("/project/lib/".$id).'">View LIB</a>'.$button;
                        break;
                        case 7:
                            $button = '<a class="dropdown-item" href="javascript:void(0)" onclick="singleSendDPMIS('.$id.')">Send to DPMIS</a>'.$button;
                        break;

                        case 9:
                        case 11:
                        case 12:
                        case 13:
                        case 14:
                        case 16:
                        case 17:

                            $button = '<a class="dropdown-item" href="javascript:void(0)" onclick="updateStatusAdmin('.$id.')">Update Status</a><a class="dropdown-item" href="'.url("/project/lib/".$id).'">View LIB</a>'.$button;
                        break;
                        
                    }
                    break;

                case 'ISP Manager':
                    switch ($record->status) {
                            case 1:
                            case 2:
                            case 6:
                            case 5:
                            case 9:
                            case 11:
                            case 12:
                            case 13:
                            case 14:
                            case 16:
                            case 17:
                                $button = '<a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus('.$id.',7)">Approve</a><a class="dropdown-item" href="'.url('project/comments/'.$id).'">Add/View Comment</a><a class="dropdown-item" href="'.url("/project/lib/".$id).'">View LIB</a><a class="dropdown-item" href="'.url("/project/workplan/".$id).'" target="_blank">View Workplan</a>'.$button.'<a class="dropdown-item" href="#" onclick="frmSubmitDelete('.$id.')">Delete</a>';

                            break;
                        
                        break;
                    }
                    break;
                case 'Proponent':
                        switch ($record->status) {
                            case 1:
                            case 2:
                            case 6:
                            case 5:
                            case 9:
                            case 11:
                            case 12:
                            case 13:
                            case 14:
                            case 16:
                            case 17:
                                    $button = '<a class="dropdown-item" href="'.url('osep/project/edit-view/'.$id).'">Edit</a><a class="dropdown-item" href="'.url('/project/comments/'.$id).'">Comments</a><a class="dropdown-item" href="'.url("/project/lib/".$id).'">View/Edit LIB</a><a class="dropdown-item" href="'.url("/project/workplan/".$id).'" target="_blank">View/Edit Workplan</a><a class="dropdown-item" href="'.url('/project/edit/'.$id).'">Edit</a>'.$button.'<a class="dropdown-item" href="#" onclick="frmSubmitDelete('.$id.')">Delete</a></div></center>';
                            break;
                        }
                        
                    break;
                
            }
    
                $data_arr[] = array(
                    "id" => $id,
                    "program_title" => $program_title,
                    "title" => $project_full_title,
                    "proposal_type" => $proposal_type,
                    "cost" => $cost,
                    "duration" => $duration,
                    "status" => $status,
                    "button" => $button_h.''.$button.''.$button_f,
                );
            
         }

         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
         );
         
         return response()->json($response); 
    }

    public function json2($progid,Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records

        $totalRecords = App\Models\OSEP\View_OSEPProject::count();
            $totalRecordswithFilter = App\Models\OSEP\View_OSEPProject::select('count(*) as allcount')
            ->where('title', 'like', '%' .$searchValue . '%')
            ->where('program_id', $progid)
            ->count();

            // Fetch records
            $records =  App\Models\OSEP\View_OSEPProject::orderBy($columnName,$columnSortOrder)
                ->where('title', 'like', '%' .$searchValue . '%')
                ->where('program_id', $progid)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        

        $data_arr = array();

        foreach($records as $record){

            if(isset($record->duration_from_month))
            {
                $start_mon = date('F',mktime(0, 0, 0, $record->duration_from_month, 10));
                $start_year = $record->duration_from_year;
                $end_mon = date('F',mktime(0, 0, 0, $record->duration_to_month, 10));
                $end_year = $record->duration_to_year;

                //MONTHS
                $d1 = $start_year."-". $record->duration_from_month."-01";
                $d2 = $end_mon."-". $record->duration_to_month."-01";
                $mon = countMonths($d1,$d2);

                $duration = $start_mon." ".$start_year." - ".$end_mon." ".$end_year." (".$mon." months)";
            }
            else
            {
                $duration = "N/A";
            }
            
            $id = $record->id;
            $program_title = $record->program_title;
            $proposal_type = $record->proposal_type;
            $project_full_title = "<b>Program:</b> ".$record->program_title."<br><b>Project:</b> ".$record->title;
            $title = $record->title;
            $cost = getProjCost($record->id,null,'totalcost');
            $duration = $duration;
            $status = getStatus($record->status);
            //$total = $record->total;

            // if(isset($record->duration_from_month))
            // {
            //     $start_mon = date('F',mktime(0, 0, 0, $record->duration_from_month, 10));
            //     $start_year = $record->duration_from_year;
            //     $end_mon = date('F',mktime(0, 0, 0, $record->duration_to_month, 10));
            //     $end_year = $record->duration_to_year;

            //     //MONTHS
            //     $d1 = $start_year."-". $record->duration_from_month."-01";
            //     $d2 = $end_mon."-". $record->duration_to_month."-01";
            //     $mon = countMonths($d1,$d2);

            //     $duration = $start_mon." ".$start_year." - ".$end_mon." ".$end_year." (".$mon." months)";
            // }
            // else
            // {
            //     $duration = "N/A";
            // }
            

        
            // if($project_dur_orig == null && $project_dur_rev == null)
            // {
            //     $start_mon = "";
            //     $end_mon = "";
            //     $start_year = "";
            //     $end_year = "";
            // }
            // else
            // {
            //     if($project_dur_rev == null)
            //         $dur = explode('|',$project_dur_orig);
            //     else
            //         $dur = explode('|',$project_dur_rev); 
                
                

            //     $dur1 = explode('-',$dur[0]);
            //     $start_mon = date('F',mktime(0, 0, 0, $dur1[0], 10));
            //     $start_year = $dur1[1];
            //     $dur2 = explode('-',$dur[1]);
            //     $end_mon = date('F',mktime(0, 0, 0, $dur2[0], 10));
            //     $end_year = $dur2[1];
            // }

 
            $data_arr[] = array(
                "id" => $id,
                "program_title" => $program_title,
                "title" => $title,
                "proposal_type" => $proposal_type,
                "cost" => $cost,
                "duration" => $duration,
                "status" => $status,
            );
         }

         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
         );
 
         return response()->json($response); 

    }

    public function json3(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records

        $totalRecords = App\Models\OSEP\View_OSEPProject::count();
            $totalRecordswithFilter = App\Models\OSEP\View_OSEPProject::select('count(*) as allcount')
            ->where('title', 'like', '%' .$searchValue . '%')
            ->where('status',4)
            ->count();

            // Fetch records
            $records =  App\Models\OSEP\View_OSEPProject::orderBy($columnName,$columnSortOrder)
                ->where('title', 'like', '%' .$searchValue . '%')
                ->where('status',4)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        

        $data_arr = array();

        foreach($records as $record){

            if(isset($record->duration_from_month))
            {
                $start_mon = date('F',mktime(0, 0, 0, $record->duration_from_month, 10));
                $start_year = $record->duration_from_year;
                $end_mon = date('F',mktime(0, 0, 0, $record->duration_to_month, 10));
                $end_year = $record->duration_to_year;

                //MONTHS
                $d1 = $start_year."-". $record->duration_from_month."-01";
                $d2 = $end_mon."-". $record->duration_to_month."-01";
                $mon = countMonths($d1,$d2);

                $duration = $start_mon." ".$start_year." - ".$end_mon." ".$end_year." (".$mon." months)";
            }
            else
            {
                $duration = "N/A";
            }

            $id = $record->id;
            $program_title = $record->program_title;
            $proposal_type = $record->proposal_type;
            $project_full_title = "<b>Program:</b> ".$record->program_title."<br><b>Project:</b> ".$record->title;
            $title = $record->title;
            $cost = getProjCost($record->id);
            $duration = $duration;
            $status = getStatus($record->status);
            //$total = $record->total;

            
            

        
            // if($project_dur_orig == null && $project_dur_rev == null)
            // {
            //     $start_mon = "";
            //     $end_mon = "";
            //     $start_year = "";
            //     $end_year = "";
            // }
            // else
            // {
            //     if($project_dur_rev == null)
            //         $dur = explode('|',$project_dur_orig);
            //     else
            //         $dur = explode('|',$project_dur_rev); 
                
                

            //     $dur1 = explode('-',$dur[0]);
            //     $start_mon = date('F',mktime(0, 0, 0, $dur1[0], 10));
            //     $start_year = $dur1[1];
            //     $dur2 = explode('-',$dur[1]);
            //     $end_mon = date('F',mktime(0, 0, 0, $dur2[0], 10));
            //     $end_year = $dur2[1];
            // }

 
            $data_arr[] = array(
                "id" => $id,
                "program_title" => $program_title,
                "title" => $project_full_title,
                "proposal_type" => $proposal_type,
                "cost" => $cost,
                "duration" => $duration,
                "status" => $status,
            );
         }

         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
         );
 
         return response()->json($response); 

    }

    public function json4(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records


        switch (Auth::user()->usertype) {
                    case 'System Administrator':
                        
                    
                        break;
                    case 'ISP Manager':
                        
                        $totalRecords = App\Models\OSEP\View_OSEPByDivisionProject::where('division_id',Auth::user()->division_id)->count();
                        $totalRecordswithFilter = App\Models\OSEP\View_OSEPByDivisionProject::select('count(*) as allcount')
                        ->where('title', 'like', '%' .$searchValue . '%')
                        ->where('status','<',9)
                        ->count();
            
                        // Fetch records
                        $records =  App\Models\OSEP\View_OSEPByDivisionProject::where('division_id',Auth::user()->division_id)
                            ->where('title', 'like', '%' .$searchValue . '%')
                            ->where('status','<',9)
                            ->skip($start)
                            ->take($rowperpage)
                            ->orderBy($columnName,$columnSortOrder)
                            ->get();
                    
                        break;
                    case 'Proponent':
                        
                    
                        break;
                    
            }
        

        $data_arr = array();

        foreach($records as $record){
            
            if(isset($record->duration_from_month))
            {
                $start_mon = date('F',mktime(0, 0, 0, $record->duration_from_month, 10));
                $start_year = $record->duration_from_year;
                $end_mon = date('F',mktime(0, 0, 0, $record->duration_to_month, 10));
                $end_year = $record->duration_to_year;

                //MONTHS
                $d1 = $start_year."-". $record->duration_from_month."-01";
                $d2 = $end_year."-". $record->duration_to_month."-01";
                $mon = countMonths($d1,$d2);

                $duration = $start_mon." ".$start_year." - ".$end_mon." ".$end_year." (".$mon." months)";
            }
            else
            {
                $duration = "N/A";
            }

            $id = $record->id;
            $program_title = $record->program_title;
            $proposal_type = $record->proposal_type;
            $project_full_title = "<b>Program:</b> ".$record->program_title."<br><b>Project:</b> ".$record->title;
            $title = $record->title;
            $cost = number_format(getLIBDetails('total',$record->id),2);
            $duration = $duration;
            $status = getStatus($record->status);

            $button_h = '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu">';  

            $button = '<a class="dropdown-item" href="'.url("osep/project/print/".$id).'" target="_blank">Print</a><a class="dropdown-item" href="'.url("osep/history/print/Project/".$id).'" target="_blank">View History</a>';  

            $button_f = '</div></center>';   
            //$total = $record->total;

            switch (Auth::user()->usertype) {
                case 'System Administrator':
                    
                    break;

                case 'ISP Manager':
                    switch ($record->status) {
                        case 2:
                        case 6:
                                $button = '<a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus('.$id.',7)">Approve</a><a class="dropdown-item" href="'.url('project/comments/'.$id).'">Add/View Comment</a><a class="dropdown-item" href="'.url("/project/lib/".$id).'">View LIB</a><a class="dropdown-item" href="'.url("/project/workplan/".$id).'" target="_blank">View Workplan</a>'.$button;

                            break;
                        case 7:
                                $button = '<a class="dropdown-item" href="'.url('project/comments/'.$id).'">Add/View Comment</a><a class="dropdown-item" href="'.url("/project/lib/".$id).'">View LIB</a>'.$button;

                            break;
                        
                        break;
                    }
                    break;
                case 'Proponent':
                        
                    break;
                
            }
    
                $data_arr[] = array(
                    "id" => $id,
                    "program_title" => $program_title,
                    "title" => $project_full_title,
                    "proposal_type" => $proposal_type,
                    "cost" => $cost,
                    "duration" => $duration,
                    "status" => $status,
                    "button" => $button_h.''.$button.''.$button_f,
                );
            
         }

         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
         );
         
         return response()->json($response); 
    }

    public function jsondpmis(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records

        $totalRecords = App\Models\OSEP\View_OSEPProject::count();
            $totalRecordswithFilter = App\Models\OSEP\View_OSEPProject::select('count(*) as allcount')
            ->where('title', 'like', '%' .$searchValue . '%')
            ->where('status',8)
            ->count();

            // Fetch records
            $records =  App\Models\OSEP\View_OSEPProject::orderBy($columnName,$columnSortOrder)
                ->where('title', 'like', '%' .$searchValue . '%')
                ->where('status',8)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        

        $data_arr = array();

        foreach($records as $record){

            if(isset($record->duration_from_month))
            {
                $start_mon = date('F',mktime(0, 0, 0, $record->duration_from_month, 10));
                $start_year = $record->duration_from_year;
                $end_mon = date('F',mktime(0, 0, 0, $record->duration_to_month, 10));
                $end_year = $record->duration_to_year;

                //MONTHS
                $d1 = $start_year."-". $record->duration_from_month."-01";
                $d2 = $end_mon."-". $record->duration_to_month."-01";
                $mon = countMonths($d1,$d2);

                $duration = $start_mon." ".$start_year." - ".$end_mon." ".$end_year." (".$mon." months)";
            }
            else
            {
                $duration = "N/A";
            }

            $id = $record->id;
            $program_title = $record->program_title;
            $proposal_type = $record->proposal_type;
            $project_full_title = "<b>Program:</b> ".$record->program_title."<br><b>Project:</b> ".$record->title;
            $title = $record->title;
            $proposal_sof = $record->proposal_sof;
            $cost = getProjCost($record->id);
            $duration = $duration;
            $status = getStatus($record->status);
            //$total = $record->total;

            
            

        
            // if($project_dur_orig == null && $project_dur_rev == null)
            // {
            //     $start_mon = "";
            //     $end_mon = "";
            //     $start_year = "";
            //     $end_year = "";
            // }
            // else
            // {
            //     if($project_dur_rev == null)
            //         $dur = explode('|',$project_dur_orig);
            //     else
            //         $dur = explode('|',$project_dur_rev); 
                
                

            //     $dur1 = explode('-',$dur[0]);
            //     $start_mon = date('F',mktime(0, 0, 0, $dur1[0], 10));
            //     $start_year = $dur1[1];
            //     $dur2 = explode('-',$dur[1]);
            //     $end_mon = date('F',mktime(0, 0, 0, $dur2[0], 10));
            //     $end_year = $dur2[1];
            // }

 
            $data_arr[] = array(
                "id" => $id,
                "program_title" => $program_title,
                "title" => $project_full_title,
                "proposal_type" => $proposal_type,
                "proposal_sof" => $proposal_sof,
                "cost" => $cost,
                "duration" => $duration,
                "status" => $status,
            );
         }

         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
         );
 
         return response()->json($response); 

    }

    public function editview($projectid)
    {
        $project = App\Models\Project::where('id',$projectid)->first();
        
        //IMPLEMENTING
        $imp_agency = App\Models\Project_agency::where('project_id',$projectid)->where('agency_type','Implementing')->first();

        //COIMPLEMENTING
        $coimp_agency = App\Models\Project_agency::where('project_id',$projectid)->where('agency_type','Co-implementing')->get();
        // $coimp = "";
        // foreach ($coimp_agency as $key => $value) {
        //     $coimp .= $value->agency_id.",";
        // }
        // $coimp = substr($coimp, 0, -1);

        $hnrda = App\Models\ProjectHNRDA::where('project_id',$projectid)->get();
        $hnrda_list = "";
        foreach ($hnrda as $key => $value) {
            $hnrda_list .= $value->hnrda_id.",";
        }
        $hnrda_list = substr($hnrda_list, 0, -1);

        $sdga = App\Models\ProjectSDGA::where('project_id',$projectid)->get();
        $sdga_list = "";
        foreach ($sdga as $key => $value) {
            $sdga_list .= $value->sdga_id.",";
        }
        $sdga_list = substr($sdga_list, 0, -1);

        $nav = activeNav('osep_project');
        $data = [
            'nav' =>  $nav,
            'type_of_research' => getAllProjectContent($projectid,8,'type_of_research'),
            'imp_agency' => $imp_agency['agency_id'],
            'coimp_agency' => $coimp_agency,
            'hnrda' => $hnrda_list,
            'sdga' => $sdga_list,
            'project' => $project,
        ];
        return view('osep.proponent.edit-project')->with('data',$data);
    }

    public function update(Request $request)
    {
        //UPDATE
        $project = App\Models\Project::where('id',request()->project_id)->update([
            "program_id" => request()->program_id,
            "title" => request()->title,
        ]);

        //IMPLEMENING
        //DELETE PREVIOUS
        $imp = App\Models\Project_agency::where('project_id',request()->project_id)->delete();
        
        //AGENCY
        $data = collect([]);
        $data->push([
            'project_id' => request()->project_id,
            'agency_type' => "Implementing",
            'agency_id' => request()->implementing_agency,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if(isset(request()->coimplementing_agency))
        {
            foreach (request()->coimplementing_agency as $key => $value) {
                $data->push([
                    'project_id' => request()->project_id,
                    'agency_type' => "Co-implementing",
                    'agency_id' => $value,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // if(isset(request()->counterpart_agency))
        // {
        //     foreach (request()->counterpart_agency as $key => $value) {
        //         $data->push([
        //             'project_id' => request()->project_id,
        //             'agency_type' => "Counterpart",
        //             'agency_id' => $value,
        //             'created_at' => date('Y-m-d H:i:s')
        //         ]);
        //     }
        // }

        $agency = new App\Models\Project_agency;
        $agency::insert($data->all());

        //OTHER DETAILS
        $other = App\Models\ProjectSection::where('project_id',request()->project_id)->delete();

        $othersection = new App\Models\ProjectSection;
        $othersection->project_id = request()->project_id;
        $othersection->type_of_research = request()->project_type_of_research;
        //$othersection->commodity = request()->project_commodity;
        //$othersection->sdg = request()->project_sdg;

        foreach (getAllProjectSection([11,12,13,14,15,16,17,18,19,20,21,23,24,25,26,28,29]) as $item)
        {
            $col = $item->col;
            $othersection->$col = $request[$item->col."_content"];
        }
        $othersection->save();

        
        if(request()->region_id)
        {
            //SITE
            $site = App\Models\ProjectSite::where('project_id',request()->project_id)->delete();
            $sites = new App\Models\ProjectSite;
            $data = collect([]);

            foreach (request()->region_id as $key => $value) {
                $data->push([
                                'project_id' => request()->project_id,
                                'region_id' => $value,
                                'province_id' => request()->province_id[$key],
                                'municipal_id' => request()->municipal_id[$key],
                                'brgy_id' => request()->brgy_id[$key],
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);
            }
            $sites::insert($data->all());
        }
        

        //PERSONNEL
        if(request()->personnel_position)
        {
            $personnel = App\Models\ProjectPersonnel::where('project_id',request()->project_id)->delete();
            $personnel = new App\Models\ProjectPersonnel;
            $data = collect([]);
            foreach (request()->personnel_position as $key => $value) {
                $data->push([
                                'project_id' => request()->project_id,
                                'position' => $value,
                                'percent_work' => request()->personnel_percent[$key],
                                'responsibility' => request()->personnel_responsibility[$key],
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);
            }
            $personnel::insert($data->all());
        }
        
        if(request()->leader_project)
        {
            //PROJECT PERSONNEL PROJECT
            $othersproject = App\Models\ProjectOthers::where('project_id',request()->project_id)->delete();
            $othersproject = new App\Models\ProjectOthers;
            $others = collect([]);
            foreach (request()->leader_project as $key => $value) {
                $others->push([
                                'project_id' => request()->project_id,
                                'leader_project' => $value,
                                'leader_funding' => request()->leader_funding[$key],
                                'leader_involvement' => request()->leader_involvement[$key],
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);
            }
            $othersproject::insert($others->all());
        }

        
        //HNRDA
        if(request()->project_commodity)
        {
            App\Models\ProjectHNRDA::where('project_id',request()->project_id)->delete();
            $hnrda = new App\Models\ProjectHNRDA;
            $data = collect([]);
            foreach (request()->project_commodity as $key => $value) {
                $data->push([
                                'project_id' => request()->project_id,
                                'hnrda_id' => $value,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
            }
            $hnrda::insert($data->all());
        }

        if(request()->project_sdg)
        {
            App\Models\ProjectSDGA::where('project_id',request()->project_id)->delete();
            $sdga = new App\Models\ProjectSDGA;
            $data = collect([]);
            foreach (request()->project_sdg as $key => $value) {
                $data->push([
                                'project_id' => request()->project_id,
                                'sdga_id' => $value,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
            }
            $sdga::insert($data->all());
        }
        


        // $project = App\Models\Project::where('id',$projectid)->first();
        
        // //IMPLEMENTING
        // $imp_agency = App\Models\Project_agency::where('project_id',$projectid)->where('agency_type','Implementing')->first();

        // //COIMPLEMENTING
        // $coimp_agency = App\Models\Project_agency::where('project_id',$projectid)->where('agency_type','Co-implementing')->get();
        // $coimp = "";
        // foreach ($coimp_agency as $key => $value) {
        //     $coimp .= $value->agency_id.",";
        // }
        // $coimp = substr($coimp, 0, -1);
        // $nav = activeNav('osep_project');
        // $data = [
        //     'nav' =>  $nav,
        //     'type_of_research' => getAllProjectContent($projectid,8,'type_of_research'),
        //     'imp_agency' => $imp_agency['agency_id'],
        //     'coimp_agency' => $coimp,
        //     'project' => $project,
        // ];
        // return view('osep.proponent.edit-project')->with('data',$data);
    }

    public function totalmonths($monstart = 0,$yearstart = 0,$monend = 0,$yearend = 0)
    {
        $data = ['totalmonths' => totalmonths($monstart,$yearstart,$monend,$yearend)];
        return json_encode($data);   
    }

}  
