<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $nav = activeNav('project');

        $data = [
                    "nav" => $nav
                ];

        return view('bp202.project')->with('data',$data);
    }

    public function new()
    {
        //return redirect('/');
        $nav = activeNav('project');

        $data = [
                    "nav" => $nav
                ];

        return view('bp202.add-new-project')->with('data',$data);
        
    }

    public function edit($id)
    {
        //CHECK IF USER IS THE CREATOR
        $proj = App\Models\BP202\BP202_Project::where('id',$id)->where('created_by_userid',Auth::user()->id)->first();
        if(isset($proj))
        {
            $nav = activeNav('project');

            //GET CATEGORIZATION, NAKATEXT KASI KAYA NEED CONVERT SA ARRAY
            $category = explode(',',$proj['categorization']);

            //DURATION
            $orig_start_mon = null;
            $orig_start_year = null;
            $orig_end_mon = null;
            $orig_end_year = null;
            $rev_start_mon = null;
            $rev_start_year = null;
            $rev_end_mon = null;
            $rev_end_year = null;

            //START
            if(isset($proj['project_dur_orig']))
            {
                $dur1 = explode('|',$proj['project_dur_orig']);
                $dt1 = explode('-',$dur1[0]);
                $orig_start_mon = $dt1[0];
                $orig_start_year = $dt1[1];
                $dt2 = explode('-',$dur1[1]);
                $orig_end_mon = $dt2[0];
                $orig_end_year = $dt2[1];

                $y1 = $orig_start_year;
                $y2 = $orig_start_year + 1;
                $y3 = $orig_start_year + 2;
            }
            //END
            if(isset($proj['project_dur_rev']))
            {
                $dur2 = explode('|',$proj['project_dur_rev']);
                $dt3 = explode('-',$dur2[0]);
                $rev_start_mon = $dt3[0];
                $rev_start_year = $dt3[1];
                $dt4 = explode('-',$dur2[1]);
                $rev_end_mon = $dt4[0];
                $rev_end_year = $dt4[1];

                $y1 = $rev_start_year;
                $y2 = $rev_start_year + 1;
                $y3 = $rev_start_year + 2;
            }
            if(!isset($proj['project_dur_rev']) && !isset($proj['project_dur_orig']))
            {
                $y1 = date('Y') + 1;
                $y2 = date('Y') + 2;
                $y3 = date('Y') + 3;
            }
            

            //PRE-REQUISITE
            $app_auth = App\Models\BP202\BP202_approve_auth::where('project_id',$id)->get();
            //$app_auth = App\Models\Library\Approving_authority::get();

            $withauth = false;

            $preq[] = array();

            foreach ($app_auth as $key => $value) {
                $preq[$key] = $value;
                $withauth = true;
                //array_push($preq, $value);
            }

            //12.1. PAP ATTRIBUTION BY EXPENSE CLASS
            $pap_exp = App\Models\BP202\BP202_Project_PAP_Attribution::where('project_id',$id)->get();
            if(count($pap_exp) > 0)
            {
                $pap_exp_code = App\Models\BP202\BP202_Project_PAP_Attribution::where('project_id',$id)->first();
                $pap_exp_code = $pap_exp_code['pap_code'];
            }
            else
            {
                $pap_exp_code = NULL;
            }


            //12.4. REQUIREMENTS FOR OPERATING COST OF INFRASTRUCTURE PROJECT
            $pap_infra = App\Models\BP202\BP202_Project_PAP_Infra::where('project_id',$id)->get();
            if(count($pap_infra) > 0)
            {
                $pap_infra_code = App\Models\BP202\BP202_Project_PAP_Infra::where('project_id',$id)->first();
                $pap_infra_code = $pap_infra_code['pap_code'];
            }
            else
            {
                $pap_infra_code = NULL;
            }

            //TOTAL PROJECT COST
            $proj_cost = App\Models\BP202\BP202_total_proj_cost::where('project_id',$id)->get();
            if(count($proj_cost) == 0)
            {
                $proj_cost = [];
            }


            //COSTING BY COMPONENT(S)
            $proj_comp = App\Models\BP202\BP202_cost_by_comp::where('project_id',$id)->get();
            if(count($proj_comp) == 0)
            {
                $proj_comp = [];
            }

            //COSTING BY COMPONENT(S)
            $proj_loc = App\Models\BP202\BP202_loc_by_imp::where('project_id',$id)->get();
            if(count($proj_loc) == 0)
            {
                $proj_loc = [];
            }
            

            //12.1. PAP ATTRIBUTION BY EXPENSE CLASS
            $target_accomp = App\Models\BP202\BP202_Project_Target_Accomp::where('project_id',$id)->get();

            //$coimp = explode(',',$proj['coimplementing_agency']);

            $data = [
                        "nav" => $nav,
                        "info" => $proj,
                        "y1" => $y1,
                        "y2" => $y2,
                        "y3" => $y3,
                        "category" => $category,
                        "coimp" => $proj['coimplementing_agency'],
                        "orig_start_mon" => $orig_start_mon,
                        "orig_start_year" => $orig_start_year,
                        "orig_end_mon" => $orig_end_mon,
                        "orig_end_year" => $orig_end_year,
                        "rev_start_mon" => $rev_start_mon,
                        "rev_start_year" => $rev_start_year,
                        "rev_end_mon" => $rev_end_mon,
                        "rev_end_year" => $rev_end_year,
                        "withauth" => $withauth,
                        "app_auth" => $preq,

                        "pap_exp" => $pap_exp,
                        "pap_exp_code" => $pap_exp_code,

                        "pap_infra" => $pap_infra,
                        "pap_infra_code" => $pap_infra_code,

                        "target_accomp" => $target_accomp,
                        "proj_cost" => $proj_cost,
                        "proj_comp" => $proj_comp,
                        "proj_loc" => $proj_loc,
                    ];

            return view('bp202.edit-project')->with('data',$data);
        }
        else
        {
            return redirect('/project');
        }
        
    }

    public function update()
    {
        $categ = "";
        foreach (request()->categorization as $catsindx => $cats) {
            $categ .= $cats.",";
        }


        $coemp = "";
        if(isset(request()->coimplementing_agency))
        {
            foreach (request()->coimplementing_agency as $cokey => $coemps) {
                $coemp .= $coemps.",";
            }
        }

        //REMOVE LAST COMMA
        $coemp = substr($coemp, 0, -1);
        $categ = substr($categ, 0, -1);

        //DURATION
        $project_dur_orig = null;
        $project_dur_rev = null;

        if(request()->slct_mon_orig_start != null && request()->slct_year_orig != null && request()->slct_mon_orig_end != null && request()->slct_year_orig_end != null)
        {
            $project_dur_orig = request()->slct_mon_orig_start."-".request()->slct_year_orig."|".request()->slct_mon_orig_end."-".request()->slct_year_orig_end;
            $y1 = request()->slct_year_orig;
            $y2 = request()->slct_year_orig_end;
        }
            

        if(request()->slct_mon_rev_start != null && request()->slct_year_rev != null && request()->slct_mon_rev_end != null && request()->slct_year_rev_end != null)
        {
            $project_dur_rev = request()->slct_mon_rev_start."-".request()->slct_year_rev."|".request()->slct_mon_rev_end."-".request()->slct_year_rev_end;
            $y1 = request()->slct_year_rev;
            $y2 = request()->slct_year_rev_end;
        }

        $proj = App\Models\BP202\BP202_Project::where('id',request()->project_id)
                ->update([
                    'program_title' => request()->program_title,
                    'project_title' => request()->project_title,
                    'project_cost' => request()->project_cost,
                    // 'monitoring_division' => request()->monitoring_division,
                    'proposal_type' => request()->proposal_type,
                    'implementing_agency' => request()->implementing_agency,
                    'coimplementing_agency' => $coemp,
                    'project_ranking' => request()->project_ranking,
                    'pip_code' => request()->pip_code,
                    'project_desc' => request()->project_desc,
                    'project_purpose' => request()->project_purpose,
                    'project_benificiaries' => request()->project_benificiaries,
                    'categorization' => $categ,
                    'project_dur_orig' => $project_dur_orig,
                    'project_dur_rev' => $project_dur_rev,
                ]);

        //DELETE PREVIOUS DATA MUNA 
        //APPROVING AUTHORITIES
        App\Models\BP202\BP202_approve_auth::where('project_id',request()->project_id)->delete();
        
        
        //THEN INSERT NEW
        $app_auth = App\Models\Library\Approving_authority::get();

        foreach ($app_auth as $key => $value) {
            $n = "appauth_".$value->id;
            $remarks = "appauth_".$value->id."_remarks";

            if(request()->$n != null)
            {
                $auth = new App\Models\BP202\BP202_approve_auth;
                $auth->project_id = request()->project_id;
                $auth->approv_auth_id = $value->id;
                $auth->approv_auth_radio = request()->$n;
                $auth->approv_auth_remarks = request()->$remarks;
                $auth->save();
            }
            
        }

        //PAP ATTRIBUTION BY EXPENSE CLASS
        App\Models\BP202\BP202_pap_attribution::where('project_id',request()->project_id)->delete();

        //REQUIREMENTS FOR OPERATING COST OF INFRASTRUCTURE PROJECT
        App\Models\BP202\BP202_opt_cost_infra::where('project_id',request()->project_id)->delete();

        //PHYSICAL ACCOMPLISHMENTS & TARGETS
        App\Models\BP202\BP202_target_accomp::where('project_id',request()->project_id)->delete();

        //PHYSICAL ACCOMPLISHMENTS & TARGETS
        App\Models\BP202\BP202_total_proj_cost::where('project_id',request()->project_id)->delete();

        //12.5. COSTING BY COMPONENT(S)
        App\Models\BP202\BP202_cost_by_comp::where('project_id',request()->project_id)->delete();
        
        //LOCATION BY IMPLEMENTATION
        App\Models\BP202\BP202_loc_by_imp::where('project_id',request()->project_id)->delete();

        //12.3. TOTAL PROJECT COST
        if(isset(request()->project_expense))
        {
            foreach (request()->project_expense as $keyexp => $exps) {
                # code...
                $cost = new App\Models\BP202\BP202_total_proj_cost;
                $cost->project_id = request()->project_id;
                $cost->expense_sub = $exps;
                $cost->val = request()->project_cost_amt[$keyexp];
                $cost->save();
                
            }
        }

        //12.5. COSTING BY COMPONENT(S)
        if(request()->project_comp)
        {
            foreach (request()->project_comp as $keycomp => $comps) {
                # code...
                $comp = new App\Models\BP202\BP202_cost_by_comp;
                $comp->project_id = request()->project_id;
                $comp->comps = $comps;
                $comp->ps = request()->project_comp_ps[$keycomp];
                $comp->mooe = request()->project_comp_mooe[$keycomp];
                $comp->co = request()->project_comp_co[$keycomp];
                $comp->finex = request()->project_comp_finex[$keycomp];
                $comp->save();
                
            }
        }

        //12.5. COSTING BY COMPONENT(S)
        if(request()->project_loc)
        {
            foreach (request()->project_loc as $keyloc => $locs) {
                # code...
                $loc = new App\Models\BP202\BP202_loc_by_imp;
                $loc->project_id = request()->project_id;
                $loc->locs = $locs;
                $loc->ps = request()->project_loc_ps[$keyloc];
                $loc->mooe = request()->project_loc_mooe[$keyloc];
                $loc->co = request()->project_loc_co[$keyloc];
                $loc->finex = request()->project_loc_finex[$keyloc];
                $loc->save();
                
            }
        }
        


        for ($i=0; $i <= 2 ; $i++) 
        {   
            $ind = $i + 1;
            //PAP ATTRIBUTION BY EXPENSE CLASS
            if(isset(request()->project_pap))
            {
                $pro_yr = "project_pap_yr".$ind;
                foreach (request()->project_pap as $keypap => $paps)
                {
                    # code...
                    //echo request()->$pro_yr[$keypap]."-".$keypap."<br>";
                    
                    if(request()->$pro_yr[$keypap] != null)
                    {
                        $pap = new App\Models\BP202\BP202_pap_attribution;
                        $pap->project_id = request()->project_id;
                        $pap->pap_sub = $paps;
                        $pap->pap_code = request()->project_pap_code;
                        $pap->yr = $y1 + $i;
                        $pap->val = request()->$pro_yr[$keypap];
                        $pap->save();
                    }
                    
                }
            }

            //REQUIREMENTS FOR OPERATING COST OF INFRASTRUCTURE PROJECT
            if(isset(request()->project_infra))
            {
                $pro_yr = "project_infra_yr".$ind;
                foreach (request()->project_infra as $keyinfra => $infras) {
                    # code...
                    if(request()->$pro_yr[$keyinfra] != null)
                    {
                        $inf = new App\Models\BP202\BP202_opt_cost_infra;
                        $inf->project_id = request()->project_id;
                        $inf->pap_code = request()->project_pap_code_infra;
                        $inf->infra_sub = $infras;
                        $inf->yr = $y1 + $i;
                        $inf->val = request()->$pro_yr[$keyinfra];
                        $inf->save();
                    }
                    
                }
            }

            //PHYSICAL ACCOMPLISHMENTS & TARGETS
            if(isset(request()->project_accomp))
            {
                $pro_yr = "project_accomp_yr".$ind;
                foreach (request()->project_accomp as $keyaccomp => $accomps) {
                    # code...
                    if(request()->$pro_yr[$keyaccomp] != null)
                    {
                        $accom = new App\Models\BP202\BP202_target_accomp;
                        $accom->project_id = request()->project_id;
                        $accom->accom = $accomps;
                        $accom->yr = $y1 + $i;
                        $accom->val = request()->$pro_yr[$keyaccomp];
                        $accom->save();
                    }
                    
                }
            }
            
            
        }

        //ETO YUNG YEAR 1-3

        //SAVE AUDIT TRAIL
        auditTrail("User : ".Auth::user()->name." -- Updated Project : ".request()->project_id);
    }

    public function create()
    {

        //return request()->proposal_type;

        //DURATION
        $project_dur_orig = null;
        $project_dur_rev = null;

        if(request()->slct_mon_orig_start != null && request()->slct_year_orig != null && request()->slct_mon_orig_end != null && request()->slct_year_orig_end != null)
        {
            $project_dur_orig = request()->slct_mon_orig_start."-".request()->slct_year_orig."|".request()->slct_mon_orig_end."-".request()->slct_year_orig_end;
            $y1 = request()->slct_year_orig;
            $y2 = request()->slct_year_orig_end;
        }
            

        if(request()->slct_mon_rev_start != null && request()->slct_year_rev != null && request()->slct_mon_rev_end != null && request()->slct_year_rev_end != null)
        {
            $project_dur_rev = request()->slct_mon_rev_start."-".request()->slct_year_rev."|".request()->slct_mon_rev_end."-".request()->slct_year_rev_end;
            $y1 = request()->slct_year_rev;
            $y2 = request()->slct_year_rev_end;
        }
        
        $categ = "";
        foreach (request()->categorization as $catsindx => $cats) {
            $categ .= $cats.",";
        }

        $coemp = "";
        if(isset(request()->coimplementing_agency))
        {
            foreach (request()->coimplementing_agency as $cokey => $coemps) {
                $coemp .= $coemps.",";
            }
        }
        

        //REMOVE LAST COMMA
        $coemp = substr($coemp, 0, -1);
        $categ = substr($categ, 0, -1);
        

        $project = new App\Models\BP202\BP202_Project;
        $project->period = (date('Y') + 1) . "-" . (date('Y') + 3);
        $project->program_title = request()->program_title;
        $project->project_title = request()->project_title;
        $project->project_cost = request()->project_cost;
        $project->project_dur_orig = $project_dur_orig;
        $project->project_dur_rev = $project_dur_rev;
        // $project->monitoring_division = request()->monitoring_division;
        $project->proposal_type = request()->proposal_type;
        $project->implementing_agency = request()->implementing_agency;
        $project->coimplementing_agency = $coemp;
        $project->project_ranking = request()->project_ranking;
        $project->categorization = $categ;
        $project->pip_code = request()->pip_code;
        $project->project_desc = request()->project_desc;
        $project->project_purpose = request()->project_purpose;
        $project->project_benificiaries = request()->project_benificiaries;
        $project->created_by = Auth::user()->name;
        $project->created_by_userid = Auth::user()->id;
        $project->created_by_division= Auth::user()->division_id;
        $project->save();
        $project_id = $project->id;

        //APPROVING AUTHORITIES
        $app_auth = App\Models\Library\Approving_authority::get();

        foreach ($app_auth as $key => $value) {
            $n = "appauth_".$value->id;
            $remarks = "appauth_".$value->id."_remarks";

            if(request()->$n != null)
            {
                $auth = new App\Models\BP202\BP202_approve_auth;
                $auth->project_id = $project_id;
                $auth->approv_auth_id = $value->id;
                $auth->approv_auth_radio = request()->$n;
                $auth->approv_auth_remarks = request()->$remarks;
                $auth->save();
            }
            
        }
        
        //ETO YUNG MAY MGA YEAR 1-3 SA TABLE

        for ($i=0; $i <= 2 ; $i++) 
        { 
            
            $ind = $i + 1;

            //PAP ATTRIBUTION BY EXPENSE CLASS
            if(request()->project_pap)
            {
                $pro_yr = "project_pap_yr".$ind;
                foreach (request()->project_pap as $keypap => $paps) {
                    # code...
                    //echo request()->$pro_yr[$keypap]."-".$keypap."<br>";
                    
                    if(request()->$pro_yr[$keypap] != null)
                    {
                        $pap = new App\Models\BP202\BP202_pap_attribution;
                        $pap->project_id = $project_id;
                        $pap->pap_sub = $paps;
                        $pap->pap_code = request()->project_pap_code;
                        $pap->yr = $y1 + $i;
                        $pap->val = request()->$pro_yr[$keypap];
                        $pap->save();
                    }
                    
                }
            }
            

            //PHYSICAL ACCOMPLISHMENTS & TARGETS
            if(request()->project_accomp )
            {
                $pro_yr = "project_accomp_yr".$ind;
                foreach (request()->project_accomp as $keyaccomp => $accomps) {
                    # code...
                    if(request()->$pro_yr[$keyaccomp] != null)
                    {
                        $accom = new App\Models\BP202\BP202_target_accomp;
                        $accom->project_id = $project_id;
                        $accom->accom = $accomps;
                        $accom->yr = $y1 + $i;
                        $accom->val = request()->$pro_yr[$keyaccomp];
                        $accom->save();
                    }
                    
                }
            }
            


            //REQUIREMENTS FOR OPERATING COST OF INFRASTRUCTURE PROJECT
            if(request()->project_infra)
            {
                $pro_yr = "project_infra_yr".$ind;
                foreach (request()->project_infra as $keyinfra => $infras) {
                    # code...
                    if(request()->$pro_yr[$keyinfra] != null)
                    {
                        $inf = new App\Models\BP202\BP202_opt_cost_infra;
                        $inf->project_id = $project_id;
                        $inf->pap_code = request()->project_pap_code_infra;
                        $inf->infra_sub = $infras;
                        $inf->yr = $y1 + $i;
                        $inf->val = request()->$pro_yr[$keyinfra];
                        $inf->save();
                    }
                    
                }
            }
            
            
        }

        //ETO YUNG YEAR 1-3

        //12.3. TOTAL PROJECT COST
        if(request()->project_expense )
        {
            foreach (request()->project_expense as $keyexp => $exps) {
                # code...
                $cost = new App\Models\BP202\BP202_total_proj_cost;
                $cost->project_id = $project_id;
                $cost->expense_sub = $exps;
                $cost->val = request()->project_cost_amt[$keyexp];
                $cost->save();
                
            }
        }
        


        //12.5. COSTING BY COMPONENT(S)
        if(request()->project_comp)
        {
            foreach (request()->project_comp as $keycomp => $comps) {
                # code...
                $comp = new App\Models\BP202\BP202_cost_by_comp;
                $comp->project_id = $project_id;
                $comp->comps = $comps;
                $comp->ps = request()->project_comp_ps[$keycomp];
                $comp->mooe = request()->project_comp_mooe[$keycomp];
                $comp->co = request()->project_comp_co[$keycomp];
                $comp->finex = request()->project_comp_finex[$keycomp];
                $comp->save();
                
            }
        }
        

        //12.5. COSTING BY COMPONENT(S)
        if(request()->project_loc)
        {
            foreach (request()->project_loc as $keyloc => $locs) {
                # code...
                $loc = new App\Models\BP202\BP202_loc_by_imp;
                $loc->project_id = $project_id;
                $loc->locs = $locs;
                $loc->ps = request()->project_loc_ps[$keyloc];
                $loc->mooe = request()->project_loc_mooe[$keyloc];
                $loc->co = request()->project_loc_co[$keyloc];
                $loc->finex = request()->project_loc_finex[$keyloc];
                $loc->save();
                
            }
        }
        


        //SAVE AUDIT TRAIL
        auditTrail("User : ".Auth::user()->name." -- Created Project : ".request()->project_title);

        return redirect(request()->frm_url_reset);
        
    }

    public function delete()
    {
        App\Models\BP202\BP202_Project::where('id',request()->project_id)->update([
            "deleted_by" => Auth::user()->id,
            "deleted_at" => date('Y-m-d H:i:s')
        ]);

        //SAVE AUDIT TRAIL
        auditTrail("User : ".Auth::user()->name." -- Deleted Project : ".request()->project_id);
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

        //IF ADMIN
        if(Auth::user()->usertype == 'System Administrator')
        {
            $totalRecords = App\Models\BP202\BP202_Project::count();
            $totalRecordswithFilter = App\Models\BP202\BP202_Project::select('count(*) as allcount')
            ->where('project_title', 'like', '%' .$searchValue . '%')
            ->whereNull('deleted_at')->count();

            // Fetch records
            $records = App\Models\BP202\BP202_Project::orderBy($columnName,$columnSortOrder)
                ->where('project_title', 'like', '%' .$searchValue . '%')
                ->whereNull('deleted_at')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }
        else
        {
            $totalRecords = App\Models\BP202\BP202_Project::count();
            $totalRecordswithFilter = App\Models\BP202\BP202_Project::select('count(*) as allcount')
            ->where('project_title', 'like', '%' .$searchValue . '%')
            ->where('created_by_division',Auth::user()->division_id)
            ->whereNull('deleted_at')->count();

            // Fetch records
            $records = App\Models\BP202\BP202_Project::orderBy($columnName,$columnSortOrder)
                ->where('project_title', 'like', '%' .$searchValue . '%')
                ->where('created_by_division',Auth::user()->division_id)
                ->whereNull('deleted_at')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }
        

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $project_title = $record->project_title;
            $proposal_type = $record->proposal_type;
            $project_cost = $record->project_cost;
            $project_dur_orig = $record->project_dur_orig;
            $project_dur_rev = $record->project_dur_rev;
            $created_by = $record->created_by;
            $created_at = $record->created_at;
            $division = getLibraryDesc('division',$record->created_by_division,'acronym');

        
            if($project_dur_orig == null && $project_dur_rev == null)
            {
                $start_mon = "";
                $end_mon = "";
                $start_year = "";
                $end_year = "";
            }
            else
            {
                if($project_dur_rev == null)
                    $dur = explode('|',$project_dur_orig);
                else
                    $dur = explode('|',$project_dur_rev); 
                
                

                $dur1 = explode('-',$dur[0]);
                $start_mon = date('F',mktime(0, 0, 0, $dur1[0], 10));
                $start_year = $dur1[1];
                $dur2 = explode('-',$dur[1]);
                $end_mon = date('F',mktime(0, 0, 0, $dur2[0], 10));
                $end_year = $dur2[1];
            }

            //YEAR1
            $pap_exp = App\Models\BP202\BP202_pap_attribution::where('project_id',$record->id)->where('yr',(date('Y')+1))->get();
            $yr1_cost = 0;
            if(count($pap_exp) > 0)
                {
                    foreach ($pap_exp as $key => $pap_exps) {
                        $yr1_cost += $pap_exps->val;
                        //$totalyear1 += convertAmount($pap_exps->val);
                    }
                    $yr1_cost = convertAmount($yr1_cost);
                }

            //$totalprojcost = $project_cost.''.'000';
            $totalprojcost = $yr1_cost;
 
            $data_arr[] = array(
                "id" => $id,
                "project_title" => $project_title,
                "proposal_type" => $proposal_type,
                "project_cost" => number_format($totalprojcost),
                "project_dur_orig" => $start_mon." ".$start_year." - ".$end_mon." ".$end_year,
                "created_by" => $created_by,
                "created_at" => $created_at,
                "division" => $division,
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


    public function jsonranking(Request $request)
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

            $totalRecords = App\Models\BP202\BP202_Project::count();
            $totalRecordswithFilter = App\Models\BP202\BP202_Project::select('count(*) as allcount')
            ->where('project_title', 'like', '%' .$searchValue . '%')
            ->whereNull('deleted_at')
            ->orderBy('project_ranking')
            ->count();

            // Fetch records
            $records = App\Models\BP202\BP202_Project::orderBy($columnName,$columnSortOrder)
                ->where('project_title', 'like', '%' .$searchValue . '%')
                ->whereNull('deleted_at')
                ->skip($start)
                ->take($rowperpage)
                ->orderBy('project_ranking')
                ->get();
        

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $project_ranking = $record->project_ranking;
            $project_title = $record->project_title;
            $proposal_type = $record->proposal_type;
            $project_cost = $record->project_cost;
            $project_dur_orig = $record->project_dur_orig;
            $project_dur_rev = $record->project_dur_rev;
            $created_by = $record->created_by;
            $created_at = $record->created_at;
            $division = getLibraryDesc('division',$record->created_by_division,'acronym');

        
            if($project_dur_orig == null && $project_dur_rev == null)
            {
                $start_mon = "";
                $end_mon = "";
                $start_year = "";
                $end_year = "";
            }
            else
            {
                if($project_dur_rev == null)
                    $dur = explode('|',$project_dur_orig);
                else
                    $dur = explode('|',$project_dur_rev); 
                
                

                $dur1 = explode('-',$dur[0]);
                $start_mon = date('F',mktime(0, 0, 0, $dur1[0], 10));
                $start_year = $dur1[1];
                $dur2 = explode('-',$dur[1]);
                $end_mon = date('F',mktime(0, 0, 0, $dur2[0], 10));
                $end_year = $dur2[1];
            }

            //YEAR1
            $pap_exp = App\Models\BP202\BP202_pap_attribution::where('project_id',$record->id)->where('yr',2024)->get();
            $yr1_cost = 0;
            if(count($pap_exp) > 0)
                {
                    foreach ($pap_exp as $key => $pap_exps) {
                        $yr1_cost += $pap_exps->val;
                        //$totalyear1 += convertAmount($pap_exps->val);
                    }
                    $yr1_cost = convertAmount($yr1_cost);
                }

            //$totalprojcost = $project_cost.''.'000';
            $totalprojcost = $yr1_cost;
 
            $data_arr[] = array(
                "id" => $id,
                "project_ranking" => $project_ranking,
                "project_title" => $project_title,
                "proposal_type" => $proposal_type,
                "project_cost" => number_format($totalprojcost),
                "project_dur_orig" => $start_mon." ".$start_year." - ".$end_mon." ".$end_year,
                "created_by" => $created_by,
                "created_at" => $created_at,
                "division" => $division,
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

    public function print($project_id)
    {
        //BASIC INFO
        $projinfo = App\Models\BP202\BP202_Project::where('id',$project_id)->first();

        //AGENCY
        $agency = getLibraryDesc('agency',$projinfo['implementing_agency'],'acronym');
        //CO-IMPLEMENTING
        $coimp = explode(',',$projinfo['coimplementing_agency']);
        foreach ($coimp as $key => $value) {
            $agency .= ",".getLibraryDesc('agency',$value,'acronym');
        }


        //APPROVING AUTHORITIES
        $appauth = "";
        foreach (showAppAuth() as $item)
        {
            $chk_yes = "&#9723;";
            $chk_no = "&#9723;";
            $chk_na = "&#9723;";
            $rem = "";

            $chk_auth = getAppAuthVal($project_id,$item->id,'radio');
            $rem = getAppAuthVal($project_id,$item->id,'remarks');
            switch ($chk_auth) {
                case 'YES':
                        $chk_yes = "&#9724;";
                    break;
                case 'NO':
                        $chk_no = "&#9724;";
                    break;
                case 'NA':
                        $chk_na = "&#9724;";
                    break;
            }

            $appauth .= '<tr>
                            <td style="font-size:10px;width:10%;vertical-align: top;">
                                '.$item->description.'
                            </td>
                            <td style="font-size:10px;width:10%;vertical-align: top;" align="center">
                                '.$chk_yes.'
                            </td>
                            <td style="font-size:10px;width:10%;vertical-align: top;" align="center">
                                '.$chk_no.'
                            </td>
                            <td style="font-size:10px;width:10%;vertical-align: top;" align="center">
                                '.$chk_na.'
                            </td>
                            <td style="font-size:10px;width:10%;vertical-align: top;" align="center">
                                '.$rem.'
                            </td>
                        </tr>';
        }

        //CATEGORIZATION
        $cat_new = "&#9723;";
        $cat_infra = "&#9723;";
        $cat_rev = "&#9723;";
        $cat_noninfra = "&#9723;";
        $categ = explode(',',$projinfo['categorization']);
        foreach ($categ as $key => $value) {
            switch ($value) {
                case 'New':
                        $cat_new = "&#9724;";
                    break;
                case 'Infrastructure':
                        $cat_infra = "&#9724;";
                    break;
                case 'Expanded/Revised':
                        $cat_rev = "&#9724;";
                    break;
                
                default:
                        $cat_noninfra = "&#9724;";
                    break;
            }
        }
        

        //DURATION
        $orig_start_date = "";
        $orig_end_date = "";
        if(isset($projinfo['project_dur_orig']))
        {
            $dt1 = explode('|',$projinfo['project_dur_orig']);
            $d1 = explode('-',$dt1[0]);
            $mon1 = $d1[0];
            $year1 = $d1[1];
            $orig_start_date = date('F',mktime(0, 0, 0, $mon1, 10))." ".$year1;

            $d2 = explode('-',$dt1[1]);
            $mon2 = $d2[0];
            $year2 = $d2[1];
            $orig_end_date = date('F',mktime(0, 0, 0, $mon2, 10))." ".$year2;
        }

        $rev_start_date = "";
        $rev_end_date = "";
        if(isset($projinfo['project_dur_rev']))
        {
            $dt2 = explode('|',$projinfo['project_dur_rev']);
            $d3 = explode('-',$dt2[0]);
            $mon3 = $d3[0];
            $year3 = $d3[1];
            $rev_start_date = date('F',mktime(0, 0, 0, $mon3, 10))." ".$year3;

            $d4 = explode('-',$dt2[1]);
            $mon4 = $d4[0];
            $year4 = $d4[1];
            $rev_end_date = date('F',mktime(0, 0, 0, $mon4, 10))." ".$year4;
        }


        //FINANCIAL
        //12.1. PAP ATTRIBUTION BY EXPENSE CLASS

        $pap_exp = App\Models\BP202\BP202_Project_PAP_Attribution::where('project_id',$project_id)->get();
        $pap_exp_row = "";
        $pap_exp_yr1_total = 0;
        $pap_exp_yr2_total = 0;
        $pap_exp_yr3_total = 0;
        
        if(count($pap_exp) > 0)
        {
            //GET PAP CODE
            $pap_exp_code_result = App\Models\BP202\BP202_Project_PAP_Attribution::where('project_id',$project_id)->orderBy('pap_code')->first();
            $pap_exp_code = $pap_exp_code_result['pap_code'];
            $pap_exp_code_desc = getLibraryDesc('pap_code',$pap_exp_code_result['pap_code'],'pap').' - '.$pap_exp_code;

            $pap_exp_row .= '<tr>
                                <td style="font-size:10px;width:45%;vertical-align: top;" align="center" colspan="6">
                                    '.$pap_exp_code_desc.'   
                                </td>
                            </tr>';

            foreach ($pap_exp as $key => $value) {
                
                $yr1_amt = getYearAmount('pap_exp', $project_id, $value->pap_sub, 2025 ,$value->pap_code);
                $yr2_amt = getYearAmount('pap_exp', $project_id, $value->pap_sub, 2026 ,$value->pap_code);
                $yr3_amt = getYearAmount('pap_exp', $project_id, $value->pap_sub, 2027 ,$value->pap_code);
                //$yr1 = (int)($yr1_amt.''.'000');

                $pap_exp_yr1_total += $yr1_amt;
                $pap_exp_yr2_total += $yr2_amt;
                $pap_exp_yr3_total += $yr3_amt;

                $pap_exp_row .= '<tr>
                                    <td style="font-size:10px;width:45%;vertical-align: top;" align="center">
                                            '.getLibraryDesc('pap',$value->pap_sub,'allotment_class_acronym').'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;width:20%" align="right">
                                            '.number_format($yr1_amt,2, '.', '').'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="right" colspan="2">
                                            '.number_format($yr2_amt,2, '.', '').'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="right" colspan="2">
                                            '.number_format($yr3_amt,2, '.', '').'
                                        </td>
                                </tr>';
            }
        }

        //12.2. PHYSICAL ACCOMPLISHMENTS & TARGETS
        $target_accomp = App\Models\BP202\BP202_Project_Target_Accomp::where('project_id',$project_id)->get();
        $target_accomp_row = "";
        $target_yr1_total = 0;
        $target_yr2_total = 0;
        $target_yr3_total = 0;
        if(count($target_accomp) > 0)
        {
            foreach ($target_accomp as $key => $value) {

                $yr1_amt = getYearAmount('phy_target', $project_id, $value->accom, 2025);
                $yr2_amt = getYearAmount('phy_target', $project_id, $value->accom, 2026);
                $yr3_amt = getYearAmount('phy_target', $project_id, $value->accom, 2027);
                //$yr1 = (int)($yr1_amt.''.'000');

                $target_yr1_total += $yr1_amt;
                $target_yr2_total += $yr2_amt;
                $target_yr3_total += $yr3_amt;

                $target_accomp_row .= '<tr>
                                    <td style="font-size:10px;width:45%;vertical-align: top;" align="center">
                                            '.$value->accom.'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;width:20%" align="center">
                                            '.number_format($yr1_amt).'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="center" colspan="2">
                                            '.number_format($yr2_amt).'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="center" colspan="2">
                                            '.number_format($yr3_amt).'
                                        </td>
                                </tr>';
            }
        }
        
        //12.3. TOTAL PROJECT COST
        $proj_cost = App\Models\BP202\BP202_total_proj_cost::where('project_id',$project_id)->get();
        $project_cost_rw = "";
        $project_cost_total = 0;
        if(count($proj_cost) > 0)
            {
                foreach ($proj_cost as $key => $value) {
                    $project_cost_total += $value->val;
                    $project_cost_rw .= '<tr>
                                <td style="font-size:10px;;vertical-align: top;" align="center">
                                        '.getLibraryDesc('pap',$value->expense_sub,'allotment_class_acronym').'
                                </td>
                                <td style="font-size:10px;vertical-align: top;" align="right" colspan="5">
                                    '.number_format($value->val).'
                            </td>
                        </tr>';
                    }
                
            }

        //12.4. REQUIREMENTS FOR OPERATING COST OF INFRASTRUCTURE PROJECT
        $pap_infra_row = "";
        $pap_infra_yr1_total = 0;
        $pap_infra_yr2_total = 0;
        $pap_infra_yr3_total = 0;
        $pap_infra = App\Models\BP202\BP202_Project_PAP_Infra::where('project_id',$project_id)->get();
            if(count($pap_infra) > 0)
            {
                //GET PAP CODE
                $pap_infra_code_result = App\Models\BP202\BP202_Project_PAP_Infra::where('project_id',$project_id)->orderBy('pap_code')->first();
                $pap_infra_code = $pap_infra_code_result['pap_code'];
                $pap_infra_code_desc = getLibraryDesc('pap_code',$pap_infra_code_result['pap_code'],'pap').' - '.$pap_infra_code;

                $pap_infra_row .= '<tr>
                                    <td style="font-size:10px;width:45%;vertical-align: top;" align="center" colspan="6">
                                        '.$pap_infra_code_desc.'   
                                    </td>
                                </tr>';
                foreach ($pap_infra as $key => $value) {
                
                    $yr1_amt = getYearAmount('pap_infra', $project_id, $value->infra_sub, 2025 ,$value->pap_code);
                    $yr2_amt = getYearAmount('pap_infra', $project_id, $value->infra_sub, 2026 ,$value->pap_code);
                    $yr3_amt = getYearAmount('pap_infra', $project_id, $value->infra_sub, 2027 ,$value->pap_code);
                    //$yr1 = (int)($yr1_amt.''.'000');
    
                    $pap_infra_yr1_total += $yr1_amt;
                    $pap_infra_yr2_total += $yr2_amt;
                    $pap_infra_yr3_total += $yr3_amt;
    
                    $pap_infra_row .= '<tr>
                                        <td style="font-size:10px;width:45%;vertical-align: top;" align="center">
                                                '.getLibraryDesc('pap',$value->infra_sub,'allotment_class_acronym').'
                                            </td>
                                            <td style="font-size:10px;vertical-align: top;width:20%" align="right">
                                                '.number_format($yr1_amt,2, '.', '').'
                                            </td>
                                            <td style="font-size:10px;vertical-align: top;" align="right" colspan="2">
                                                '.number_format($yr2_amt,2, '.', '').'
                                            </td>
                                            <td style="font-size:10px;vertical-align: top;" align="right" colspan="2">
                                                '.number_format($yr3_amt,2, '.', '').'
                                            </td>
                                    </tr>';
                }
            }

        //COSTING BY COMPONENT(S)
        $proj_comp = App\Models\BP202\BP202_cost_by_comp::where('project_id',$project_id)->get();
        $proj_comp_row = "";
        $proj_comp_ps_total = 0;
        $proj_comp_mooe_total = 0;
        $proj_comp_co_total = 0;
        $proj_comp_finex_total = 0;
        $proj_comp_row_total = 0;
        if(count($proj_comp) > 0)
            {
                foreach ($proj_comp as $key => $value) {
                    
                    $proj_comp_ps_total += $value->ps;
                    $proj_comp_mooe_total += $value->mooe;
                    $proj_comp_co_total += $value->co;
                    $proj_comp_finex_total += $value->finex;
                    $row_total = $value->ps + $value->mooe + $value->co + $value->finex;
                    $proj_comp_row_total += $row_total;
                    $proj_comp_row .= '<tr>
                                        <td style="font-size:10px;vertical-align: top; width:40%">
                                        '.$value->comps.'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="right">
                                            '.number_format($value->ps,2, '.', '').'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="right">
                                            '.number_format($value->mooe,2, '.', '').'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="right">
                                            '.number_format($value->co,2, '.', '').'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="right">
                                            '.number_format($value->finex,2, '.', '').'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="right">
                                            '.number_format($row_total,2, '.', '').'
                                        </td>
                                </tr>';
                }
            }

        
        //12.6. LOCATION OF IMPLEMENTATION
        $projloc_comp = App\Models\BP202\BP202_loc_by_imp::where('project_id',$project_id)->get();
        $projloc_comp_row = "";
        $projloc_comp_ps_total = 0;
        $projloc_comp_mooe_total = 0;
        $projloc_comp_co_total = 0;
        $projloc_comp_finex_total = 0;
        $projloc_comp_row_total = 0;
        if(count($projloc_comp) > 0)
            {
                foreach ($projloc_comp as $key => $value) {
                    
                    $projloc_comp_ps_total += $value->ps;
                    $projloc_comp_mooe_total += $value->mooe;
                    $projloc_comp_co_total += $value->co;
                    $projloc_comp_finex_total += $value->finex;
                    $rowloc_total = $value->ps + $value->mooe + $value->co + $value->finex;
                    $projloc_comp_row_total += $rowloc_total;
                    $projloc_comp_row .= '<tr>
                                        <td style="font-size:10px;vertical-align: top; width:40%" align="center">
                                        '.getLibraryDesc('region',$value->locs,'desc').'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="right">
                                            '.number_format($value->ps,2, '.', '').'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="right">
                                            '.number_format($value->mooe,2, '.', '').'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="right">
                                            '.number_format($value->co,2, '.', '').'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="right">
                                            '.number_format($value->finex,2, '.', '').'
                                        </td>
                                        <td style="font-size:10px;vertical-align: top;" align="right">
                                            '.number_format($rowloc_total,2, '.', '').'
                                        </td>
                                </tr>';
                }
            }
        $total_proj_cost = (int)(convertAmount($pap_exp_yr1_total));
        $total_proj_cost = number_format($total_proj_cost);

        //PROGRAM
        $program_title = null;
        if($projinfo['program_title'] != null)
        {
            $program_title = "Program Title : ".$projinfo['program_title']."<br/>";
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
                  margin: 15;
                }
            body
            {
                font-family:DejaVu Sans;
            }
            th,td
            {
                border:1px solid #555;
                font-size:10px;
                page-break-inside: always;

            }
            .tr-space,.td-space
            {
                border:1px solid #FFF;
                font-size:10px;
            }
            .page-break {
                page-break-after: always;
               }
            table
            {
                page-break-inside: always;

            }
        </style>
        <body>
        <span style="font-size: 12px;text-align:right"><b>Revised BP Form 202 (2025 Budget Tier 2)</b></span>
        <center><span style="font-size: 15px"><b>PROFILE FOR TIER 2 BUDGET PROPOSALS</b></span></center>
        <table width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed">
            <tr>
                <td style="font-size:10px;width:45%">
                    <b>1. Proposal/Project Name</b>
                </td>
                <td style="font-size:10px;width:55%" colspan="5">
                    '.$program_title.'
                    '.$projinfo['project_title'].'
                </td>
            </tr>
            <tr>
                <td style="font-size:10px;width:45%">
                    <b>2. Implementing Department/Agency</b>
                </td>
                <td style="font-size:10px;width:55%" colspan="5">
                    '.$agency.'
                </td>
            </tr>
            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br></td>
            </tr>
            <tr>
                <td style="font-size:10px;width:45%">
                    <b>3. Priority Ranking</b>
                </td>
                <td style="font-size:10px;width:55%" colspan="5">
                    '.$projinfo['project_ranking'].'
                </td>
            </tr>
            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br></td>
            </tr>
            <tr>
                <td style="font-size:10px;width:45%;vertical-align: top;" rowspan="2">
                    <b>4. Categorization</b>
                </td>
                <td style="font-size:10px;width:55%" colspan="2" align="right">
                    New '.$cat_new.'
                </td>
                <td style="font-size:10px;width:55%" colspan="3" align="right">
                    Infrastructure '.$cat_infra.'
                </td>
            </tr>
            <tr>
                <td style="font-size:10px;width:55%" colspan="2" align="right">
                    Expanded/Revised '.$cat_rev.'
                </td>
                <td style="font-size:10px;width:55%" colspan="3" align="right">
                    Non-Infrastructure '.$cat_noninfra.'
                </td>
            </tr>
            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br></td>
            </tr>
            <tr>
                <td style="font-size:10px;width:45%">
                    <b>5. PIP Code:</b>
                </td>
                <td style="font-size:10px;width:55%" colspan="5">
                    '.$projinfo['pip_code'].'
                </td>
            </tr>
            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br></td>
            </tr>
            <tr>
                <td style="font-size:10px;width:45%">
                    <b>6. Total Project Cost:</b>
                </td>
                <td style="font-size:10px;width:55%" colspan="5">
                    '.$total_proj_cost.'
                </td>
            </tr>
            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br></td>
            </tr>
            <tr>
                <td style="font-size:10px;width:45%;vertical-align: top;">
                    <b>7. Description:</b>
                </td>
                <td style="font-size:10px;width:55%" colspan="5">
                    '.$projinfo['project_desc'].'
                </td>
            </tr>
            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br></td>
            </tr>
            <tr>
                <td style="font-size:10px;width:45%;vertical-align: top;">
                    <b>8. Purpose:</b>
                </td>
                <td style="font-size:10px;width:55%" colspan="5">
                    '.$projinfo['project_purpose'].'
                </td>
            </tr>
            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br></td>
            </tr>
            <tr>
                <td style="font-size:10px;width:45%">
                    <b>9. Beneficiaries:</b>
                </td>
                <td style="font-size:10px;width:55%" colspan="5">
                    '.$projinfo['project_benificiaries'].'
                </td>
            </tr>
            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br></td>
            </tr>
            <tr>
                <td style="font-size:10px;width:45%;vertical-align: top;" rowspan="6">
                    <b>10. Implementation Period:</b>
                </td>
                <td style="font-size:10px;width:55%" colspan="5">
                    <b>ORGINAL</b>
                </td>
            </tr>
            <tr>
                <td style="font-size:10px;width:20%">
                    Start Date:
                </td>
                <td style="font-size:10px;width:25%" colspan="4">
                    '.$orig_start_date.'
                </td>
            </tr>
            <tr>
                <td style="font-size:10px;width:25%">
                    Finish Date:
                </td>
                <td style="font-size:10px;width:25%" colspan="4">
                    '.$orig_end_date.'
                </td>
            </tr>
            <tr>
                <td style="font-size:10px;width:55%" colspan="5">
                    <b>REVISED</b>
                </td>
            </tr>
            <tr>
                <td style="font-size:10px;width:20%">
                    Start Date:
                </td>
                <td style="font-size:10px;width:25%" colspan="4">
                    '.$rev_start_date.'
                </td>
            </tr>
            <tr>
                <td style="font-size:10px;width:20%">
                    Finish Date:
                </td>
                <td style="font-size:10px;width:25%" colspan="4">
                    '.$rev_end_date.'
                </td>
            </tr>

            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br></td>
            </tr>
            <tr>
                <td style="font-size:10px;width:45%;vertical-align: top;" rowspan="13">
                    <b>11. Pre-Requisites:</b>
                </td>
                <td style="font-size:10px;width:10%!important" align="center" rowspan="2">
                    <b>Approving Authorities</b>
                </td>
                <td style="font-size:10px;width:35%" colspan="4" align="center">
                    <b>Reviewed/Approved</b>
                </td>
            </tr>
            <tr>
                <td style="font-size:10px;width:10%;vertical-align: top;" align="center">
                    YES
                </td>
                <td style="font-size:10px;width:10%;vertical-align: top;" align="center">
                    NO
                </td>
                <td style="font-size:10px;width:10%;vertical-align: top;" align="center">
                    Not<br>Applicable
                </td>
                <td style="font-size:10px;width:10%;vertical-align: top;" align="center">
                    Remarks
                </td>
            </tr>
            '.$appauth.'
            <tr>
                 <td style="font-size:10px;width:10%;vertical-align: top;">
                    Others (please specify)
                 </td>
                 <td style="font-size:10px;width:10%;vertical-align: top;" align="center">
                </td>
                 <td style="font-size:10px;width:10%;vertical-align: top;" align="center">
                 </td>
                 <td style="font-size:10px;width:10%;vertical-align: top;" align="center">
                </td>
                <td style="font-size:10px;width:10%;vertical-align: top;" align="center">
                </td>
            </tr>
            </table>
            <div class="page-break"></div>
            <table width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed">
            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br><b>12. Financial (in P\'000) and Physical Details</b><br><br><b>12.1. PAP ATTRIBUTION BY EXPENSE CLASS</b></td>
            </tr>
            <tr>
                 <td style="font-size:10px;width:45%;vertical-align: top;" align="center">
                    <b>PAP<br>(A)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;width:20%" align="center">
                    <b>FY 2025 TIER2<br>(B)</b>
                </td>
                 <td style="font-size:10px;vertical-align: top;" align="center" colspan="2">
                    <b>2026<br>(C)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center" colspan="2">
                    <b>2027<br>(D)</b>
                </td>
            </tr>
            '.$pap_exp_row.'
            <tr>
                 <td style="font-size:10px;;vertical-align: top;"">
                    <b>GRAND TOTAL</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="right">
                    <b>'.number_format($pap_exp_yr1_total,2, '.', '').'</b>
                </td>
                 <td style="font-size:10px;vertical-align: top;" align="right" colspan="2">
                    <b>'.number_format($pap_exp_yr2_total,2, '.', '').'</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="right" colspan="2">
                    <b>'.number_format($pap_exp_yr3_total,2, '.', '').'</b>
                </td>
            </tr>
            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br><b>12.2. PHYSICAL ACCOMPLISHMENTS & TARGETS</b></td>
            </tr>
            <tr>
                 <td style="font-size:10px;;vertical-align: top;" align="center">
                    <b>Physical Accomplishment<br>(A)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <b>FY 2025 TIER2<br>(B)</b>
                </td>
                 <td style="font-size:10px;vertical-align: top;" align="center" colspan="2">
                    <b>2026<br>(C)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center" colspan="2">
                    <b>2027<br>(D)</b>
                </td>
            </tr>
            '.$target_accomp_row .'
            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br><b>12.3. TOTAL PROJECT COST</b></td>
            </tr>
            <tr>
                 <td style="font-size:10px;;vertical-align: top;" align="center">
                    <b>Expense Class</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center" colspan="5">
                    <b>Total Project Cost</b>
                </td>
            </tr>
            '.$project_cost_rw.'
            <tr>
                 <td style="font-size:10px;;vertical-align: top;">
                    <b>GRAND TOTAL</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="right" colspan="5">
                 <b>'.number_format($project_cost_total,2, '.', '').'</b>
                </td>
            </tr>
            <tr class="tr-space">
                <td class="td-space" colspan="6" style=""><br><b>12.4. REQUIREMENTS FOR OPERATING COST OF INFRASTRUCTURE PROJECT</b><br>For Infrastructure projects, show the estimated ongoing operating cost to be included in Forward Estimates</td>
            </tr>
            <tr>
                 <tr>
                 <td style="font-size:10px;;vertical-align: top;" align="center">
                    <b>PAP<br>(A)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <b>FY 2025 TIER2<br>(B)</b>
                </td>
                 <td style="font-size:10px;vertical-align: top;" align="center" colspan="2">
                    <b>2026<br>(C)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center" colspan="2">
                    <b>2027<br>(D)</b>
                </td>
            </tr>
            '.$pap_infra_row.'
            <tr>
                 <td style="font-size:10px;;vertical-align: top;"">
                    <b>GRAND TOTAL</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="right">
                    <b>'.number_format($pap_infra_yr1_total,2, '.', '').'</b>
                </td>
                 <td style="font-size:10px;vertical-align: top;" align="right" colspan="2">
                    <b>'.number_format($pap_infra_yr2_total,2, '.', '').'</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="right" colspan="2">
                    <b>'.number_format($pap_infra_yr3_total,2, '.', '').'</b>
                </td>
            </tr>
            </table>
            <table width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed">
            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br><b>12.5. COSTING BY COMPONENT(S)</b><br></td>
            </tr>
            <tr>
                 <td style="font-size:10px;vertical-align: top; width:40%" align="center">
                    <b>Component<br>(A)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <b>PS<br>(B)</b>
                </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <b>MOOE<br>(C)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <b>CO<br>(D)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <b>FINEX<br>(E)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <b>Total<br>(F)</b>
                 </td>
            </tr>
               '.$proj_comp_row.'
            <tr>
                 <td style="font-size:10px;;vertical-align: top;"">
                    <b>GRAND TOTAL</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="right">
                    <b>'.number_format($proj_comp_ps_total,2, '.', '').'</b>
                </td>
                 <td style="font-size:10px;vertical-align: top;" align="right">
                    <b>'.number_format($proj_comp_mooe_total,2, '.', '').'</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="right">
                    <b>'.number_format($proj_comp_co_total,2, '.', '').'</b>
                </td>
                <td style="font-size:10px;vertical-align: top;" align="right">
                    <b>'.number_format($proj_comp_finex_total,2, '.', '').'</b>
                </td>
                <td style="font-size:10px;vertical-align: top;" align="right">
                    <b>'.number_format($proj_comp_row_total,2, '.', '').'</b>
                </td>
            </tr>

            <tr class="tr-space">
                <td class="td-space" colspan="6" style="border-bottom:1px solid #555"><br><b>12.6. LOCATION OF IMPLEMENTATION</b><br></td>
            </tr>
            <tr>
                 <td style="font-size:10px;vertical-align: top; width:40%" align="center">
                    <b>Location<br>(A)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <b>PS<br>(B)</b>
                </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <b>MOOE<br>(C)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <b>CO<br>(D)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <b>FINEX<br>(E)</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <b>Total<br>(F)</b>
                 </td>
            </tr>
            '.$projloc_comp_row.'
            <tr>
                 <td style="font-size:10px;;vertical-align: top;"">
                    <b>GRAND TOTAL</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="right">
                    <b>'.number_format($projloc_comp_ps_total,2, '.', '').'</b>
                </td>
                 <td style="font-size:10px;vertical-align: top;" align="right">
                    <b>'.number_format($projloc_comp_mooe_total,2, '.', '').'</b>
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="right">
                    <b>'.number_format($projloc_comp_co_total,2, '.', '').'</b>
                </td>
                <td style="font-size:10px;vertical-align: top;" align="right">
                    <b>'.number_format($projloc_comp_finex_total,2, '.', '').'</b>
                </td>
                <td style="font-size:10px;vertical-align: top;" align="right">
                    <b>'.number_format($projloc_comp_row_total,2, '.', '').'</b>
                </td>
            </tr>
            </table>
            <table width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed">
            <tr class="tr-space">
                <td class="td-space" colspan="5" style="border-bottom:1px solid #555"><br><br></td>
            </tr>
            <tr>
                 <td style="font-size:10px;;vertical-align: top;" colspan="2">
                    Prepared by:
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    Certified Correct:
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    Approved:
                </td>
                <td style="font-size:10px;vertical-align: top;" align="center">
                    Date:
                </td>
            </tr>
            <tr>
                 <td style="font-size:10px;;vertical-align: top;" align="center">
                    <br>
                    Susan L. Garcia
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <br>
                    Lilian G. Bondoc
                </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <br>
                    Jaivee Ann M. Tabadero
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    <br>
                    Reynaldo V. Ebora
                </td>
                <td style="font-size:10px;vertical-align: top;" align="center">
                    
                </td>
            </tr>
            <tr>
                 <td style="font-size:10px;;vertical-align: top;" align="center">
                    Budget Officer
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    Planning Office
                </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    Chief Accountant
                 </td>
                 <td style="font-size:10px;vertical-align: top;" align="center">
                    Head of Agency
                </td>
                <td style="font-size:10px;vertical-align: top;" align="center">
                    DAY/MO/YEAR
                </td>
            </tr>
        </table>
        </body>
        </html>')
        ->setPaper('A4', 'portrait');
        return $pdf->stream();
    }

    public function priority()
    {
        $nav = activeNav('bp202_priority');

        $data = [
                    "nav" => $nav
                ];

        return view('bp202.priority-list')->with('data',$data);
    }
}
