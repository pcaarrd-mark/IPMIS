<?php

function formatCash($val)
{
	if($val == 0 || $val == null || $val == "")
	{
		return "-";
	}
	else
	{
		return number_format($val,2);
	}
}

function auditTrail($msg)
{
	Log::channel('audit')->info($msg);
}

function showAppAuth()
{
	$tbl = App\Models\Library\Approving_authority::get();
	return $tbl;
}

function getTotalProposal($type = null)
{
	if($type)
	{
		if($type == 'RD')
			$proj = App\Models\BP202\BP202_Project::where('proposal_type','RD')->get();
		else
			$proj = App\Models\BP202\BP202_Project::where('proposal_type','NONRD')->get();
	}
	else
	{
		$proj = App\Models\BP202\BP202_Project::get();
	}

	return count($proj);
}

function getTotalProposalBudget($type = null)
{
	if($type)
	{
		if($type == 'RD')
			$proj = App\Models\BP202\BP202_Project::where('proposal_type','RD')->get();
		else
			$proj = App\Models\BP202\BP202_Project::where('proposal_type','NONRD')->get();
	}
	else
	{
		$proj = App\Models\BP202\BP202_Project::get();
	}

	$yr1_cost = 0;
	foreach ($proj as $key => $value) {
		$pap_exp = App\Models\BP202\BP202_pap_attribution::where('project_id',$value->id)->where('yr',2024)->get();
		
		if(count($proj) > 0)
		{
			foreach ($pap_exp as $key => $pap_exps)
			{
				$yr1_cost += $pap_exps->val;
			}
		}
	}

	$yr1_cost = convertAmount($yr1_cost);
	return $yr1_cost;
	
}

function getTotalProjCost($yr = null)
{
	if($yr)
	{
		$yr = $yr;
	}
	else
	{
		$yr = date('Y') + 1;
	}

	// $projcost = App\Models\BP202\BP202_pap_attribution::where('yr', $yr)
    //     ->groupBy('yr')
    //     ->sum('val');

	$totalcost = 0;

	$proj = App\Models\BP202\BP202_Project::get();
		foreach ($proj as $key => $value) {
			$projcost = App\Models\BP202\BP202_pap_attribution::where('project_id',$value->id)->where('yr', $yr)->get();
			foreach($projcost AS $costs)
			{
				$totalcost += $costs->val;
			}
			
		}
	
		$totalcost = convertAmount($totalcost);
		return $totalcost;
}

function cashFormat($val)
{
	return number_format($val);
}

function getCategory()
{
	return App\Models\BP202\BP202_Category::get();
}

function ave($total,$val)
{
	if($val > 0)
	{
		$percent = $val/$total;
		return round($percent * 100,1);
	}
	else
	{
		return 0;
	}
	
}

function getYearAmount($tbl,$projid,$sub,$yr = null,$code = null)
{
	switch($tbl)
	{
		case 'pap_exp':
			$result = App\Models\BP202\BP202_pap_attribution::where('project_id',$projid)->where('pap_code',$code)->where('pap_sub',$sub)->where('yr',$yr)->first();
		break;
		case 'pap_infra':
			$result = App\Models\BP202\BP202_opt_cost_infra::where('project_id',$projid)->where('pap_code',$code)->where('infra_sub',$sub)->where('yr',$yr)->first();
		break;
		case 'phy_target':
			$result = App\Models\BP202\BP202_target_accomp::where('project_id',$projid)->where('accom',$sub)->where('yr',$yr)->first();
		break;
		case 'proj_cost':
			$result = App\Models\BP202\BP202_total_proj_cost::where('project_id',$projid)->where('expense_sub',$sub)->first();
		break;
	}
	
	if(isset($result['val']))
		return $result['val'];
	else
		return null;
}

function getLibraryDesc($tbl,$id,$desc)
{
	//return $tbl;
	switch ($tbl) {
		case 'agency':
				$result = App\Models\Library\Agency::where('id',$id)->first();
			break;
		
		case 'pap':
				$result = App\Models\Library\Allotment_class::where('id',$id)->first();
			break;
		
		case 'pap_code':
				$result = App\Models\Library\PAP::where('pap_code',$id)->first();
			break;

		case 'municipal':
				$result = App\Models\Library\Loc_Municipal::where('id',$id)->first();
			break;

		case 'province':
				$result = App\Models\Library\Loc_Province::where('id',$id)->first();
			break;
		
		case 'region':
				$result = App\Models\Library\Region::where('id',$id)->first();
			break;
		case 'division':
				$result = App\Models\Library\Division::where('division_id',$id)->first();
			break;
		
		default:
			# code...
			break;
	}

	if(isset($result[$desc]))
		return $result[$desc];
	else
		return null;
}

function getAppAuthVal($projid,$id,$ty)
{
	switch ($ty) {
		case 'radio':
				$auth = App\Models\BP202\BP202_approve_auth::where('project_id',$projid)->where('approv_auth_id',$id)->first();
				if(isset($auth['approv_auth_radio']))
					return $auth['approv_auth_radio'];
				else
					return null;
			break;
		
		default:
				$auth = App\Models\BP202\BP202_approve_auth::where('project_id',$projid)->where('approv_auth_id',$id)->first();
				if(isset($auth['approv_auth_remarks']))
					return $auth['approv_auth_remarks'];
				else
					return null;
			break;
	}
}

function getPeriod()
{
	$list = App\Models\BP202\BP202_Project::groupBy('period')->get();
	return $list;
}

function convertAmount($amt)
{
	//count decimal if any
	$dec = strlen(strrchr($amt, '.'));

	//return $amt;
	
	switch(true)
	{
		case $dec == 2:
			$zer = "00";
		break;
		case $dec == 3:
			$zer = "0";
		break;
		case $dec == 0:
			$zer = "000";
		break;
		case $dec >= 4:
			$zer = "";
		break;
	}

	$amt = (int)(str_replace('.', '' , ($amt.''.$zer)));
	return $amt;
}

function getDivision()
{
	//$getAllDiv = App\Models\BP202\BP202_Project::groupBy('created_by_division')->get();
    $tbl = App\Models\Library\Division::whereNotIn('division_id',['s','q','t','m','r','v','u','x','C'])->orderBy('acronym')->get();
    return $tbl;
}

function getDivisionProposal($id)
{
    $tbl = App\Models\BP202\BP202_Project::where('created_by_division',$id)->count();
    return $tbl;
}

function getDivisionProposalBudget($id,$yr)
{
	$totalcost = 0;

	$proj = App\Models\BP202\BP202_Project::where('created_by_division',$id)->get();
		foreach ($proj as $key => $value) {
			$projcost = App\Models\BP202\BP202_pap_attribution::where('project_id',$value->id)->where('yr',$yr)->get();
			foreach($projcost AS $costs)
			{
				$totalcost += $costs->val;
			}
			
		}
	
		$totalcost = convertAmount($totalcost);
		return $totalcost;
}

function getDivisionProposalType($type,$div,$yr = null)
{
	if(!$yr)
	{
		$proj = App\Models\BP202\BP202_Project::where('proposal_type',$type)->where('created_by_division',$div)->count();
		return $proj;
	}
	else
	{
		if($type)
		{	
			$proj = App\Models\BP202\BP202_Project::where('proposal_type',$type)->where('created_by_division',$div)->get();
		}
		else
		{
			$proj = App\Models\BP202\BP202_Project::where('created_by_division',$div)->get();
		}
		
		$totalproj = 0;
		foreach($proj AS $projs)
			{
				$projcost = App\Models\BP202\BP202_pap_attribution::where('project_id',$projs->id)->where('yr',$yr)->groupBy('project_id')->get();
				foreach($projcost AS $costs)
				{
					$totalproj++;
				}
			}
		return $totalproj;
	}
	
}

function formatNum($val)
{
	if($val == 0 || $val == null)
	{
		return "-";
	}
	else
	{
		return $val;
	}
}

function getRankingCount()
{
	$ctr = App\Models\BP202\BP202_Project::get();
	return $ctr;
}

function getRankingExist()
{
	$ctr = App\Models\BP202\BP202_Project::whereNotNull("project_ranking")->get();
	return $ctr;
}

function getProgramDetails($id,$col)
{
	$prog = App\Models\OSEP\View_OSEPProgram::where('id',$id)->first();
	return $prog[$col];
}

function countMonths($d1,$d2)
{
	$toDate = Carbon\Carbon::parse($d2);
	$fromDate = Carbon\Carbon::parse($d1);
	$months = $toDate->diffInMonths($fromDate);

	return ++$months;
}

function getProgram()
{
	return App\Models\OSEP\View_OSEPProgram::where('created_by',Auth::user()->id)->get();
}

function getBudget($projid,$budgetid,$libtype)
{
	$lib = App\Models\LIB::where('project_id',$projid)->where('lib_year_id',$budgetid)->where('lib_type',$libtype)->get();
	$proj = App\Models\OSEP\View_OSEPProject::where('id',$projid)->first();
	if(count($lib) > 0)
	{
		$total = 0;
		foreach ($lib as $value) {
			$total += $value->jan + $value->feb + $value->mar + $value->apr + $value->may + $value->jun + $value->jul + $value->aug + $value->sep + $value->oct + $value->nov + $value->dec;
		}
		return "<center>".number_format($total,2)."</center>";
	}
	else
	{
		if($proj['created_by'] == Auth::user()->id)
			return "<center><span class='text-danger'><code>CLICK TO ADD BUDGET</code></span></center>";
		else
			return "<center><span class='text-danger'><code>NO DATA</code></span></center>";
	}
}

function getBudgetList($projid,$budgetid,$libtype)
{
	$lib = App\Models\OSEP\LIB::where('project_id',$projid)->where('budget_id',$budgetid)->where('lib_type',$libtype)->get();
	return $lib;
}

function getProjCost($projid,$progid = null,$cost = null)
{
	if($progid)
	{
		$proj = App\Models\Project::where('program_id',$progid)->get();
		if($proj)
		{
			$total = 0;
			foreach ($proj as $value) {
				$lib = App\Models\OSEP\LIB::where('project_id',$value->id)->get();
				if(count($lib) > 0)
				{
					foreach ($lib as $value) {
						$total += $value->jan + $value->feb + $value->mar + $value->apr + $value->may + $value->jun + $value->jul + $value->aug + $value->sep + $value->oct + $value->nov + $value->dec;
					}
				}
			}

			return number_format($total,2);

		}
		else
		{
			return "-";
		}
	}
	else
	{
		if(isset($cost) && $cost == 'counterpart')
			$lib = App\Models\OSEP\LIB::where('project_id',$projid)->where('cost_type','Indirect')->get();
		elseif(isset($cost) && $cost == 'totalcost')
			$lib = App\Models\OSEP\LIB::where('project_id',$projid)->get();
		else
			$lib = App\Models\OSEP\LIB::where('project_id',$projid)->where('cost_type','Direct')->get();

		if(count($lib) > 0)
		{
			$total = 0;
			foreach ($lib as $value) {
				$total += $value->jan + $value->feb + $value->mar + $value->apr + $value->may + $value->jun + $value->jul + $value->aug + $value->sep + $value->oct + $value->nov + $value->dec;
			}
			return number_format($total,2);
		}
		else
		{
			//return "<center><span class='text-danger'>ADD LIB</span></center>";
		}
	}

}

function getStatus($id,$style = null)
{
	$status = App\Models\OSEP\Status::where('id',$id)->first();

	return $status['description'];
	
}

function getBudgetLIBExpenditure($projectid,$budgetid)
{
	$lib = App\Models\LIB::where('project_id',$projectid)->where('lib_type',$budgetid)->groupBy('expenditure_id')->get();
	return $lib;
}

function getAllotmentLib($id,$arr = null)
    {
        switch ($id) {
            case 'PS':
                    $id = 1;
                break;
            case 'MOOE':
                    $id = 2;
                break;
            case 'CO':
                    $id = 3;
                break;
        }
        $tbl = App\Models\Library\LIB::where('allotment_class_id',$id)->get();

        return $tbl;
    }
function getBudgetLIBExpenditureSub($projectid,$budgetid,$expenditureid)
{
	$lib = App\Models\LIB::where('project_id',$projectid)->where('budget_id',$budgetid)->where('expenditure_id',$expenditureid)->get();
	return $lib;
}

function addHistoryLog($msg,$type,$id)
{
	$history = new App\Models\History;
	$history->type = $type;
	$history->type_id = $id;
	$history->msg = $msg;
	$history->action_by = Auth::user()->id;
	$history->save();
}

function getUserInfo($id,$col)
{
	$user = App\Models\User::where('id',$id)->first();
	return strtoupper($user[$col]);
}

function getDivisionInfo($id)
{
	$tbl = App\Models\Library\Division::where('division_id',$id)->first();
	return $tbl['acronym'];
}


function getCommentSection($type,$id = null)
{
	if($id)
	{
		$tbl = App\Models\OSEP\OSEPProjectSection::where('id',$id)->first();
		return $tbl['description'];
	}
	else
	{
		$tbl = App\Models\OSEP\OSEPProjectSection::where('type',$type)->get();
		return $tbl;
	}
	
}

function getAgencyProject($projectid)
{
	$agency = App\Models\Project_agency::where('project_id',$projectid)->get();
	return $agency;
}


function getLIB($projid,$libyrid,$class)
{
	
	$lib = App\Models\OSEP\LIB::where('project_id',$projid)->where('lib_year_id',$libyrid)->where('lib_type',$class)->get();
	$data = collect([]);

        foreach ($lib as $key => $value)
        {
            $data->push([
							'id' => $value->id,
							'expenditure_id' => $value->expenditure_id,
							'expenditure' => getExpenditure($value->expenditure_id)."<br/>".$value->expenditure_sub,
                            'project_id' => $value->project_id,
                            'lib_year_id' => $value->lib_year_id,
							'agency_id' => $value->agency_id,
							'agency' => getLibraryDesc('agency',$value->agency_id,'acronym'),
							'agency_type' => $value->agency_type,
							'cost_type' => $value->cost_type,
                            'lib_type' => $value->lib_type,
                            'jan' => $value->jan,
                            'feb' => $value->feb,
                            'mar' => $value->mar,
                            'apr' => $value->apr,
                            'may' => $value->may,
                            'jun' => $value->jun,
                            'jul' => $value->jul,
                            'aug' => $value->aug,
                            'sep' => $value->sep,
                            'oct' => $value->oct,
                            'nov' => $value->nov,
                            'dec' => $value->dec,
							'total' => number_format(($value->jan + $value->feb + $value->mar + $value->apr + $value->may + $value->jun + $value->jul + $value->aug + $value->sep + $value->oct + $value->nov + $value->dec),2),
                        ]);
        }
	return $data->all();
}

function getExpenditure($id)
{
	$lib = App\Models\Library\LIB::where('id',$id)->first();
	return $lib['object_expenditure'];
}

function getMon($i)
{
	--$i;
	$months = [
		'JAN',
		'FEB',
		'MAR',
		'APR',
		'MAY',
		'JUN',
		'JUL',
		'AUG',
		'SEP',
		'OCT',
		'NOV',
		'DEC'
		];

	return $months[$i];
}

function getLibMonths($projectid,$yr)
{
	$projlib = App\Models\LIBYear::where('project_id',$projectid)->where('year',$yr)->first();
	return $projlib['months'];
}

function count_date($start_date,$end_date,$type='d')
{
     $start_date             =       new DateTime($start_date);
     $end_date               =       date('Y-m-d',strtotime($end_date));
     $end_date               =       new DateTime($end_date);
     $get_val                =       $end_date->diff($start_date);
     $result                 =       $get_val->format('%'.$type);
     return $result;
}

function getLIBDetails($type,$projectid = null,$yr = null,$cls = null,$agency = null)
{
	$total = 0;
	if($type == 'specific')
	{
		
		if($agency)
		{

		}
		else
		{
			$lib = App\Models\LIB::where('project_id',$projectid)->where('budget_yr',$yr)->where('object_class',$cls)->where('counterpart','No')->get();
			$total = 0;
			foreach ($lib as $value) {
				$total += App\Models\LIBMons::where('lib_id',$value->id)->sum('amt');
			}
		}
		
	}
	elseif($type == 'budget')
	{
		$lib = App\Models\LIB::where('project_id',$projectid)->where('counterpart','No')->get();
			$total = 0;
			foreach ($lib as $value) {
				$total += App\Models\LIBMons::where('lib_id',$value->id)->sum('amt');
			}
	}
	elseif($type == 'counterpart')
	{
		$lib = App\Models\LIB::where('project_id',$projectid)->where('counterpart','Yes')->get();
			$total = 0;
			foreach ($lib as $value) {
				$total += App\Models\LIBMons::where('lib_id',$value->id)->sum('amt');
			}
	}
	elseif($type == 'total')
	{
		$lib = App\Models\LIB::where('project_id',$projectid)->get();
			$total = 0;
			foreach ($lib as $value) {
				$total += App\Models\LIBMons::where('lib_id',$value->id)->sum('amt');
			}
	}

	return $total;
}

function getLIBList($projectid,$agencyid,$yr,$cls,$cost)
{
	$list = App\Models\LIB::where('project_id',$projectid)->where('agency_id',$agencyid)->where('budget_yr',$yr)->where('object_class',$cls)->where('cost',$cost)->get();

	return $list;
}

function getLIBMon($libid)
{
	return App\Models\LIBMons::mons($libid);
}

function randomCode()
{
	return Str::random(50);
}

function randomNum()
{
	return rand(1000000000,9000000000);
}
function budgetLibrary($id)
{
    $tbl = App\Models\Library\LIB::where('allotment_class_id',$id)->get();
    return $tbl;
}

function getProjectYear($id)
{
	return App\Models\LIB::totalYear($id);
}

function formatDuration($from_mon,$from_yr,$to_mon,$to_yr)
{
	if(isset($from_mon))
            {
                $start_mon = date('F',mktime(0, 0, 0, $from_mon, 10));
                $start_year = $from_yr;
                $end_mon = date('F',mktime(0, 0, 0, $to_mon, 10));
                $end_year = $to_yr;

                //MONTHS
                $d1 = $start_year."-". $from_mon."-01";
                $d2 = $end_year."-". $to_mon."-01";
                $mon = countMonths($d1,$d2);

                $duration = $start_mon." ".$start_year." - ".$end_mon." ".$end_year." (".$mon." months)";
            }
            else
            {
                $duration = "N/A";
            }
	return $duration;
}

function formatCurrentDuration($projectid,$yrnum,$from_mon,$from_yr,$to_mon,$to_yr)
{
	//GET MUNA YUNG TOTAL DURATION
	$start_mon = date('F',mktime(0, 0, 0, $from_mon, 10));
	$start_year = $from_yr;
	$end_mon = date('F',mktime(0, 0, 0, $to_mon, 10));
	$end_year = $to_yr;

	//MONTHS
	$d1 = $start_year."-". $from_mon."-01";
	$d2 = $end_year."-". $to_mon."-01";
	$mon = countMonths($d1,$d2);

	$mon1 = $from_mon;

	//GET TOTAL YEAR
	$totalyr = App\Models\LIBYear::totalYear($projectid);

	$data = [];
	$yr =  $from_yr;
	foreach ($totalyr as $value) {

		$totalmons = getLibMonths($projectid,$value->year);
		$mons =  $from_mon;
		for ($i=1; $i <= $totalmons; $i++) { 

			if($i == 1)
				$frommon = $mons;

			if($i == $totalmons)
			{
				if($mons >= 13)
				{
					$newmons = $mons - 12;

						$data[] = [
							'project_yr' => $value->year,
							'from_mon' => date('F',mktime(0, 0, 0, $frommon, 10)),
							'from_year' => $yr,
							'to_mon' => date('F',mktime(0, 0, 0, $newmons, 10)),
							'to_year' => ++$yr,
							'total_mons' => $totalmons,
						];
				}
				else
				{
					$data[] = [
						'project_yr' => $value->year,
						'from_mon' => date('F',mktime(0, 0, 0, $frommon, 10)),
						'from_year' => $yr,
						'to_mon' => date('F',mktime(0, 0, 0, $mons, 10)),
						'to_year' => $yr,
						'total_mons' => $totalmons,
					];
				}
			}
			$mons++;
		}
	}
    

	// $data = [];
	// $yr = 1;
	// for($i = 1;$i <= $mon; $i++)
	// {
	// 	// $data[] = [
	// 	// 	'mon' => $i,
	// 	//   ];
		
	// 	if($i == 1)
	// 	{
	// 		$totalmons = getLibMonths($projectid,$yr);
	// 		$to_mon = $totalmons + $mon1;
	// 		$data[] = [
    //                     'yr' => $yr,
    //                     'from_mon' => $mon1,
	// 					'to_mon' => $to_mon,
    //                   ];
	// 	}

	// 	if($mon1 >= 12)
	// 	{
	// 		$to_mon = $totalmons + $mon1;
	// 		$mon1 -= 12;
	// 		$data[] = [
	// 			'yr' => $yr,
	// 			'from_mon' => $mon1,
	// 			'to_mon' => $to_mon,
	// 		  ];
			
	// 		  $yr++;
	// 	}
        
	// 	$mon1++;
	// }

	return $data[--$yrnum];
}

function getValueByClassCost($projectid,$projyear,$cls,$cost)
{
	$totalprojcost = 0;
	//GET ALL LIB Implementing Agency
	if($cost == 'total')
	{	
		if($projyear == 0)
			$projagencylib = App\Models\LIB::where('project_id',$projectid)->where('counterpart','No')->groupBy('agency_id')->get();
		else
			$projagencylib = App\Models\LIB::where('project_id',$projectid)->where('budget_yr',$projyear)->where('counterpart','No')->groupBy('agency_id')->get();

		if($cls == 'all')
		{
			if($projyear == 0)
				$lib = App\Models\LIB::where('project_id',$projectid)->where('counterpart','No')->get();
			else
				$lib = App\Models\LIB::where('project_id',$projectid)->where('budget_yr',$projyear)->where('counterpart','No')->get();
		}	
		else
		{
			if($projyear == 0)
				$lib = App\Models\LIB::where('project_id',$projectid)->where('object_class',$cls)->where('counterpart','No')->get();
			else
				$lib = App\Models\LIB::where('project_id',$projectid)->where('budget_yr',$projyear)->where('object_class',$cls)->where('counterpart','No')->get();
		}
			

		$total = 0;
		$tr = '';
		foreach ($projagencylib as $key => $value) 
		{
			
		$td = '';
		foreach ($projagencylib as $agencies) {
			if($cls == 'all')
			{
				if($projyear == 0)
					$lib = App\Models\LIB::where('project_id',$projectid)->where('agency_id',$agencies->agency_id)->where('counterpart','No')->get();
				else
					$lib = App\Models\LIB::where('project_id',$projectid)->where('budget_yr',$projyear)->where('agency_id',$agencies->agency_id)->where('counterpart','No')->get();
			}
			else
			{
				if($projyear == 0)
					$lib = App\Models\LIB::where('project_id',$projectid)->where('agency_id',$agencies->agency_id)->where('object_class',$cls)->where('counterpart','No')->get();
				else
					$lib = App\Models\LIB::where('project_id',$projectid)->where('budget_yr',$projyear)->where('agency_id',$agencies->agency_id)->where('object_class',$cls)->where('counterpart','No')->get();
			}
				

			$total = 0;
			foreach ($lib as  $libs) 
			{
				$totalprojcost += getValueByClassCostByAgency($libs->id,$agencies->agency_id);
				$total += getValueByClassCostByAgency($libs->id,$agencies->agency_id);
			}

							$td .= '<td style="border:1px solid #FFF;width:20%" align="right">
										<b>'.formatCash($total).'</b>
									</td>';
						}
					
			$tr = $td;
		}

		
	}
	else
	{
		if($projyear == 0)
			$projagencylib = App\Models\LIB::where('project_id',$projectid)->where('counterpart','No')->groupBy('agency_id')->get();
		else
			$projagencylib = App\Models\LIB::where('project_id',$projectid)->where('budget_yr',$projyear)->where('counterpart','No')->groupBy('agency_id')->get();

		
		if($projyear == 0)
			$lib = App\Models\LIB::where('project_id',$projectid)->where('object_class',$cls)->where('cost',$cost)->where('counterpart','No')->get();
		else
			$lib = App\Models\LIB::where('project_id',$projectid)->where('budget_yr',$projyear)->where('object_class',$cls)->where('cost',$cost)->where('counterpart','No')->get();

		$total = 0;
		$tr = '';
		foreach ($lib as $key => $value) 
		{
			$tr .= '<tr valign="top">
						<td style="border:1px solid #FFF;">
						</td>
						<td style="border:1px solid #FFF;">
							'.getClassDetail($value->object_expenditure).' '.getRemarks($value->object_remarks).'
						</td>';
			
			$td = '';
			foreach ($projagencylib as $agencies) {
							$totalprojcost += getValueByClassCostByAgency($value->id,$agencies->agency_id);
							$td .= '<td style="border:1px solid #FFF;width:20%" align="right">
										'.formatCash(getValueByClassCostByAgency($value->id,$agencies->agency_id)).'
									</td>';
						}
					
			$tr .=	$td.'</tr>';
		}
	}
	


	return $tr."|".$totalprojcost;
}

function getValueByClassCostByAgency($libid,$agencyid)
{
	$lib = App\Models\LIB::where('id',$libid)->where('agency_id',$agencyid)->get();
	$total = 0;

	foreach ($lib as $key => $value) {
		$libmons = App\Models\LIBMons::where('lib_id',$value->id)->get();
			foreach ($libmons as $val) {
				$total += $val->amt;
			}
	}
	
	return $total;
}


function getClassDetail($id)
{
	return App\Models\Library\LIB::getDetail($id);
}

function getRemarks($remarks)
{
	if($remarks)
		return "<br>-".$remarks;
}

function getAllComments($projectid,$type = null)
{
	if($type == 'list')
	{
		$comments = App\Models\OSEP\OSEPComment::where('project_id',$projectid)->get();
		return $comments;
	}
	else
	{
		$comments = App\Models\OSEP\OSEPComment::where('project_id',$projectid)->count();
		if($comments >= 0)
			return "(".$comments.")";
	}
	
	
}

function getComments($projectid,$sectionid,$type)
{
	if($type == 'list')
	{
		$comments = App\Models\OSEP\OSEPComment::where('project_id',$projectid)->where('project_section_id',$sectionid)->get();
		if(count($comments) >= 0)
			return $comments;
		else
			return null;
	}
	else
	{
		$comments = App\Models\OSEP\OSEPComment::where('project_id',$projectid)->count();
		if($comments >= 0)
			return "(".$comments.")";
	}
	
	
}

function getAllProjectSection(Array $arr = null)
{
	if($arr)
	{
		$list = App\Models\OSEP\OSEPProjectSection::whereIn('id',$arr)->get();
	}
	else
		$list = App\Models\OSEP\OSEPProjectSection::get();

	return $list;
}

function getAllProjectContent($projectid,$section,$cl = null)
{
	// return $projectid." ".$section." ".$cl;
	$project = App\Models\Project::where('id',$projectid)->first();
	

	if($cl)
	{
		$projectsection = App\Models\ProjectSection::where('project_id',$projectid)->first();
		if(isset($projectsection[$cl]))
			$col = $projectsection[$cl];
		else
			// $col = "ERROR : ".$cl;
			$col = "N/A";
	}
	else
	{
		switch ($section) {
			case 1:
					$col = getProgramDetails($project['program_id'],'title');
					//$col = "";
				break;
			case 2:
					$col = $project['title'];
				break;
			case 3:
					$col = formatDuration($project['duration_from_month'],$project['duration_from_year'],$project['duration_to_month'],$project['duration_to_year']);
				break;

			case 4:
				//GET IMPLENTING AND CO-IMPLEMENT AGENCY ONLY
					$projagency = App\Models\Project_agency::where('project_id',$projectid)->whereIn('agency_type',['Implementing','Co-implementing'])->get();
					$col = "";
					foreach ($projagency as $key => $value) {
						$col .= App\Models\Library\Agency::getDetails($value->agency_id)."<br/>";
					}
				break;
			
			default:
					$col = "";
				break;
		}
	}
	

	return $col;
}

function getProjectSiteList($projectid)
{
	return App\Models\ProjectSite::where('project_id',$projectid)->get();
}


function getProjectOtherList($projectid)
{
	return App\Models\ProjectOthers::where('project_id',$projectid)->get();
}

function getLocationLib($tbl,$id)
{
	switch ($tbl) {
		case 'region':
				$loc = App\Models\Library\Loc_Region::where('id',$id)->first();
				return $col = $loc['region_number'];
			break;
		case 'province':
				$loc = App\Models\Library\Loc_Province::where('id',$id)->first();
				return $col = $loc['province'];
			break;
		case 'municipal':
				$loc = App\Models\Library\Loc_Municipal::where('id',$id)->first();
				return $col = $loc['municipality'];
			break;
		case 'brgy':
				$loc = App\Models\Library\Loc_Barangay::where('id',$id)->first();
				return $col = $loc['barangay'];
			break;
	}

	return $loc;
}

function getSiteImp($projectid)
{
	$site = App\Models\ProjectSite::where('project_id',$projectid)->get();
	return $site;
}

function getProjectPersonnel($projectid)
{
	$site = App\Models\ProjectPersonnel::where('project_id',$projectid)->get();
	return $site;
}

function getOtherProject($projectid)
{
	$site = App\Models\ProjectOthers::where('project_id',$projectid)->get();
	return $site;
}

function divisionProject($projectid)
{
	if(Auth::user()->usertype == 'ISP Manager')
	{
		$project = App\Models\OSEP\OSEPMonitoringDivision::where('project_id',$projectid)->where('division_id',Auth::user()->division)->get();
		if(count($project) > 0)
			return true;
		else
			return false;
	}
	else
	return true;
	
}

function getSection($id)
{
	$section = App\Models\OSEP\OSEPProjectSection::where('id',$id)->first();
	return $section['description'];
}

function getExpectedOut($grp)
{
	$list = App\Models\ExpectedOutput::where('grp',$grp)->get();
	return $list;
}

function getWorkplan($grp,$project_id)
{
	switch ($grp) {
		case 'A':
			$list = App\Models\ProjectWorkplanA::where('project_id',$project_id)->get();
		break;
		case 'C':
			$list = App\Models\ProjectWorkplanC::where('project_id',$project_id)->get();
		break;
	}
	
	return $list;
}

function getWorkplanB($projectID,$expectedOutputID,$col)
{
	$data = App\Models\ProjectWorkplanB::where('project_id',$projectID)->where('expected_output_id',$expectedOutputID,)->first();
	if($data)
		return $data[$col];
}

function getWorkplanBTotal($projectID,$expectedOutputID,$yr)
{
	$data = App\Models\ProjectWorkplanB::where('project_id',$projectID)->where('expected_output_id',$expectedOutputID)->first();
	if($data)
		return $data["y".$yr."_q1"] + $data["y".$yr."_q2"] + $data["y".$yr."_q3"] + $data["y".$yr."_q4"];
}

function ifOwner($projectID)
{
	$list = App\Models\Project::where('id',$projectID)->where('created_by',Auth::user()->id)->first();
	if($list)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function ifNull($val)
{
	if($val == NULL || $val == "" || $val === " ")
		return "N/A";
	else
		return $val;
}

function getProjectDate($duration,$projectID)
{
	if($duration == 'total')
	{
		$project = App\Models\Project::where('id',$projectID)->first();
		return totalmonths($project['duration_from_month'],$project['duration_from_year'],$project['duration_to_month'],$project['duration_to_year']);
	}
	else
	{
		$project = App\Models\Project::where('id',$projectID)->first();
		if($duration == 'start')
		{
			$colmon = 'duration_from_month';
			$colyear = 'duration_from_year';
		}
		else
		{
			$colmon = 'duration_to_month';
			$colyear = 'duration_to_year';
		}

		$mon = date('F',mktime(0, 0, 0, $project[$colmon], 10));
			
		$yr = $project[$colyear];
		return $mon." ".$yr;
	}
}

function totalmonths($monstart,$yearstart,$monend,$yearend)
{
	//MONTHS
	$d1 = $yearstart."-". $monstart."-01";
	$d2 = $yearend."-". $monend."-31 ";
	
	try {
		$mon = countMonths($d1,$d2);
		$duration = $mon;
	} catch (\Throwable $th) {
		$duration = 'Invalid Date';
	}

	return $duration;
}


