<?php

function formatCash($val)
{
	if($val == 0 || $val == null || $val == "")
	{
		return "0.00";
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
		$yr = date('Y');
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

function getDivisionProposalType($type,$div)
{
	$proj = App\Models\BP202\BP202_Project::where('proposal_type',$type)->where('created_by_division',$div)->count();
	return $proj;
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