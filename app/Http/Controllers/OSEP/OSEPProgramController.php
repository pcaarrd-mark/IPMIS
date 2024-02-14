<?php

namespace App\Http\Controllers\OSEP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;
use Carbon;

class OSEPProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $nav = activeNav('osep_program');

        $data = [
                    "nav" => $nav
                ];

        return view('osep.program')->with('data',$data);
    }

    public function add()
    {
        $nav = activeNav('osep_program');

        $data = [
                    "nav" => $nav
                ];

        return view('osep.add-program')->with('data',$data);
    }

    public function create()
    {
        $coemp = "";
        if(isset(request()->coimplementing_agency))
        {
            foreach (request()->coimplementing_agency as $cokey => $coemps) {
                $coemp .= $coemps.",";
            }
        }
        

        //REMOVE LAST COMMA
        $coemp = substr($coemp, 0, -1);

        $prog = new App\Models\Program;
        $prog->title = request()->title;
        $prog->agency_imp = request()->implementing_agency;
        $prog->program_objective = request()->program_objective;
        $prog->program_significance = request()->program_significance;
        $prog->program_methodology = request()->program_methodology;
        $prog->duration_from_month = request()->slct_mon_orig_start;
        $prog->duration_from_year = request()->slct_year_orig;
        $prog->duration_to_month = request()->slct_mon_orig_end;
        $prog->duration_to_year = request()->slct_year_orig_end;
        $prog->created_by = Auth::user()->id;
        $prog->save();
        $id = $prog->id;

        addHistoryLog('Program Created','Program',$id);

        return redirect('/osep/program');
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
                $totalRecords = App\Models\OSEP\View_OSEPProgram::count();
                $totalRecordswithFilter = App\Models\OSEP\View_OSEPProgram::select('count(*) as allcount')
                ->where('title', 'like', '%' .$searchValue . '%')
                ->count();

                // Fetch records
                $records =  App\Models\OSEP\View_OSEPProgram::orderBy($columnName,$columnSortOrder)
                    ->where('title', 'like', '%' .$searchValue . '%')
                    ->skip($start)
                    ->take($rowperpage)
                    ->orderBy('id')
                    ->get();
            
                break;
            case 'ISP Manager':
                $totalRecords = App\Models\OSEP\View_OSEPProgram::count();
                $totalRecordswithFilter = App\Models\OSEP\View_OSEPProgram::select('count(*) as allcount')
                ->where('title', 'like', '%' .$searchValue . '%')
                ->count();

                // Fetch records
                $records =  App\Models\OSEP\View_OSEPProgram::orderBy($columnName,$columnSortOrder)
                    ->where('title', 'like', '%' .$searchValue . '%')
                    ->skip($start)
                    ->take($rowperpage)
                    ->orderBy('id')
                    ->get();
            
                break;
            case 'Proponent':
                $totalRecords = App\Models\OSEP\View_OSEPProgram::count();
                $totalRecordswithFilter = App\Models\OSEP\View_OSEPProgram::select('count(*) as allcount')
                ->where('title', 'like', '%' .$searchValue . '%')
                ->where('created_by',Auth::user()->id)
                ->count();

                // Fetch records
                $records =  App\Models\OSEP\View_OSEPProgram::orderBy($columnName,$columnSortOrder)
                    ->where('title', 'like', '%' .$searchValue . '%')
                    ->where('created_by',Auth::user()->id)
                    ->skip($start)
                    ->take($rowperpage)
                    ->orderBy('id')
                    ->get();
            
                break;
            
    }

        
        

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $title = $record->title;
            $total = $record->total;
            $cost = getProjCost(null,$record->id,null);

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
                "title" => $title,
                "total" => $total,
                "cost" => $cost,
                "duration" => $duration,
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
}
