@extends('admin.template.master')


@section('content')
<div class="block-header">
    <h2>Logs</h2>                
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card planned_task">
            <div class="body">
                    <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Logs</th>
                                        </tr>
                                    </thead>
                                    @foreach($log AS $logs)
                                        <tr>
                                            <td>{!! $logs['content'] !!}</td>
                                        </tr>
                                    @endforeach
                                </table>
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(function () {
    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        buttons: [
        {
            extend: 'excel',
            text: 'Download Excel',
            exportOptions: {
                modifier: {
                    page: 'current'
                }
            }
        }
    ]
    });
});
</script>
@endsection