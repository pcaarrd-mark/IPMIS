<?php

function activeNav($activepage = null)
{
	$dashboard = "";
	$bp202_menu = "";
    $bp202 = "";
	$program = "";
	$project = "";
	$bp202summary = "";
	$bp202_priority = "";

	$bp206_menu = "";
	$bp206 = "";
	$bp206_project = "";
	$bp206_summary = "";

	$bp207_menu = "";
	$bp207 = "";
	$bp207_project = "";
	$bp207_summary = "";

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

	}

	return  [
				"dashboard" => $dashboard,
                "bp202_menu" => $bp202_menu,
				"bp202" => $bp202,
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
			];
}
