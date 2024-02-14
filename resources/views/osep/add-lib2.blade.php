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
              <h1 class="m-0">PROJECT : {{$data['title']}}</h1>
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
                  <h3 class="card-title">Line Item Budget (LIB)</h3>
                  <div class="card-tools">
                    <a href="javascript:void(0)"  class="btn btn-primary" onclick="addBudget()"><i class="fas fa-puls"></i> ADD </a>
                  </div>
  
                </div>
                 
                <!-- /.card-header -->
                <div class="card-body">
                  <?php
                      // print_r(getLIB($data['project_id'],$data['budget_id'],$data['budget_code']));
                    ?>
                  <center><h3><b>{{$data['budget_type']}}</b></h3></center>
                  <div class="table-responsive">
                  {{-- <form method="POST" id="frm" enctype="multipart/form-data" role="form"> --}}
                  {{-- <form method="POST" id="frm2" enctype="multipart/form-data" action="{{ url('/project/lib/create') }}"> --}}
                        {{-- @csrf --}}
                        {{-- <input type="hidden" name="frm_url_action" id="frm_url_action" value="{{ url('/project/lib/create') }}">
                        <input type="hidden" name="frm_url_reset" id="frm_url_reset" value="{{ url('/project/lib/'.$data['project_id']) }}">
                        <input type="hidden" name="project_id" id="project_id" value="{{$data['project_id']}}">
                        <input type="hidden" name="lib_year_id" id="lib_year_id" value="{{$data['budget_id']}}">
                        
                        <input type="hidden" name="budget_code" id="budget_code" value="{{$data['budget_code']}}"> --}}

                  <table id="tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="text-center" valign='middle' style="width: 30%">DESCRIPTION</th>
                        <th class="text-center">AGENCY</th>
                        <th class="text-center">COST TYPE</th>
                        <th class="text-center">AMOUNT</th>
                        <th class="text-center"></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach (getLIB($data['project_id'],$data['budget_id'],$data['budget_code']) as $item)
                            <tr>
                              <td>{!!$item['expenditure']!!}</td>
                              <td>{{$item['agency']}}</td>
                              <td align="center">{{$item['cost_type']}}</td>
                              <td align="right">{{$item['total']}}</td>
                              <td align="center"><i class="fas fa-edit text-info" style="cursor: pointer"></i>&nbsp&nbsp<i class="fas fa-trash text-danger" style="cursor: pointer"></i></td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                  </table>
                  
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  {{-- <span class="float-right"><button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> SAVE</button></span>
                  </form> --}}
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

      <div class="modal fade" id="formBudget" tabindex="-1" aria-labelledby="formBudget" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="formBudget">ADD</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              {{-- <form method="POST" id="frm" enctype="multipart/form-data" role="form"> --}}
                <form method="POST" id="frm_budget" enctype="multipart/form-data" role="form" action="{{ url('/project/lib/create') }}">
                @csrf
                <input type="hidden" name="lib_year_id" id="lib_year_id" value="{{$data['budget_id']}}">
                <input type="hidden" name="project_id" id="project_id" value="{{$data['project_id']}}">
                <input type="hidden" name="budget_code" id="budget_code" value="{{$data['budget_code']}}">
                <fieldset class="form-group">
                  <span>Cost Type</span>
                  <select class="form-control" name="cost_type" id="cost_type">
                    <option value="Direct">Direct</option>
                    <option value="Indirect">Indirect</option>
                  </select>
              </fieldset>
              <fieldset class="form-group">
                  <span>Object of Expenditure</span>
                  <select class="form-control" name="object_expenditure" id="object_expenditure">
                  </select>
              </fieldset>
              <fieldset class="form-group">
                <span>Remarks</span>
                <input type="text" class="form-control" name="object_expenditure_remarks" id="object_expenditure_remarks">
              </fieldset>
              <fieldset class="form-group">
                <span>Agency</span>
                <select class="form-control" name="agency_id" id="agency_id">
                    <option value="1-Funding">PCAARRD</option>
                    @foreach(getAgencyProject($data['project_id']) as $item)
                        <option value="{{$item->agency_id.'-'.$item->agency_type}}">{{getLibraryDesc('agency',$item->agency_id,'acronym')}} ({{$item->agency_type}})</option>
                    @endforeach
                </select>
            </fieldset>
            @if($data['budget_code'] == 'PS')
            <div class="row">
              <div class="col-6">
                <fieldset class="form-group">
                  <span>Number of Items</span>
                  <input type="number" class="form-control" name="num_items" id="num_items">
                  </select>
                </fieldset>
              </div>
              <div class="col-6">
                <fieldset class="form-group">
                  <span>Amount</span>
                  <input type="number" class="form-control" name="amt" id="amt">
                  </select>
              </fieldset>
              </div>
            </div>
            
            
          <fieldset class="form-group">
            <span>Months</span>
              <div class="row">
                <div class="form-check col-2">
                  <input class="form-check-input" type="checkbox" value="" id="mon_1" name="mon[]" value="1">
                  <label class="form-check-label" for="mon_1">
                    Jan
                  </label>
                </div>
                <div class="form-check col-2">
                  <input class="form-check-input" type="checkbox" value="" id="mon_2" name="mon[]" value="2">
                  <label class="form-check-label" for="mon_2">
                    Feb
                  </label>
                </div>
                <div class="form-check col-2">
                  <input class="form-check-input" type="checkbox" value="" id="mon_1" name="mon[]" value="3">
                  <label class="form-check-label" for="mon_1">
                    Mar
                  </label>
                </div>
                <div class="form-check col-2">
                  <input class="form-check-input" type="checkbox" value="" id="mon_1" name="mon[]" value="4">
                  <label class="form-check-label" for="mon_1">
                    Apr
                  </label>
                </div>
                <div class="form-check col-2">
                  <input class="form-check-input" type="checkbox" value="" id="mon_1" name="mon[]" value="5">
                  <label class="form-check-label" for="mon_1">
                    May
                  </label>
                </div>
                <div class="form-check col-2">
                  <input class="form-check-input" type="checkbox" value="" id="mon_1" name="mon[]" value="6">
                  <label class="form-check-label" for="mon_1">
                    Jun
                  </label>
                </div>
              </div>

              <div class="row">
                <div class="form-check  col-2">
                  <input class="form-check-input" type="checkbox" value="" id="mon_1" name="mon[]" value="7">
                  <label class="form-check-label" for="mon_1">
                    Jul
                  </label>
                </div>
                <div class="form-check  col-2">
                  <input class="form-check-input" type="checkbox" value="" id="mon_1" name="mon[]" value="8">
                  <label class="form-check-label" for="mon_1">
                    Aug
                  </label>
                </div>
                <div class="form-check  col-2">
                  <input class="form-check-input" type="checkbox" value="" id="mon_1" name="mon[]" value="9">
                  <label class="form-check-label" for="mon_1">
                    Sep
                  </label>
                </div>
                <div class="form-check  col-2">
                  <input class="form-check-input" type="checkbox" value="" id="mon_1" name="mon[]" value="10">
                  <label class="form-check-label" for="mon_1">
                    Oct
                  </label>
                </div>
                <div class="form-check  col-2">
                  <input class="form-check-input" type="checkbox" value="" id="mon_1" id="mon[]" value="11">
                  <label class="form-check-label" for="mon_1">
                    Nov
                  </label>
                </div>
                <div class="form-check  col-2">
                  <input class="form-check-input" type="checkbox" value="" id="mon_1" name="mon[]" value="12">
                  <label class="form-check-label" for="mon_1">
                    Dec
                  </label>
                </div>
              </div>
              
        </fieldset>
          @else
          <fieldset class="form-group">
            
            <span class="text-bold">Months</span>
            <div class="row">
              <div class="col-4">
                  <label class="form-check-label" for="mon_1">
                  January
                  </label>
                <input class="form-control" type="number" value="" id="mon_1" name="mon[]" value="">
              </div>
              <div class="col-4">
                <label class="form-check-label" for="mon_2">
                Feburary
                </label>
                <input class="form-control" type="number" value="" id="mon_2" name="mon[]" value="">
              </div>
              <div class="col-4">
                <label class="form-check-label" for="mon_3">
                March
                </label>
                <input class="form-control" type="number" value="" id="mon_3" name="mon[]" value="">
              </div>
            </div>

            <div class="row">
              <div class="col-4">
                  <label class="form-check-label" for="mon_4">
                  April
                  </label>
                <input class="form-control" type="number" value="" id="mon_4" name="mon[]" value="">
              </div>
              <div class="col-4">
                <label class="form-check-label" for="mon_5">
                May
                </label>
                <input class="form-control" type="number" value="" id="mon_5" name="mon[]" value="">
              </div>
              <div class="col-4">
                <label class="form-check-label" for="mon_6">
                June
                </label>
                <input class="form-control" type="number" value="" id="mon_6" name="mon[]" value="">
              </div>
            </div>

            <div class="row">
              <div class="col-4">
                  <label class="form-check-label" for="mon_7">
                  July
                  </label>
                <input class="form-control" type="number" value="" id="mon_7" name="mon[]" value="">
              </div>
              <div class="col-4">
                <label class="form-check-label" for="mon_8">
                August
                </label>
                <input class="form-control" type="number" value="" id="mon_8" name="mon[]" value="">
              </div>
              <div class="col-4">
                <label class="form-check-label" for="mon_9">
                September
                </label>
                <input class="form-control" type="number" value="" id="mon_9" name="mon[]" value="">
              </div>
            </div>

            <div class="row">
              <div class="col-4">
                  <label class="form-check-label" for="mon_10">
                  October
                  </label>
                <input class="form-control" type="number" value="" id="mon_10" name="mon[]" value="">
              </div>
              <div class="col-4">
                <label class="form-check-label" for="mon_11">
                November
                </label>
                <input class="form-control" type="number" value="" id="mon_11" name="mon[]" value="">
              </div>
              <div class="col-4">
                <label class="form-check-label" for="mon_12">
                December
                </label>
                <input class="form-control" type="number" value="" id="mon_12" name="mon[]" value="">
              </div>
            </div>

        </fieldset>
          @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              {{-- <button type="button" class="btn btn-primary" onclick="sendFrm()">Add</button> --}}
              <button type="submit" class="btn btn-primary">Add</button>
            </form>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('js')
<script>
loadJSON('object_expenditure',"lib","{{ url('/library/lib/'.$data['budget_code']) }}");
function addBudget()
{
  $("#formBudget").modal("toggle");
}

function sendFrm()
{
  frmSubmit('frm','{{ url('/project/lib/create') }}','{{ url('/project/lib/'.$data['project_id']) }}')
}

</script>
@endsection