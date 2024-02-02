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
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">PRIORITIZATION</h3>

                <div class="card-tools">
                  {{-- <a href="{{ url('/project/new') }}"  class="btn btn-primary"><i class="fas fa-puls"></i> ADD NEW PROPOSAL </a> --}}
                </div>
              </div>
               
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tbl" class="table">
                    <thead>
                        <th># Priority</th>
                        <th>Project Title</th>
                        <th>Total Budget 2024</th>
                        <th>Duration</th>
                        <th>Division</th>
                        <th></th>
                    </thead>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
              </form>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="modal-ranking">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">SET PRIORITY RANKING</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" id="_ranking" enctype="multipart/form-data" role="form" action="{{ url('/bp202/set-priority') }}">
              @csrf
              <input type="hidden" name="project_id" id="project_id">
  
              <div class="form-group">
                <label for="exampleInputEmail1">Ranking</label>
                <select class="form-control" name="project_ranking" id="project_ranking">
                    <option value="0" disabled selected>--Select Ranking--</option>
                    <option value="x">Remove Ranking</option>
                    @foreach (getRankingCount() as $key => $item)
                        <option value="{{ ($key + 1) }}">{{ ($key + 1) }}</option>
                    @endforeach
                </select>
              </div>
          
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
@endsection

@section('js')
<script>
      $(document).ready(function(){

        // DataTable
        $('#tbl').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("/project/jsonranking") }}',
            columns: [
                { data: 'project_ranking' },
                { data: 'project_title' },
                { data: 'project_cost' },
                { data: 'project_dur_orig'},
                { data: 'division'},
                { 
                "data": function ( row, type, val, meta ) {
                    return '<center><button class="btn btn-primary btn-sm" onclick="setRanking('+row.id+','+row.project_ranking+')">Set Priority Ranking</small></center>';
                }
                
                },
            ]
        });

});

function setRanking(id,ranking)
{
    $("#project_id").val(id);
    $("#project_ranking").val(ranking);
    $("#modal-ranking").modal('toggle');
}

$("#project_ranking").change(function(){
    var ranks = [
                        @foreach (getRankingExist() as $key => $item)
                            {{ $item->project_ranking }},
                        @endforeach
                    ];
    var rank = this.value;
    $.each(ranks,function(key, value){
            console.log(value + " == " + rank);
            if(value ==  rank)
            {
                Swal.fire(
                    'Rank '+rank+' already taken!',
                    '',
                    'info'
                    );
                $("#project_ranking").val(0);
            }
                
    });
})
</script>
@endsection