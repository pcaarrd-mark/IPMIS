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
              <h1 class="m-0">PROJECT : {{$data['title']}}</h1>
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
                  <h3 class="card-title">COMMENTS</h3>
                  <div class="card-tools">
                    <a href="javascript:void(0)"  class="btn btn-primary" onclick="addComment()"><i class="fas fa-puls"></i> ADD </a>
                  </div>
  
                </div>
                 
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="tbl" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th style="width: 40%">Comments</th>
                        <th>Remarks By</th>
                        <th>Status</th>
                        <th>Date Acted</th>
                        <th style="width: 15%"></th>
                      </tr>
                      </thead>
                      <tbody>
                     
                      </tbody>
                      
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
                  <input type="hidden" name="comment_project_id" value="{{$data['project_id']}}">
                  <label for="project_section_id">Section</label>
                  <select class="form-control" name="project_section_id" id="project_section_id">
                      @foreach (getCommentSection('Project') as $item)
                        <option value="{{$item->id}}">{{$item->description}}</option>   
                      @endforeach
                  </select>
                  <br>
                  <label for="project_comment">Comments</label>
                  <textarea class="form-control" name="project_comment"></textarea>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="frmSubmit('frm_comment','{{ url('/project/add-comments') }}','{{ url('project/comments/'.$data['project_id']) }}')">Continue</button>
              {{-- <button type="submit" class="btn btn-primary">Continue</button> --}}
              {{-- </form> --}}
            </div>
          </div>
        </div>
      </div>
      <form method="POST" id="frm_done" enctype="multipart/form-data" role="form">
          @csrf
          <input type="hidden" name="comment_id" id="comment_id" value="">
          <input type="hidden" name="comment_project_id" id="comment_project_id" value="">
      </form>
@endsection

@section('js')
<script>
function addComment()
{
  $("#addCommentModal").modal("toggle");
}

$(document).ready(function(){

// DataTable
$('#tbl').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ url("/project/list-comments/".$data['project_id']) }}',
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

function commentDone(id,proj_id)
{
  $("#comment_id").val(id);
  $("#comment_project_id").val(proj_id);
  frmSubmit('frm_done','{{ url('/project/done-comments') }}','{{ url('project/comments/'.$data['project_id']) }}')
}
</script>
@endsection