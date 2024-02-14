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
    <input type="hidden" name="frm_url_reset" id="frm_url_reset" value="{{ url('/osep/program') }}">

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
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-home-tab2" data-toggle="pill" href="#custom-tabs-two-home2" role="tab" aria-controls="custom-tabs-two-home2" aria-selected="true">NUMBER OF PERSONNEL REQUIREMENT</a>
                  </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">SUMMARY OF EQUIPMENT RELEVANT TO THE PROGRAM </a>
                </li>
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
                  <p align="right"><a href="javascript:void(0)" class="btn btn-info" onclick="addEquipment()">ADD</a></p>
                  <table class="table" id="tbl_personnel">
                    <thead>
                      <th>Name of Equipment</th>
                      <th>Existing Equipment in the Implementing Agency (number)</th>
                      <th>Existing Equipment from Other Collaborating Agency/ies (Local and Abroad) (number)</th>
                      <th>To Be Purchased (number)</th>
                      <th>Justification for the Purchase</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                </div>

                <div class="tab-pane fade" id="program-summary" role="tabpanel" aria-labelledby="program-summary-tab">
                    @foreach (getAllProjectSection([31,32,33,34,35,36,37,38]) as $item)
                    <div class="row">
                      <div class="col-12">
                            <div class="form-group">
                              <label for="exampleInputEmail1"><h4>{!! $item->description !!}</h4></label>
                              <input type="hidden" id="{{$item->col}}_content" name="{{$item->col}}_content">
                              <textarea class="otherinfo" id="{{$item->col}}" name="{{$item->col}}"></textarea>
                          </div>
                      </div>
                  </div>
                  @endforeach
                </div>


                <div class="tab-pane fade" id="custom-tabs-two-home2" role="tabpanel" aria-labelledby="custom-tabs-two-home2-tab">
                  <p align="right"><a href="javascript:void(0)" class="btn btn-info" onclick="addPersonnel()">ADD</a></p>
                  <table class="table" id="tbl_personnel">
                    <thead>
                      <th>Full-time</th>
                      <th>Part-Time</th>
                      <th></th>
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

<script type="text/javascript">
    tinymce.init({
      selector: '.otherinfo',
      plugins: 'lists',
      toolbar: 'numlist bullist'
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

  function addPersonnel()
  {

    $("#tbl_personnel").append("<tr><td><input type='text' class='form-control' name='fulltime[]'></td><td><input type='text' class='form-control' name='parttime[]'></td><td><i class='fas fa-times-circle text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td></tr>");
  }

  function addEquipment()
  {

    $("#tbl_personnel").append("<tr><td><input type='text' class='form-control'  name='equip_name[]'></td><td><input type='text' class='form-control'  name='equip_exist[]'></td><td><input type='text' class='form-control'  name='equip_others[]'></td><td><input type='text' class='form-control'  name='equip_tobe[]'></td><td><input type='text' class='form-control'  name='equip_justi[]'></td><td><i class='fas fa-times-circle text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td></tr>");
  }
</script>
@endsection