<?php

function activeNav($activepage = null)
{
	$dashboard = "";

	$osep = "";
	$osep_menu = "";
	$osep_project = "";
	$osep_program = "";
	$osep_summary = "";
	$osep_dashboard = "";
	$osep_dpmis = "";
	$osep_proposals = "";

	$bp202_menu = "";
    $bp202 = "";
	$program = "";
	$project = "";
	$bp202summary = "";
	$bp202_dashboard = "";
	$bp202_priority = "";

	$bp206_menu = "";
	$bp206 = "";

	$bp206_project = "";
	$bp206_summary = "";

	$bp207_menu = "";
	$bp207 = "";
	$bp207_project = "";
	$bp207_summary = "";

	$settings_menu = "";
	$settings = "";
	$settings_account = "";

	$proponent_dashboard = "";
	$ispmanager_dashboard = "";

	$osep_division_program = "";
	$osep_division_project = "";

	$monitor_menu = "";
	$monitor = "";
	$monitor_project = "";


	switch ($activepage) {
		//ADMIN
		case 'dashboard':
			# code...
				$dashboard = "active";
			break;
		case 'program':
			# code...
                $bp202_menu = "menu-open";
                $bp202 = "active";
                $program = "active";
			break;
		case 'project':
			# code...
                $bp202_menu = "menu-open";
                $bp202 = "active";
                $project = "active";
			break;
		case 'bp202summary':
			# code...
                $bp202_menu = "menu-open";
                $bp202 = "active";
                $bp202summary = "active";
			break;
		case 'bp202_dashboard':
			# code...
                $bp202_menu = "menu-open";
                $bp202 = "active";
                $bp202_dashboard = "active";
			break;
		case 'bp202_priority':
			# code...
                $bp202_menu = "menu-open";
                $bp202 = "active";
                $bp202_priority = "active";
			break;
		case 'bp206_project':
			# code...
                $bp206_menu = "menu-open";
                $bp206 = "active";
                $bp206_project = "active";
			break;
		case 'bp206_summary':
			# code...
                $bp206_menu = "menu-open";
                $bp206 = "active";
                $bp206_summary = "active";
			break;
		case 'bp207_project':
			# code...
                $bp207_menu = "menu-open";
                $bp207 = "active";
                $bp207_project = "active";
			break;
		case 'bp207_summary':
			# code...
                $bp207_menu = "menu-open";
                $bp207 = "active";
                $bp207_summary = "active";
			break;
		case 'osep_project':
			# code...
                $osep_menu = "menu-open";
                $osep = "active";
                $osep_project = "active";
			break;
		case 'osep_program':
			# code...
                $osep_menu = "menu-open";
                $osep = "active";
                $osep_program = "active";
			break;
		case 'osep_dashboard':
			# code...
                $osep_menu = "menu-open";
                $osep = "active";
                $osep_dashboard = "active";
			break;
		case 'osep_dpmis':
			# code...
                $osep_menu = "menu-open";
                $osep = "active";
                $osep_dpmis = "active";
			break;
		case 'osep_proposals':
			# code...
                $osep_menu = "menu-open";
                $osep = "active";
                $osep_proposals = "active";
			break;
		case 'settings_account':
			# code...
                $settings_menu = "menu-open";
                $settings = "active";
                $settings_account = "active";
			break;
		case 'proponent_dashboard':
			# code...
                $proponent_dashboard = "active";
			break;
		
		case 'ispmanager_dashboard':
			# code...
                $ispmanager_dashboard = "active";
			break;

		case 'osep_division_program':
			# code...
                $osep_division_program = "active";
			break;
		case 'osep_division_project':
			# code...
                $osep_division_project = "active";
			break;
		case 'monitor_project':
			# code...
                $monitor_menu = "menu-open";
                $monitor = "active";
                $monitor_project = "active";
			break;

	}

	return  [
				"dashboard" => $dashboard,
				"proponent_dashboard" => $proponent_dashboard,
				"ispmanager_dashboard" => $ispmanager_dashboard,

				"osep_division_program" => $osep_division_program,

				"osep_menu" => $osep_menu,
				"osep" => $osep,
				"osep_project" => $osep_project,
				"osep_dashboard" => $osep_dashboard,
				"osep_program" => $osep_program,
				"osep_dpmis" => $osep_dpmis,
				"osep_proposals" => $osep_proposals,

                "bp202_menu" => $bp202_menu,
				"bp202" => $bp202,
				"bp202_dashboard" => $bp202_dashboard,
				"program" => $program,
				"project" => $project,
				"bp202summary" => $bp202summary,
				"bp202_priority" => $bp202_priority,

				"bp206_menu" => $bp206_menu,
				"bp206" => $bp206,
				"bp206_project" => $bp206_project,
				"bp206_summary" => $bp206_summary,

				"bp207_menu" => $bp207_menu,
				"bp207" => $bp207,
				"bp207_project" => $bp207_project,
				"bp207_summary" => $bp207_summary,

				'monitor_menu' => $monitor_menu,
				'monitor' => $monitor,
				'monitor_project' => $monitor_project,

				"settings_menu" => $settings_menu,
				"settings" => $settings,
				"settings_account" => $settings_account,

				"osep_division_project" => $osep_division_project,
			];
}
