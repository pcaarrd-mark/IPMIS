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

        {{-- @if(ifOwner($data['project']['id'])) --}}
        <div class="alert alert-warning  alert-dismissible fade show"><center>Caution: Avoid refreshing or closing this page. To preserve the modifications, kindly select the save button.The page will automatically save if there is no activity for a duration of 5 minutes.</center>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <p align="right"><a href="{{url('/print/workplan/'.$data['project']['id'])}}" class="btn btn-info btn-lg" target="_blank"><i class="fas fa-print"></i> PRINT</a> &nbsp; <button class="btn btn-primary btn-lg" onclick="frmSubmit('frm_workplan','{{ url('project/workplan/create') }}','{{ url('project/workplan/'.$data['project']['id']) }}');"><i class="fas fa-save"></i> SAVE</button></p>
        {{-- @else --}}
        {{-- <p align="right"><a href="{{url('/print/workplan/'.$data['project']['id'])}}" class="btn btn-info btn-lg" target="_blank"><i class="fas fa-print"></i> PRINT</a></p>
            <br/> --}}
        {{-- @endif --}}
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

        {{-- <ul class="nav nav-pills mb-3 justify-content-center custom-nav-color" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><h5>A – PROJECT WORKPLAN</h5></button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><h5>B – EXPECTED OUTPUTS</h5></button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"><h5>C – RISKS AND ASSUMPTIONS</h5></button>
            </li>
        </ul> --}}

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active p-3 alert alert-secondary" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <table class="table table-bordered bg-white" id="tbl_work_a">
                    <tr>
                        <td style="width: 40%" valign="middle">
                            <b></b>
                        </td>
                        <td align="center"><b>YEAR1</b></td>
                        <td align="center"><b>YEAR2</b></td>
                        <td align="center"><b>YEAR3</b></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td align="center"><b></b></td>
                    </tr>

                    <tr>
                        <td valign="middle">
                            <b>I. Personal Services</b>
                        </td>
                    </tr>
                    <tr id="ps_dc">
                        <td valign="middle">
                            <b>&nbsp&nbspDirect Cost</b>
                            <button type="button" class="btn btn-info btn-sm" onclick="addDATA('ps_dc')">add</button>
                        </td>
                    </tr>
                    <tr id="ps_ic">
                        <td valign="middle">
                            <b>&nbsp&nbspIndirect Cost</b>
                            <button type="button" class="btn btn-info btn-sm" onclick="addDATA('ps_ic')">add</button>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle">
                            <b>&nbsp&nbspSub-total PS</b>
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle">
                            <b>II. Maintenance and Other Operating Expenses</b>
                        </td>
                    </tr>
                    <tr id="mooe_dc">
                        <td  valign="middle">
                            <b>&nbsp&nbspDirect Cost</b>
                            <button type="button" class="btn btn-info btn-sm" onclick="addDATA('mooe_dc')">add</button>
                        </td>
                    </tr>
                    <tr id="mooe_ic">
                        <td valign="middle">
                            <b>&nbsp&nbspIndirect Cost</b>
                            <button type="button" class="btn btn-info btn-sm" onclick="addDATA('mooe_ic')">add</button>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle">
                            <b>&nbsp&nbspSub-total MOOE</b>
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                    </tr>
                    <tr id="eo_dc">
                        <td valign="middle">
                            <b>III. Equipment Outlay</b>
                            <br>
                            <b>&nbsp&nbspDirect Cost</b>
                            <button type="button" class="btn btn-info btn-sm" onclick="addDATA('eo_dc')">add</button>
                        </td>
                    </tr>
                    <tr id="eo_ic">
                        <td  valign="middle">
                            <b>&nbsp&nbspIndirect Cost</b>
                            <button type="button" class="btn btn-info btn-sm" onclick="addDATA('eo_ic')">add</button>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle">
                            <b>&nbsp&nbspSub-total EO</b>
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle">
                            <b>GRANDTOTAL</b>
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                        <td valign="middle">
                            
                        </td>
                    </tr>
                    
                </table>
                {{-- @if(!ifOwner($data['project']['id'])) --}}
                    <p align="right"><button type="button" class="btn btn-info btn-sm" onclick="addComment(39)"> ADD COMMENT/S</button></p>
                {{-- @endif --}}
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

    function Generator() {};

        Generator.prototype.rand =  Math.floor(Math.random() * 26) + Date.now();

        Generator.prototype.getId = function() {
        return this.rand++;
    };
    var idGen =new Generator();
    function addDATA(tbl)
    {
        var addworkA = idGen.getId();
        console.log(addworkA);

        $("#"+tbl).after("<tr><td>ITEM<br># of ITEM<br>AGENCY<br>COUNTERPART(YES/NO)</td><td valign='middle'><input type='number' class='form-control'></td><td valign='middle'><input type='number' class='form-control'></td><td valign='middle'><input type='number' class='form-control'></td><td></td><td valign='middle' align='center'><i class='fas fa-trash text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td></tr>");
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