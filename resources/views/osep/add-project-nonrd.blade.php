@extends('layouts.master')

@section('css')
   <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> 
@endsection

@section('content')
{{-- <form method="POST" id="frm" enctype="multipart/form-data" role="form"> --}}
  <form method="POST" id="frm2" enctype="multipart/form-data" action="{{ url('/osep/project/create') }}">
    @csrf
    <input type="hidden" name="frm_url_action" id="frm_url_action" value="{{ url('osep/project/create') }}">
    <input type="hidden" name="frm_url_reset" id="frm_url_reset" value="{{ url('/project') }}">
    <input type="hidden" name="program_title" id="program_title" value="{{$data['program_id']}}">
    <input type="hidden" name="proposal_type" id="proposal_type" value="{{$data['proposal_type']}}">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-12">
              <h1 class="m-0">{!!$data['title']!!}</h1>
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
                  <a class="nav-link active" id="aria-profile-tab" data-toggle="pill" href="#profile-tab" role="tab" aria-controls="aria-profile-tab" aria-selected="true">I. PROJECT PROFILE</a>
                </li>
                {{-- <li class="nav-item">
                  <a class="nav-link" id="project-site-tab" data-toggle="pill" href="#project-site" role="tab" aria-controls="project-site" aria-selected="true">SITE/S OF IMPLEMENTATION</a>
                </li> --}}
                <li class="nav-item">
                  <a class="nav-link" id="project-summary-1-tab" data-toggle="pill" href="#project-summary-1" role="tab" aria-controls="project-summary-1" aria-selected="true">II. SUMMARY</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="project-summary-2-tab" data-toggle="pill" href="#project-summary-2" role="tab" aria-controls="project-summary-2" aria-selected="true">FOR STARTUPS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="project-summary-3-tab" data-toggle="pill" href="#project-summary-3" role="tab" aria-controls="project-summary-3" aria-selected="true">METHODOLOGY</a>
                  </li>

                <li class="nav-item">
                  <a class="nav-link" id="projectfiles-tab" data-toggle="pill" href="#project-files" role="tab" aria-controls="project-other-handled-tab" aria-selected="true"><small>FILES</small></a>
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
                <div class="tab-pane fade show active" id="profile-tab" role="tabpanel" aria-labelledby="aria-profile-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                              <label for="exampleInputEmail1"><h4>PROGRAM TITLE</h4></label>
                              <textarea class="form-control" readonly>{{getProgramDetails($data['program_id'],'title')}}</textarea>
                              {{-- <select class="form-control select2 select2bs4" id="program_title" name="program_title">
                                <option value="N/A">N/A</option>
                              </select> --}}
                          </div>
                      </div>
                        <div class="col-12">
                              <div class="form-group">
                                <label for="title"><h4>PROJECT TITLE</h4></label>
                                <textarea class="form-control" id="title" name="title"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                            <label for="title"><h4>PROJECT LEADER/SEX</h4></label><br>
                            <label for="title"><h5>AGENCY(Smallest Unit):</h5></label><br>
                            <label for="title"><h5>ADDRESS/TELEPHONE/FAX/EMAIL:</h5></label>
                        </div>
                    </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="implementing_agency"><h4>IMPLEMENTING  AGENCY</h4></label>
                                        <select class="form-control select2 select2bs4" id="implementing_agency" name="implementing_agency">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="coimplementing_agency"><h4>BASE STATION</h4></label>
                                        <input type="text" class="form form-control">
                                    </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                      <label for="coimplementing_agency"><h4>OTHER IMPLEMENTATION SITE/S</h4></label>
                                      <input type="text" class="form form-control">
                                  </div>
                              </div>

                                {{-- <div class="col-4">
                                  <div class="form-group">
                                      <label for="counterpart_agency"><h4>COUNTERPART</h4></label>
                                      <select class="form-control select2 select2bs4" id="counterpart_agency" name="counterpart_agency[]" multiple="multiple">
                                      </select>
                                  </div>
                              </div> --}}
                                
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                              <label for="exampleInputEmail1"><h4>PROJECT DURATION (Number of Months : <span id="totalmonths"></span>)</h4></label>
                              <div class="row">
                                <div class="col-6">
                                  <label for="slct_mon_orig_start">Project Start Date</label>
                                  <select class="form-control slct_month" id="slct_mon_orig_start" name="slct_mon_orig_start" onchange="getTotalMonths()">
                                    
                                  </select>
                                  <select class="form-control slct_year" id="slct_year_orig" name="slct_year_orig" style="margin-top:3%" onchange="getTotalMonths()">
                                    
                                  </select>
                                </div>
                                <div class="col-6">
                                  <label for="slct_mon_orig_end">Project End Date</label>
                                  <select class="form-control slct_month" id="slct_mon_orig_end" name="slct_mon_orig_end" onchange="getTotalMonths()">
                                    
                                  </select>
                                  <select class="form-control" id="slct_year_orig_end" name="slct_year_orig_end" style="margin-top:3%" onchange="getTotalMonths()">
                                    
                                  </select>
                                </div>
                              </div>
                            </div>
                        </div>
                   </div>
                </div>

                <div class="tab-pane fade" id="project-summary-1" role="tabpanel" aria-labelledby="project-summary-1-tab">
                    @foreach (getAllProjectSection([10,11,12,14,15,19,20,21,22,23,25,27]) as $item)
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><h4>{!! $item->description !!}</h4></label>
                                <input type="hidden" id="{{$item->col}}_content" name="{{$item->col}}_content">
                                <div class="otherinfo" id="{{$item->col}}" name="{{$item->col}}"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach  
                </div>

                <div class="tab-pane fade" id="project-summary-2" role="tabpanel" aria-labelledby="project-summary-2-tab">
                    @foreach (getAllProjectSection([44,45,46,47,48]) as $item)
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><h4>{!! $item->description !!}</h4></label>
                                <input type="hidden" id="{{$item->col}}_content" name="{{$item->col}}_content">
                                <div class="otherinfo" id="{{$item->col}}" name="{{$item->col}}"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach  
                </div>

                <div class="tab-pane fade" id="project-summary-3" role="tabpanel" aria-labelledby="project-summary-3-tab">
                    @foreach (getAllProjectSection([49,50,51,52,53,54]) as $item)
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><h4>{!! $item->description !!}</h4></label>
                                <input type="hidden" id="{{$item->col}}_content" name="{{$item->col}}_content">
                                <div class="otherinfo" id="{{$item->col}}" name="{{$item->col}}"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach  
                </div>


                <div class="tab-pane fade" id="project-personnel" role="tabpanel" aria-labelledby="project-personnel-tab">
                  <p align="right"><a href="javascript:void(0)" class="btn btn-info" onclick="addPersonnel()">ADD</a></p>
                  <table class="table" id="tbl_personnel">
                      <thead>
                        <th>Position</th>
                        <th>Percent Time Devoted to the Project</th>
                        <th>Responsibilities</th>
                        <th></th>
                      </thead>
                      <tbody></tbody>
                  </table>
                </div>

                <div class="tab-pane fade" id="project-other-handled" role="tabpanel" aria-labelledby="project-other-handled-tab">
                  <p align="right"><a href="javascript:void(0)" class="btn btn-info" onclick="addPersonnelProject()">ADD</a></p>
                  <table class="table" id="tbl_involvement">
                      <thead>
                        <th>Title of the Project</th>
                        <th>Funding Agency</th>
                        <th>Involvement in the Project</th>
                        <th></th>
                      </thead>
                  </table>
                </div>


                <div class="tab-pane fade" id="project-files" role="tabpanel" aria-labelledby="project-files-tab">
                    <div class="form-group">
                      <label for="exampleInputFile">Detailed Program Proposal (if applicable)</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="form1">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Detailed Project Proposal <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="form2">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Project Line-Item Budget<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="form4">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Work Plan<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="form5">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Executive Summary for the Semi-Annual Progress Report<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="form6">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Executive Summary for the Annual Progress Report<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="form7">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Semi-Annual and-or Annual Financial Report<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="form8">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Project Monitoring Field Evaluation Report<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="form10">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Schedule of Accounts Payable<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="form9">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">List of Personnel Involved<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="form11">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">List of Personnel Involved<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="form11">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div>
                    </div>

                </div>


              </div>
            </div>
          </form>
            <!-- /.card -->
            <div class="card-footer">
                <button type="button" class="btn btn-primary btn-lg float-right" onclick="frmAddProj()">SAVE</button>
            </div>
        
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->


@endsection

@section('js')
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
{{-- <script src="{{ asset('tinymce/jquery.tinymce.min.js') }}"></script> --}}

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
  loadJSON("counterpart_agency","agency","{{ url('/library/agency') }}");
  loadJSON("program_title","program","{{ url('/library/program') }}");

  function addSite()
  {
    reg = idGen.getId();
    prov = idGen.getId();
    mun = idGen.getId();
    brgy = idGen.getId();
    $("#tbl_site").append("<tr><td>Philippines</td><td><select id='"+reg+"' name='region_id[]' class='form-control' onchange='regionSelect("+prov+","+mun+","+brgy+",this.value)'></select></td><td><select id='"+prov+"' class='form-control' onchange='provinceSelect("+mun+",this.value)' name='province_id[]'></select></td><td><select id='"+mun+"' class='form-control' onchange='municipalSelect("+brgy+",this.value)' name='municipal_id[]'></select></td><td><select id='"+brgy+"' class='form-control' name='brgy_id[]'></select></td><td><i class='fas fa-times-circle text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td></tr>");
    
    loadJSON(reg,"locregion","{{ url('/library/locregion') }}");
    loadJSON(prov,"locprovince","{{ url('/library/locprovince') }}/1");
    loadJSON(mun,"locmunicipal","{{ url('/library/locmunicipal') }}/1");
    loadJSON(brgy,"locbarangay","{{ url('/library/locbarangay') }}/1");
  }

  function getTotalMonths()
  {
    loadProjectMonths('{{url('/project/total-months/')}}');
  }

  function addPersonnel()
  {
    position = idGen.getId();
    percent = idGen.getId();
    responsibility = idGen.getId();

    $("#tbl_personnel").append("<tr><td><input type='text' class='form-control' id='"+position+"' name='personnel_position[]'></td><td><input type='text' class='form-control' id='"+percent+"'  name='personnel_percent[]'></td><td><input type='text' class='form-control' id='"+responsibility+"'  name='personnel_responsibility[]'></td><td><i class='fas fa-times-circle text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td></tr>");
  }

  function addPersonnelProject()
  {
    project = idGen.getId();
    funding = idGen.getId();
    involvement = idGen.getId();

    $("#tbl_involvement").append("<tr><td><input type='text' class='form-control' id='"+project+"' name='leader_project[]'></td><td><input type='text' class='form-control' id='"+funding+"'  name='leader_funding[]'></td><td><input type='text' class='form-control' id='"+involvement+"'  name='leader_involvement[]'></td><td><i class='fas fa-times-circle text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td></tr>");
  }

  function frmAddProj()
  {

    @foreach (getAllProjectSection([10,11,12,14,15,19,20,21,22,23,25,27,44,45,46,47,48,49,50,51,52,53,54]) as $item)
    comment = tinymce.get("{{$item->col}}").getContent();
    $("#{{$item->col}}_content").val(comment);
    @endforeach
    

    $("#frm2").submit()
  }


</script>
@endsection