@extends('layouts.master')

@section('css')
   <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> 
@endsection

@section('content')
<form method="POST" id="frm" enctype="multipart/form-data" role="form">
  {{-- <form method="POST" id="frm2" enctype="multipart/form-data" action="{{ url('/osep/program/create') }}"> --}}
    @csrf
    <input type="hidden" name="frm_url_action" id="frm_url_action" value="{{ url('osep/program/create') }}">
    <input type="hidden" name="frm_url_reset" id="frm_url_reset" value="{{ url('/project') }}">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Add New Program</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
              <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="pt-2 px-3"><h3 class="card-title"></h3></li>
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">PROGRAM PROFILE</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="program-summary-tab" data-toggle="pill" href="#program-summary" role="tab" aria-controls="program-summary" aria-selected="true">PROGRAM SUMMARY</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-home-tab2" data-toggle="pill" href="#custom-tabs-two-home2" role="tab" aria-controls="custom-tabs-two-home2" aria-selected="true">COMPONENT PROJECT</a>
                  </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">LIB</a>
                </li> --}}
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>PROGRAM TITLE</h4></label>
                                <textarea class="form-control" id="title" name="title"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><h4>IMPLEMENTING DEPARTMENT / AGENCY</h4></label>
                                        <select class="form-control select2 select2bs4" id="implementing_agency" name="implementing_agency">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><h4>CO-IMPLEMENTING DEPARTMENT / AGENCy</h4></label>
                                        <select class="form-control select2 select2bs4" id="coimplementing_agency" name="coimplementing_agency[]" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><h4>PROGRAM DURATION</h4></label>
                                <div class="row">
                                  <div class="col-6">
                                    <label for="exampleInputEmail1">Program Start Date</label>
                                    <select class="form-control slct_month" id="slct_mon_orig_start" name="slct_mon_orig_start">
                                      
                                    </select>
                                    <select class="form-control slct_year" id="slct_year_orig" name="slct_year_orig" style="margin-top:3%">
                                      
                                    </select>
                                  </div>
                                  <div class="col-6">
                                    <label for="exampleInputEmail1">Program End Date</label>
                                    <select class="form-control slct_month" id="slct_mon_orig_end" name="slct_mon_orig_end">
                                      
                                    </select>
                                    <select class="form-control" id="slct_year_orig_end" name="slct_year_orig_end" style="margin-top:3%">
                                      
                                    </select>
                                  </div>
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">

                </div>

                <div class="tab-pane fade" id="program-summary" role="tabpanel" aria-labelledby="program-summary-tab">
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>OBJECTIVE OF THE PROGRAM</h4></label>
                                <textarea class="form-control" id="program_objective" name="program_objective"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                              <label for="exampleInputEmail1"><h4>SIGNIFICANCE/IMPACT TO KNOWLEDGE ADVANCEMENT AND TO THE SOCIETY</h4></label>
                              <textarea class="form-control" id="program_significance" name="program_significance"></textarea>
                          </div>
                          <div class="col-12">
                            <div class="form-group">
                              <label for="exampleInputEmail1"><h4>METHODOLOGY</h4></label>
                              <textarea class="form-control" id="program_methodology" name="program_methodology"></textarea>
                          </div>
                      </div>
                      </div>
                   </div>
                </div>


                <div class="tab-pane fade" id="custom-tabs-two-home2" role="tabpanel" aria-labelledby="custom-tabs-two-home2-tab">
                    <table id="tbl_project" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th style="width: 40%">Project Title</th>
                          <th>Project Cost</th>
                          <th>Duration</th>
                          <th>Status</th>
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
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-lg float-right">SAVE</button>
            </div>
        </form>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->


@endsection

@section('js')
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('tinymce/jquery.tinymce.min.js') }}"></script>

<script type="text/javascript">
    tinymce.init({
      selector: '#program_objective'
    });

    // tinymce.init({
    //   selector: '#program_significance'
    // });

    // tinymce.init({
    //   selector: '#program_methodology'
    // });
</script>

<script>
  $('#tbl_project').DataTable();



  $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  loadJSON("implementing_agency","agency","{{ url('/library/agency') }}");
  loadJSON("monitoring_division","division","{{ url('/library/division') }}");
  loadJSON("coimplementing_agency","agency","{{ url('/library/agency') }}");
</script>
@endsection