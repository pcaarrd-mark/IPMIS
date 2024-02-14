<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf_token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="device-width, initial-scale=1">
  <title>IPMIS | Project Monitoring System</title>

     <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admintemplate/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admintemplate/plugins/bootstrap5/css/bootstrap.min.css') }}">

    <!-- sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('sweetalert2/package/dist/sweetalert2.min.css') }}">

  
  <style>
    body{
        font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .custom-nav-color .nav-link {
      background-color: #fdfdfc; /* Your custom color here */
      color: #000; /* Text color */
      margin : 5px;
    }

    .custom-nav-color .nav-link.active{
      background-color: #7085FF; /* Your custom color for active and hover states */
      color: #FFF; /* Text color */
    }

    .custom-nav-color .nav-link:hover {
      background-color: #8BbbF8; /* Your custom color for active and hover states */
      color: #ffffff; /* Text color */
    }
  </style>

  <body class="p-2">
    <div id="overlay"></div>
    <div class="container-fluid">

        @if(ifOwner($data['project']['id']))
        <div class="alert alert-warning  alert-dismissible fade show"><center>Caution: Avoid refreshing or closing this page. To preserve the modifications, kindly select the save button.The page will automatically save if there is no activity for a duration of 5 minutes.</center>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <p align="right"><a href="{{url('/print/workplan/'.$data['project']['id'])}}" class="btn btn-info btn-lg" target="_blank"><i class="fas fa-print"></i> PRINT</a> &nbsp; <button class="btn btn-primary btn-lg" onclick="frmSubmit('frm_workplan','{{ url('project/workplan/create') }}','{{ url('project/workplan/'.$data['project']['id']) }}');"><i class="fas fa-save"></i> SAVE</button></p>
        @else
        <p align="right"><a href="{{url('/print/workplan/'.$data['project']['id'])}}" class="btn btn-info btn-lg" target="_blank"><i class="fas fa-print"></i> PRINT</a></p>
            <br/>
        @endif
        <form method="POST" id="frm_workplan" enctype="multipart/form-data" role="form">
        @csrf
        <input type="hidden" name="project_id" value="{{$data['project']['id']}}">
        <div class="row">
            <div class="col-12">
                <center></center>
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
        <br>

        <ul class="nav nav-pills mb-3 justify-content-center custom-nav-color" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><h5>A – PROJECT WORKPLAN</h5></button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><h5>B – EXPECTED OUTPUTS</h5></button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"><h5>C – RISKS AND ASSUMPTIONS</h5></button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active p-3 alert alert-secondary" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                @if(ifOwner($data['project']['id']))
                    <p align="right"><button type="button" class="btn btn-info btn-sm" onclick="addWorkA()"> ADD</button></p>
                @endif
                <table class="table table-bordered bg-white" id="tbl_work_a" style="font-size:11px">
                    <tr>
                        <td style="width: 15%" rowspan="2" valign="middle">
                            <b><center>(6) OBJECTIVES</<center></b>
                        </td>
                        <td style="width: 15%" rowspan="2" valign="middle">
                            <b><center>(7) TARGET ACTIVITIES</<center></b>
                        </td>
                        <td style="width: 15%" rowspan="2" valign="middle">
                            <b><center>(8) TARGET ACCOMPLISHMENTS <small>(quantify, if possible)</small></center></b>
                        </td>
                        <td colspan="5"><b><center>Y1</center></b></td>
                        <td colspan="5"><b><center>Y2</center></b></td>
                        <td colspan="5"><b><center>Y3</center></b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td></td>
                    </tr>
                    @foreach (getWorkplan('A',$data['project']['id']) as $item)
                    <tr>
                        @if(ifOwner($data['project']['id']))
                        <?php
                            $id = randomNum();    
                        ?>
                        <td><input type="text" class="form-control" name="objectives[]" value="{{$item->objectives}}"></td>
                        <td><input type="text" class="form-control" name="activity[]" value="{{$item->activity}}"></td>
                        <td><input type="text" class="form-control" name="accomplishment[]" value="{{$item->accomplishment}}"></td>
                        <td align="center">
                            <input type="text" class="form-control {{$id}}_y1" name="y1_q1[]" value="{{$item->y1_q1}}" onkeyup="setTotal({{$id}},1)">
                        </td>
                        <td align="center">
                            <input type="text" class="form-control {{$id}}_y1" name="y1_q2[]" value="{{$item->y1_q2}}" onkeyup="setTotal({{$id}},1)">
                        </td>
                        <td align="center">
                            <input type="text" class="form-control {{$id}}_y1" name="y1_q3[]" value="{{$item->y1_q3}}" onkeyup="setTotal({{$id}},1)">
                        </td>
                        <td align="center">
                            <input type="text" class="form-control {{$id}}_y1" name="y1_q4[]" value="{{$item->y1_q4}}" onkeyup="setTotal({{$id}},1)">
                        </td>
                        <td align="center" valign='middle'>
                           <span style="font-size: 16px;font-weight:bold" id="{{$id}}_y1_total">{{$item->y1_q1 + $item->y1_q2 + $item->y1_q3 + $item->y1_q4}}</span>
                        </td>
                        <td align="center">
                            <input type="text" class="form-control {{$id}}_y2" name="y2_q1[]" value="{{$item->y2_q1}}" onkeyup="setTotal({{$id}},2)">
                        </td>
                        <td align="center">
                            <input type="text" class="form-control {{$id}}_y2" name="y2_q2[]" value="{{$item->y2_q2}}" onkeyup="setTotal({{$id}},2)">
                        </td>
                        <td align="center">
                            <input type="text" class="form-control {{$id}}_y2" name="y2_q3[]" value="{{$item->y2_q3}}" onkeyup="setTotal({{$id}},2)">
                        </td>
                        <td align="center">
                            <input type="text" class="form-control {{$id}}_y2" name="y2_q4[]" value="{{$item->y2_q4}}" onkeyup="setTotal({{$id}},2)">
                        </td>
                        <td align="center" valign='middle'>
                           <span style="font-size: 16px;font-weight:bold" id="{{$id}}_y2_total">{{$item->y2_q1 + $item->y2_q2 + $item->y2_q3 + $item->y2_q4}}</span>
                        </td>
                        <td align="center">
                            <input type="text" class="form-control {{$id}}_y3" name="y3_q1[]" value="{{$item->y3_q1}}" onkeyup="setTotal({{$id}},3)">
                        </td>
                        <td align="center">
                            <input type="text" class="form-control {{$id}}_y3" name="y3_q2[]" value="{{$item->y3_q2}}" onkeyup="setTotal({{$id}},3)">
                        </td>
                        <td align="center">
                            <input type="text" class="form-control {{$id}}_y3" name="y3_q3[]" value="{{$item->y3_q3}}" onkeyup="setTotal({{$id}},3)">
                        </td>
                        <td align="center">
                            <input type="text" class="form-control {{$id}}_y3" name="y3_q4[]" value="{{$item->y3_q4}}" onkeyup="setTotal({{$id}},3)">
                        </td>
                        <td align="center" valign='middle'>
                           <span style="font-size: 16px;font-weight:bold" id="{{$id}}_y3_total">{{$item->y3_q1 + $item->y3_q2 + $item->y3_q3 + $item->y3_q4}}</span>
                        </td>
                        <td valign='middle'><i class='fas fa-trash text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td>
                    </tr>
                    @else
                    <tr>
                        <td>{{$item->objectives}}</td>
                        <td>{{$item->activity}}</td>
                        <td>{{$item->accomplishment}}</td>
                        <td align="center">
                            {{$item->y1_q1}}
                        </td>
                        <td align="center">
                            {{$item->y1_q2}}
                        </td>
                        <td align="center">
                            {{$item->y1_q3}}
                        </td>
                        <td align="center">
                            {{$item->y1_q4}}
                        </td>
                        <td align="center" valign='middle'>
                           <span style="font-size: 16px;font-weight:bold">{{$item->y1_q1 + $item->y1_q2 + $item->y1_q3 + $item->y1_q4}}</span>
                        </td>
                        <td align="center">
                            {{$item->y2_q1}}
                        </td>
                        <td align="center">
                            {{$item->y2_q2}}
                        </td>
                        <td align="center">
                            {{$item->y2_q3}}
                        </td>
                        <td align="center">
                            {{$item->y2_q4}}
                        </td>
                        <td align="center" valign='middle'>
                           <span style="font-size: 16px;font-weight:bold">{{$item->y2_q1 + $item->y2_q2 + $item->y2_q3 + $item->y2_q4}}</span>
                        </td>
                        <td align="center">
                            {{$item->y3_q1}}
                        </td>
                        <td align="center">
                            {{$item->y3_q2}}
                        </td>
                        <td align="center">
                            {{$item->y3_q3}}
                        </td>
                        <td align="center">
                            {{$item->y3_q4}}
                        </td>
                        <td align="center" valign='middle'>
                           <span style="font-size: 16px;font-weight:bold">{{$item->y3_q1 + $item->y3_q2 + $item->y3_q3 + $item->y3_q4}}</span>
                        </td>
                        <td valign='middle'></td>
                    </tr>
                    @endif
                    @endforeach
                </table>
                @if(!ifOwner($data['project']['id']))
                    <p align="right"><button type="button" class="btn btn-info btn-sm" onclick="addComment(39)"> ADD COMMENT/S</button></p>
                @endif
                <div class="alert" style="background-color: rgb(248, 248, 248)">  
                    <ul>Comments : 
                    @foreach (getComments($data['project']['id'],39,'list') as $item)
                      <li>
                        {!! $item->comment !!} <small>({{ $item->remarks_by." ". $item->created_at }})</small>
                        @if($item->remarks_by_id == Auth::user()->id)
                          <a class="btn btn-sm text-danger"  onclick='deleteComment({{$item->id}})'><small><b>delete</b></small></a>
                          <a class="btn btn-sm text-primary" onclick='updateComment({{$item->id}})'><small><b>edit</b></small></a>
                        @endif
                      </li>  
                    @endforeach
                    </ul>
                  </div>
            </div>

            <div class="tab-pane fade  p-3 alert alert-secondary" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <table class="table table-bordered bg-white" style="font-size:12px">
                    <tr>
                        <td style="width: 20%" rowspan="2" valign="middle">
                            <b><center>(9) EXPECTED OUTPUTS (6Ps)</<center></b>
                        </td>
                        <td style="width: 20%" valign="middle" colspan="5">
                            <b><center>Y1 Objectively Verifiable Indicators (OVIs)</<center></b>
                        </td>
                        <td style="width: 20%" valign="middle" colspan="5">
                            <b><center>Y2 Objectively Verifiable Indicators (OVIs)</small></center></b>
                        </td>
                        <td style="width: 20%" valign="middle" colspan="5">
                            <b><center>Y3 Objectively Verifiable Indicators (OVIs)</small></center></b>
                        </td>
                    </tr>
                    <tr>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td align="center"><b>Q1</b></td>
                        <td align="center"><b>Q2</b></td>
                        <td align="center"><b>Q3</b></td>
                        <td align="center"><b>Q4</b></td>
                        <td align="center"><b>TOTAL</b></td>
                    </tr>

                    @foreach (getExpectedOut("(9) EXPECTED OUTPUTS (6Ps)") as $item)
                        @if(ifOwner($data['project']['id']))
                        <tr>
                            <?php
                                $id = randomNum()."_".$item->id;
                            ?>
                            <td>{{ $item->description}}<input type="hidden" name="expected_output_id[]" value="{{$item->id}}"></td>
                            <td><input type="number" class="form-control {{$id}}_exp_y1" name="expected_y1_q1[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y1_q1')}}" onkeyup="setTotal('{{$id}}_exp',1)"></td>
                            <td><input type="number" class="form-control {{$id}}_exp_y1" name="expected_y1_q2[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y1_q2')}}" onkeyup="setTotal('{{$id}}_exp',1)"></td>
                            <td><input type="number" class="form-control {{$id}}_exp_y1" name="expected_y1_q3[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y1_q3')}}" onkeyup="setTotal('{{$id}}_exp',1)"></td>
                            <td><input type="number" class="form-control {{$id}}_exp_y1" name="expected_y1_q4[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y1_q4')}}" onkeyup="setTotal('{{$id}}_exp',1)"></td>
                            <td align="center" valign="middle"><span style="font-size: 16px;font-weight:bold" id="{{$id}}_exp_y1_total">{{getWorkplanBTotal($data['project']['id'],$item->id,1)}}</span></td>
                            <td><input type="number" class="form-control {{$id}}_exp_y2" name="expected_y2_q1[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y2_q1')}}" onkeyup="setTotal('{{$id}}_exp',2)"></td>
                            <td><input type="number" class="form-control {{$id}}_exp_y2" name="expected_y2_q2[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y2_q2')}}" onkeyup="setTotal('{{$id}}_exp',2)"></td>
                            <td><input type="number" class="form-control {{$id}}_exp_y2" name="expected_y2_q3[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y2_q3')}}" onkeyup="setTotal('{{$id}}_exp',2)"></td>
                            <td><input type="number" class="form-control {{$id}}_exp_y2" name="expected_y2_q4[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y2_q4')}}" onkeyup="setTotal('{{$id}}_exp',2)"></td>
                            <td align="center" valign="middle"><span style="font-size: 16px;font-weight:bold" id="{{$id}}_exp_y2_total">{{getWorkplanBTotal($data['project']['id'],$item->id,2)}}</span></td>
                            <td><input type="number" class="form-control {{$id}}_exp_y3" name="expected_y3_q1[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y3_q1')}}" onkeyup="setTotal('{{$id}}_exp',3)"></td>
                            <td><input type="number" class="form-control {{$id}}_exp_y3" name="expected_y3_q2[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y3_q2')}}" onkeyup="setTotal('{{$id}}_exp',3)"></td>
                            <td><input type="number" class="form-control {{$id}}_exp_y3" name="expected_y3_q3[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y3_q3')}}" onkeyup="setTotal('{{$id}}_exp',3)"></td>
                            <td><input type="number" class="form-control {{$id}}_exp_y3" name="expected_y3_q4[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y3_q4')}}" onkeyup="setTotal('{{$id}}_exp',3)"></td>
                            <td align="center" valign="middle"><span style="font-size: 16px;font-weight:bold" id="{{$id}}_exp_y3_total">{{getWorkplanBTotal($data['project']['id'],$item->id,3)}}</span></td>
                        </tr>
                        @else
                        <tr>
                            <td>{{ $item->description}}</td>
                            <td>{{getWorkplanB($data['project']['id'],$item->id,'y1_q1')}}</td>
                            <td>{{getWorkplanB($data['project']['id'],$item->id,'y1_q2')}}</td>
                            <td>{{getWorkplanB($data['project']['id'],$item->id,'y1_q3')}}</td>
                            <td>{{getWorkplanB($data['project']['id'],$item->id,'y1_q4')}}</td>
                            <td align="center" valign="middle"><span style="font-size: 16px;font-weight:bold">{{getWorkplanBTotal($data['project']['id'],$item->id,1)}}</span></td>
                            <td>{{getWorkplanB($data['project']['id'],$item->id,'y2_q1')}}</td>
                            <td>{{getWorkplanB($data['project']['id'],$item->id,'y2_q2')}}</td>
                            <td>{{getWorkplanB($data['project']['id'],$item->id,'y2_q3')}}</td>
                            <td>{{getWorkplanB($data['project']['id'],$item->id,'y2_q4')}}</td>
                            <td align="center" valign="middle"><span style="font-size: 16px;font-weight:bold">{{getWorkplanBTotal($data['project']['id'],$item->id,2)}}</span></td>
                            <td>{{getWorkplanB($data['project']['id'],$item->id,'y3_q1')}}</td>
                            <td>{{getWorkplanB($data['project']['id'],$item->id,'y3_q2')}}</td>
                            <td>{{getWorkplanB($data['project']['id'],$item->id,'y3_q3')}}</td>
                            <td>{{getWorkplanB($data['project']['id'],$item->id,'y3_q4')}}</td>
                            <td align="center" valign="middle"><span style="font-size: 16px;font-weight:bold">{{getWorkplanBTotal($data['project']['id'],$item->id,3)}}</span></td>
                        </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td align="center"><b>(10) POTENTIAL IMPACTS (2Is)</b></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @foreach (getExpectedOut("(10) POTENTIAL IMPACTS (2Is)") as $item)
                    @if(ifOwner($data['project']['id']))
                    <tr>
                        <?php
                            $id = randomNum()."_".$item->id;
                        ?>
                        <td>{{ $item->description}}<input type="hidden" name="expected_output_id[]" value="{{$item->id}}"></td>
                        <td><input type="number" class="form-control {{$id}}_exp_y1" name="expected_y1_q1[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y1_q1')}}" onkeyup="setTotal('{{$id}}_exp',1)"></td>
                        <td><input type="number" class="form-control {{$id}}_exp_y1" name="expected_y1_q2[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y1_q2')}}" onkeyup="setTotal('{{$id}}_exp',1)"></td>
                        <td><input type="number" class="form-control {{$id}}_exp_y1" name="expected_y1_q3[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y1_q3')}}" onkeyup="setTotal('{{$id}}_exp',1)"></td>
                        <td><input type="number" class="form-control {{$id}}_exp_y1" name="expected_y1_q4[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y1_q4')}}" onkeyup="setTotal('{{$id}}_exp',1)"></td>
                        <td align="center" valign="middle"><span style="font-size: 16px;font-weight:bold" id="{{$id}}_exp_y1_total">{{getWorkplanBTotal($data['project']['id'],$item->id,1)}}</span></td>
                        <td><input type="number" class="form-control {{$id}}_exp_y2" name="expected_y2_q1[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y2_q1')}}" onkeyup="setTotal('{{$id}}_exp',2)"></td>
                        <td><input type="number" class="form-control {{$id}}_exp_y2" name="expected_y2_q2[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y2_q2')}}" onkeyup="setTotal('{{$id}}_exp',2)"></td>
                        <td><input type="number" class="form-control {{$id}}_exp_y2" name="expected_y2_q3[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y2_q3')}}" onkeyup="setTotal('{{$id}}_exp',2)"></td>
                        <td><input type="number" class="form-control {{$id}}_exp_y2" name="expected_y2_q4[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y2_q4')}}" onkeyup="setTotal('{{$id}}_exp',2)"></td>
                        <td align="center" valign="middle"><span style="font-size: 16px;font-weight:bold" id="{{$id}}_exp_y2_total">{{getWorkplanBTotal($data['project']['id'],$item->id,2)}}</span></td>
                        <td><input type="number" class="form-control {{$id}}_exp_y3" name="expected_y3_q1[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y3_q1')}}" onkeyup="setTotal('{{$id}}_exp',3)"></td>
                        <td><input type="number" class="form-control {{$id}}_exp_y3" name="expected_y3_q2[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y3_q2')}}" onkeyup="setTotal('{{$id}}_exp',3)"></td>
                        <td><input type="number" class="form-control {{$id}}_exp_y3" name="expected_y3_q3[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y3_q3')}}" onkeyup="setTotal('{{$id}}_exp',3)"></td>
                        <td><input type="number" class="form-control {{$id}}_exp_y3" name="expected_y3_q4[]" value="{{getWorkplanB($data['project']['id'],$item->id,'y3_q4')}}" onkeyup="setTotal('{{$id}}_exp',3)"></td>
                        <td align="center" valign="middle"><span style="font-size: 16px;font-weight:bold" id="{{$id}}_exp_y3_total">{{getWorkplanBTotal($data['project']['id'],$item->id,3)}}</span></td>
                    </tr>
                    @else
                    <tr>
                        <td>{{ $item->description}}</td>
                        <td>{{getWorkplanB($data['project']['id'],$item->id,'y1_q1')}}</td>
                        <td>{{getWorkplanB($data['project']['id'],$item->id,'y1_q2')}}</td>
                        <td>{{getWorkplanB($data['project']['id'],$item->id,'y1_q3')}}</td>
                        <td>{{getWorkplanB($data['project']['id'],$item->id,'y1_q4')}}</td>
                        <td align="center" valign="middle"><span style="font-size: 16px;font-weight:bold">{{getWorkplanBTotal($data['project']['id'],$item->id,1)}}</span></td>
                        <td>{{getWorkplanB($data['project']['id'],$item->id,'y2_q1')}}</td>
                        <td>{{getWorkplanB($data['project']['id'],$item->id,'y2_q2')}}</td>
                        <td>{{getWorkplanB($data['project']['id'],$item->id,'y2_q3')}}</td>
                        <td>{{getWorkplanB($data['project']['id'],$item->id,'y2_q4')}}</td>
                        <td align="center" valign="middle"><span style="font-size: 16px;font-weight:bold">{{getWorkplanBTotal($data['project']['id'],$item->id,2)}}</span></td>
                        <td>{{getWorkplanB($data['project']['id'],$item->id,'y3_q1')}}</td>
                        <td>{{getWorkplanB($data['project']['id'],$item->id,'y3_q2')}}</td>
                        <td>{{getWorkplanB($data['project']['id'],$item->id,'y3_q3')}}</td>
                        <td>{{getWorkplanB($data['project']['id'],$item->id,'y3_q4')}}</td>
                        <td align="center" valign="middle"><span style="font-size: 16px;font-weight:bold">{{getWorkplanBTotal($data['project']['id'],$item->id,3)}}</span></td>
                    </tr>
                    @endif
                    @endforeach
                </table>

                @if(!ifOwner($data['project']['id']))
                <p align="right"><button type="button" class="btn btn-info btn-sm" onclick="addComment(40)"> ADD COMMENT/S</button></p>
            @endif
            <div class="alert" style="background-color: rgb(248, 248, 248)">  
                <ul>Comments : 
                @foreach (getComments($data['project']['id'],40,'list') as $item)
                  <li>
                    {!! $item->comment !!} <small>({{ $item->remarks_by." ". $item->created_at }})</small>
                    @if($item->remarks_by_id == Auth::user()->id)
                      <button class="btn btn-sm text-danger"  onclick='deleteComment({{$item->id}})'><small><b>delete</b></small></button>
                      <button class="btn btn-sm text-primary" onclick='updateComment({{$item->id}})'><small><b>edit</b></small></button>
                    @endif
                  </li>  
                @endforeach
                </ul>
              </div>
            </div>

            <div class="tab-pane fade p-3 alert alert-secondary" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                
                @if(ifOwner($data['project']['id']))
                    <p align="right"><button type="button" class="btn btn-info btn-sm" onclick="addWorkC()"> ADD</button></p>
                @endif
                <table class="table table-bordered bg-white" id="tbl_work_c" style="font-size:12px">
                    <tr>
                        <td style="width: 30%">
                            <b><center>OBJECTIVES</<center></b>
                        </td>
                        <td style="width: 30%">
                            <b><center>(11) RISKS AND ASSUMPTIONS</<center></b>
                        </td>
                        <td>
                            <b><center>(12) ACTION PLAN (use separate sheet if necessary)</small></center></b>
                        </td>
                    </tr>
                    @foreach (getWorkplan('C',$data['project']['id']) as $item)
                        @if(ifOwner($data['project']['id']))
                            <tr>
                                <td>
                                    <input type='text' class='form-control' name='assump_obj[]' value="{{$item->objectives}}"></td>
                                <td>
                                    <input type='text' class='form-control' name='assump_risk[]' value="{{$item->risk}}">
                                </td>
                                <td>
                                    <input type='text' class='form-control' name='assump_action[]' value="{{$item->risk}}">
                                </td>
                                <td valign='middle' align='center'>
                                    <i class='fas fa-trash text-danger' style='cursor:pointer' onclick='removeRow(this)'></i>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td>
                                    {{$item->objectives}}
                                </td>
                                <td>
                                    {{$item->risk}}
                                </td>
                                <td>
                                    {{$item->action_plan}}
                                </td>
                                <td valign='middle' align='center'>
                                    <i class='fas fa-trash text-danger' style='cursor:pointer' onclick='removeRow(this)'></i>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>

                @if(!ifOwner($data['project']['id']))
                <p align="right"><button type="button" class="btn btn-info btn-sm" onclick="addComment(41)"> ADD COMMENT/S</button></p>
            @endif
            <div class="alert" style="background-color: rgb(248, 248, 248)">  
                <ul>Comments : 
                @foreach (getComments($data['project']['id'],41,'list') as $item)
                  <li>
                    {!! $item->comment !!} <small>({{ $item->remarks_by." ". $item->created_at }})</small>
                    @if($item->remarks_by_id == Auth::user()->id)
                      <button class="btn btn-sm text-danger"  onclick='deleteComment({{$item->id}})'><small><b>delete</b></small></button>
                      <button class="btn btn-sm text-primary" onclick='updateComment({{$item->id}})'><small><b>edit</b></small></button>
                    @endif
                  </li>  
                @endforeach
                </ul>
              </div>
            </div>
            </div>
          </div>
        

        </form>
    </div>

    <!-- Modal -->
<div class="modal fade" id="addCommentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Comment</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         {{-- <form method="POST" id="frm_comment" enctype="multipart/form-data" role="form" action="{{ url('/project/add-comments') }}"> --}}
            <form method="POST" id="frm_comment" enctype="multipart/form-data" role="form">
                @csrf
                  <input type="hidden" name="comment_project_id" value="{{$data['project']['id']}}">
                  <input type="hidden" name="project_comment_section" id="project_comment_section" value="">
                  <input type="hidden" name="project_comment_content" id="project_comment_content" value="">
                  <input type="hidden" name="comment_type" id="comment_type" value="">
                  <textarea class="form-control" name="project_comment" id="project_comment"></textarea>
              </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="addCommentPost()">Continue</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Comment</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         {{-- <form method="POST" id="frm_comment" enctype="multipart/form-data" role="form" action="{{ url('/project/update-comments') }}"> --}}
            <form method="POST" id="frm_update_comment" enctype="multipart/form-data" role="form">
                @csrf
                  <input type="hidden" name="edit_comment_id" id="edit_comment_id" value="">
                  <input type="hidden" name="edit_comment_content" id="edit_comment_content" value="">
                  <input type="hidden" name="edit_project_comment_section" id="edit_project_comment_section" value="">
                  <textarea class="form-control" name="edit_project_comment" id="edit_project_comment"></textarea>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="updateCommentPost()">Continue</button>
              {{-- <button type="submit" class="btn btn-primary">Continue</button> --}}
              {{-- </form> --}}
        </div>
      </div>
    </div>
  </div>

  </body>

  <script src="{{ asset('admintemplate/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('admintemplate/plugins/bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Sweetalert2 -->
  <script src="{{ asset('sweetalert2/package/dist/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('js/post.js') }}"></script>
  <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>

  <script>
      tinymce.init({
      selector: '#edit_project_comment'
    });
  tinymce.init({
      selector: '#project_comment'
    });

    function Generator() {};

        Generator.prototype.rand =  Math.floor(Math.random() * 26) + Date.now();

        Generator.prototype.getId = function() {
        return this.rand++;
    };
    var idGen =new Generator();
    function addWorkA()
    {
        var addworkA = idGen.getId();
        console.log(addworkA);

        $("#tbl_work_a").append("<tr><td><input type='text' class='form-control' name='objectives[]'></td><td><input type='text' class='form-control' name='activity[]'></td><td><input type='text' class='form-control' name='accomplishment[]'></td><td><input type='text' class='form-control "+addworkA+"_y1' name='y1_q1[]' onkeyup='setTotal("+addworkA+",1)'></td><td><input type='text' class='form-control "+addworkA+"_y1' name='y1_q2[]' onkeyup='setTotal("+addworkA+",1)'></td><td><input type='text' class='form-control "+addworkA+"_y1' name='y1_q3[]' onkeyup='setTotal("+addworkA+",1)'></td><td><input type='text' class='form-control "+addworkA+"_y1' name='y1_q4[]' onkeyup='setTotal("+addworkA+",1)'></td><td align='center' valign='middle'><span style='font-size: 16px;font-weight:bold' id='"+addworkA+"_y1_total'></span></td><td><input type='text' class='form-control "+addworkA+"_y2' name='y2_q1[]' onkeyup='setTotal("+addworkA+",2)'></td><td><input type='text' class='form-control "+addworkA+"_y2' name='y2_q2[]' onkeyup='setTotal("+addworkA+",2)'></td><td><input type='text' class='form-control "+addworkA+"_y2' name='y2_q3[]' onkeyup='setTotal("+addworkA+",2)'></td><td><input type='text' class='form-control "+addworkA+"_y2' name='y2_q4[]' onkeyup='setTotal("+addworkA+",2)'></td><td align='center' valign='middle'><span style='font-size: 16px;font-weight:bold' id='"+addworkA+"_y2_total'></span></td><td><input type='text' class='form-control "+addworkA+"_y3' name='y3_q1[]' onkeyup='setTotal("+addworkA+",3)'></td><td><input type='text' class='form-control "+addworkA+"_y3' name='y3_q2[]' onkeyup='setTotal("+addworkA+",3)'></td><td><input type='text' class='form-control "+addworkA+"_y3' name='y3_q3[]' onkeyup='setTotal("+addworkA+",3)'></td><td><input type='text' class='form-control "+addworkA+"_y3' name='y3_q4[]' onkeyup='setTotal("+addworkA+",3)'></td><td align='center' valign='middle'><span style='font-size: 16px;font-weight:bold' id='"+addworkA+"_y3_total'></span></td><td valign='middle'><i class='fas fa-trash text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td></tr>");
    }

    function addWorkC()
    {
        $("#tbl_work_c").append("<tr><td><input type='text' class='form-control' name='assump_obj[]'></td><td><input type='text' class='form-control' name='assump_risk[]'></td><td><input type='text' class='form-control' name='assump_action[]'></td><td valign='middle' align='center'><i class='fas fa-trash text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td></tr>");
    }

    function removeRow(obj)
    {
        $(obj).closest('tr').remove();
    }


    function setTotal(id,yr)
    {
        var total = 0;
        $('.'+id+"_y"+yr).each(function() {
        // 'this' refers to the current element in the iteration
            var currentElementText = $(this).val();
            if(currentElementText > 0)
                total += parseInt(currentElementText);
            else
                total += 0;
        // Perform any operation you need on each element
        });
       console.log(total);
        $("#"+id+"_y"+yr+"_total").empty().text(total);
    }

    function setTotalB(id,yr)
    {
        var total = 0;
        $('.'+id+"_exp_y"+yr).each(function() {
        // 'this' refers to the current element in the iteration
            var currentElementText = $(this).val();
            if(currentElementText > 0)
                total += parseInt(currentElementText);
            else
                total += 0;
        // Perform any operation you need on each element
        });
       
        $("#"+id+"_y"+yr+"_total").empty().text(total);
    }

    // $(".y1_q,.y2_q,.y3_q").keyup(function(){
    //     var class_name = $(this).attr('class');
    //     class_name = class_name.split(' ');
    //     //console.log(class_name[1]);
    //     var total = 0;
    //     $('.'+class_name[1]).each(function() {
    //     // 'this' refers to the current element in the iteration
    //         var currentElementText = $(this).val();
    //         if(currentElementText > 0)
    //             total += parseInt(currentElementText);
    //         else
    //             total += 0;
    //     // Perform any operation you need on each element
    //     });
    //     console.log("#"+class_name[1]+"_total"+":"+total);
    //     $("#"+class_name[1]+"_total").empty().text(total);
    // })

    function addComment(type)
{
  $("#comment_type").val(type);
  $("#project_comment_section").val(type);
  $("#addCommentModal").modal("toggle");
}

function addCommentPost()
{
  comment = tinymce.get("project_comment").getContent();
  var section = $("#project_comment_section").val();
  $("#project_comment_content").val(comment);
  frmSubmit('frm_comment','{{ url('/project/add-comments') }}','{{ url('project/workplan/'.$data['project']['id']) }}');
}

function updateComment(id)
{
  $.getJSON( "{{url('project/json-comment')}}/"+id, function(data ) {
        //console.log( "success" );
    }).done(function(data) {
        //console.log(data.section_id);
        $("#edit_project_comment_section").val(data.section_id);
        tinymce.get("edit_project_comment").setContent(data.comment);

    }).fail(function(data) {
        console.log( "error" );
    })
    
  $("#edit_comment_id").val(id);
  $("#editCommentModal").modal("toggle");
  
}

function updateCommentPost()
{
  comment = tinymce.get("edit_project_comment").getContent();
  var editsection = $("#edit_project_comment_section").val();
  $("#edit_comment_content").val(comment);
  frmSubmit('frm_update_comment','{{ url('/project/update-comments') }}','{{ url('project/workplan/'.$data['project']['id']) }}')
}

  </script>