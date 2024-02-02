@extends('admin.template.master')


@section('content')
<div class="block-header">
    <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-danger">
                        <h1>ERROR</h1>
                    </div>         
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card planned_task">
            <div class="body">
                   <h2>{!! $message !!}</h2>                 
            </div>
        </div>
    </div>
</div>
@endsection