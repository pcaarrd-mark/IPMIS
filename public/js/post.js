function frmSubmit()
{
  $("#frm").submit();
}

$("#frm").submit(function(e) {
        e.preventDefault();    
                var formData = new FormData(this);
                Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            type: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok'
                            }).then((result) => {
                            if (result.value) {
                                    $.ajax({
                                        url: $("#frm_url_action").val(),
                                        type: 'POST',
                                        beforeSend: function (xhr) {
                                            $("#overlay").show();
                                            var token = $('meta[name="csrf_token"]').attr('content');
        
                                            if (token) {
                                                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                                            }
                                        },
                                        data: formData,
                                        success:function(data){
                                            $("#overlay").hide();
                                            Swal.fire({
                                                    title: 'Success!',
                                                    text: "",
                                                    type: 'success',
                                                    confirmButtonText: 'Ok'
                                                        }).then((result) => {
                                                        if (result.value) {
                                                            window.location.href= $("#frm_url_reset").val();
                                                        }
                                                        })
        
                                        },error:function(){ 
                                            $("#overlay").hide();
                                            Swal.fire({
                                                        title: 'Ooppsss!',
                                                        text: "Something went wrong..Page will now reload",
                                                        type: 'error',
                                                        confirmButtonText: 'Ok'
                                                        }).then((result) => {
                                                            if (result.value) {
                                                            location.reload();
                                                            }
                                                        })
                                        },
                                        cache: false,
                                        contentType: false,
                                        processData: false
                                    });
        
                                    return false;
                            }
                            })
        
        });

function loadJSON(slct,typ,url,def_val = null)
{
$.ajax({
    url: url,
    dataType: 'json',
    async: true,
    data: typ,
    success: function(datajson) {
        jQuery.each(datajson,function(i,obj){
            var sl = '';
            switch(typ)
            {
                case 'pap':
                    var id = obj.pap_code;
                    var val = obj.pap;
                break;

                case 'expense':
                    var id = obj.expense_account_code;
                    var val = obj.expense_account;
                break;

                case 'allotment':
                    var id = obj.id;
                    var val = obj.allotment_class_acronym;
                break;

                case 'region':
                    var id = obj.id;
                    var val = obj.desc;
                break;

                default:
                    var id = obj.id;
                    var val = obj.acronym;
                break;
            }

            //CONVERT STRING TO ARRAY
            if(def_val != null)
                {
                    if(def_val == "[]")
                    {
                        

                        $("#"+slct).append("<option value='"+id+"' "+sl+">"+val+"</option>");
                    }
                    else
                    {
                        parsedID = JSON.parse(def_val);

                        $.each(parsedID, function( index, value ) {
                            if(value == id)
                                var sl = 'selected';
                            else
                                var sl = '';

                            $("#"+slct).append("<option value='"+id+"' "+sl+">"+val+"</option>");
                        });
                        }
                    
                }
                else
                {
                    $("#"+slct).append("<option value='"+id+"' "+sl+">"+val+"</option>");
                }
            
        });
    }
  });

}

$(document).ready(function(){
    $(".slct_month").append('<option value=""></option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option>');

    //CURRENT YEAR
    yr = new Date().getFullYear();
    yr++;
    $(".slct_year").append('<option value=""></option>');
    for(x = yr;x <= (yr + 5);x++)
    {
        $(".slct_year").append('<option value="'+x+'">'+x+'</option>');
    }

    $(".slct_year").change(function(){
        yr_2 = Number(this.value);
        $("#"+this.id+"_end").empty();
        // for(x2 = (yr_2 + 1);x2 <= (yr_2 + 5);x2++)
        for(x2 = yr_2;x2 <= (yr_2 + 5);x2++)
        {
            $("#"+this.id+"_end").append('<option value="'+x2+'">'+x2+'</option>');
        }
        
    })

})