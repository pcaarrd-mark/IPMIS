@extends('layouts.master')

@section('css')
   <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> 
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Program</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">LIST</h3>

                <div class="card-tools">
                  <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-program"><i class="fas fa-puls"></i> ADD NEW PROGRAM </a>
                </div>
              </div>
               
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tbl" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 5%">#</th>
                    <th>Program Title</th>
                    <th style="width: 20%">Program Leader</th>
                    <th style="width: 15%">No. of Projects</th>
                    <th style="width: 10%"></th>
                  </tr>
                  </thead>
                  <tbody>
                 
                  </tbody>
                  <tfoot>
                    <tr>
                      <th style="width: 5%">#</th>
                      <th>Program Title</th>
                      <th>Program Leader</th>
                      <th>No. of Projects</th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    
    <div class="modal fade" id="modal-program">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">NEW PROGRAM</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" id="frm" enctype="multipart/form-data" role="form">
            @csrf
            <input type="hidden" name="frm_url_action" id="frm_url_action" value="{{ url('/program/create') }}">
            <input type="hidden" name="frm_url_reset" id="frm_url_reset" value="{{ url('/program') }}">

            <div class="form-group">
              <label for="exampleInputEmail1">Program Title</label>
              <textarea class="form-control" id="program_title" name="program_title" placeholder=""></textarea>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Program Leader</label>
              <input type="text" class="form-control" id="program_leader" name="program_leader" placeholder="">
            </div>
          </div>
        
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('js')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
      $(document).ready(function(){

      // DataTable
      $('#tbl').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ url("/program/json") }}',
          columns: [
              { data: 'id' },
              { data: 'program_title' },
              { data: 'program_leader' },
              { data: 'id'},
              { 
                "data": function ( row, type, val, meta ) {
                    return '<div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a><div class="dropdown-divider"></div><a class="dropdown-item" href="#">Separated link</a></div></div>';
                }
              
              },
          ]
      });

      });
    </script>
@endsection