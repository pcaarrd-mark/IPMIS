<?php

namespace App\Http\Controllers\OSEP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class OSEPProponentController extends Controller
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

        return view('osep.project')->with('data',$data);
    }

    public function jsonproject(Request $request)
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

}
