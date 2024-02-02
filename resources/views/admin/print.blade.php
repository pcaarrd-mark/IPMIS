@extends('admin.template.master')

@section('css')
<style type="text/css">
    .brk{
        border-bottom: 1px solid #EEE;
        padding: 5px;
    }
</style>
@endsection

@section('content')
<div class="block-header">
    <h2>Print Out</h2>                
</div>

<div class="row clearfix">
    <div class="col-lg-7 col-md-6 col-sm-12">
        <div class="card planned_task">
            <div class="body">
                <div class="row">
                    <div class="col-9 brk">
                        <div class="form-group">
                            <label>Type of printout</label>
                            <br>
                            <label class="fancy-radio custom-color-green"><input name="gender3" value="male" type="radio" checked><span><i></i>Reciept</span></label>
                            <label class="fancy-radio custom-color-green"><input name="gender3" value="female" type="radio"><span><i></i>Sales Invoice</span></label>
                        </div>   
                    </div>
                    <div class="col-3 brk">
                    </div>
                </div>
                <div class="row">
                    <div class="col-9 brk">
                         <div class="form-group">
                            <label>VAT TIN</label>
                            <input type="text" class="form-control" name="print_vat">
                        </div>
                    </div>
                    <div class="col-3 brk">
                        <br>
                        <br>
                        <label class="fancy-radio custom-color-green"><input name="gender3" value="male" type="radio" checked><span><i></i>Show</span></label>
                        <label class="fancy-radio custom-color-green"><input name="gender3" value="female" type="radio"><span><i></i>Hide</span></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-9 brk">
                         <div class="form-group">
                            <label>Telephone</label>
                            <input type="text" class="form-control" name="print_telno">
                        </div>
                    </div>
                    <div class="col-3 brk">
                        <br>
                        <br>
                        <label class="fancy-radio custom-color-green"><input name="gender3" value="male" type="radio" checked><span><i></i>Show</span></label>
                        <label class="fancy-radio custom-color-green"><input name="gender3" value="female" type="radio"><span><i></i>Hide</span></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-9 brk">
                         <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="print_add"></textarea>
                        </div>
                    </div>
                    <div class="col-3 brk">
                        <br>
                        <br>
                        <label class="fancy-radio custom-color-green"><input name="gender3" value="male" type="radio" checked><span><i></i>Show</span></label>
                        <label class="fancy-radio custom-color-green"><input name="gender3" value="female" type="radio"><span><i></i>Hide</span></label>
                    </div>
                </div>
                       
            </div>
        </div>
    </div>
    
</div>
@endsection