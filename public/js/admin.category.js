$(document).ready(function(){
        getList();
    });


function getList()
    {

        $.getJSON( "http://localhost/pos/public/category/json/", function( datajson ) {
                
              }).done(function(datajson){

                    $('#table-category').DataTable({
                         dom: 'Bfrtip',
                         buttons: [
                                {
                                  extend: 'excelHtml5',
                                  text: 'Download to Excel',
                                  }    
                            ],
                         "data" : datajson,
                         columns : [
                          {"data" : "description"},
                          {
                            "data" : "total_list",
                            "className" : "text-center"
                          },
                          {
                            "data": function ( row, type, val, meta ) {
                                          return "<center><button class='btn btn-danger btn-sm' onclick='deleteCategory("+row.id+")'><i class='fa fa-trash'></i> Delete</button>&nbsp&nbsp<button class='btn btn-warning btn-sm' onclick='editCategory("+row.id+",\""+row.description+"\")'><i class='fa fa-edit'></i> Edit</button></center>"
                                        }
                          },
                         ]
                    });

              }).fail(function(datajson){
                    
              });
    }

    function deleteCategory(id)
    {
        $("#category_id").val(id);
        Swal.fire({
                    title: 'Delete Category?',
                    text: "All products under this category will have a blank value",
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

    function editCategory(id,desc)
    {
        $("#edit_category_id").val(id);
        $("#edit_category_desc").val(desc);
        $("#editModal").modal('toggle');
    }

    function addCategory()
    {
        $("#addModal").modal('toggle');
    }

