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
        <div class="row">
          <div class="col-5">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">ADD NEW</h3>

                <div class="card-tools">
                  {{-- <a href="{{ url('/project/new') }}"  class="btn btn-primary"><i class="fas fa-puls"></i> ADD NEW PROPOSAL </a> --}}
                </div>
              </div>
               
              <!-- /.card-header -->
              <div class="card-body">
                <form method="POST" id="frm-summary" enctype="multipart/form-data" role="form" action="{{ url('/bp202/add-agency') }}" target="_blank">
                  @csrf
                <label for="period">Agency</label>
                <input type="text" class="form-control" name="agency_desc" placeholder="Description">
                <br>
                <input type="text" class="form-control" name="agency_acro" placeholder="Acronym">

              </div>
              <!-- /.card-body -->
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
              </div>
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

@endsection

@section('js')
<script>
  $(document).ready(function(){
    $("#division").css("width","auto");

  });

loadJSON("division","division","{{ url('/library/division') }}");

</script>
@endsection