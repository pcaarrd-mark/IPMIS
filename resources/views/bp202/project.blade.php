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
              <h1 class="m-0">PROPOSAL</h1>
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
                  <a href="{{ url('/project/new') }}"  class="btn btn-primary"><i class="fas fa-puls"></i> ADD NEW PROPOSAL </a>
                </div>
              </div>
               
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tbl" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 20%">Program Title</th>
                    <th style="width: 20%">Project Title</th>
                    <th>Proposal Type</th>
                    <th>Project Cost</th>
                    <th>Duration</th>
                    <th>Division</th>
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
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
<form method="POST" id="frm" enctype="multipart/form-data" role="form">
  @csrf
  <input type="hidden" name="frm_url_action" id="frm_url_action" value="{{ url('/project/delete') }}">
  <input type="hidden" name="frm_url_reset" id="frm_url_reset" value="{{ url('/project') }}">
  <input type="hidden" name="project_id" id="project_id" value="">
</form>
@endsection

@section('js')
    <!-- DataTables  & Plugins -->

    <script>
      // $(function () {
      //   $("#example1").DataTable({
      //     "responsive": true, "lengthChange": false, "autoWidth": false,
      //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      //   }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      //   $('#example2').DataTable({
      //     "paging": true,
      //     "lengthChange": false,
      //     "searching": false,
      //     "ordering": true,
      //     "info": true,
      //     "autoWidth": false,
      //     "responsive": true,
      //   });
      // });

      $(document).ready(function(){

      // DataTable
      $('#tbl').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ url("/project/json") }}',
          columns: [
              { data: 'program_title'},
              { data: 'project_title' },
              { data: 'proposal_type' },
              { data: 'project_cost' },
              { data: 'project_dur_orig'},
              { data: 'division'},
              { 
                "data": function ( row, type, val, meta ) {
                    return '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="{{ url('/project/edit/') }}/'+row.id+'">Edit</a><a class="dropdown-item" href="{{ url("/project/print") }}/'+row.id+'" target="_blank">Print</a><a class="dropdown-item" href="#" onclick="frmSubmitDelete('+row.id+')">Delete</a></div></center>';

                    // return '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="{{ url("/project/print") }}/'+row.id+'" target="_blank">Print</a></div></center>';
                }
              
              },
          ]
      });

      });

      function frmSubmitDelete(id)
      {
        $("#project_id").val(id);
        $("#frm").submit();
      }
    </script>
@endsection