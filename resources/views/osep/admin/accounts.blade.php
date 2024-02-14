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
              <h1 class="m-0">ACCOUNTS</h1>
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
                    <button class="btn btn-primary">ADD USER</button>
                  </div>
                </div>
                 
                <!-- /.card-header -->
                <div class="card-body">
              

                  <table id="tbl" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th style="width: 60%">Name</th>
                      <th>Type</th>
                      <th style="width: 5%"></th>
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
    $('#tbl').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url("/settings/account/json") }}',
        
        columns: [
            { data: 'name' },
            { data: 'usertype' },
            { 
              "data": function ( row, type, val, meta ) {

              return '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="{{ url('/acc/edit/') }}/'+row.id+'">Reset Password</a><a class="dropdown-item" href="{{ url('/project/edit/') }}/'+row.id+'">Delete</a></div></center>';

              }
            }
        ]
    });
  
    $('#tbl').DataTable();
  });

  </script>
@endsection