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
                  <h3 class="card-title">TOTAL LIB : <b>{{getProjCost($data['project_id']);}}</b></h3>
  
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
                                <td>{{ $item->year }}</td>
                                <td><a href="{{url('/project/add-lib/'.$data['project_id'].'/'.$item->id.'/PS')}}">{!! getBudget($data['project_id'],$item->id,'PS') !!}</a></td>
                                <td><a href="{{url('/project/add-lib/'.$data['project_id'].'/'.$item->id.'/MOOE')}}">{!! getBudget($data['project_id'],$item->id,'MOOE') !!}</a></td>
                                <td><a href="{{url('/project/add-lib/'.$data['project_id'].'/'.$item->id.'/CO')}}">{!! getBudget($data['project_id'],$item->id,'CO') !!}</a></td>
                           </tr>  
                        @endforeach
                    </tbody>
                    
                  </table>
                </div>
                <!-- /.card-body -->
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

</script>
@endsection