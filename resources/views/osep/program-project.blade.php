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
              <h1 class="m-0">PROGRAM : {{ $data['program_title'] }}</h1>
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
                  <h3 class="card-title">PROJECT LIST</h3>
  
                  <div class="card-tools">
                    <a href="{{ url('/osep/project/add') }}"  class="btn btn-primary"><i class="fas fa-puls"></i> ADD NEW PROJECT </a>
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
      ajax: '{{ url("/osep/project/json2") }}/'+{{$data['progid']}},
      columns: [
          { data: 'title' },
          { data: 'proposal_type' },
          { data: 'cost' },
          { data: 'duration'},
          { data: 'status'},
          { 
            "data": function ( row, type, val, meta ) {
                return '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="{{ url('/project/edit/') }}/'+row.id+'">Edit</a><a class="dropdown-item" href="{{ url("/project/lib") }}/'+row.id+'">LIB</a><a class="dropdown-item" href="{{ url("/project/print") }}/'+row.id+'" target="_blank">Print</a><a class="dropdown-item" href="#" onclick="frmSubmitDelete('+row.id+')">Delete</a></div></center>';

                // return '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="{{ url("/project/print") }}/'+row.id+'" target="_blank">Print</a></div></center>';
            }
          
          },
      ]
  });

  $('#tbl').DataTable();

});
</script>
@endsection