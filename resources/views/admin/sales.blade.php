@extends('admin.template.master')


@section('content')
<div class="block-header">
    <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>Sales</h2>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="p-2 d-flex">
                                <button class="btn btn-info btn-sm align-center" onclick="filterDate()">FILTER DATE</button>
                            </div>
                        </div>
                    </div>
                </div>             
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card planned_task">
            <div class="body">
                <div class="row">
                    <div class="col-12">
                        <h3>SALES : <b><span id="total_sales" class="text-success"></span></b></h3>
                        <h3>PROFIT : <b><span id="total_profit" class="text-success"></span></b></h3>

                        @if(isset($data['filter_text']))
                        <h5><span class="badge btn-warning">Filter : {{ $data['filter_text'] }}</span></h5>
                        @endif
                    </div>
                </div>
                <hr>
                    <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="table-sales">
                                    <thead>
                                        <tr>
                                            <th>Transaction No.</th>
                                            <th>Date</th>
                                            <th>User</th>
                                            <th>Total Amount</th>
                                            <th>Total Profit</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                    </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filterModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="smallModalLabel">FILTER</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="frm" action="{{ url('/admin/sales') }}">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <span>Filter Type:</span>
                        <select class="form-control" name="select_type" id="select_type">
                                    <option value="1">Date</option>
                                    <option value="2">Monthly</option>
                                    <option value="3">Yearly</option>
                                    <option value="4">Duration</option>
                        </select>
                    </div>
                </div>

                <div class="row filter_group" id="filter_date" style="margin-top: 2.5%;">
                    <div class="col-6">
                        <span>Select Date:</span>
                        <input data-provide="datepicker" name="filter_date_dt" id="filter_date_dt" data-date-autoclose="true" class="form-control" value="{{ date('m/d/Y') }}">
                    </div>
                </div>

                <div class="row filter_group" id="filter_month" style="margin-top: 2.5%;">
                    <div class="col-6">
                        <span>Select Month:</span>
                        <select class="form-control" name="filter_month_mon" id="filter_month_mon">
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <span>Select Year:</span>
                        <select class="form-control" name="filter_month_year" id="filter_month_year">
                            <?php
                                $date_now = date('Y');
                                for($i = $date_now;$i >= ($date_now - 5);$i--)
                                {
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                            ?>
                        </select>
                    </div>

                </div>

                <div class="row filter_group" id="filter_year" style="margin-top: 2.5%;">
                    <div class="col-6">
                        <span>Select Year:</span>
                        <select class="form-control" name="filter_year_yr" id="filter_year_yr">
                            <?php
                                $date_now = date('Y');
                                for($i = $date_now;$i >= ($date_now - 5);$i--)
                                {
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                            ?>
                        </select>
                    </div>

                </div>

                <div class="row filter_group" id="filter_duration" style="margin-top: 2.5%;">
                    <div class="input-daterange input-group" data-provide="datepicker">
                    <div class="col-6">
                        <span>Select Date From:</span>
                        <input type="text" class="input-sm form-control" name="start"  value="{{ date('m/d/Y') }}">
                    </div>
                    <div class="col-6">
                        <span>Select Date To:</span>
                        <input type="text" class="input-sm form-control" name="end"  value="{{ date('m/d/Y') }}">
                    </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info" >SUBMIT</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="listModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="smallModalLabel">TRANSACTION LIST</h4>
            </div>
            <div class="modal-body">
                <h3>Transaction No : <span id="transaction_id_list"></span></h3>
                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="table-list" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th style="width:20%">Purchase Price</th>
                                            <th style="width:20%">Sale Price</th>
                                            <th style="width:20%">Qty</th>
                                            <th style="width:20%"></th>
                                        </tr>
                                    </thead>
                                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </form>
            </div>
        </div>
    </div>
</div>


<form method="POST" id="frm_delete" action="{{ url('/admin/sales/delete') }}">
    @csrf
    <input type="hidden" name="transaction_id" id="transaction_id" value="">

    <input type="hidden" name="transaction_list_id" id="transaction_list_id" value="">

    <input type="hidden" name="filter" id="filter" value="{{ $data['filter'] }}">
    <input type="hidden" name="dt" id="dt" value="{{ date('Y-m-d',strtotime($data['dt'])) }}">
    <input type="hidden" name="mon" id="mon" value="{{ $data['mon'] }}">
    <input type="hidden" name="yr" id="yr" value="{{ $data['yr'] }}">
    <input type="hidden" name="yr2" id="yr2" value="{{ $data['yr2'] }}">
    <input type="hidden" name="dur1" id="dur1" value="{{ date('Y-m-d',strtotime($data['dur1'])) }}">
    <input type="hidden" name="dur2" id="dur2" value="{{ date('Y-m-d',strtotime($data['dur2'])) }}">
</form>

@endsection

@section('js')
<script src="{{ asset('js/admin.sales.js') }}"></script>
@endsection