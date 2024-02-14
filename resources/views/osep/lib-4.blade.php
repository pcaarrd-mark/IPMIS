<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf_token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="device-width, initial-scale=1">
  <title>IPMIS | Project Monitoring System</title>

     <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admintemplate/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('admintemplate/plugins/bootstrap5/css/bootstrap.min.css') }}">

    <!-- sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('sweetalert2/package/dist/sweetalert2.min.css') }}">

  
  <style>
    body{
        font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
  </style>

  <body class="">
    <div id="overlay"></div>
    <div class="container-fluid">


        <div class="alert alert-warning m-2"><center>Caution: Avoid refreshing or closing this page. To preserve the modifications, kindly select the save button.The page will automatically save if there is no activity for a duration of 5 minutes.</center></div>
        <p align="right"><button class="btn btn-primary btn-lg" onclick="submitFormBudget()"><i class="fas fa-save"></i> SAVE</button></p>

        <form method="POST" id="frm_budget" enctype="multipart/form-data" role="form" action="{{ url('/project/lib/create') }}">
        @csrf
        <input type="hidden" name="project_id" value="{{$data['project']['id']}}">
        <input type="hidden" name="agency_id" value="{{$data['agency_id']}}">
        <div class="row">
            <div class="col-12">
                <center><h1>LINE-ITEM BUDGET</h1></center>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                PROGRAM TITLE :
            </div>
            <div class="col-9 fw-bold">
                {{ getProgramDetails($data['project']['program_id'],'title') }}
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                PROJECT TITLE :
            </div>
            <div class="col-9 fw-bold">
                {{ $data['project']['title'] }}
            </div>
        </div>

        <div class="row">
            <div class="col-3">
                TOTAL DURATION :
            </div>
            <div class="col-9 fw-bold">
                {{ $data['duration'] }}
            </div>
        </div>

        <div class="row">
            <div class="col-3">
                AGENCY :
            </div>
            <div class="col-9 fw-bold">
                {{$data['agency']}}
            </div>
        </div>
        
        <div class="row">
            <div class="col-3">
                TOTAL COUNTERPART :
            </div>
            <div class="col-9 fw-bold">
                <span id='total_proj_counterpart'></span>
            </div>
        </div>

        <div class="row">
            <div class="col-3">
                TOTAL PROJECT COST :
            </div>
            <div class="col-9 fw-bold">
                <span id='total_proj_cost'></span>
            </div>
        </div>

        <br>
        <br>
        <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
            <?php
                $active = 'active';
            ?>
            @for($x = 1;$x <= $data['yrs'];$x++)
            
            <li class="nav-item" role="presentation">
                <a
                  class="nav-link {{$active}}"
                  id="ex3-tab-1"
                  data-bs-toggle="tab"
                  href="#ex3-tabs-{{$x}}"
                  role="tab"
                  aria-controls="ex3-tabs-{{$x}}"
                  aria-selected="true"
                  >YEAR {{$x}}</a
                >
              </li>
              <?php
                $active = '';
                ?>
            @endfor
           
          </ul>
          <?php
                $active = 'show active';
            ?>
          <div class="tab-content" id="ex2-content">
          
          @for($x = 1;$x <= $data['yrs'];$x++)
            
            <div class="tab-pane fade {{$active}}" id="ex3-tabs-{{$x}}" role="tabpanel" aria-labelledby="ex3-tab-{{$x}}">
                <div class="row">
                    <div class="col-6">
                        <h4 class="fw-bold">TOTAL PS: <span class="text-primary" id="yr-{{$x}}-ps-total"></span></h4>
                        <h4 class="fw-bold">TOTAL MOOE : <span class="text-primary" id="yr-{{$x}}-mooe-total"></span></h4>
                        <h4 class="fw-bold">TOTAL EO : <span class="text-primary" id="yr-{{$x}}-eo-total"></span></h4>
                        <h4 class="fw-bold">TOTAL COUNTERPART : <span class="text-primary" id="yr-{{$x}}-cp-total"></span></h4>
                    </div>
                    <div class="col-6">
                        <h5 class="fw-bold">ALLOWABLE INDIRECT COST : <span class="text-success" id="yr-{{$x}}-ic-total"></span></h5>
                        <h5 class="fw-bold">TOTAL INDIRECT COST : <span class="text-success" id="yr-{{$x}}-ic-allotment"></span></h5>
                        <h5 class="fw-bold">OUTSTANDING BALANCE  : <span class="text-success" id="yr-{{$x}}-ic-remain"></span></h5>
                    </div>
                </div>
                
                <table class="table table-bordered" style="width: 120%" border="1" cellpadding="0" cellspacing="0">
                    <tr class="text-center fw-bold">
                        <td style="width: 20%"></td>
                        {{-- <td>JAN</td>
                        <td>FEB</td>
                        <td>MAR</td>
                        <td>APR</td>
                        <td>MAY</td>
                        <td>JUN</td>
                        <td>JUL</td>
                        <td>AUG</td>
                        <td>SEP</td>
                        <td>OCT</td>
                        <td>NOV</td>
                        <td>DEC</td> --}}
                        <?php
                            $mon = $data['project']['duration_from_month'];
                            $totalmons = getLibMonths($data['project']['id'],$x);
                        ?>

                        @for($y = 1; $y <= $totalmons; $y++)
                            <?php
                                if($mon >= 13)
                                    $mon -= 12; 

                                echo "<td>".getMon($mon)."</td>";
                                $mon++;
                            ?>
                        @endfor
                    </tr>

                    <tr class="fw-bold">
                        <td>I. Personal Services</td>
                        <td colspan="{{$totalmons}}"></td>
                    </tr>
                    <tr class="fw-bold" id="yr-{{$x}}-ps-dc">
                        <td>Direct Cost <button type="button" class="btn btn-info btn-sm float-end" onclick="addRow('yr-{{$x}}-ps-dc',{{$totalmons}},1)"><i class="fas fa-plus fa-xs"></i></button></td>
                        <td colspan="{{$totalmons}}"></td>
                    </tr>
                    @foreach (getLIBList($data['project']['id'],$data['agency_id'],$x,'ps','dc') as $item)
                        <?php
                            $ranCode = randomCode();
                            if($item->counterpart == 'Yes')
                                $monlib =  "yr-".$x."-ps-dc-cp";
                            else
                                $monlib =  "yr-".$x."-ps-dc";
                        ?>
                        <tr>
                            <td>
                                <input type='hidden' name='budget_row[]' value='budget-yr-{{$x}}-ps-dc-{{$ranCode}}'>
                                <div class='alert alert-info'>
                                    <button type="button" class='btn btn-danger btn-sm float-end m-1' onclick='removeRow(this)'><i class='fas fa-trash fa-xs'></i></button><br>
                                    <div class='form-group'><span>Object of Expenditure</span>
                                        <select class='form-control' id='{{$ranCode}}' name='budget-yr-{{$x}}-ps-dc-{{$ranCode}}'>
                                            @foreach (budgetLibrary(1) as $libs)
                                                @if($libs->id == $item->object_expenditure)
                                                    <option value="{{$libs->id}}" selected>{{$libs->object_expenditure}}</option>
                                                @else
                                                    <option value="{{$libs->id}}">{{$libs->object_expenditure}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class='form-group'>
                                        <span>Remarks</span><input type='text' class='form-control' placeholder='' style='margin-top:2px' name='budget-yr-{{$x}}-ps-dc-{{$ranCode}}_remarks' value="{{$item->object_remarks}}">
                                    </div>
                                    <div class='form-group'>
                                        <span>Counterpart </span>
                                        @if($item->counterpart == 'No')
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,"budget-yr-{{$x}}-ps-dc-{{$ranCode}}",this.value)'><label class='form-check-label' for='inlineRadio1'>Yes</label>
                                        </div>
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,"budget-yr-{{$x}}-ps-dc-{{$ranCode}}",this.value)' checked><label class='form-check-label' for='inlineRadio2'>No</label>
                                        </div>
                                        @else
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,"budget-yr-{{$x}}-ps-dc-{{$ranCode}}",this.value)' checked><label class='form-check-label' for='inlineRadio1'>Yes</label>
                                        </div>
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,"budget-yr-{{$x}}-ps-dc-{{$ranCode}}",this.value)'><label class='form-check-label' for='inlineRadio2'>No</label>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            @foreach (getLIBMon($item->id) as $val)
                                <td>
                                    <input type='number' class='form-control input-sm {{$monlib}}' name='budget-yr-{{$x}}-ps-dc-{{$ranCode}}_mon[]' onkeyup='countTotalIC()' value='{{$val->amt}}'>
                                </td>
                            @endforeach

                            
                        </tr>
                    @endforeach
                    <tr class="fw-bold" id="yr-{{$x}}-ps-ic">
                        <td>Indirect Cost <button type="button" class="btn btn-info btn-sm float-end" onclick="addRow('yr-{{$x}}-ps-ic',{{$totalmons}},1)"><i class="fas fa-plus fa-xs"></i></button></td>
                        <td colspan="{{$totalmons}}"></td>
                    </tr>
                    @foreach (getLIBList($data['project']['id'],$data['agency_id'],$x,'ps','ic') as $item)
                        <?php
                            $ranCode = randomCode();
                            if($item->counterpart == 'Yes')
                                $monlib =  "yr-".$x."-ps-ic-cp";
                            else
                                $monlib =  "yr-".$x."-ps-ic";
                        ?>
                        <tr>
                            <td>
                                <input type='hidden' name='budget_row[]' value='budget-yr-{{$x}}-ps-ic-{{$ranCode}}'>
                                <div class='alert alert-info'>
                                    <button type="button" class='btn btn-danger btn-sm float-end m-1' onclick='removeRow(this)'><i class='fas fa-trash fa-xs'></i></button><br>
                                    <div class='form-group'><span>Object of Expenditure</span>
                                        <select class='form-control' id='{{$ranCode}}' name='budget-yr-{{$x}}-ps-ic-{{$ranCode}}'>
                                            @foreach (budgetLibrary(1) as $libs)
                                                @if($libs->id == $item->object_expenditure)
                                                    <option value="{{$libs->id}}" selected>{{$libs->object_expenditure}}</option>
                                                @else
                                                    <option value="{{$libs->id}}">{{$libs->object_expenditure}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class='form-group'>
                                        <span>Remarks</span><input type='text' class='form-control' placeholder='' style='margin-top:2px' name='budget-yr-{{$x}}-ps-ic-{{$ranCode}}_remarks' value="{{$item->object_remarks}}">
                                    </div>
                                    <div class='form-group'>
                                        <span>Counterpart </span>
                                        @if($item->counterpart == 'No')
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,"budget-yr-{{$x}}-ps-ic-{{$ranCode}}",this.value)'><label class='form-check-label' for='inlineRadio1'>Yes</label>
                                        </div>
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,"budget-yr-{{$x}}-ps-ic-{{$ranCode}}",this.value)' checked><label class='form-check-label' for='inlineRadio2'>No</label>
                                        </div>
                                        @else
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,"budget-yr-{{$x}}-ps-ic-{{$ranCode}}",this.value)' checked><label class='form-check-label' for='inlineRadio1'>Yes</label>
                                        </div>
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,"budget-yr-{{$x}}-ps-ic-{{$ranCode}}",this.value)'><label class='form-check-label' for='inlineRadio2'>No</label>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            @foreach (getLIBMon($item->id) as $val)
                                <td>
                                    <input type='number' class='form-control input-sm {{$monlib}}' name='budget-yr-{{$x}}-ps-ic-{{$ranCode}}_mon[]' onkeyup='countTotalIC()' value='{{$val->amt}}'>
                                </td>
                            @endforeach

                            
                        </tr>
                    @endforeach

                    <tr class="fw-bold">
                        <td>II. Maintenance and Other Operating Expenses</td>
                        <td colspan="{{$totalmons}}"></td>
                    </tr>
                    <tr class="fw-bold" id="yr-{{$x}}-mooe-dc">
                        <td>Direct Cost <button type="button" class="btn btn-info btn-sm float-end" onclick="addRow('yr-{{$x}}-mooe-dc',{{$totalmons}},2)"><i class="fas fa-plus fa-xs"></i></button></td>
                        <td colspan="{{$totalmons}}"></td>
                    </tr>
                    @foreach (getLIBList($data['project']['id'],$data['agency_id'],$x,'mooe','dc') as $item)
                        <?php
                            $ranCode = randomCode();
                            if($item->counterpart == 'Yes')
                                $monlib =  "yr-".$x."-mooe-dc-cp";
                            else
                                $monlib =  "yr-".$x."-mooe-dc";
                        ?>
                        <tr>
                            <td>
                                <input type='hidden' name='budget_row[]' value='budget-yr-{{$x}}-mooe-dc-{{$ranCode}}'>
                                <div class='alert alert-info'>
                                    <button type="button" class='btn btn-danger btn-sm float-end m-1' onclick='removeRow(this)'><i class='fas fa-trash fa-xs'></i></button><br>
                                    <div class='form-group'><span>Object of Expenditure</span>
                                        <select class='form-control' id='{{$ranCode}}' name='budget-yr-{{$x}}-mooe-dc-{{$ranCode}}'>
                                            @foreach (budgetLibrary(2) as $libs)
                                                @if($libs->id == $item->object_expenditure)
                                                    <option value="{{$libs->id}}" selected>{{$libs->object_expenditure}}</option>
                                                @else
                                                    <option value="{{$libs->id}}">{{$libs->object_expenditure}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class='form-group'>
                                        <span>Remarks</span><input type='text' class='form-control' placeholder='' style='margin-top:2px' name='budget-yr-{{$x}}-mooe-dc-{{$ranCode}}_remarks' value="{{$item->object_remarks}}">
                                    </div>
                                    <div class='form-group'>
                                        <span>Counterpart </span>
                                        @if($item->counterpart == 'No')
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,"budget-yr-{{$x}}-mooe-dc-{{$ranCode}}",this.value)'><label class='form-check-label' for='inlineRadio1'>Yes</label>
                                        </div>
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,"budget-yr-{{$x}}-mooe-dc-{{$ranCode}}",this.value)' checked><label class='form-check-label' for='inlineRadio2'>No</label>
                                        </div>
                                        @else
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,"budget-yr-{{$x}}-mooe-dc-{{$ranCode}}",this.value)' checked><label class='form-check-label' for='inlineRadio1'>Yes</label>
                                        </div>
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,"budget-yr-{{$x}}-mooe-dc-{{$ranCode}}",this.value)'><label class='form-check-label' for='inlineRadio2'>No</label>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            @foreach (getLIBMon($item->id) as $val)
                                <td>
                                    <input type='number' class='form-control input-sm {{$monlib}}' name='budget-yr-{{$x}}-mooe-dc-{{$ranCode}}_mon[]' onkeyup='countTotalIC()' value='{{$val->amt}}'>
                                </td>
                            @endforeach

                            
                        </tr>
                    @endforeach
                    <tr class="fw-bold" id="yr-{{$x}}-mooe-ic">
                        <td>Indirect Cost <button type="button" class="btn btn-info btn-sm float-end" onclick="addRow('yr-{{$x}}-mooe-ic',{{$totalmons}},2)"><i class="fas fa-plus fa-xs"></i></button></td>
                        <td colspan="{{$totalmons}}"></td>
                    </tr>
                    
                    @foreach (getLIBList($data['project']['id'],$data['agency_id'],$x,'mooe','ic') as $item)
                        <?php
                            $ranCode = randomCode();
                            if($item->counterpart == 'Yes')
                                $monlib =  "yr-".$x."-mooe-ic-cp";
                            else
                                $monlib =  "yr-".$x."-mooe-ic";
                        ?>
                        <tr>
                            <td>
                                <input type='hidden' name='budget_row[]' value='budget-yr-{{$x}}-mooe-ic-{{$ranCode}}'>
                                <div class='alert alert-info'>
                                    <button type="button" class='btn btn-danger btn-sm float-end m-1' onclick='removeRow(this)'><i class='fas fa-trash fa-xs'></i></button><br>
                                    <div class='form-group'><span>Object of Expenditure</span>
                                        <select class='form-control' id='{{$ranCode}}' name='budget-yr-{{$x}}-mooe-ic-{{$ranCode}}'>
                                            @foreach (budgetLibrary(2) as $libs)
                                                @if($libs->id == $item->object_expenditure)
                                                    <option value="{{$libs->id}}" selected>{{$libs->object_expenditure}}</option>
                                                @else
                                                    <option value="{{$libs->id}}">{{$libs->object_expenditure}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class='form-group'>
                                        <span>Remarks</span><input type='text' class='form-control' placeholder='' style='margin-top:2px' name='budget-yr-{{$x}}-mooe-ic-{{$ranCode}}_remarks' value="{{$item->object_remarks}}">
                                    </div>
                                    <div class='form-group'>
                                        <span>Counterpart </span>
                                        @if($item->counterpart == 'No')
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,"budget-yr-{{$x}}-mooe-ic-{{$ranCode}}",this.value)'><label class='form-check-label' for='inlineRadio1'>Yes</label>
                                        </div>
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,"budget-yr-{{$x}}-mooe-ic-{{$ranCode}}",this.value)' checked><label class='form-check-label' for='inlineRadio2'>No</label>
                                        </div>
                                        @else
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,"budget-yr-{{$x}}-mooe-ic-{{$ranCode}}",this.value)' checked><label class='form-check-label' for='inlineRadio1'>Yes</label>
                                        </div>
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,"budget-yr-{{$x}}-mooe-ic-{{$ranCode}}",this.value)'><label class='form-check-label' for='inlineRadio2'>No</label>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            @foreach (getLIBMon($item->id) as $val)
                                <td>
                                    <input type='number' class='form-control input-sm {{$monlib}}' name='budget-yr-{{$x}}-mooe-ic-{{$ranCode}}_mon[]' onkeyup='countTotalIC()' value='{{$val->amt}}'>
                                </td>
                            @endforeach

                            
                        </tr>
                    @endforeach

                    <tr class="fw-bold">
                        <td>III. Equipment Outlay</td>
                        <td colspan="{{$totalmons}}"></td>
                    </tr>
                    <tr class="fw-bold" id="yr-{{$x}}-eo-dc">
                        <td>Direct Cost <button type="button" class="btn btn-info btn-sm float-end" onclick="addRow('yr-{{$x}}-eo-dc',{{$totalmons}},2)"><i class="fas fa-plus fa-xs"></i></button></td>
                        <td colspan="{{$totalmons}}"></td>
                    </tr>

                    @foreach (getLIBList($data['project']['id'],$data['agency_id'],$x,'eo','dc') as $item)
                        <?php
                            $ranCode = randomCode();
                            if($item->counterpart == 'Yes')
                                $monlib =  "yr-".$x."-eo-dc-cp";
                            else
                                $monlib =  "yr-".$x."-eo-dc";
                        ?>
                        <tr>
                            <td>
                                <input type='hidden' name='budget_row[]' value='budget-yr-{{$x}}-eo-dc-{{$ranCode}}'>
                                <div class='alert alert-info'>
                                    <button type="button" class='btn btn-danger btn-sm float-end m-1' onclick='removeRow(this)'><i class='fas fa-trash fa-xs'></i></button><br>
                                    <div class='form-group'><span>Object of Expenditure</span>
                                        <select class='form-control' id='{{$ranCode}}' name='budget-yr-{{$x}}-eo-dc-{{$ranCode}}'>
                                            @foreach (budgetLibrary(3) as $libs)
                                                @if($libs->id == $item->object_expenditure)
                                                    <option value="{{$libs->id}}" selected>{{$libs->object_expenditure}}</option>
                                                @else
                                                    <option value="{{$libs->id}}">{{$libs->object_expenditure}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class='form-group'>
                                        <span>Remarks</span><input type='text' class='form-control' placeholder='' style='margin-top:2px' name='budget-yr-{{$x}}-eo-dc-{{$ranCode}}_remarks' value="{{$item->object_remarks}}">
                                    </div>
                                    <div class='form-group'>
                                        <span>Counterpart </span>
                                        @if($item->counterpart == 'No')
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,"budget-yr-{{$x}}-eo-dc-{{$ranCode}}",this.value)'><label class='form-check-label' for='inlineRadio1'>Yes</label>
                                        </div>
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,"budget-yr-{{$x}}-eo-dc-{{$ranCode}}",this.value)' checked><label class='form-check-label' for='inlineRadio2'>No</label>
                                        </div>
                                        @else
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,"budget-yr-{{$x}}-eo-dc-{{$ranCode}}",this.value)' checked><label class='form-check-label' for='inlineRadio1'>Yes</label>
                                        </div>
                                        <div class='form-check form-check-inline'>
                                            <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,"budget-yr-{{$x}}-eo-dc-{{$ranCode}}",this.value)'><label class='form-check-label' for='inlineRadio2'>No</label>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            @foreach (getLIBMon($item->id) as $val)
                                <td>
                                    <input type='number' class='form-control input-sm {{$monlib}}' name='budget-yr-{{$x}}-eo-dc-{{$ranCode}}_mon[]' onkeyup='countTotalIC()' value='{{$val->amt}}'>
                                </td>
                            @endforeach

                            
                        </tr>
                    @endforeach
                    <tr class="fw-bold" id="yr-{{$x}}-eo-ic">
                        <td>Indirect Cost <button type="button" class="btn btn-info btn-sm float-end" onclick="addRow('yr-{{$x}}-eo-ic',{{$totalmons}},3)"><i class="fas fa-plus fa-xs"></i></button></td>
                        <td colspan="{{$totalmons}}"></td>
                    </tr>

                    @foreach (getLIBList($data['project']['id'],$data['agency_id'],$x,'eo','ic') as $item)
                    <?php
                        $ranCode = randomCode();
                        if($item->counterpart == 'Yes')
                            $monlib =  "yr-".$x."-eo-ic-cp";
                        else
                            $monlib =  "yr-".$x."-eo-ic";
                    ?>
                    <tr>
                        <td>
                            <input type='hidden' name='budget_row[]' value='budget-yr-{{$x}}-eo-ic-{{$ranCode}}'>
                            <div class='alert alert-info'>
                                <button type="button" class='btn btn-danger btn-sm float-end m-1' onclick='removeRow(this)'><i class='fas fa-trash fa-xs'></i></button><br>
                                <div class='form-group'><span>Object of Expenditure</span>
                                    <select class='form-control' id='{{$ranCode}}' name='budget-yr-{{$x}}-eo-ic-{{$ranCode}}'>
                                        @foreach (budgetLibrary(3) as $libs)
                                            @if($libs->id == $item->object_expenditure)
                                                <option value="{{$libs->id}}" selected>{{$libs->object_expenditure}}</option>
                                            @else
                                                <option value="{{$libs->id}}">{{$libs->object_expenditure}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class='form-group'>
                                    <span>Remarks</span><input type='text' class='form-control' placeholder='' style='margin-top:2px' name='budget-yr-{{$x}}-eo-ic-{{$ranCode}}_remarks' value="{{$item->object_remarks}}">
                                </div>
                                <div class='form-group'>
                                    <span>Counterpart </span>
                                    @if($item->counterpart == 'No')
                                    <div class='form-check form-check-inline'>
                                        <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,"budget-yr-{{$x}}-eo-ic-{{$ranCode}}",this.value)'><label class='form-check-label' for='inlineRadio1'>Yes</label>
                                    </div>
                                    <div class='form-check form-check-inline'>
                                        <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,"budget-yr-{{$x}}-eo-ic-{{$ranCode}}",this.value)' checked><label class='form-check-label' for='inlineRadio2'>No</label>
                                    </div>
                                    @else
                                    <div class='form-check form-check-inline'>
                                        <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,"budget-yr-{{$x}}-eo-ic-{{$ranCode}}",this.value)' checked><label class='form-check-label' for='inlineRadio1'>Yes</label>
                                    </div>
                                    <div class='form-check form-check-inline'>
                                        <input class='form-check-input' type='radio' name='{{$ranCode}}_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,"budget-yr-{{$x}}-eo-ic-{{$ranCode}}",this.value)'><label class='form-check-label' for='inlineRadio2'>No</label>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        @foreach (getLIBMon($item->id) as $val)
                            <td>
                                <input type='number' class='form-control input-sm {{$monlib}}' name='budget-yr-{{$x}}-eo-ic-{{$ranCode}}_mon[]' onkeyup='countTotalIC()' value='{{$val->amt}}'>
                            </td>
                        @endforeach

                        
                    </tr>
                @endforeach
                    {{-- <tr>
                        <td>I. Personal Services</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr> --}}
                </table>
              </div>
            <?php
              $active = '';
              ?>
          @endfor
        </div>

        <br>
        <br>
        </form>
    </div>
  </body>

  <script src="{{ asset('admintemplate/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('admintemplate/plugins/bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Sweetalert2 -->
  <script src="{{ asset('sweetalert2/package/dist/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('js/post.js') }}"></script>

  <script>
    $(document).ready(function(){
        countTotalIC();
    })

    function Generator() {};

    Generator.prototype.rand =  Math.floor(Math.random() * 26) + Date.now();

    Generator.prototype.getId = function() {
    return this.rand++;
    };

    let agency = "@foreach(getAgencyProject($data['project']['id']) as $item)<option value='{{$item->agency_id.'-'.$item->agency_type}}'>{{getLibraryDesc('agency',$item->agency_id,'acronym')}} ({{$item->agency_type}})</option>@endforeach";

    var idGen =new Generator();
    function removeRow(obj)
    {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $(obj).closest('tr').remove();
                countTotalIC();
            }
            });

    }
    function addRow(row,col,code)
    {
        console.log(row);
        expenditure = idGen.getId();

        let tds = "";
        for (let index = 1; index <= col; index++) {
            tds += "<td><input type='number' class='form-control input-sm "+row+"' name='budget-"+row+"-"+expenditure+"_mon[]' onkeyup='countTotalIC()' value='0'></td>";
        }

        

        $("#"+row).after("<tr><td><input type='hidden' name='budget_row[]' value='budget-"+row+"-"+expenditure+"'><div class='alert alert-info'><button class='btn btn-danger btn-sm float-end m-1' onclick='removeRow(this)'><i class='fas fa-trash fa-xs'></i></button><br><div class='form-group'><span>Object of Expenditure</span><select class='form-control' id='"+expenditure+"' name='budget-"+row+"-"+expenditure+"'></select></div><div class='form-group'><span>Remarks</span><input type='text' class='form-control' placeholder='' style='margin-top:2px' name='budget-"+row+"-"+expenditure+"_remarks'></div><div class='form-group'><span>Counterpart </span><div class='form-check form-check-inline'><input class='form-check-input' type='radio' name='"+expenditure+"_counterpart' id='inlineRadio1' value='Yes' onclick='counterpart(this,\""+row+"\",this.value)'><label class='form-check-label' for='inlineRadio1'>Yes</label></div><div class='form-check form-check-inline'><input class='form-check-input' type='radio' name='"+expenditure+"_counterpart' id='inlineRadio2' value='No' onclick='counterpart(this,\""+row+"\",this.value)' checked><label class='form-check-label' for='inlineRadio2'>No</label></div></div></div></td>"+tds+"</div></tr>");

        loadJSON(expenditure,"lib","{{ url('/library/lib/') }}/"+code);


    }

    let USDollar = new Intl.NumberFormat('fil-PH', {
            style: 'currency',
            currency: 'PHP',
    });
    function countTotalIC()
    {
        let total_proj_cost = 0;
        
        //counterpart
        let total_proj_counterpart = 0;
        
        //console.log(this);
        @for($x = 1;$x <= $data['yrs'];$x++)
        let totalic_{{$x}} = 0;
        let total_ic_allotment_{{$x}} = 0;
        let total_ps_{{$x}} = 0;
        let total_mooe_{{$x}} = 0;
        let total_eo_{{$x}} = 0;

        let yr_{{$x}}_cp_total = 0;


        $('.yr-{{$x}}-ps-dc').each(function(i, obj) {
            if(obj.value > 0)
            {
                totalic_{{$x}} += parseFloat(obj.value);
                total_proj_cost += parseFloat(obj.value);
                total_ps_{{$x}} += parseFloat(obj.value);
            }
            else
                totalic_{{$x}} += 0;
        });

        $('.yr-{{$x}}-mooe-dc').each(function(i, obj) {
            if(obj.value > 0)
            {
                total_proj_cost += parseFloat(obj.value);
                totalic_{{$x}} += parseFloat(obj.value);
                total_mooe_{{$x}} += parseFloat(obj.value);
            }
            else
                totalic_{{$x}} += 0;
        });

        $('.yr-{{$x}}-eo-dc').each(function(i, obj) {
            if(obj.value > 0)
            {
                total_proj_cost += parseFloat(obj.value);
                total_eo_{{$x}} += parseFloat(obj.value);
            }
                
        });

        //GET ALLOTMENT
        $('.yr-{{$x}}-ps-ic').each(function(i, obj) {
            if(obj.value > 0)
            {
                total_proj_cost += parseFloat(obj.value);
                total_ic_allotment_{{$x}} += parseFloat(obj.value);
                total_ps_{{$x}} += parseFloat(obj.value);
            }
            else
                total_ic_allotment_{{$x}} += 0;
        });

        $('.yr-{{$x}}-mooe-ic').each(function(i, obj) {
            if(obj.value > 0)
            {
                total_proj_cost += parseFloat(obj.value);
                total_ic_allotment_{{$x}} += parseFloat(obj.value);
                total_mooe_{{$x}} += parseFloat(obj.value);
            }
            else
                total_ic_allotment_{{$x}} += 0;
        });

        $('.yr-{{$x}}-eo-ic').each(function(i, obj) {
            if(obj.value > 0)
            {
                total_proj_cost += parseFloat(obj.value);
                total_ic_allotment_{{$x}} += parseFloat(obj.value);
                total_eo_{{$x}} += parseFloat(obj.value);
            } 
            else
                total_ic_allotment_{{$x}} += 0;
        });

        //COUNTERPART
        $('.yr-{{$x}}-ps-dc-cp').each(function(i, obj) {
            if(obj.value > 0)
            {
                yr_{{$x}}_cp_total += parseFloat(obj.value);
                total_proj_counterpart += parseFloat(obj.value);
            }
            else
                total_proj_counterpart += 0;
        });
        $('.yr-{{$x}}-ps-ic-cp').each(function(i, obj) {
            if(obj.value > 0)
            {
                yr_{{$x}}_cp_total += parseFloat(obj.value);
                total_proj_counterpart += parseFloat(obj.value);
            }
            else
                total_proj_counterpart += 0;
        });
        
        $('.yr-{{$x}}-mooe-dc-cp').each(function(i, obj) {
            if(obj.value > 0)
            {
                yr_{{$x}}_cp_total += parseFloat(obj.value);
                total_proj_counterpart += parseFloat(obj.value);
            }
            else
                total_proj_counterpart += 0;
        });
        $('.yr-{{$x}}-mooe-ic-cp').each(function(i, obj) {
            if(obj.value > 0)
            {
                yr_{{$x}}_cp_total += parseFloat(obj.value);
                total_proj_counterpart += parseFloat(obj.value);
            }
            else
                total_proj_counterpart += 0;
        });

        $('.yr-{{$x}}-eo-dc-cp').each(function(i, obj) {
            if(obj.value > 0)
            {
                yr_{{$x}}_cp_total += parseFloat(obj.value);
                total_proj_counterpart += parseFloat(obj.value);
            }
            else
                total_proj_counterpart += 0;
        });
        $('.yr-{{$x}}-eo-ic-cp').each(function(i, obj) {
            if(obj.value > 0)
            {
                yr_{{$x}}_cp_total += parseFloat(obj.value);
                total_proj_counterpart += parseFloat(obj.value);
            }
            else
                total_proj_counterpart += 0;
        });

        //TOTAL COUNTER
        $("#total_proj_counterpart").text(USDollar.format(total_proj_counterpart));
        $("#yr-{{$x}}-cp-total").text(USDollar.format(yr_{{$x}}_cp_total));


        $("#yr-{{$x}}-ic-total").text(USDollar.format((totalic_{{$x}} * 0.075)));
        $("#yr-{{$x}}-ic-allotment").text(USDollar.format((total_ic_allotment_{{$x}})));

        let total_remain_{{$x}} = (totalic_{{$x}} * 0.075) - total_ic_allotment_{{$x}};
        if(total_remain_{{$x}} < 0)
            $("#yr-{{$x}}-ic-remain").removeClass('text-success').addClass('text-danger');
        else
            $("#yr-{{$x}}-ic-remain").removeClass('text-danger').addClass('text-success');

        $("#yr-{{$x}}-ic-remain").text(USDollar.format(total_remain_{{$x}}));
        
        //ALLOTMENT CLASS
        $("#yr-{{$x}}-ps-total").text(USDollar.format(total_ps_{{$x}}));
        $("#yr-{{$x}}-mooe-total").text(USDollar.format(total_mooe_{{$x}}));
        $("#yr-{{$x}}-eo-total").text(USDollar.format(total_eo_{{$x}}));


        //TOTAL PROJECT COST
        $("#total_proj_cost").text(USDollar.format(total_proj_cost));

        console.log(totalic_{{$x}});
        @endfor
    }

    function counterpart(obj,cl,cp)
    {
        var nearestNumberInputs = $(obj).closest("tr").find("input[type='number']");
    
        nearestNumberInputs.each(function() {
            var classAttribute = $(this).attr("class");
            var classesArray = classAttribute.split(" "); 
            console.log(classesArray[2]);
            
            if(cp == 'Yes')
            {
                $(this).removeClass(classesArray[2]).addClass(classesArray[2]+"-cp");
            }
            else
            {
                oldClass = classesArray[2].slice(0, -3);
                $(this).removeClass(classesArray[2]).addClass(oldClass);
            }
        });

        countTotalIC();
    }


    function submitFormBudget()
    {
        Swal.fire({
            title: 'Are you sure?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Submit!'
            }).then((result) => {
            if (result.isConfirmed) {
                $("#frm_budget").submit();
            }
            });
        
    }
  </script>