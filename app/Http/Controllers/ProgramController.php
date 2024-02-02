<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $nav = activeNav('program');

        $data = [
                    "nav" => $nav
                ];

        return view('bp202.program')->with('data',$data);
    }

    public function create()
    {

        $program = new App\Models\BP202\BP202_Program;
        $program->program_title = request()->program_title;
        $program->program_leader = request()->program_leader;
        $program->save();

        //SAVE AUDIT TRAIL
        auditTrail("User : ".Auth::user()->name." -- Created Program : ".request()->program_title);

        return redirect(request()->frm_url_reset);
        
    }

    public function delete()
    {
        App\Models\Category::where('id',request()->category_id)->delete();

        return redirect('admin/category');
    }

    public function update()
    {
        App\Models\Category::where('id',request()->edit_category_id)->update(['description' => request()->edit_category_desc]);

        return redirect('admin/category');
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
        $totalRecords = App\Models\BP202\BP202_Program::count();
        $totalRecordswithFilter = App\Models\BP202\BP202_Program::select('count(*) as allcount')
        ->where('program_title', 'like', '%' .$searchValue . '%')
        ->Orwhere('program_leader', 'like', '%' .$searchValue . '%')
        ->whereNotNull('deleted_at')->count();

        // Fetch records
        $records = App\Models\BP202\BP202_Program::orderBy($columnName,$columnSortOrder)
            ->where('program_title', 'like', '%' .$searchValue . '%')
            ->orWhere('program_leader', 'like', '%' .$searchValue . '%')
            ->whereNotNull('deleted_at')
            ->select('id','program_title','program_leader','created_by','created_at')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $program_title = $record->program_title;
            $program_leader = $record->program_leader;
            $created_by = $record->created_by;
            $created_at = $record->created_at;
 
            $data_arr[] = array(
                "id" => $id,
                "program_title" => $program_title,
                "program_leader" => $program_leader,
                "created_by" => $created_by,
                "created_at" => $created_at,
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

    public function randomCat()
    {
        $list = App\Models\Product::get();

        foreach($list AS $lists)
        {
            App\Models\Product::where('id',$lists->id)->update(['category_id' => $this->randomNum()]);
        }
    }

    public function randomNum()
    {
        return rand(1,6);
    }
}
