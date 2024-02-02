@extends('admin.template.master')


@section('content')
<div class="block-header">
    <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>Users</h2>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="p-2 d-flex">
                                <button class="btn btn-info btn-sm align-center" onclick="newUser()">ADD USER</button>
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
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th style="width:15%">Username</th>
                                            <th>Fullname</th>
                                            <th style="width:15%">User Type</th>
                                            <th style="width:15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user AS $users)
                                            <tr>
                                                <td>{{ $users->username }}</td>
                                                <td>{{ $users->name }}</td>
                                                <td>{{ $users->usertype }}</td>
                                                <td>
                                                    <center><button class='btn btn-danger btn-sm' onclick='deleteUser({{ $users->id }})'><i class='fa fa-trash'></i> Delete</button>&nbsp&nbsp<button class='btn btn-warning btn-sm' onclick='editUser({{ $users->id }})'><i class='fa fa-edit'></i> Edit</button>
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                    </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="smallModalLabel">EDIT USER</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="frm_update" action="{{ url('/user/update') }}">
                @csrf
                <input type="hidden" name="edit_user_id" id="edit_user_id" value="">
                <span class="text-success">Username</span>
                <input type="text" class="form-control" name="edit_username" id="edit_username" autocomplete="off" required>
                <br>
                <span class="text-success">Fullname</span>
                <input type="text" class="form-control" name="edit_fullname" id="edit_fullname" autocomplete="off" required>
                <br>
                <span class="text-success">Usertype</span>
                <br>
                <label class="fancy-radio">
                    <input type="radio" name="edit_usertype" id="usertype_admin" value="Admin" required data-parsley-errors-container="#error-radio">
                    <span><i></i>Admin</span>
                </label>
                <label class="fancy-radio">
                    <input type="radio" name="edit_usertype" id="usertype_counter" value="Counter" checked>
                    <span><i></i>Counter</span>
                </label>
                <hr>
                <span class="text-success">Password<br><span class="text-danger">*<small>Leave blank if no changes needed</small></span></span>
                <input type="password" class="form-control" name="edit_password" id="edit_password" autocomplete="off">
                <br>
                <span>Confirm Password</span>
                <input type="password" class="form-control" name="edit_password2" id="edit_password2" autocomplete="off">
            </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" onclick="submitEditUser()">SUBMIT</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="newModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="smallModalLabel">NEW USER</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="frm_create" action="{{ url('/user/create') }}">
                @csrf
                <input type="hidden" name="edit_user_id" id="edit_user_id" value="">
                <span class="text-success">Username</span>
                <input type="text" class="form-control" name="new_username" id="new_username" autocomplete="off" required>
                <br>
                <span class="text-success">Fullname</span>
                <input type="text" class="form-control" name="new_fullname" id="new_fullname" autocomplete="off" required>
                <br>
                <span class="text-success">Usertype</span>
                <br>
                <label class="fancy-radio">
                    <input type="radio" name="new_usertype" id="new_usertype_admin" value="Admin" required data-parsley-errors-container="#error-radio">
                    <span><i></i>Admin</span>
                </label>
                <label class="fancy-radio">
                    <input type="radio" name="new_usertype" id="new_usertype_counter" value="Counter" checked>
                    <span><i></i>Counter</span>
                </label>
                <hr>
                <input type="password" class="form-control" name="new_password" id="new_password" autocomplete="off">
                <br>
                <span>Confirm Password</span>
                <input type="password" class="form-control" name="new_password2" id="new_password2" autocomplete="off">
            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">SUBMIT</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </form>    
            </div>
        </div>
    </div>
</div>
<form method="POST" id="frm_delete" action="{{ url('/user/delete') }}">
    @csrf
    <input type="hidden" name="user_id" id="user_id" value="">
</form>
@endsection

@section('js')
<script src="{{ asset('js/admin.users.js') }}"></script>
@endsection