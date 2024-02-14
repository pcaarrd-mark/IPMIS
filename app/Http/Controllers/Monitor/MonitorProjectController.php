<?php

namespace App\Http\Controllers\Monitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class MonitorProjectController extends Controller
{
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
                        ->where('status','!=',4)
                        ->count();
            
                        // Fetch records
                        $records =  App\Models\OSEP\View_OSEPProject::orderBy($columnName,$columnSortOrder)
                            ->where('title', 'like', '%' .$searchValue . '%')
                            ->where('status','!=',4)
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();
                    
                        break;
                    case 'ISP Manager':
                        $totalRecords = App\Models\OSEP\View_OSEPProject::count();
                        $totalRecordswithFilter = App\Models\OSEP\View_OSEPProject::select('count(*) as allcount')
                        ->where('title', 'like', '%' .$searchValue . '%')
                        ->where('status','!=',4)
                        ->count();
            
                        // Fetch records
                        $records =  App\Models\OSEP\View_OSEPProject::orderBy($columnName,$columnSortOrder)
                            ->where('title', 'like', '%' .$searchValue . '%')
                            ->where('status','!=',4)
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();
                    
                        break;
                    case 'Proponent':
                        $totalRecords = App\Models\OSEP\View_OSEPProject::count();
                        $totalRecordswithFilter = App\Models\OSEP\View_OSEPProject::select('count(*) as allcount')
                        ->where('title', 'like', '%' .$searchValue . '%')
                        ->where('created_by', Auth::user()->id)
                        ->count();
            
                        // Fetch records
                        $records =  App\Models\OSEP\View_OSEPProject::orderBy($columnName,$columnSortOrder)
                            ->where('title', 'like', '%' .$searchValue . '%')
                            ->where('created_by', Auth::user()->id)
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

            $button_h = '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu">';  

            $button = '<a class="dropdown-item" href="'.url("/project/print/".$id).'" target="_blank">Print</a><a class="dropdown-item" href="'.url("/project/print/".$id).'" target="_blank">History</a>';  

            $button_f = '</div></center>';   
            //$total = $record->total;

            switch (Auth::user()->usertype) {
                case 'System Administrator':
                    switch ($record->status) {
                        case 1:
                                $button = '<a class="dropdown-item" href="javascript:void(0)" onclick="approve('.$id.')">Approve</a><a class="dropdown-item" href="'.url('/project/edit/'.$id).'">Disapprove</a>'.$button;
                        break;
                    }
                    break;

                case 'ISP Manager':
                    switch ($record->status) {
                        case 2:
                                $button = '<a class="dropdown-item" href="'.url('project/comments/'.$id).'">Comments</a>'.$button.'<a class="dropdown-item" href="#" onclick="frmSubmitDelete('.$id.')">Delete</a>';
                        break;

                        case 6:
                                $button = '<a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus('.$id.',7)">Approve</a><a class="dropdown-item" href="'.url('project/comments/'.$id).'">Comments</a>'.$button.'<a class="dropdown-item" href="#" onclick="frmSubmitDelete('.$id.')">Delete</a>';

                            break;
                        
                        break;
                    }
                    break;
                case 'Proponent':
                        switch ($record->status) {
                            case 1:
                            case 6:
                                    $button = '<a class="dropdown-item" href="'.url('/project/edit/'.$id).'">Edit</a>'.$button.'<a class="dropdown-item" href="'.url("/project/lib/".$id).'">LIB</a><a class="dropdown-item" href="#" onclick="frmSubmitDelete('.$id.')">Delete</a></div></center>';
                                break;
                            
                            case 5:
                                case 1:
                                    $button = '<a class="dropdown-item" href="'.url('/project/comments/'.$id).'">Comments</a><a class="dropdown-item" href="'.url("/project/lib/".$id).'">LIB</a><a class="dropdown-item" href="'.url('/project/edit/'.$id).'">Edit</a>'.$button.'<a class="dropdown-item" href="#" onclick="frmSubmitDelete('.$id.')">Delete</a></div></center>';
                                break;
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
}
