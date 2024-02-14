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
              <h1 class="m-0"></h1>
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
                  <h3 class="card-title">LIST PROJECT PROPOSAL</h3>
  
                  <div class="card-tools">
                  </div>
                </div>
                 
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="tbl" class="table table-bordered table-striped">
                    <thead>
                    <tr>
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
      
@endsection

@section('js')
<script>
$(document).ready(function(){

  // DataTable
  $('#tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ url("/osep/proposal-by-division/json") }}',
      columns: [
          { data: 'title' },
          { data: 'proposal_type' },
          { data: 'cost' },
          { data: 'duration'},
          { data: 'status'},
          { data: 'button'},
      ]
  });
});

function showOption()
  {
    $("#optionModal").modal("toggle");
  }

function addNew()
  {
    type = $('input[name=gridRadios]:checked').val();
    programid = $("#programid").val();
    switch (type) {
      case "option1":
          window.location.replace("{{ url('/osep/project/add') }}/"+type+"/"+programid);
        break;
    }
  }

  function updateStatus(id,status_id)
  {
    $("#update_project_id").val(id);
    $("#update_project_status").val(status_id);
    frmSubmit('frm_project_update','{{ url('/project/update-status') }}','{{ url('/project/division') }}');
  }

</script>
@endsection