@extends('layouts.master')
@section('css')
   <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> 
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
  
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-12">
  
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"></h3>
                  <div class="card-tools">
                    <a href="{{url('/project/comments-view-all/'.$data['project']['id'])}}" class="btn btn-primary" target="_blank">VIEW ALL COMMENTS</a>
                  </div>
                </div>
                  <div class="card-body">
                    <table class="table table-bordered">

                      @foreach (getAllProjectSection([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25]) as $item)

                        
                      <tr id="comp_{{$item->id}}">
                        <td>
                          <span class="float-left"><b>{!!$item->description!!}</b></span>
                          <span class="float-right"><button class="btn btn-info" onclick="addComment({{$item->id}})"> <small>add comment</small></button></span>
                          
                          @switch($item->id)
                            @case(6)
                              <br><br>
                              <table class="table table-bordered" >
                                <thead class="table-info">
                                  <th><center>Country</center></th>
                                  <th><center>Region</center></th>
                                  <th><center>Province</center></th>
                                  <th><center>Municipal</center></th>
                                  <th><center>Brgy</center></th>
                                </thead>
                                @foreach (getProjectSiteList($data['project']['id']) as $locs)
                                  <tr>
                                      <td>Philippines</td>
                                      <td>{{getLocationLib('region',$locs->region_id)}}</td>
                                      <td>{{getLocationLib('province',$locs->province_id)}}</td>
                                      <td>{{getLocationLib('municipal',$locs->municipal_id)}}</td>
                                      <td>{{getLocationLib('brgy',$locs->brgy_id)}}</td>
                                  </tr>   
                                @endforeach
                              </table>
                              @break

                            @case(26)
                              <br><br>
                              <table class="table table-bordered">
                                <thead class="table-info">
                                  <th><center>Position</center></th>
                                  <th><center>Percent Time Devoted to the Project</center></th>
                                  <th><center>Responsibilities</center></th>
                                </thead>
                                
                              </table>
                              @break
                            
                              @case(27)
                              <br><br>
                              <table class="table table-bordered">
                                <thead class="table-info">
                                  <th><center>YEAR</center></th>
                                  <th><center>PS</center></th>
                                  <th><center>MOOE</center></th>
                                  <th><center>EO</center></th>
                                  <th><center>TOTAL</center></th>
                                </thead>
                                @foreach ($data['budgetlist'] as $budgets)
                                    <tr>
                                          <?php
                                            $ps =   getLIBDetails('specific',$data['project']['id'],$budgets->year,'ps');
                                            $mooe =   getLIBDetails('specific',$data['project']['id'],$budgets->year,'mooe');
                                            $eo =   getLIBDetails('specific',$data['project']['id'],$budgets->year,'eo');
                                            $total = $ps + $mooe + $eo;
                                          ?>
                                          <td align="center">{{ $budgets->year }}</td>
                                          <td align="right">{{ number_format($ps,2) }}</td>
                                          <td align="right">{{ number_format($mooe,2) }}</td>
                                          <td align="right">{{ number_format($eo,2) }}</td>
                                          <td align="right">{{ number_format($total,2) }}</td>
                                    </tr>  
                                  @endforeach
                              </table>
                              @break

                              @case(28)
                              <br><br>
                              <table class="table table-bordered">
                                <thead class="table-info">
                                  <th><center>Title of the Project</center></th>
                                  <th><center>Funding Agency</center></th>
                                  <th><center>Involvement in the Project</center></th>
                                </thead>
                                @foreach (getProjectOtherList($data['project']['id']) as $others)
                                  <tr>
                                      <td>{{$others->leader_project}}</td>
                                      <td>{{$others->leader_funding}}</td>
                                      <td>{{$others->leader_involvement}}</td>
                                  </tr>   
                                @endforeach
                                
                              </table>
                              @break

                            @default
                                <br><br>
                                <div class="alert" style="background-color: rgb(207, 233, 244)"><p class="pl-5">{!! getAllProjectContent($data['project']['id'],$item->id,$item->col) !!}</p></div>
                              @break
                          @endswitch


                          <div class="alert" style="background-color: rgb(248, 248, 248)">  
                            <ul>Comments : 
                            @foreach (getComments($data['project']['id'],$item->id,'list') as $item)
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
                        </td>
                      </tr>


                      @endforeach
                      

                    </table>
                  </div>  
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

      <div class="modal fade" id="addCommentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Comment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
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
              {{-- <button type="submit" class="btn btn-primary">Continue</button> --}}
              {{-- </form> --}}
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Comment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              {{-- <form method="POST" id="frm_comment" enctype="multipart/form-data" role="form" action="{{ url('/project/update-comments') }}"> --}}
              <form method="POST" id="frm_update_comment" enctype="multipart/form-data" role="form">
                @csrf
                  <input type="hidden" name="edit_comment_id" id="edit_comment_id" value="">
                  <input type="hidden" name="edit_comment_content" id="edit_comment_content" value="">
                  <input type="text" name="edit_project_comment_section" id="edit_project_comment_section" value="">
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
      <form method="POST" id="frm_comment_delete" enctype="multipart/form-data" role="form">
        @csrf
        <input type="hidden" name="delete_comment_id" id="delete_comment_id" value="">
      </form>
@endsection

@section('js')
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>

<script>
  $("#comp_27").focus();

  
  tinymce.init({
      selector: '#edit_project_comment'
    });
  tinymce.init({
      selector: '#project_comment'
    });
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
  frmSubmit('frm_comment','{{ url('/project/add-comments') }}','{{ url('project/comments/'.$data['project']['id']) }}');
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
  frmSubmit('frm_update_comment','{{ url('/project/update-comments') }}','{{ url('project/comments/'.$data['project']['id']) }}')
}

$(document).ready(function(){

// DataTable
$('#tbl').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ url("/project/list-comments/".$data['project']['id']) }}',
    columns: [
        { data: 'comment' },
        { data: 'remarks_by' },
        { data: 'status' },
        { data: 'done_at' },
        { data: 'button' },
    ]
});

$('#tbl').DataTable();
});

function commentDone(id,proj_id,type)
{
  $("#comment_id").val(id);
  $("#comment_project_id").val(proj_id);
  $("#comment_type").val(type);
  frmSubmit('frm_done','{{ url('/project/done-comments') }}','{{ url('project/comments/'.$data['project']['id']) }}')
}

function deleteComment(id)
{
  $("#delete_comment_id").val(id);
  frmSubmit('frm_comment_delete','{{ url('/project/delete-comments') }}','{{ url('project/comments/'.$data['project']['id']) }}')
}
</script>
@endsection