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
                    <a href="javascript:void(0)"  class="btn btn-primary" onclick="addRow()"><i class="fas fa-puls"></i> ADD </a>
                  </div>
  
                </div>
                 
                <!-- /.card-header -->
                <div class="card-body">
                  <center><h3><b>{{$data['budget_type']}}</b></h3></center>
                  <div class="table-responsive">
                  <form method="POST" id="frm" enctype="multipart/form-data" role="form">
                  {{-- <form method="POST" id="frm2" enctype="multipart/form-data" action="{{ url('/project/lib/create') }}"> --}}
                        @csrf
                        <input type="hidden" name="frm_url_action" id="frm_url_action" value="{{ url('/project/lib/create') }}">
                        <input type="hidden" name="frm_url_reset" id="frm_url_reset" value="{{ url('/project/lib/'.$data['project_id']) }}">
                        <input type="hidden" name="project_id" id="project_id" value="{{$data['project_id']}}">
                        <input type="hidden" name="budget_id" id="budget_id" value="{{$data['budget_id']}}">
                        <input type="hidden" name="budget_yr" id="budget_yr" value="{{$data['budget_yr']}}">
                        <input type="hidden" name="budget_code" id="budget_code" value="{{$data['budget_code']}}">

                  <table id="tbl" class="table table-bordered table-striped" style="width: 150%">
                    <thead>
                      <tr>
                        <th class="text-center" rowspan="2" valign='middle' style="width: 20%">Description</th>
                        <th class="text-center" colspan="12">YEAR : {{ $data['budget_yr'] }}<br/>MONTHS</th>
                        <th class="text-center" rowspan="2" style="width: 2%"></th>
                      </tr>
                      <tr>

                        <th class="text-center" style="width: 6%">JAN</th>
                        <th class="text-center" style="width: 6%">FEB</th>
                        <th class="text-center" style="width: 6%">MAR</th>
                        <th class="text-center" style="width: 6%">APR</th>
                        <th class="text-center" style="width: 6%">MAY</th>
                        <th class="text-center" style="width: 6%">JUN</th>
                        <th class="text-center" style="width: 6%">JUL</th>
                        <th class="text-center" style="width: 6%">AUG</th>
                        <th class="text-center" style="width: 6%">SEP</th>
                        <th class="text-center" style="width: 6%">OCT</th>
                        <th class="text-center" style="width: 6%">NOV</th>
                        <th class="text-center" style="width: 6%">DEC</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                        @foreach (getBudgetLIBExpenditure($data['project_id'],$data['budget_code']) as $item)
                            <tr class="row_{{$item->expenditure_id}}">
                              <td>
                                <input type="hidden" name="row_id[]" value="{{$item->expenditure_id}}">
                                <select class="form-control" name="expenditure_{{$item->expenditure_id}}[]" id="expenditure_{{$item->expenditure_id}}">
                                  @foreach (getAllotmentLib($data['budget_code']) as $val)
                                      @if($val->id == $item->expenditure_id)
                                        <option value="{{$val->id}}" selected>{{$val->object_expenditure}}</option>
                                      @else
                                        <option value="{{$val->id}}">{{$val->object_expenditure}}</option>
                                      @endif
                                  @endforeach
                                </select>
                              </td>
                              <td colspan="12"></td>
                              <td align="center"><i class='fas fa-plus text-primary' style='cursor:pointer' onclick='addRowNext({{$item->expenditure_id}})'></i>&nbsp<i class='fas fa-times-circle text-danger' style='cursor:pointer' onclick='removeRowLIB({{$item->expenditure_id}})'></i></td>
                            </tr>
                            @foreach (getBudgetLIBExpenditureSub($data['project_id'],$data['budget_id'],$item->expenditure_id) as $val)
                            <tr class='row_{{$item->expenditure_id}}' id='row_{{$item->expenditure_id}}'>
                                <td><input type='text' name='expenditure_sub_{{$item->expenditure_id}}[]' class='form-control' value="{{$val->expenditure_sub}}"></td>
                                <td><input type='number' class='form-control input-sm' name='lib_mon_jan_{{$item->expenditure_id}}[]' value="{{$val->jan}}"></td>
                                <td><input type='number' class='form-control input-sm' name='lib_mon_feb_{{$item->expenditure_id}}[]' value="{{$val->feb}}"></td>
                                <td><input type='number' class='form-control input-sm' name='lib_mon_mar_{{$item->expenditure_id}}[]' value="{{$val->mar}}"></td>
                                <td><input type='number' class='form-control input-sm' name='lib_mon_apr_{{$item->expenditure_id}}[]' value="{{$val->apr}}"></td>
                                <td><input type='number' class='form-control input-sm' name='lib_mon_may_{{$item->expenditure_id}}[]' value="{{$val->may}}"></td>
                                <td><input type='number' class='form-control input-sm' name='lib_mon_jun_{{$item->expenditure_id}}[]' value="{{$val->jun}}"></td>
                                <td><input type='number' class='form-control input-sm' name='lib_mon_jul_{{$item->expenditure_id}}[]' value="{{$val->jul}}"></td>
                                <td><input type='number' class='form-control input-sm' name='lib_mon_aug_{{$item->expenditure_id}}[]' value="{{$val->aug}}"></td>
                                <td><input type='number' class='form-control input-sm' name='lib_mon_sep_{{$item->expenditure_id}}[]' value="{{$val->sep}}"></td>
                                <td><input type='number' class='form-control input-sm' name='lib_mon_oct_{{$item->expenditure_id}}[]' value="{{$val->oct}}"></td>
                                <td><input type='number' class='form-control input-sm' name='lib_mon_nov_{{$item->expenditure_id}}[]' value="{{$val->nov}}"></td>
                                <td><input type='number' class='form-control input-sm' name='lib_mon_dec_{{$item->expenditure_id}}[]' value="{{$val->dec}}"></td>
                                <td align='center'>
                                  <i class='fas fa-times-circle text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td>
                              </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    
                  </table>
                  
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <span class="float-right"><button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> SAVE</button></span>
                  </form>
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

@endsection

@section('js')
<script>

function addRow()
{
  expenditure = idGen.getId();

  $("#tbl").append("<tr class='row_"+expenditure+"'><td><input type='hidden' name='row_id[]' value='"+expenditure+"'><select id='"+expenditure+"' name='expenditure_"+expenditure+"[]' class='form-control'></select></td><td colspan='12'></td><td align='center'><i class='fas fa-plus text-primary' style='cursor:pointer' onclick='addRowNext("+expenditure+")'></i>&nbsp<i class='fas fa-times-circle text-danger' style='cursor:pointer' onclick='removeRowLIB("+expenditure+")'></i></td></tr><tr class='row_"+expenditure+"' id='row_"+expenditure+"'><td><input type='text' name='expenditure_sub_"+expenditure+"[]' class='form-control'></td><td><input type='number' class='form-control input-sm' name='lib_mon_jan_"+expenditure+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_feb_"+expenditure+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_mar_"+expenditure+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_apr_"+expenditure+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_may_"+expenditure+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_jun_"+expenditure+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_jul_"+expenditure+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_aug_"+expenditure+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_sep_"+expenditure+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_oct_"+expenditure+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_nov_"+expenditure+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_dec_"+expenditure+"[]'></td><td align='center'></td></tr>");


  loadJSON(expenditure,"lib","{{ url('/library/lib/'.$data['budget_code']) }}");
}

function addRowNext(id)
{
  var specificRow = $('#row_'+id);

  specificRow.after("<tr class='row_"+id+"'><td><input type='text' name='expenditure_sub_"+id+"[]' class='form-control'></td><td><input type='number' class='form-control input-sm' name='lib_mon_jan_"+id+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_feb_"+id+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_mar_"+id+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_apr_"+id+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_may_"+id+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_jun_"+id+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_jul_"+id+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_aug_"+id+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_sep_"+id+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_oct_"+id+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_nov_"+id+"[]'></td><td><input type='number' class='form-control input-sm' name='lib_mon_dec_"+id+"[]'></td><td align='center'><i class='fas fa-times-circle text-danger' style='cursor:pointer' onclick='removeRow(this)'></i></td></tr>");

  specificRow.after(newRow);
}

</script>
@endsection