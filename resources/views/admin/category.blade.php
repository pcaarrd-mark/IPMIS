@extends('admin.template.master')


@section('content')
<div class="block-header">
    <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>Category</h2>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="p-2 d-flex">
                                <button class="btn btn-info btn-sm align-center" onclick="addCategory()">ADD NEW CATEGORY</button>
                            </div>
                        </div>
                    </div>
                </div>             
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card planned_task">
            <div class="body">
                    <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="table-category">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th style="width:20%">Items</th>
                                            <th style="width:20%"></th>
                                        </tr>
                                    </thead>
                                </table>
                    </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="smallModalLabel">EDIT CATERGORY</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="frm_update" action="{{ url('/category/update') }}">
                @csrf
                <input type="hidden" name="edit_category_id" id="edit_category_id" value="">
                <span>Description</span>
                <input type="text" class="form-control" name="edit_category_desc" id="edit_category_desc" placeholder="Description" autocomplete="off">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info" >SUBMIT</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="smallModalLabel">NEW CATERGORY</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="frm_create" action="{{ url('/category/create') }}">
                @csrf
                <span>Description</span>
                <input type="text" class="form-control" name="new_category_desc" id="new_category_desc" placeholder="" autocomplete="off">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">SUBMIT</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </form>
            </div>
        </div>
    </div>
</div>

<form method="POST" id="frm_delete" action="{{ url('/category/delete') }}">
    @csrf
    <input type="hidden" name="category_id" id="category_id" value="">
</form>

@endsection

@section('js')
<script src="{{ asset('js/admin.category.js') }}"></script>
@endsection