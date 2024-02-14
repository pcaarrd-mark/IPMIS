@extends('layouts.master')
@section('css')
   <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> 
  <style>

  </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">PROJECTS</h1>
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
                  <h3 class="card-title">LIST</h3>
  
                  <div class="card-tools">
                    <button class="btn btn-primary">Send to DPMIS</button>
                  </div>
                </div>
                 
                <!-- /.card-header -->
                <div class="card-body">
                
                  <div class="icheck-primary">
                    <input type="checkbox" id="checkAll" />
                    <label for="checkAll">SELECT ALL CLEARED PROPOSAL</label>
                </div>

                  <table id="tbl" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th></th>
                      <th style="width: 40%">Project Title</th>
                      <th>Type</th>
                      <th>Cost</th>
                      <th>Duration</th>
                      <th>Status</th>
                      <th style="width: 15%"></th>
                    </tr>
                    </thead>
                    <tbody>
                   
                    </tbody>
                    
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->    

<!-- Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Approve Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="frm" enctype="multipart/form-data" role="form">
        {{-- <form method="POST" id="frm2" enctype="multipart/form-data" action="{{ url('/osep/project/add-division') }}"> --}}
            @csrf
            <input type="hidden" name="frm_url_action" id="frm_url_action" value="{{ url('osep/project/add-division') }}">
            <input type="hidden" name="frm_url_reset" id="frm_url_reset" value="{{ url('/osep/proposals') }}">
            <input type="hidden" name="project_id" id="project_id" value="">
        <fieldset class="form-group row">
          <div class="col-sm-12">
            <h5>Assign Monitoring Division</h5>
          </div>

          <div class="col-sm-12">
            @foreach(getDivision() AS $list)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="division[]" id="gridRadios_{{$list->id}}" value="{{$list->id}}">
                <label class="form-check-label" for="gridRadios_{{$list->id}}">
                  {{$list->acronym}}
                </label>
              </div>
            @endforeach
          </div>

        </fieldset>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Continue</button>
      </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){
   // Check or uncheck all checkboxes based on the "checkAll" checkbox
   $("#checkAll").change(function() {
    $(".checkbox").prop('checked', $(this).prop("checked"));
  });
  
  // Update the "checkAll" checkbox when individual checkboxes are clicked
  $(".checkbox").change(function() {
    if ($(".checkbox:checked").length == $(".checkbox").length) {
      $("#checkAll").prop("checked", true);
    } else {
      $("#checkAll").prop("checked", false);
    }
  });

  // DataTable
  $('#tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ url("/osep/project/json") }}',
      
      columns: [
          {
            data: 'id',
            orderable: false,
            render: function(data, type, row) {
              // Render checkbox column
              if(row.status == 'Pending')
                return '<input type="checkbox" class="checkbox" disabled style="display:none">';
              else
                return '<input type="checkbox" value="'+row.id+'" class="checkbox">';
            },
            checkbox: true // Enable checkboxes
          },
          { data: 'title' },
          { data: 'proposal_type' },
          { data: 'cost' },
          { data: 'duration'},
          { data: 'status'},
          { 
            "data": function ( row, type, val, meta ) {

                if(row.status == 'Pending')
                  return '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="javascript:void(0)" onclick="approve('+row.id+')">Approve</a><a class="dropdown-item" href="{{ url('/project/edit/') }}/'+row.id+'">Disapprove</a><a class="dropdown-item" href="{{ url('/project/edit/') }}/'+row.id+'">View</a></div></center>';
                else
                  return '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="{{ url('/project/edit/') }}/'+row.id+'">Send to DPMIS</a></div></center>';

                // return '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="{{ url("/project/print") }}/'+row.id+'" target="_blank">Print</a></div></center>';
            }
          
          },
      ]
  });

  $('#tbl').DataTable();
});

function showOption()
  {
    $("#optionModal").modal("toggle");
  }

function approve(id)
  {
    $("#project_id").val(id);
    $("#approveModal").modal("toggle");
  }


</script>
@endsection