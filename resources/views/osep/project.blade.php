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
              <h1 class="m-0">PROJECTS</h1>
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
                  <h3 class="card-title">LIST</h3>
  
                  <div class="card-tools">
                    {{-- <a href="{{ url('/osep/project/add') }}"  class="btn btn-primary"><i class="fas fa-puls"></i> ADD NEW PROJECT </a> --}}
                    <a href="javascript:void(0)"  class="btn btn-primary" onclick="showOption()"><i class="fas fa-puls"></i> ADD NEW PROJECT </a>
                  </div>
                </div>
                 
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="tbl" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th style="width: 40%">Project Title</th>
                      <th>Type</th>
                      <th>Cost</th>
                      <th>Duration</th>
                      <th>Status</th>
                      <th style="width: 15%"></th>
                    </tr>
                    </thead>
                    <tbody>
                   
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

<!-- Modal -->
<div class="modal fade" id="optionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select Proposal Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <fieldset class="form-group row">
          <div class="col-sm-10">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
              <label class="form-check-label" for="gridRadios1">
                DOST Form 2 Detailed Project Proposal (for Basic or Applied Research)
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
              <label class="form-check-label" for="gridRadios2">
                DOST Form 3 Non-R&D Proposal
              </label>
            </div>
            <div class="form-check disabled">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3">
              <label class="form-check-label" for="gridRadios3">
                DOST Form 2 Detailed Project Proposal (for Startups)
              </label>
            </div>
          </div>
        </fieldset>
        <fieldset class="form-group row">
            <span>Program Title</span>
            <select class="form-control" name="programid" id="programid">
              <option value="1" selected>N/A</option>
            @foreach (getProgram() as $item)
                <option value="{{$item->id}}">{{$item->title}}</option>
            @endforeach
            </select>
        </fieldset>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addNew()">Continue</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){

  // DataTable
  $('#tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ url("/osep/project/json") }}',
      columns: [
          { data: 'title' },
          { data: 'proposal_type' },
          { data: 'cost' },
          { data: 'duration'},
          { data: 'status'},
          { 
            "data": function ( row, type, val, meta ) {

                if(row.status == 'Pending')
                  return '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="{{ url('/project/edit/') }}/'+row.id+'">Edit</a><a class="dropdown-item" href="{{ url("/project/lib") }}/'+row.id+'">LIB</a><a class="dropdown-item" href="{{ url("/project/print") }}/'+row.id+'" target="_blank">Print</a><a class="dropdown-item" href="#" onclick="frmSubmitDelete('+row.id+')">Delete</a></div></center>';
                else
                  return '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="{{ url('/project/edit/') }}/'+row.id+'">Edit</a><a class="dropdown-item" href="{{ url("/project/lib") }}/'+row.id+'">LIB</a><a class="dropdown-item" href="{{ url("/project/print") }}/'+row.id+'" target="_blank">Print</a><a class="dropdown-item" href="#" onclick="frmSubmitDelete('+row.id+')">Delete</a></div></center>';

                // return '<center><div class="btn-group"><button type="button" class="btn btn-info">Action</button><button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu" role="menu"><a class="dropdown-item" href="{{ url("/project/print") }}/'+row.id+'" target="_blank">Print</a></div></center>';
            }
          
          },
      ]
  });

  $('#tbl').DataTable();
});

function showOption()
  {
    $("#optionModal").modal("toggle");
  }

function addNew()
  {
    alert();
    type = $('input[name=gridRadios]:checked').val();
    programid = $("#programid").val();
    window.location.replace("{{ url('/osep/project/add') }}/"+type+"/"+programid);
  }

</script>
@endsection