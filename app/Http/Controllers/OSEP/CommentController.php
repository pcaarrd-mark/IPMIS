<?php

namespace App\Http\Controllers\OSEP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index($id)
    {
        $nav = activeNav('osep_project');
        $proj = App\Models\Project::where('id',$id)->first();
        $budgets = App\Models\LIBYear::where('project_id',$id)->get();

        $data = [
                    "nav" => $nav,
                    "project" => $proj,
                    "budgetlist" => $budgets
                ];
        
        return view('osep.comments')->with('data',$data);
        
        // if(Auth::user()->usertype == 'ISP Manager')
        //     return view('osep.project-comments')->with('data',$data);
        // else
        //     return view('osep.comments')->with('data',$data);
    }

    public function create()
    {
        $comment = new App\Models\OSEP\OSEPComment;
        $comment->project_id = request()->comment_project_id;
        $comment->project_section_id = request()->comment_type;
        $comment->comment = request()->project_comment_content;
        $comment->remarks_by = Auth::user()->name;
        $comment->remarks_by_id = Auth::user()->id;
        $comment->remarks_for_id = request()->remarks_for_id;
        $comment->save();

        addHistoryLog('Added comment : '.request()->project_comment_content,'Project',request()->comment_project_id);
    }

    public function update()
    {
        $comment = App\Models\OSEP\OSEPComment::where('id',request()->edit_comment_id)
                ->update([
                    "comment" => request()->edit_comment_content
                ]);
    }

    public function delete()
    {
        $comment = App\Models\OSEP\OSEPComment::where('id',request()->delete_comment_id)->delete();
    }

    public function jsoncomment($id,Request $request)
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
        

        $totalRecords = App\Models\OSEP\OSEPComment::count();
            $totalRecordswithFilter = App\Models\OSEP\OSEPComment::select('count(*) as allcount')
            ->where('comment', 'like', '%' .$searchValue . '%')
            ->orWhere('remarks_by', 'like', '%' .$searchValue . '%')
            ->where('project_id',$id)
            ->count();

            // Fetch records
            $records =  App\Models\OSEP\OSEPComment::orderBy($columnName,$columnSortOrder)
                ->where('comment', 'like', '%' .$searchValue . '%')
                ->orWhere('remarks_by', 'like', '%' .$searchValue . '%')
                ->where('project_id',$id)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        

        $data_arr = array();

        foreach($records as $record){

            $id = $record->id;
            $project_id = $record->project_id;
            $comment = $record->comment;
            $remarks_by = $record->remarks_by;
            $status = $record->status;
            $done_at = $record->done_at;
            $button = "";
            
            //$total = $record->total;

            switch (Auth::user()->usertype) {
                case 'System Administrator':
                        $button = "";
                    break;

                case 'ISP Manager':
                        if($record->remarks_by_id == Auth::user()->id)
                        {
                            if($record->status == 'Pending')
                                $button = '<center><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></center>';
                        }
                            
                    break;
                case 'Proponent':
                        if($record->remarks_for_id == Auth::user()->id)
                        {
                            if($record->status == 'Pending')
                                $button = '<center><button class="btn btn-success btn-sm" onclick="commentDone('.$id.','.$project_id.',1)"><i class="fas fa-check"></i> TAG AS COMPLETED</button></center>';
                            else
                                $button = '<center><button class="btn btn-warning btn-sm" onclick="commentDone('.$id.','.$project_id.',2)"><i class="fas fa-rewind"></i> REVERT</button></center>';
                        }
                    break;
                
            }

            
            $data_arr[] = array(
                "id" => $id,
                "comment" => $comment,
                "remarks_by" => $remarks_by,
                "status" => $status,
                "done_at" => $done_at,
                "button" => $button,
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
    
    public function json($id)
    {
        $comment = App\Models\OSEP\OSEPComment::where('id',$id)->first();
        if($comment)
            return json_encode(['section_id' => $comment['project_section_id'],'comment' => $comment['comment']]);
    }

    public function donecomment()
    {
        //COMMENTS DETAILS
        $com = App\Models\OSEP\OSEPComment::where('id',request()->comment_id)->first();

        //REMARKS DONE
        if(request()->comment_type == 1)
        {
            App\Models\OSEP\OSEPComment::where('id',request()->comment_id)->update(['status' => 'Done','done_at' => date('Y-m-d H:i:s')]);
            addHistoryLog('Tag comment as completed -> '.$com['comment'],'Project',request()->comment_project_id);
        }   
        else
        {
            App\Models\OSEP\OSEPComment::where('id',request()->comment_id)->update(['status' => 'Pending','done_at' => NULL]);
            addHistoryLog('Revert comment as pending -> '.$com['comment'],'Project',request()->comment_project_id);
        }
            

        //CHECK IF ALL REMARKS ARE DONE
        $comment_total = App\Models\OSEP\OSEPComment::where('project_id',request()->comment_project_id)->count();
        $comment_done = App\Models\OSEP\OSEPComment::where('project_id',request()->comment_project_id)->where('status','Done')->count();

        

        if($comment_done == $comment_total)
        {
            App\Models\Project::where('id',request()->comment_project_id)->update(['status' => '6']);
        }
    
    }

    public function all($id)
    {
        $project = App\Models\Project::where('id',$id)->first();

        //GET ALL COMMENTS
        $comment = App\Models\OSEP\OSEPComment::where('project_id',$id)->orderBy('project_section_id')->get();

        $row = "";
        foreach ($comment as $key => $value) {
            $row .= "<tr>
                        <td>".getSection($value->project_section_id)."</td>
                        <td>".$value->comment."</td>
                        <td align='center'>".$value->created_at."</td>
                        <td align='center'>".$value->remarks_by."</td>
                    </tr>";
        }

        //return $row;

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
        
        <table style="border:1px solid #FFF" width="100%" cellspacing="3" cellpadding="3" style="table-layout: fixed" page-break-inside: auto;>
            <tr>
                <td  style="border:1px solid #FFF">
                </td>
                <td style="width:80%;border:1px solid #FFF">
                    <center><span style="font-size:12px"><b>Consolidated Comments<b></span><br/><span style="font-size:15px"><b>Project Title : '.strtoupper($project['title']).'</b></span><center>
                </td>
                <td style="border:1px solid #FFF">
                </td>
            </tr>
        </table>
        <table style="border:1px solid #FFF" width="100%" cellspacing="0" cellpadding="1" style="table-layout: fixed" page-break-inside: auto;>
               <tr>
                    <td align="center"><b>Section</b></td>
                    <td align="center"><b>Remarks</b></td>
                    <td align="center"><b>Date</b></td>
                    <td align="center"><b>User</b></td>
               </tr>
               '.$row.'
        </table>
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

        $t = 600;
        for ($i = 1; $i <= $pageCount; $i++) {
            $pdf->getDomPDF()->get_canvas()->page_text(450, $t, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, $size, array(0, 0, 0));

            $t += 600;
        }
    

        return $pdf->stream();
        
        
    }
}
