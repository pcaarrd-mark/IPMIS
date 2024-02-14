<?php

namespace App\Http\Controllers\OSEP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class OSEPProjectByDivisionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $nav = activeNav('osep_division_project');

        $data = [
                    "nav" => $nav
                ];

        return view('osep.isp-manager.project')->with('data',$data);
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

        $totalRecords = App\Models\OSEP\View_OSEPByDivisionProject::count();
            $totalRecordswithFilter = App\Models\OSEP\View_OSEPByDivisionProject::select('count(*) as allcount')
            ->where('title', 'like', '%' .$searchValue . '%')
            ->whereIn('status',[2,4,5])
            ->where('division_id',Auth::user()->division_id)
            ->count();

            // Fetch records
            $records =  App\Models\OSEP\View_OSEPByDivisionProject::orderBy($columnName,$columnSortOrder)
                ->where('title', 'like', '%' .$searchValue . '%')
                ->whereIn('status',[2,4,5])
                ->where('division_id',Auth::user()->division_id)
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
            $button = "";

            switch ($record->status) {
                case 2:
                        $button = '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="'.url('/project/comments/'.$id).'">Comments</a><a class="dropdown-item" href="'.url("/project/lib/".$id).'">LIB</a><a class="dropdown-item" href="#" target="_blank">Print</a><a class="dropdown-item" href="#" onclick="#">View Files</a><a class="dropdown-item" href="#" onclick="#">Print</a></div></center>';
                    break;
                case 5:
                        $button = '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="'.url('/project/comments/'.$id).'">Comments</a><a class="dropdown-item" href="#" onclick="#">Approve</a><a class="dropdown-item" href="'.url("/project/lib/".$id).'">LIB</a><a class="dropdown-item" href="#" target="_blank">Print</a><a class="dropdown-item" href="#" onclick="#">View Files</a><a class="dropdown-item" href="#" onclick="#">Print</a></div></div></center>';
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
                "button" => $button
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

    public function jsonprogram(Request $request)
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

        $totalRecords = App\Models\OSEP\View_OSEPByDivisionProject::count();
            $totalRecordswithFilter = App\Models\OSEP\View_OSEPByDivisionProject::select('count(*) as allcount')
            ->where('title', 'like', '%' .$searchValue . '%')
            ->whereIn('status',[2,4])
            ->where('division_id',Auth::user()->division_id)
            ->groupBy('program_title')
            ->count();

            // Fetch records
            $records =  App\Models\OSEP\View_OSEPByDivisionProject::orderBy($columnName,$columnSortOrder)
                ->where('title', 'like', '%' .$searchValue . '%')
                ->whereIn('status',[2,4])
                ->where('division_id',Auth::user()->division_id)
                ->groupBy('program_title')
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
