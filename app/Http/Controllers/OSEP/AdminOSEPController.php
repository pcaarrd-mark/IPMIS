<?php

namespace App\Http\Controllers\OSEP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

use Illuminate\Database\Eloquent\Collection;

class AdminOSEPController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function dpmis()
    {
        $nav = activeNav('osep_dpmis');

        $data = [
                    "nav" => $nav
                ];

        return view('osep.admin.dpmis')->with('data',$data);
    }

    public function proposals()
    {
        $nav = activeNav('osep_proposals');

        $data = [
                    "nav" => $nav
                ];
                
        return view('osep.admin.proposals')->with('data',$data);
    }

    public function index()
    {
        $nav = activeNav('monitor_project');

        $data = [
                    "nav" => $nav
                ];
                
        return view('osep.admin.project')->with('data',$data);
    }

    public function assignDivision()
    {
        //UPDATE STATUS
        App\Models\Project::where('id',request()->project_id)->update(['status' => 2]);

        $monitoring = new App\Models\OSEP\OSEPMonitoringDivision;
        $div = "";
         
        $data = collect([]);
        $data->push([
            'project_id' => request()->project_id,
            'division_id' => request()->lead_division,
            'division_type' => 'Lead Monitoring Division',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $div .= getDivisionInfo(request()->lead_division).'(Lead Monitoring Division)'.",";

        
        foreach (request()->division as $key => $value) {
            // $data[] = array('project_id'=> request()->project_id, 'division_id'=> $value,'created_by' => Auth::user()->id,'created_at' => date('Y-m-d H:i:s'));

            $data->push([
                'project_id' => request()->project_id,
                'division_id' => $value,
                'division_type' => 'Monitoring Division',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $div .= getDivisionInfo($value).'(Monitoring Division)'.",";
        }

        addHistoryLog('Admin assigned project to Division : '.substr($div, 0, -1),'Project',request()->project_id);
        $monitoring::insert($data->all());
        //$monitoring::insert($data);
    }

    public function singleSendToDPMIS()
    {
        App\Models\Project::where('id',request()->project_id)->update(['status' => 8]);
        addHistoryLog('Sent to DPMIS','Project',request()->project_id);
        return redirect('/osep/proposals');
    }

    public function batchSendToDPMIS()
    {
        $data = [];
        foreach (request()->checkproposal as $key => $value) {
            $data[] = array('id'=> $value);
        }
        $ids = array_column($data, 'id');

        $proposal = App\Models\OSEP\OSEPProject::whereIn('id',$ids)->update(['status' => 3]);
    }

    public function batchAcceptFromDPMIS()
    {
        $data = [];
        foreach (request()->checkproposal as $key => $value) {
            $data[] = array('id'=> $value);

            addHistoryLog('Received from DPMIS','Project',$value);
        }
        $ids = array_column($data, 'id');

        $proposal = App\Models\Project::whereIn('id',$ids)->update(['status' => 9]);
    }

    public function adminUpdateStatus(Request $request)
    {
        App\Models\Project::where('id',request()->update_project_id)->update(['status' => request()->statusAdmin]);
        
        switch (request()->statusAdmin) {
            case 11:
                addHistoryLog('Schedule for DC : '.request()->updateDate,'Project',request()->update_project_id);   
            break;
            case 12:
                addHistoryLog('DC Approved : '.request()->updateRemarks,'Project',request()->update_project_id);   
            break;
            case 13:
                addHistoryLog('Schedule for GC : '.request()->updateDate,'Project',request()->update_project_id);   
            break;
            case 14:
                addHistoryLog('GC Approved: '.request()->updateRemarks,'Project',request()->update_project_id);   
            break;
            case 16:
                addHistoryLog('GC Disapproved: '.request()->updateRemarks,'Project',request()->update_project_id);   
            break;
            case 17:
                addHistoryLog('GC Disapproved: '.request()->updateRemarks,'Project',request()->update_project_id);   
            break;
        }
    }
}
