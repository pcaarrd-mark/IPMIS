@extends('admin.template.master')


@section('content')
<div class="block-header">
    <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>Inventory</h2>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="p-2 d-flex">
                                <button class="btn btn-info btn-sm align-center" onclick="addNewProduct()">ADD PRODUCT</button>
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
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="table-list">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Barcode</th>
                                            <th>Category</th>
                                            <th>Purchase Price</th>
                                            <th>Sale Price</th>
                                            <th>Stocks</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                    </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="smallModalLabel">NEW PRODUCT</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="frm_create" class="frms" action="{{ url('/product/create') }}">
                @csrf
                <input type="hidden" name="edit_user_id" id="edit_user_id" value="">
                <span class="text-success">Product Description</span>
                <input type="text" class="form-control" name="new_product" id="new_product" autocomplete="off" required>
                <br>
                <span class="text-success">Barcode</span>
                <input type="text" class="form-control" name="new_barcode" id="new_barcode" autocomplete="off" required>
                <br>
                <span class="text-success">Category</span>
                <select class="form-control" name="new_category">
                   @foreach($category AS $categories)
                        <option value="{{ $categories->id }}">{{ $categories->description }}</option>
                    @endforeach 
                </select>
                <br>
                <span class="text-success">Purchase Price</span>
                <input type="number" class="form-control" name="new_pur_price" id="new_pur_price" autocomplete="off">
                <br>
                <span class="text-success">Sale Price</span>
                <input type="number" class="form-control" name="new_sale_price" id="new_sale_price" autocomplete="off">
                <br>
                <span class="text-success">Initial Stock</span>
                <input type="number" class="form-control" name="new_initial_stocks" id="new_initial_stocks" autocomplete="off">
                <br>
            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">SUBMIT</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </form>    
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="smallModalLabel">EDIT PRODUCT</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="frm_update" class="frms" action="{{ url('/product/update') }}">
                @csrf
                <input type="hidden" name="edit_product_id" id="edit_product_id" value="">
                <span class="text-success">Product Description</span>
                <input type="text" class="form-control" name="edit_product" id="edit_product" autocomplete="off" required>
                <br>
                <span class="text-success">Barcode</span>
                <input type="text" class="form-control" name="edit_barcode" id="edit_barcode" autocomplete="off" required>
                <br>
                <span class="text-success">Category</span>
                <select class="form-control" name="edit_category" id="edit_category">
                   @foreach($category AS $categories)
                        <option value="{{ $categories->id }}">{{ $categories->description }}</option>
                    @endforeach 
                </select>
                <br>
                <span class="text-success">Purchase Price</span>
                <input type="number" class="form-control" name="edit_pur_price" id="edit_pur_price" autocomplete="off">
                <br>
                <span class="text-success">Sale Price</span>
                <input type="number" class="form-control" name="edit_sale_price" id="edit_sale_price" autocomplete="off">
                <br>
            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">SUBMIT</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </form>    
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="smallModalLabel">UPDATE INVENTORY</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="frm_inventory" class="frms" action="{{ url('/inventory/create') }}">
                @csrf
                <input type="hidden" name="inv_product_id" id="inv_product_id">
                <span class="text-success">Transaction Type</span>
                <select class="form-control" name="inv_type" id="inv_type" required>
                    <option value="increase">Increase</option>
                    <option value="decrease">Decrease</option>
                </select>
                <br>
                <span class="text-success">Quantity</span>
                <input type="number" class="form-control" name="inv_quantity" id="inv_quantity" autocomplete="off" required>
                <br>
                <span class="text-success">Remarks</span>
                <textarea class="form-control" name="inv_remarks" id="inv_remarks"></textarea>
                <br>
            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">SUBMIT</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </form>    
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="historyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="smallModalLabel">INVENTORY HISTORY</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="history-list" style="width:100%">
                    <thead>
                        <tr>
                            <th>Transaction</th>
                            <th>Quantity</th>
                            <th>Stock before</th>
                            <th>Stock after</th>
                            <th>Remarks</th>
                            <th>User</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">SUBMIT</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </form>    
            </div>
        </div>
    </div>
</div>

<form method="POST" id="frm_delete" action="{{ url('/product/delete') }}">
    @csrf
    <input type="hidden" name="del_product_id" id="del_product_id" value="">
</form>
@endsection

@section('js')
<script type="text/javascript">

$(document).ready(function() {
  inventoryList();
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

function addNewProduct()
{
    $("#newModal").modal("toggle");
}


function editProduct(id)
    {
        $("#editModal").modal('toggle');
        $("#edit_product_id").val(id);

         $.getJSON( "http://localhost/pos/public/inventory/json/"+id, function( datajson ) {
                
              }).done(function(datajson){
                    $("#edit_product").val(datajson['product_desc']);
                    $("#edit_barcode").val(datajson['product_barcode']);
                    $("#edit_category").val(datajson['category_id']);
                    $("#edit_pur_price").val(datajson['purc_price']);
                    $("#edit_sale_price").val(datajson['product_amt']);

              }).fail(function(datajson){
              });
    }

function inventoryList()
    {
        $('#table-list').DataTable().clear().destroy();

         $.getJSON( "http://localhost/pos/public/inventory/json/", function( datajson ) {
                
              }).done(function(datajson){

                    $('#table-list').DataTable({
                        dom: 'Bfrtip',
                         buttons: [
                                {
                                  extend: 'excelHtml5',
                                  text: 'Download to Excel',
                                  }    
                            ],
                         "data" : datajson,
                         columns : [
                          {
                            "data" : "product_desc"
                          },
                          {
                            "data" : "product_barcode"
                          },
                          {
                            "data" : "cat_desc"
                          },
                          {
                            "data" : "purc_price",
                            "render" : $.fn.dataTable.render.number( ',', '.', 2 ),
                            "className" : "text-right"
                          },
                          {
                            "data" : "product_amt",
                            "render" : $.fn.dataTable.render.number( ',', '.', 2 ),
                            "className" : "text-right"
                          },
                          {
                            "data" : "stocks"
                          },
                          {
                            "data": function ( row, type, val, meta ) {
                                          return "<div class='btn-group' role='group'><button id='btnGroupDrop1' type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action</button><div class='dropdown-menu' aria-labelledby='btnGroupDrop1'><a class='dropdown-item' href='javascript:void(0);' onclick='deleteProduct("+row.id+")'><i class='fa fa-trash'></i> Delete</a><a class='dropdown-item' href='javascript:void(0);' onclick='editProduct("+row.id+")'><i class='fa fa-edit'></i> Edit</a><a class='dropdown-item' href='javascript:void(0);' onclick='updateInventory("+row.id+")'><i class='fa fa-pencil'></i> Update Inventory</a><a class='dropdown-item' href='javascript:void(0);' onclick='inventoryHistory("+row.id+")'><i class='fa fa-history'></i> Inventory History</a></div></div>"
                                        }
                          }
                         ]
                    });

              }).fail(function(datajson){
                    
              });
    }

function deleteProduct(id)
    {
        $("#del_product_id").val(id);
        Swal.fire({
                    title: 'Delete product?',
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

function updateInventory(id)
    {
        $("#inv_product_id").val(id);
        $("#inventoryModal").modal("toggle");
    }

function inventoryHistory(id)
    {

        $('#history-list').DataTable().clear().destroy();

         $.getJSON( "http://localhost/pos/public/history-inventory/json/"+id, function( datajson ) {
                
              }).done(function(datajson){

                    $('#history-list').DataTable({
                        dom: 'Bfrtip',
                         buttons: [
                                {
                                  extend: 'excelHtml5',
                                  text: 'Download to Excel',
                                  }    
                            ],
                         "data" : datajson,
                         columns : [
                          {
                            "data" : "trans_type"
                          },
                          {
                            "data" : "quantity"
                          },
                          {
                            "data" : "stocks_before"
                          },
                          {
                            "data" : "stocks_after"
                          },
                          {
                            "data" : "remarks"
                          },
                          {
                            "data" : "user"
                          },
                          {
                            "data" : "date_string"
                          }
                         ]
                    });

              }).fail(function(datajson){
                    
              });
        $("#historyModal").modal("toggle");
    }
</script>
@endsection