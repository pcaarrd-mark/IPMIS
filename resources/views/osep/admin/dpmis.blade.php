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
              <h1 class="m-0">RECEIVED FROM DPMIS</h1>
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
                    <button class="btn btn-primary" onclick="frmSubmit('frm_dpmis','{{ url('/osep/project/batch-accept-from-dpmis') }}','{{ url('osep/proposals') }}')">ACCEPT</button>
                    {{-- <button class="btn btn-primary" onclick="submitTest()">ACCEPT</button> --}}
                  </div>
                </div>
                 
                <!-- /.card-header -->
                <div class="card-body">
                
                  <div class="icheck-primary">
                    <input type="checkbox" id="checkAll" />
                    <label for="checkAll">SELECT ALL PROPOSAL</label>
                </div>
                <form method="POST" id="frm_dpmis" enctype="multipart/form-data" role="form">
                {{-- <form method="POST" id="frm_dpmis" enctype="multipart/form-data" role="form" action="{{ url('/osep/project/batch-accept-from-dpmis') }}"> --}}
                  @csrf
                  <table id="tbl" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th></th>
                      <th style="width: 40%">Project Title</th>
                      <th>Type</th>
                      <th>SOF</th>
                      <th>Cost</th>
                      <th>Duration</th>
                    </tr>
                    </thead>
                    <tbody>
                   
                    </tbody>
                  </form>
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
      ajax: '{{ url("/osep/dpmis/json") }}',
      
      columns: [
          {
            data: 'id',
            orderable: false,
            render: function(data, type, row) {
              return '<input type="checkbox" value="'+row.id+'" class="checkbox" name="checkproposal[]">';
            },
            checkbox: true // Enable checkboxes
          },
          { data: 'title' },
          { data: 'proposal_type' },
          { data: 'proposal_sof' },
          { data: 'cost' },
          { data: 'duration'},
      ]
  });

  $('#tbl').DataTable();
});

function submitTest()
{
  $("#frm_dpmis").submit();
}
</script>
@endsection