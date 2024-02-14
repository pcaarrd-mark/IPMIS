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
              <h1 class="m-0">{{$data['title']}}</h1>
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
                  <a class="nav-link active" id="aria-profile-tab" data-toggle="pill" href="#profile-tab" role="tab" aria-controls="aria-profile-tab" aria-selected="true">PROJECT PROFILE</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="project-site-tab" data-toggle="pill" href="#project-site" role="tab" aria-controls="project-site" aria-selected="true">SITE/S OF IMPLEMENTATION</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="project-summary-1-tab" data-toggle="pill" href="#project-summary-1" role="tab" aria-controls="project-summary-1" aria-selected="true">ITEM 6-12</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="project-summary-tab" data-toggle="pill" href="#project-summary-2" role="tab" aria-controls="project-summary-tab" aria-selected="true">ITEM 13-19</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="project-personnel-tab" data-toggle="pill" href="#project-personnel" role="tab" aria-controls="project-personnel-tab" aria-selected="true">PERSONNEL REQUIREMENTS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="project-other-handled-tab" data-toggle="pill" href="#project-other-handled" role="tab" aria-controls="project-other-handled-tab" aria-selected="true"><small>OTHER ONGOING PROJECTS BY THE PROJECT LEADER</small></a>
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
                                        <label for="coimplementing_agency"><h4>CO-IMPLEMENTING AGENCY</h4></label>
                                        <select class="form-control select2 select2bs4" id="coimplementing_agency" name="coimplementing_agency[]" multiple="multiple">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                  <div class="form-group">
                                      <label for="counterpart_agency"><h4>COUNTERPART</h4></label>
                                      <select class="form-control select2 select2bs4" id="counterpart_agency" name="counterpart_agency[]" multiple="multiple">
                                      </select>
                                  </div>
                              </div>
                                
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><h4>PROJECT DURATION</h4></label>
                                <div class="row">
                                  <div class="col-6">
                                    <label for="slct_mon_orig_start">Project Start Date</label>
                                    <select class="form-control slct_month" id="slct_mon_orig_start" name="slct_mon_orig_start">
                                      
                                    </select>
                                    <select class="form-control slct_year" id="slct_year_orig" name="slct_year_orig" style="margin-top:3%">
                                      
                                    </select>
                                  </div>
                                  <div class="col-6">
                                    <label for="slct_mon_orig_end">Project End Date</label>
                                    <select class="form-control slct_month" id="slct_mon_orig_end" name="slct_mon_orig_end">
                                      
                                    </select>
                                    <select class="form-control" id="slct_year_orig_end" name="slct_year_orig_end" style="margin-top:3%">
                                      
                                    </select>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                              <div class="col-4">
                                <label for="proj_type"><h4>TYPE OF RESEARCH</h4></label>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="project_type_of_research" id="type_of_research1" value="option1" checked>
                                    <label class="form-check-label" for="type_of_research1">
                                      Basic
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="project_type_of_research" id="type_of_research2" value="option2">
                                    <label class="form-check-label" for="type_of_research2">
                                      Applied
                                    </label>
                                  </div>                                
                              </div>
                              <div class="col-4">
                                <label for="proj_type"><h5>R&D PRIORITY AREA & PROGRAM (based on HNRDA 2017-2022)</h5></label>
                                <input type="text" class="form-control" name="project_commodity" placeholder="Commodity">
                              </div>
                              <div class="col-4">
                                <label for="proj_type"><h5>Sustainable Development Goal (SDG) Addressed</h5></label>
                                <input type="text" class="form-control" name="project_sdg" placeholder="">
                              </div>
                            </div>
                        </div>
                   </div>
                </div>

                <div class="tab-pane fade" id="project-site" role="tabpanel" aria-labelledby="project-site-tab">
                  <p align="right"><a href="javascript:void(0)" class="btn btn-info" onclick="addSite()">ADD</a></p>
                  <table class="table" id="tbl_site">
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

                <div class="tab-pane fade" id="project-summary-2" role="tabpanel" aria-labelledby="project-summary-2-tab">
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>POTENTIAL IMPACTS (2Is)</h4></label>
                                <input type="hidden" id="project_executive_content" name="project_executive_content">
                                <div class="otherinfo" id="project_executive" name="project_executive"></div>
                                {{-- <textarea class="form-control otherinfo" id="project_executive" name="project_executive"></textarea> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>TARGET BENEFICIARIES</h4></label>
                                <textarea class="form-control" id="project_rationale" name="project_rationale"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>SUSTAINABILITY PLAN (if applicable) </h4></label>
                                <textarea class="form-control" id="project_sci_basis" name="project_sci_basis"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>GENDER AND DEVELOPMENT (GAD) SCORE <small>(refer to the attached GAD checklist)</small></h4></label>
                                <textarea class="form-control" id="project_objective" name="project_objective"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>LIMITATIONS OF THE PROJECT</h4></label>
                                <textarea class="form-control" id="project_review" name="project_review"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>LIST OF RISKS AND ASSUMPTIONS RISK MANAGEMENT PLAN <small>(List possible risks and assumptions in attaining target outputs or objectives.)</small></h4></label>
                                <textarea class="form-control" id="project_methodology" name="project_methodology"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>TECHNOLOGY ROADMAP<small>(if applicable) (use the attached sheet)</small></h4></label>
                                <textarea class="form-control" id="project_roadmap" name="project_roadmap"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>LITERATURE CITED</h4></label>
                                <textarea class="form-control" id="project_output" name="project_output"></textarea>
                            </div>
                        </div>
                    </div>
                    
                </div>


                <div class="tab-pane fade" id="project-summary-1" role="tabpanel" aria-labelledby="project-summary-1-tab">
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>EXECUTIVE SUMMARY</h4></label>
                                <textarea class="form-control" id="project_executive" name="project_executive"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>RATIONALE/SIGNIFICANCE</h4></label>
                                <textarea class="form-control" id="project_rationale" name="project_rationale"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>SCIENTIFIC BASIS/THEORETICAL FRAMEWORK</h4></label>
                                <textarea class="form-control" id="project_sci_basis" name="project_sci_basis"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>OBJECTIVES</h4></label>
                                <textarea class="form-control" id="project_objective" name="project_objective"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>REVIEW OF LITERATURE</h4></label>
                                <textarea class="form-control" id="project_review" name="project_review"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>METHODOLOGY</h4></label>
                                <textarea class="form-control" id="project_methodology" name="project_methodology"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>TECHNOLOGY ROADMAP<small>(if applicable) (use the attached sheet)</small></h4></label>
                                <textarea class="form-control" id="project_roadmap" name="project_roadmap"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>EXPECTED OUTPUTS (6Ps)</small></h4></label>
                                <textarea class="form-control" id="project_output" name="project_output"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                              <div class="form-group">
                                <label for="exampleInputEmail1"><h4>POTENTIAL OUTCOMES</small></h4></label>
                                <textarea class="form-control" id="project_outcome" name="project_outcome"></textarea>
                            </div>
                        </div>
                    </div>
                    
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
                  <p align="right"><a href="javascript:void(0)" class="btn btn-info">ADD</a></p>
                  <table class="table">
                      <thead>
                        <th>#</th>
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
{{-- <script src="{{ asset('tinymce/jquery.tinymce.min.js') }}"></script> --}}

<script type="text/javascript">
    tinymce.init({
      selector: '.otherinfo'
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
    $("#tbl_site").append("<tr><td>Philippines</td><td><select id='"+reg+"' class='form-control' onchange='regionSelect("+prov+","+mun+","+brgy+",this.value)'></select></td><td><select id='"+prov+"' class='form-control' onchange='provinceSelect("+mun+",this.value)'></select></td><td><select id='"+mun+"' class='form-control' onchange='municipalSelect("+brgy+",this.value)'></select></td><td><select id='"+brgy+"' class='form-control'></select></td><td><i class='fas fa-times-circle text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td></tr>");
    
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

    $("#tbl_personnel").append("<tr><td><input type='text' class='form-control' id='"+position+"'></td><td><input type='text' class='form-control' id='"+percent+"'></td><td><input type='text' class='form-control' id='"+responsibility+"'></td><td><i class='fas fa-times-circle text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td></tr>");
  }


</script>
@endsection