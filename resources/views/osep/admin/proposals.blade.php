@extends('layouts.master')
@section('css')
   <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> 
  <style>

  </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">PROPOSALS</h1>
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
                    <button class="btn btn-primary" onclick="frmSubmit('frm_batch','{{ url('osep/project/batch-send-to-dpmis') }}','{{ url('osep/proposals') }}')">Send to DPMIS</button>
                  </div>
                </div>
                 
                <!-- /.card-header -->
                <div class="card-body">
                
                  <div class="icheck-primary">
                    <input type="checkbox" id="checkAll" />
                    <label for="checkAll">SELECT ALL CLEARED PROPOSAL</label>
                </div>
                <form method="POST" id="frm_batch" enctype="multipart/form-data">
                  @csrf
                  <table id="tbl" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th></th>
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
                </form>
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
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Approve Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="frm_assign_div" enctype="multipart/form-data" role="form">
        {{-- <form method="POST" id="frm2" enctype="multipart/form-data" action="{{ url('/osep/project/add-division') }}"> --}}
            @csrf
            {{-- <input type="hidden" name="frm_url_action" id="frm_url_action" value="{{ url('osep/project/add-division') }}"> --}}
            {{-- <input type="hidden" name="frm_url_reset" id="frm_url_reset" value="{{ url('/osep/proposals') }}"> --}}
            <input type="hidden" name="project_id" id="project_id" value="">
        <fieldset class="form-group row">
          <div class="col-sm-12">
            <h5>Lead Monitoring Division</h5>
          </div>
          <div class="col-sm-12">
            <select class="form-control" name="lead_division">
            @foreach(getDivision() AS $list)
              <option value="{{$list->division_id}}">{{$list->acronym}}</option>
            @endforeach
            </select>
          </div>

          <br>
          <br>

          <div class="col-sm-12">
            <h5>Assign Monitoring Division</h5>
          </div>

          <div class="col-sm-12">
            @foreach(getDivision() AS $list)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="division[]" id="gridRadios_{{$list->division_id}}" value="{{$list->division_id}}">
                <label class="form-check-label" for="gridRadios_{{$list->division_id}}">
                  {{$list->acronym}}
                </label>
              </div>
            @endforeach
          </div>

        </fieldset>
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="frmSubmit('frm_assign_div','{{ url('/osep/project/add-division') }}','{{ url('osep/proposals') }}');">Continue</button>
      
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="sendDPMISModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">SEND TO DPMIS?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{-- <form method="POST" id="frm" enctype="multipart/form-data" role="form"> --}}
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="updateStatusAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">UPDATE STATUS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{-- <form method="POST" id="frm_update" enctype="multipart/form-data" role="form" action="{{url('/osep/admin-update-status')}}"> --}}
        <form method="POST" id="frm_update" enctype="multipart/form-data" role="form">
          @csrf
          <input type="hidden" name="update_project_id" id="update_project_id" value="">

          <div class="form-check">
            <input class="form-check-input" type="radio" name="statusAdmin" id="flexRadioDefault1" value="11">
            <label class="form-check-label" for="flexRadioDefault1">
              Schedule for DC
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="statusAdmin" id="flexRadioDefault2" value="12">
            <label class="form-check-label" for="flexRadioDefault2">
              DC Approved
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="statusAdmin" id="flexRadioDefault2" value="16">
            <label class="form-check-label text-danger" for="flexRadioDefault2">
              DC Disapproved
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="statusAdmin" id="flexRadioDefault1" value="13">
            <label class="form-check-label" for="flexRadioDefault1">
              Schedule for GC
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="statusAdmin" id="flexRadioDefault2"  value="14">
            <label class="form-check-label" for="flexRadioDefault2">
              GC Approved
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="statusAdmin" id="flexRadioDefault2" value="16">
            <label class="form-check-label text-danger" for="flexRadioDefault2">
              GC Disapproved
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="statusAdmin" id="flexRadioDefault2" value="15">
            <label class="form-check-label text-success" for="flexRadioDefault2">
              Proposal Approved
            </label>
          </div>

          <div class="row mt-2" id="updateDate" style="display: none">
            <div class="col-12">
              <input type="date" name="updateDate" class="form-control" value="{{date('Y-m-d')}}">
            </div>
          </div>

          <div class="row mt-2" id="updateRemarks" style="display: none">
            <div class="col-12">
              <textarea class="form-control" name="updateRemarks" placeholder="Remarks"></textarea>
            </div>
          </div>
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateStatusAdminSend()">Send</button>
      </div>
    </div>
  </div>
</div>

<form method="POST" id="frm_single" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="project_id" id="dpmis_project_id" value="">
</form>
@endsection

@section('js')
<script>
$(document).ready(function(){
   // Check or uncheck all checkboxes based on the "checkAll" checkbox
   $("#checkAll").change(function() {
    $(".checkbox").prop('checked', $(this).prop("checked"));
  });
  
  // Update the "checkAll" checkbox when individual checkboxes are clicked
  $(".checkbox").change(function() {
    if ($(".checkbox:checked").length == $(".checkbox").length) {
      $("#checkAll").prop("checked", true);
    } else {
      $("#checkAll").prop("checked", false);
    }
  });

  $("input[name='statusAdmin']").click(function(){
   $("#updateRemarks,#updateDate").hide();
            switch(this.value)
            {
              case "11":
              case "13":
                  $("#updateDate").show();
                break;
              case "12":
              case "14":
              case "16":
              case "17":
              case "15":
                  $("#updateRemarks").show();
                break;
            }
        });

  // DataTable
  $('#tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ url("/osep/proposal/json") }}',
      
      columns: [
          {
            data: 'id',
            orderable: false,
            render: function(data, type, row) {
              // Render checkbox column
              if(row.status == 'Pending')
                return '<input type="checkbox" class="checkbox" disabled style="display:none">';
              else if(row.status == 'Cleared by ISP Manager')
                return '<input type="checkbox" value="'+row.id+'" class="checkbox" name="checkproposal[]">';
              else
                return "";
                
            },
            checkbox: true // Enable checkboxes
          },
          { data: 'title' },
          { data: 'proposal_type' },
          { data: 'cost' },
          { data: 'duration'},
          { data: 'status'},
          { data: 'button'},
      ]
  });

  $('#tbl').DataTable();
});

function showOption()
  {
    $("#optionModal").modal("toggle");
  }

function approve(id)
  {
    $("#project_id").val(id);
    $("#approveModal").modal("toggle");
  }

  function singleSendDPMIS(id)
  {
    $("#dpmis_project_id").val(id);
    frmSubmit('frm_single','{{ url('osep/project/single-send-to-dpmis') }}','{{ url('osep/proposals') }}');
  }

  function updateStatusAdmin(id)
  {
    $("#update_project_id").val(id);
    $("#updateStatusAdmin").modal("toggle");
  }

  function updateStatusAdminSend()
  {
    // $("#frm_update").submit();
    frmSubmit('frm_update','{{ url('/osep/admin-update-status') }}','{{ url('osep/proposals') }}');
  }
</script>
@endsection