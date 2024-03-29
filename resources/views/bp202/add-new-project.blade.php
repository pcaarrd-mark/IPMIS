@extends('layouts.master')

@section('css')
  <!-- Select2 -->

@endsection

@section('content')
<form method="POST" id="frm" enctype="multipart/form-data" role="form">
  {{-- <form method="POST" id="frm2" enctype="multipart/form-data" action="{{ url('/project/create') }}"> --}}
    @csrf
    <input type="hidden" name="frm_url_action" id="frm_url_action" value="{{ url('/project/create') }}">
    <input type="hidden" name="frm_url_reset" id="frm_url_reset" value="{{ url('/project') }}">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Add New Proposal</h1>
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
                  <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Information</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Financial (in P'000) and Physical Details</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                  

                    <div class="row">
                        <div class="col-6">
                              <div class="form-group">
                                <label for="exampleInputEmail1">1.1 Program Title</label>
                                <textarea class="form-control" id="program_title" name="program_title"></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="exampleInputEmail1">1.2 Proposal / Project Name</label>
                                <textarea class="form-control" id="project_title" name="project_title"></textarea>
                            </div>
                            <br>
                            <div class="form-group">

                              <label for="exampleInputEmail1">Proposal Type</label>
                              <br>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="proposal_type" id="inlineRadio1" value="RD" checked>
                                <label class="form-check-label" for="inlineRadio1">R&D</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="proposal_type" id="inlineRadio2" value="NONRD">
                                <label class="form-check-label" for="inlineRadio2">NON R&D</label>
                              </div>

                          </div>

                            {{-- <div class="form-group">
                                <label for="exampleInputEmail1">Monitoring Division</label>
                                <select class="form-control select2 select2bs4" id="monitoring_division" name="monitoring_division">
                                </select>
                            </div>
                            <br>
                            <br> --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">2.1 Implementing Department / Agency</label>
                                <select class="form-control select2 select2bs4" id="implementing_agency" name="implementing_agency">
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                              <label for="exampleInputEmail1">2.2 Co-Implementing Department / Agency</label>
                              <select class="form-control select2 select2bs4" id="coimplementing_agency" name="coimplementing_agency[]" multiple="multiple">
                              </select>
                          </div>
                          <br>

                            <div class="form-group" style="display:none">
                                <label for="exampleInputEmail1">3. Priority Ranking No.:</label>
                                <input type="text" class="form-control w-50" id="project_ranking" name="project_ranking"/>
                            </div>
                            {{-- <br> --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">4. Categorization:</label>
                                {{-- <select class="form-control select2 select2bs4 w-50" id="categorization" name="categorization">
                                  <option value="New">New</option>
                                  <option value="Expanded/Revised">Expanded/Revised</option>
                                  <option value="Infrastructure">Infrastructure</option>
                                  <option value="Non-Infrastructure">Non-Infrastructure</option>
                                </select> --}}

                                <br>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="categorization[]" id="categorization1" value="New" checked>
                                  <label class="form-check-label" for="categorization1">New</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="categorization[]" id="categorization2" value="Expanded/Revised">
                                  <label class="form-check-label" for="categorization2">Expanded/Revised</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="categorization[]" id="categorization3" value="Infrastructure">
                                  <label class="form-check-label" for="categorization3">Infrastructure</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="categorization[]" id="categorization4" value="Non-Infrastructure">
                                  <label class="form-check-label" for="categorization4">Non-Infrastructure</label>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="exampleInputEmail1">5. PIP Code:</label>
                                <input type="text" class="form-control w-50" id="pip_code" name="pip_code"/>
                            </div>
                            <br>
                            <div class="form-group" style="display:none">
                                <label for="exampleInputEmail1">6. Total Proposal Cost:</label>
                                <input type="number" class="form-control w-50" id="project_cost" name="project_cost">
                            </div>
                            {{-- <br> --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">7. Description:</label>
                                <textarea class="form-control" id="project_desc" name="project_desc"></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="exampleInputEmail1">8. Purpose:</label>
                                <textarea class="form-control" id="project_purpose" name="project_purpose"></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="exampleInputEmail1">9. Beneficiaries:</label>
                                <textarea class="form-control" id="project_benificiaries" name="project_benificiaries"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">10. Implementation Period:</label>
                                <div class="row">
                                  <div class="col-6">
                                    <label for="exampleInputEmail1">Original</label>
                                    <br>
                                    <label for="exampleInputEmail1">Start Date</label>
                                    <select class="form-control slct_month" id="slct_mon_orig_start" name="slct_mon_orig_start">
                                      
                                    </select>
                                    <select class="form-control slct_year" id="slct_year_orig" name="slct_year_orig" style="margin-top:3%">
                                      
                                    </select>
                                  </div>
                                  <div class="col-6">
                                    <label for="exampleInputEmail1">&nbsp</label>
                                    <br>
                                    <label for="exampleInputEmail1">End Date</label>
                                    <select class="form-control slct_month" id="slct_mon_orig_end" name="slct_mon_orig_end">
                                      
                                    </select>
                                    <select class="form-control" id="slct_year_orig_end" name="slct_year_orig_end" style="margin-top:3%">
                                      
                                    </select>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col-6">
                                    <label for="exampleInputEmail1">Revised</label>
                                    <br>
                                    <label for="exampleInputEmail1">Start Date</label>
                                    <select class="form-control slct_month" id="slct_mon_rev_start" name="slct_mon_rev_start">
                                      
                                    </select>
                                    <select class="form-control slct_year"  name="slct_year_rev" id="slct_year_rev" style="margin-top:3%">
                                      
                                    </select>
                                  </div>
                                  <div class="col-6">
                                    <label for="exampleInputEmail1">&nbsp</label>
                                    <br>
                                    <label for="exampleInputEmail1">End Date</label>
                                    <select class="form-control slct_month" id="slct_mon_rev_end" name="slct_mon_rev_end">
                                      
                                    </select>
                                    <select class="form-control slct_year2" name="slct_year_rev_end" id="slct_year_rev_end" style="margin-top:3%">
                                      
                                    </select>
                                  </div>
                                </div>

                            </div>
                            <br>
                            <div class="form-group">
                                <label for="exampleInputEmail1">11. Pre-Requisites:</label>
                                <table class="table table-bordered">
                                  <tr>
                                    <td class="align-middle" style="width:30%" rowspan="2">Approving Authorities</td>
                                    <td class="align-middle" align="center" colspan="4">Reviewed/Approved</td>
                                  </tr>
                                  <tr>
                                    <td align="center">YES</td>
                                    <td align="center">NO</td>
                                    <td align="center">N/A</td>
                                    <td align="center">Remarks</td>
                                  </tr>

                                  @foreach (showAppAuth() as $item)
                                  <tr>
                                    <td>{{ $item->description }}</td>
                                    <td align="center">
                                      <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="{{ "appauth_".$item->id."_YES" }}" name="{{ "appauth_".$item->id }}" value="YES">
                                        <label for="{{ "appauth_".$item->id."_YES" }}" class="custom-control-label"></label>
                                      </div>
                                    </td>
                                    <td align="center">
                                      <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="{{ "appauth_".$item->id."_NO" }}" name="{{ "appauth_".$item->id }}" value="NO">
                                        <label for="{{ "appauth_".$item->id."_NO" }}" class="custom-control-label"></label>
                                      </div>
                                    </td>
                                    <td align="center">
                                      <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="{{ "appauth_".$item->id."_NA" }}" name="{{ "appauth_".$item->id }}" value="NA">
                                        <label for="{{ "appauth_".$item->id."_NA" }}" class="custom-control-label"></label>
                                      </div>
                                    </td>
                                    <td align="center">
                                      <input type="text" class="form-control" name="{{ "appauth_".$item->id."_remarks" }}">
                                    </td>
                                  </tr>
                                  @endforeach
                                  
                                  <tr>
                                    <td>Others (please specify)</td>
                                    <td align="center"></td>
                                    <td align="center"></td>
                                    <td align="center"></td>
                                    <td align="center"></td>
                                  </tr>
                                </table>
                            </div>
                        </div>
                   </div>
                   {{-- <hr>
                    <a href="#custom-tabs-two-profile" data-toggle="pill" class="btn btn-primary btn-lg float-right" role="tab" aria-controls="custom-tabs-two-profile">Next Page</a> --}}
                </div>
                <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                   <div class="row">
                      <div class="col-12">
                        <label for="exampleInputEmail1">12.1. PAP ATTRIBUTION BY EXPENSE CLASS</label>&nbsp;&nbsp;<a href="javascript:void(0);" class="btn-primary btn-sm" onclick="addnewrow('tbl_pap')"><i class="fas fa-plus"></i></a>
                                <table class="table table-bordered" id="tbl_pap">
                                  <tr>
                                    <td class="align-middle" align="center" style="width: 50%"><b>PAP<br>(A)</b>
                                      <select class="form-control select2 select2bs4 selectpap" id="pap_cat" name="project_pap_code">
                                      </select>
                                    </td>
                                    <td class="align-middle" align="center"><b>YR1 TIER2<br>(B)</b></td>
                                    <td class="align-middle" align="center"><b>YR2<br>(C)</b></td>
                                    <td class="align-middle" align="center"><b>YR3<br>(D)</b></td>
                                  </tr>
                                  
                                  
                                  {{-- <tr>
                                    <td class="align-middle" align="right"><b>GRANDTOTAL</b></td>
                                    <td class="align-middle" align="center"><b></b></td>
                                    <td class="align-middle" align="center"><b></b></td>
                                    <td class="align-middle" align="center"><b></b></td>
                                  </tr> --}}
                                </table>
                      </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                      <div class="col-12">
                        <label for="exampleInputEmail1">12.2. PHYSICAL ACCOMPLISHMENTS & TARGETS</label>&nbsp;&nbsp;<a href="javascript:void(0);" class="btn-primary btn-sm" onclick="addnewrow('tbl_accomp')"><i class="fas fa-plus"></i></a>
                          <table class="table table-bordered" id="tbl_accomp">
                            <tr>
                              <td class="align-middle" align="center" style="width:50%" rowspan="2"><b>Physical Accomplishments<br>(A)</b></td>
                              <td class="align-middle" align="center" colspan="3"><b>Targets</b></td>
                            </tr>
                            <tr>
                              <td class="align-middle" align="center"><b>YR1 TIER2<br>(B)</b></td>
                              <td class="align-middle" align="center"><b>YR2<br>(C)</b></td>
                              <td class="align-middle" align="center"><b>YR3<br>(D)</b></td>
                            </tr>
                          </table>
                      </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                      <div class="col-12">
                        <label for="exampleInputEmail1">12.3. TOTAL PROJECT COST</label>&nbsp;&nbsp;<a href="javascript:void(0);" class="btn-primary btn-sm" onclick="addnewrow('tbl_proj_cost')"><i class="fas fa-plus"></i></a>
                          <table class="table table-bordered" id="tbl_proj_cost">
                            <tr>
                              <td class="align-middle" align="center" style="width:50%"><b>Expense Class</b></td>
                              <td class="align-middle" align="center"><b>Total Project Cost</b></td>
                            </tr>
                            {{-- <tr>
                              <td class="align-middle" align="right"><b>GRANDTOTAL</b></td>
                              <td class="align-middle" align="right"><b></b></td>
                            </tr> --}}
                          </table>
                      </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                      <div class="col-12">
                        <label for="exampleInputEmail1">12.4. REQUIREMENTS FOR OPERATING COST OF INFRASTRUCTURE PROJECT</label>&nbsp;&nbsp;<a href="javascript:void(0);" class="btn-primary btn-sm" onclick="addnewrow('tbl_infra')"><i class="fas fa-plus"></i></a>
                        <table class="table table-bordered" id="tbl_infra">
                          <tr>
                            <td class="align-middle" align="center" style="width: 50%"><b>PAP<br>(A)</b>
                              <select class="form-control select2 select2bs4 selectpap" id="pap_cat_infra" name="project_pap_code_infra">
                              </select></td>
                            <td class="align-middle" align="center"><b>YR1<br>(B)</b></td>
                            <td class="align-middle" align="center"><b>YR2<br>(C)</b></td>
                            <td class="align-middle" align="center"><b>YR3<br>(D)</b></td>
                          </tr>
                          {{-- <tr>
                            <td class="align-middle" align="right"><b>GRANDTOTAL</b></td>
                            <td class="align-middle" align="center"><b></b></td>
                            <td class="align-middle" align="center"><b></b></td>
                            <td class="align-middle" align="center"><b></b></td>
                          </tr> --}}
                        </table>
                      </div>

                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">

                      <div class="col-12">
                        <label for="exampleInputEmail1">12.5. COSTING BY COMPONENT(S)</label>&nbsp;&nbsp;<a href="javascript:void(0);" class="btn-primary btn-sm" onclick="addnewrow('tbl_comp')"><i class="fas fa-plus"></i></a>
                        <table class="table table-bordered" id="tbl_comp">
                          <tr>
                            <td class="align-middle" align="center" style="width: 30%"><b>Components<br>(A)</b></td>
                            <td class="align-middle" align="center"><b>PS<br>(B)</b></td>
                            <td class="align-middle" align="center"><b>MOOE<br>(C)</b></td>
                            <td class="align-middle" align="center"><b>CO<br>(D)</b></td>
                            <td class="align-middle" align="center"><b>FINEX<br>(E)</b></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                      <div class="col-12">
                        <label for="exampleInputEmail1">12.6. LOCATION OF IMPLEMENTATION</label>&nbsp;&nbsp;<a href="javascript:void(0);" class="btn-primary btn-sm" onclick="addnewrow('tbl_loc')"><i class="fas fa-plus"></i></a>
                        <table class="table table-bordered" id="tbl_loc">
                          <tr>
                            <td class="align-middle" align="center" style="width: 30%"><b>Location<br>(A)</b></td>
                            <td class="align-middle" align="center"><b>PS<br>(B)</b></td>
                            <td class="align-middle" align="center"><b>MOOE<br>(C)</b></td>
                            <td class="align-middle" align="center"><b>CO<br>(D)</b></td>
                            <td class="align-middle" align="center"><b>FINEX<br>(E)</b></td>
                          </tr>
                          {{-- <tr>
                            <td class="align-middle" align="right"><b>GRANDTOTAL</b></td>
                            <td class="align-middle" align="center"><b></b></td>
                            <td class="align-middle" align="center"><b></b></td>
                            <td class="align-middle" align="center"><b></b></td>
                            <td class="align-middle" align="center"><b></b></td>
                          </tr> --}}
                        </table>
                      </div>
                    </div>
                    <hr>
                    <button type="button" class="btn btn-primary btn-lg float-right"  onclick="frmSubmit('frm','{{ url('/project/create') }}','{{ url('/project') }}')">Submit</button>
                    {{-- <button type="submit" class="btn btn-primary btn-lg float-right"  >Submit</button> --}}
                   </div>
                </div>
              </div>
            </div>
          </form>
            <!-- /.card -->
            <div class="card-footer">
              
            
            </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->


@endsection

@section('js')
<!-- Select2 -->

<script>
  $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  loadJSON("implementing_agency","agency","{{ url('/library/agency') }}");
  loadJSON("monitoring_division","division","{{ url('/library/division') }}");
  loadJSON("coimplementing_agency","agency","{{ url('/library/agency') }}");
  loadJSON("pap","allotment","{{ url('/library/allotment') }}");
  loadJSON("pap2","allotment","{{ url('/library/allotment') }}");
  loadJSON("exp","allotment","{{ url('/library/allotment') }}");
  loadJSON("pap_cat_infra","pap","{{ url('/library/pap') }}");
  loadJSON("pap_cat","pap","{{ url('/library/pap') }}");
  loadJSON("project_loc","region","{{ url('/library/region') }}");

  function addnewrow(tbl)
  {
    var uID = $.now();
    switch(tbl)
    {
      case "tbl_pap":
        var rows = '<tr><td class="align-middle" align="center"><select class="form-control select2 select2bs4 selectpap" id="'+uID+'" name="project_pap[]" onchange="getValue(this)"></select></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_pap_yr1[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_pap_yr2[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_pap_yr3[]"></td>';

          // var rows = '<tr><td class="align-middle" align="center"><input type="text" class="form-control" name="project_pap[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_pap_yr1[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_pap_yr2[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_pap_yr3[]"></td>';

        loadJSON(uID,'allotment',"{{ url('/library/allotment') }}");

      break;

      case "tbl_accomp":
        var rows = '<tr><td class="align-middle" align="center"><input type="text" class="form-control" name="project_accomp[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_accomp_yr1[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_accomp_yr2[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_accomp_yr3[]"></td>';
      break;

      case "tbl_proj_cost":
        var rows = '<tr><td class="align-middle" align="center" style="width:50%"><select class="form-control select2 select2bs4" id="'+uID+'" name="project_expense[]"></select></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_cost_amt[]"></td>';
        
        
        loadJSON(uID,'allotment',"{{ url('/library/allotment') }}");
      break;

      case "tbl_infra":
        var rows = '<tr><td class="align-middle" align="center"><select class="form-control select2 select2bs4" id="'+uID+'" name="project_infra[]"></select></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_infra_yr1[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_infra_yr2[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_infra_yr3[]"></td>';

          // var rows = '<tr><td class="align-middle" align="center"><input type="text" class="form-control" name="project_infra[]"></select></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_infra_yr1[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_infra_yr2[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_infra_yr3[]"></td>';

        loadJSON(uID,'allotment',"{{ url('/library/allotment') }}");
      break;

      case "tbl_comp":
          var rows = '<tr><td class="align-middle" align="center"><input type="text" class="form-control" name="project_comp[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_comp_ps[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_comp_mooe[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_comp_co[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_comp_finex[]"></td>';
      break;

      case "tbl_loc":
            var rows = '<tr><td align="center"><select class="form-control select2 select2bs4" id="'+uID+'" name="project_loc[]"></select></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_loc_ps[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_loc_mooe[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_loc_co[]"></td><td class="align-middle" align="center"><input type="number" class="form-control" name="project_loc_finex[]"></td></td>';

              loadJSON(uID,'region',"{{ url('/library/region') }}");
      break;
    }

    $("#"+tbl).append(rows + '<td class="align-middle" align="center"><a href="javascript:void(0);" onclick="removeRow(this)"><i class="fas fa-times-circle text-danger"></i></a></td></tr>');
  }

  function removeRow(tbl)
  {
    $(tbl).closest("tr").remove();
  } 
</script>
@endsection