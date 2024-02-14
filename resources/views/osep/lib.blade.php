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
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-12">
  
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title">PROJECT TITLE : <b>{{$data['title']}}</b></h5><br>
                  <br>
                  @if(Auth::user()->id == $data['created_by'])
                  <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        EDIT
                      </button>
                      <div class="dropdown-menu">
                        @foreach(getAgencyProject($data['project_id']) as $item)
                            <a class="dropdown-item" href="{{url('/project/lib-edit/'.$data['project_id'].'/'.$item->agency_id)}}" target="_blank">{{getLibraryDesc('agency',$item->agency_id,'acronym')}} ({{$item->agency_type}})</a>
                        @endforeach
                      </div>
                    </div>
                  </div>
                  @endif

                  <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        PRINT
                      </button>
                      <div class="dropdown-menu">
                        {{-- <a class="dropdown-item" href="#" onclick="printLIB()" target="_blank">ALL</a> --}}
                        <a class="dropdown-item" href="#" onclick="printLIB(0)" target="_blank">SUMMARY</a>
                        @foreach(getProjectYear($data['project_id']) as $item)
                            <a class="dropdown-item" href="#" onclick="printLIB({{$item->budget_yr}})" target="_blank">YEAR {{$item->budget_yr}}</a>
                        @endforeach
                      </div>
                    </div>
                  </div>

                  <div class="card-tools">
                    
                    

                    
                  </div>
  
                </div>
                
                 
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="tbl" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">Year #</th>
                        <th class="text-center" style="width: 25%">PS</th>
                        <th class="text-center" style="width: 25%">MOOE</th>
                        <th class="text-center" style="width: 25%">EO/CO</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['budgetlist'] as $item)
                           <tr>
                                <td align="center">{{ $item->year }}</td>
                                <td align="right"><code class="text-md">{{ number_format(getLIBDetails('specific',$data['project_id'],$item->year,'ps'),2) }}</code></td>
                                <td align="right"><code class="text-md">{{ number_format(getLIBDetails('specific',$data['project_id'],$item->year,'mooe'),2) }}</code></td>
                                <td align="right"><code class="text-md">{{ number_format(getLIBDetails('specific',$data['project_id'],$item->year,'eo'),2) }}</code></td>
                           </tr>  
                        @endforeach
                    </tbody>
                    
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-right">
                  <div class="row">
                    <div class="col-3"></div>
                    <div class="col-3"></div>
                    <div class="col-3">TOTAL BUDGET PROPOSAL : </div>
                    <div class="col-3"><b><code class="text-lg">{{ number_format(getLIBDetails('budget',$data['project_id']),2) }}</code></b></div>
                  </div>
                  <div class="row">
                    <div class="col-3"></div>
                    <div class="col-3"></div>
                    <div class="col-3">TOTAL COUNTERPART FUND: </div>
                    <div class="col-3"><b><code class="text-lg">{{ number_format(getLIBDetails('counterpart',$data['project_id']),2) }}</code></b></div>
                  </div>
                  <div class="row">
                    <div class="col-3"></div>
                    <div class="col-3"></div>
                    <div class="col-3"><h5>TOTAL PROJECT COST : <h5></div>
                    <div class="col-3"><h5><b><code class="text-lg">{{ number_format(getLIBDetails('total',$data['project_id']),2) }}</code></b></h5></div>
                  </div>
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
      <form method="POST" id="frm_budget" enctype="multipart/form-data" role="form" action="{{ url('/project/lib/print') }}" target="_blank">
        @csrf
        <input type="hidden" name="project_id" id="project_id" value="{{$data['project_id']}}">
        <input type="hidden" name="project_year" id="project_year" value="">
      </form>

      <form method="POST" id="frm_lib" enctype="multipart/form-data" role="form" action="{{ url('/project/lib-edit') }}" target="_blank">
        @csrf
        <input type="hidden" name="lib_project_id" id="lib_project_id" value="">
      </form>
@endsection

@section('js')
<script>
  function printLIB(yr)
  {
    $("#project_year").val(yr);
    $('#frm_budget').submit();
  }

  function editLIB(id)
  {
    $("#lib_project_id").val(id);
    $('#frm_lib').submit();
  }
</script>
@endsection