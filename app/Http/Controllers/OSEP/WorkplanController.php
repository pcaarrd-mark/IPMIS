<?php

namespace App\Http\Controllers\OSEP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class WorkplanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index($id)
    {
        $nav = activeNav('osep_project');
        $proj = App\Models\Project::where('id',$id)->first();
        $yrs = App\Models\LIBYear::where('project_id',$id)->count();

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
                    "nav" => $nav,
                    "project" => $proj,
                    'yrs' => $yrs,
                    'duration' => $duration,
                ];
        
        return view('osep.workplan')->with('data',$data);
    }

    public function create()
    {
        //WORKPLAN A
        //DELETE THEN INSERT NA LANG
        App\Models\ProjectWorkplanA::where('project_id',request()->project_id)->delete();

        $workplanA = new App\Models\ProjectWorkplanA;
        $data = collect([]);
        foreach (request()->objectives as $key => $value) {
            $data->push([
                            'project_id' => request()->project_id,
                            'objectives' => $value,
                            'activity' => request()->activity[$key],
                            'accomplishment' => request()->accomplishment[$key],
                            'y1_q1' => request()->y1_q1[$key],
                            'y1_q2' => request()->y1_q2[$key],
                            'y1_q3' => request()->y1_q3[$key],
                            'y1_q4' => request()->y1_q4[$key],
                            'y2_q1' => request()->y2_q1[$key],
                            'y2_q2' => request()->y2_q2[$key],
                            'y2_q3' => request()->y2_q3[$key],
                            'y2_q4' => request()->y2_q4[$key],
                            'y3_q1' => request()->y3_q1[$key],
                            'y3_q2' => request()->y3_q2[$key],
                            'y3_q3' => request()->y3_q3[$key],
                            'y3_q4' => request()->y3_q4[$key],
                            
                        ]);
        }
        $workplanA::insert($data->all());

        //WORKPLAN B
        //DELETE THEN INSERT NA LANG
        App\Models\ProjectWorkplanB::where('project_id',request()->project_id)->delete();
        $workplanB = new App\Models\ProjectWorkplanB;
        $data = collect([]);
        foreach (request()->expected_output_id as $key => $value) {
            $data->push([
                            'project_id' => request()->project_id,
                            'expected_output_id' => $value,
                            'y1_q1' => request()->expected_y1_q1[$key],
                            'y1_q2' => request()->expected_y1_q2[$key],
                            'y1_q3' => request()->expected_y1_q3[$key],
                            'y1_q4' => request()->expected_y1_q4[$key],
                            'y2_q1' => request()->expected_y2_q1[$key],
                            'y2_q2' => request()->expected_y2_q2[$key],
                            'y2_q3' => request()->expected_y2_q3[$key],
                            'y2_q4' => request()->expected_y2_q4[$key],
                            'y3_q1' => request()->expected_y3_q1[$key],
                            'y3_q2' => request()->expected_y3_q2[$key],
                            'y3_q3' => request()->expected_y3_q3[$key],
                            'y3_q4' => request()->expected_y3_q4[$key],
                            
                        ]);
        }
        $workplanB::insert($data->all());

        //WORKPLAN C
        //DELETE THEN INSERT NA LANG
        App\Models\ProjectWorkplanC::where('project_id',request()->project_id)->delete();
        
        $workplanC = new App\Models\ProjectWorkplanC;
        $data = collect([]);
        foreach (request()->assump_obj as $key => $value) {
            $data->push([
                            'project_id' => request()->project_id,
                            'objectives' => $value,
                            'risk' => request()->assump_risk[$key],
                            'action_plan' => request()->assump_action[$key]
                        ]);
        }
        $workplanC::insert($data->all());
    }

    public function update()
    {
        
    }

    public function delete()
    {
        $comment = App\Models\OSEP\OSEPComment::where('id',request()->delete_comment_id)->delete();
    }

    
    public function json($id)
    {
        $comment = App\Models\OSEP\OSEPComment::where('id',$id)->first();
        if($comment)
            return json_encode(['section_id' => $comment['project_section_id'],'comment' => $comment['comment']]);
    }

    public function print($id)
    {
        
    }
}
