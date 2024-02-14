<?php

namespace App\Http\Controllers\OSEP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

use Illuminate\Database\Eloquent\Collection;

class AdminAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $nav = activeNav('settings_account');

        $data = [
                    "nav" => $nav
                ];
                
        return view('osep.admin.accounts')->with('data',$data);
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

        $totalRecords = App\Models\User::count();
            $totalRecordswithFilter = App\Models\User::select('count(*) as allcount')
            ->where('name', 'like', '%' .$searchValue . '%')
            ->count();

            // Fetch records
            $records =  App\Models\User::orderBy($columnName,$columnSortOrder)
                ->where('name', 'like', '%' .$searchValue . '%')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        

        $data_arr = array();

        foreach($records as $record){

            $id = $record->id;
            $name = $record->name;
            $usertype = $record->usertype;

 
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "usertype" => $usertype,
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
