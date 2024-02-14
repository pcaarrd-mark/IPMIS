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
            <div class="col-10">
              <h1 class="m-0">{!!$data['title']!!}</h1>
            </div><!-- /.col -->
            <div class="col-2">
              <button type="button" class="btn btn-primary btn-lg float-right" onclick="frmAddProj()">SAVE</button>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-2">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <button class="nav-link active" id="v-pills-home-tab" data-toggle="pill" data-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">PROJECT PROFILE</button>
              <button class="nav-link" id="v-pills-profile-tab" data-toggle="pill" data-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">SITE/S OF IMPLEMENTATION</button>
              <button class="nav-link" id="v-pills-messages-tab" data-toggle="pill" data-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">SUMMARY</button>
              <button class="nav-link" id="v-pills-settings-tab" data-toggle="pill" data-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">PERSONNEL REQUIREMENTS</button>
              <button class="nav-link" id="v-pills-settings-tab" data-toggle="pill" data-target="#v-pills-others" type="button" role="tab" aria-controls="v-pills-others" aria-selected="false">OTHER ONGOING PROJECTS BY THE PROJECT LEADER</button>
              <button class="nav-link" id="v-pills-settings-tab" data-toggle="pill" data-target="#v-pills-forms" type="button" role="tab" aria-controls="v-pills-forms" aria-selected="false">DOST FORMS</button>
              <button class="nav-link" id="v-pills-settings-tab" data-toggle="pill" data-target="#v-pills-files" type="button" role="tab" aria-controls="v-pills-files" aria-selected="false">SUPPLEMENTARY FILES</button>
            </div>
          </div>
          <div class="col-10">
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show active alert bg-light border" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <div class="row">
                  <div class="col-12">
                      <div class="form-group">
                        <label for="exampleInputEmail1"><b>PROGRAM TITLE</b></label>
                        <textarea class="form-control" readonly>{{getProgramDetails($data['program_id'],'title')}}</textarea>
                        {{-- <select class="form-control select2 select2bs4" id="program_title" name="program_title">
                          <option value="N/A">N/A</option>
                        </select> --}}
                    </div>
                </div>
                  <div class="col-12">
                        <div class="form-group">
                          <label for="title"><b>PROJECT TITLE</b></label>
                          <textarea class="form-control" id="title" name="title"></textarea>
                      </div>
                  </div>

                  <div class="col-8">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><b>PROJECT DURATION (Number of Months : <span id="totalmonths"></span>)</b></label>
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

                  <div class="col-12">
                    <div class="row">
                          <div class="col-12">
                              
                            <label for="implementing_agency"><b>IMPLEMENTING  AGENCY</b></label>
                              <table id="implementing_agency_tbl_1" class="table table-bordered bg-light">
                                <thead>
                                  <th style="width: 40%"><center>Agency</center></th>
                                  <th><center>Address</center></th>
                                  <th style="width: 15%"><center>Contact #</center></th>
                                  <th style="width: 15%"><center>Email</center></th>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                        <select class="form-control select2 select2bs4" id="implementing_agency_1" name="implementing_agency" onchange="getAgencyInfo('imp',this.value,1)">
                                          <option selected disabled>--Select--</option>
                                        </select>
                                    </td>
                                    <td><span id="imp_agency_address_1"></span></td>
                                    <td><span id="imp_agency_contact_1"></span></td>
                                    <td><span id="imp_agency_email_1"></span></td>
                                  </tr>
                                </tbody>
                              </table>
                          </div>

                          {{-- <div class="col-4">
                            <div class="form-group">
                                <label for="counterpart_agency"><b>COUNTERPART</b></label>
                                <select class="form-control select2 select2bs4" id="counterpart_agency" name="counterpart_agency[]" multiple="multiple">
                                </select>
                            </div>
                        </div> --}}
                          
                      </div>
                  </div>

                  <div class="col-12">
                    <div class="row">
                          <div class="col-12">
                              
                            <label for="coimplementing_agency"><b>COIMPLEMENTING AGENCY <button type="button" class="btn btn-success btn-xs" onclick="addCoImp()"><i class="fas fa-plus fa-xs"></i> add</button></b></label>
                              <table id="coimplementing_agency_tbl" class="table table-bordered bg-light">
                                <thead>
                                  <th style="width: 40%"><center>Agency</center></th>
                                  <th><center>Address</center></th>
                                  <th style="width: 15%"><center>Contact #</center></th>
                                  <th style="width: 15%"><center>Email</center></th>
                                  <th style="width: 5%"></th>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                              </table>
                          </div>

                          {{-- <div class="col-4">
                            <div class="form-group">
                                <label for="counterpart_agency"><b>COUNTERPART</b></label>
                                <select class="form-control select2 select2bs4" id="counterpart_agency" name="counterpart_agency[]" multiple="multiple">
                                </select>
                            </div>
                        </div> --}}
                          
                      </div>
                  </div>
                  
                  <div class="col-12">
                      <div class="row">
                        <div class="col-4">
                          <label for="proj_type"><b>TYPE OF RESEARCH</b></label>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="project_type_of_research" id="type_of_research1" value="Basic" checked>
                              <label class="form-check-label" for="type_of_research1">
                                Basic
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="project_type_of_research" id="type_of_researcb" value="Applied">
                              <label class="form-check-label" for="type_of_researcb">
                                Applied
                              </label>
                            </div>                                
                        </div>
                        <div class="col-4">
                          <label for="proj_type"><b>R&D PRIORITY AREA & PROGRAM (based on HNRDA 2017-2022)</b></label>
                          {{-- <input type="text" class="form-control" name="project_commodity" placeholder="Commodity"> --}}
                          <select class="form-control select2 select2bs4" id="project_commodity" name="project_commodity[]"  multiple="multiple">
                            
                          </select>
                        </div>
                        <div class="col-4">
                          <label for="proj_type"><b>Sustainable Development Goal (SDG) Addressed</b></label>
                          {{-- <input type="text" class="form-control" name="project_sdg" placeholder=""> --}}
                          <select class="form-control select2 select2bs4" id="project_sdg" name="project_sdg[]"  multiple="multiple">
                            
                          </select>
                        </div>
                      </div>
                  </div>
             </div>
              </div>
              <div class="tab-pane fade alert bg-light border" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <p align="right"><a href="javascript:void(0)" class="btn btn-info" onclick="addSite()">ADD</a></p>
                  <table class="table table-bordered bg-white" id="tbl_site">
                      <thead>
                        <th>Country</th>
                        <th>Region</th>
                        <th>Province</th>
                        <th>Municipality</th>
                        <th>Baranggay</th>
                        <th></th>
                      </thead>
                      <tbody></tbody>
                  </table>
                
              </div>
              <div class="tab-pane fade alert bg-light border" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                @foreach (getAllProjectSection([11,12,13,14,16,17,18,19,20,21,23,24,25,26,28,29]) as $item)
                <div class="row">
                  <div class="col-12">
                        <div class="form-group">
                          <label for="exampleInputEmail1"><b>{!! $item->description !!}</b></label>
                          <input type="hidden" id="{{$item->col}}_content" name="{{$item->col}}_content">
                          <div class="otherinfo" id="{{$item->col}}" name="{{$item->col}}"></div>
                      </div>
                  </div>
              </div>
              @endforeach
              </div>
              <div class="tab-pane fade alert bg-light border" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                <p align="right"><a href="javascript:void(0)" class="btn btn-info" onclick="addPersonnel()">ADD</a></p>
                  <table class="table table-bordered bg-white" id="tbl_personnel">
                      <thead>
                        <th>Position</th>
                        <th>Percent Time Devoted to the Project</th>
                        <th>Responsibilities</th>
                        <th></th>
                      </thead>
                      <tbody></tbody>
                  </table>
              </div>

              <div class="tab-pane fade alert bg-light border" id="v-pills-others" role="tabpanel" aria-labelledby="v-pills-others-tab">
                <p align="right"><a href="javascript:void(0)" class="btn btn-info" onclick="addPersonnelProject()">ADD</a></p>
                  <table class="table table-bordered bg-white" id="tbl_involvement">
                      <thead>
                        <th>Title of the Project</th>
                        <th>Funding Agency</th>
                        <th>Involvement in the Project</th>
                        <th></th>
                      </thead>
                  </table>
              </div>

              <div class="tab-pane fade alert bg-light border" id="v-pills-forms" role="tabpanel" aria-labelledby="v-pills-forms-tab">
                <h5 class="alert alert-warning text-center">Kindly press the save button to activate editing for DOST forms.</h5>
              </div>

              <div class="tab-pane fade alert bg-light border" id="v-pills-files" role="tabpanel" aria-labelledby="v-pills-files-tab">
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
                  <label for="exampleInputFile">GAD Score Sheet<span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="exampleInputFile" name="form4">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                  </div>
                </div>
              </div>

            </div>
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
      plugins: 'lists table',
      toolbar: 'numlist bullist table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol'
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
      theme: 'bootstrap4',
    });

  function getAgencyInfo(info,id,x)
  {
    loadAgencyAdd(info,'{{url('/library/agencyinfo/')}}/'+id,x);
  }

  function getTotalMonths()
  {
    loadProjectMonths('{{url('/project/total-months/')}}');
  }

  function addCoImp()
  {
    coimpid = idGen.getId();
    $("#coimplementing_agency_tbl").append('<tr><td><select class="form-control select2 select2bs4" id="coimplementing_agency_'+coimpid+'" name="coimplementing_agency[]" onchange="getAgencyInfo(\'coimp\',this.value,'+coimpid+')"><option selected disabled>--Select--</option></select></td><td><span id="coimp_agency_address_'+coimpid+'"></span></td><td><span id="coimp_agency_contact_'+coimpid+'"></span></td><td><span id="coimp_agency_email_'+coimpid+'"></span></td><td align="center" valign="middle"><i class="fas fa-times-circle text-danger" style="cursor:pointer" onclick="removeRow(this)"></i></td></tr>');

    loadJSON("coimplementing_agency_"+coimpid,"agency","{{ url('/library/agency') }}");
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

  }

  loadJSON("implementing_agency_1","agency","{{ url('/library/agency') }}");
  loadJSON("monitoring_division_1","division","{{ url('/library/division') }}");
  loadJSON("coimplementing_agency_1","agency","{{ url('/library/agency') }}");
  loadJSON("counterpart_agency_1","agency","{{ url('/library/agency') }}");
  loadJSON("program_title","program","{{ url('/library/program') }}");
  loadJSON("project_commodity","hnrda","{{ url('/library/hnrda') }}");
  loadJSON("project_sdg","sdga","{{ url('/library/sdga') }}");

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

    @foreach (getAllProjectSection([11,12,13,14,16,17,18,19,20,21,23,24,25,26,28,29]) as $item)
    comment = tinymce.get("{{$item->col}}").getContent();
    $("#{{$item->col}}_content").val(comment);
    @endforeach
    

    $("#frm2").submit()
  }


</script>
@endsection