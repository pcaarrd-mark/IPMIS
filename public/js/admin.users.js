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

function newUser()
    {
        $("#newModal").modal('toggle');
    }


function deleteUser(id)
    {
        $("#user_id").val(id);
        Swal.fire({
                    title: 'Delete User?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $("#frm_delete").submit();
                    }
                })
    }

function editUser(id)
    {
        $.getJSON( "http://localhost/pos/public/user/json/"+id, function( datajson ) {
                
              }).done(function(datajson){

                    $("#edit_username").val(datajson['username']);
                    $("#edit_fullname").val(datajson['name']);
                    $("#edit_password,#edit_password2").val('');
                    
                    if(datajson['usertype'] == 'Admin')
                        $("#usertype_admin").prop("checked", true);
                    else
                        $("#usertype_counter").prop("checked", true);

              }).fail(function(datajson){
                    
              });

        $("#edit_user_id").val(id);
        $("#editModal").modal('toggle');
    }


function submitEditUser()
    {
        if($("#edit_password").val() != null)
            {
                if($("#edit_password").val() != $("#edit_password2").val())
                {
                    Swal.fire("Error!", "Password does not match!", "error");
                }
                else
                {
                    $("#frm_update").submit();
                }
                
            }
            else
            {
                $("#frm_update").submit();
            }
    }
