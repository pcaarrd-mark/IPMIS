 $(document).ready(function(){
        getList();
        $(".filter_group").hide();
        $("#filter_date").show();

        // Date picker
        var d = new Date();
           var currMonth = d.getMonth();
           var currYear = d.getFullYear();
           var startDate = new Date(currYear, currMonth, 1);

        $('.inline-datepicker').datepicker({
            todayHighlight: true
        });


    });

    function getList()
    {
        //FILTER
        var filter = $("#filter").val();
        var dt = $("#dt").val();
        var mon = $("#mon").val();
        var yr = $("#yr").val();
        var yr2 = $("#yr2").val();
        var dur1 = $("#dur1").val();
        var dur2 = $("#dur2").val();



        $.getJSON( "http://localhost/pos/public/sales/json/"+filter+"/"+dt+"/"+mon+"/"+yr+"/"+yr2+"/"+dur1+"/"+dur2, function( datajson ) {
                
              }).done(function(datajson){

                    $('#table-sales').DataTable({
                         dom: 'Bfrtip',
                         buttons: [
                                {
                                  extend: 'excelHtml5',
                                  text: 'Download to Excel',
                                  }    
                            ],
                         "data" : datajson,
                         columns : [
                          {"data" : "transaction_id"},
                          {
                            "data" : "date_string",
                            // "render" : $.fn.dataTable.render.moment( 'HH:mm MMM D, YY') 
                          },
                          {"data" : "transaction_by"},
                          {
                            "data" : "total_amount",
                            "render" : $.fn.dataTable.render.number( ',', '.', 2 ),
                            "className" : "text-right"
                          },
                          {
                            "data" : "total_profit",
                            "render" : $.fn.dataTable.render.number( ',', '.', 2 ),
                            "className" : "text-right"
                          },
                          {
                            "data": function ( row, type, val, meta ) {
                                          return "<center><button class='btn btn-danger btn-sm' onclick='deleteTransaction("+row.transaction_id+")'><i class='fa fa-trash'></i> Delete</button>&nbsp&nbsp<button class='btn btn-warning btn-sm' onclick='deleteTransactionList("+row.transaction_id+")'><i class='fa fa-list'></i> List</button></center>"
                                        }
                          },
                         ]
                    });

                    //TOTAL SALES
                    var total_sales = 0;
                    jQuery.each(datajson,function(i,obj){
                         total_sales += obj.total_amount;
                    });

                    //TOTAL PROFIT
                    var total_profit = 0;
                    jQuery.each(datajson,function(i,obj){
                         total_profit += obj.total_profit;
                    });

                    $("#total_sales").text(formatCash(total_sales));
                    $("#total_profit").text(formatCash(total_profit));

              }).fail(function(datajson){
                    
              });
    }

    function formatCash(val)
    {
        var formatter = new Intl.NumberFormat('en-US', {
              style: 'currency',
              currency: 'PHP',
            });
        var cash = formatter.format(val);
        return cash.substring(1);
    }

    function filterDate()
    {
        $("#filterModal").modal('toggle');
    }

    $("#select_type").change(function(){
        $(".filter_group").hide();

        switch(this.value)
        {
            case "1":
                $("#filter_date").show();
            break;
            case "2":
                $("#filter_month").show();
            break;
            case "3":
                $("#filter_year").show();
            break;
            case "4":
                $("#filter_duration").show();
            break;
        }
    });


    function deleteTransaction(id)
    {
        $("#transaction_id").val(id);
        Swal.fire({
                    title: 'Delete transaction?',
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

    function deleteTransactionList(id)
    {
        $("#transaction_id_list").text(id);
        $("#listModal").modal('toggle');

        $('#table-list').DataTable().clear().destroy();

         $.getJSON( "http://localhost/pos/public/sales/list/json/"+id, function( datajson ) {
                
              }).done(function(datajson){

                    $('#table-list').DataTable({
                         "data" : datajson,
                         columns : [
                          {
                            "data" : "product_desc"

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
                            "data" : "quantity",
                            "className" : "text-center"
                          },
                          {
                            "data": function ( row, type, val, meta ) {
                                          return "<center><button class='btn btn-danger btn-sm' onclick='deleteList("+row.id+")'><i class='fa fa-trash'></i></button></center>"
                                        }
                          },
                         ]
                    });

              }).fail(function(datajson){
                    
              });
    }

    function deleteList(id)
    {
        $("#transaction_list_id").val(id);
        Swal.fire({
                    title: 'Delete transaction?',
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
