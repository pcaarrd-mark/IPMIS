<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        if(isset(request()->select_type))
        {

          switch(request()->select_type)
          {
                case 1:
                    $filter_text = "Date - ".date('F d, Y',strtotime(request()->filter_date_dt));
                break;

                case 2:
                    $filter_text = "Month of ".date('F',mktime(0, 0, 0, request()->filter_month_mon, 10))." ".date('Y',strtotime(request()->filter_month_year));
                break;

                case 3:
                    $filter_text = "Year ".date('Y',strtotime(request()->filter_year_yr));
                break;

                case 4:
                    $filter_text = "Duration From ".date('F d, Y',strtotime(request()->start))." to ".date('F d, Y',strtotime(request()->end));
                break;
          }

            

          $data = [
                    "filter" => request()->select_type,
                    "dt" => request()->filter_date_dt,
                    "mon" => request()->filter_month_mon,
                    "yr" => request()->filter_month_year,
                    "yr2" => request()->filter_year_yr,
                    "dur1" => request()->start,
                    "dur2" => request()->end,
                    "filter_text" => $filter_text
                ]; 
        }
        else
        {
          $filter_text = "Date - ".date('F d, Y');
          $data = [
                    "filter" => 1,
                    "dt" => date('Y-m-d'),
                    "mon" => 0,
                    "yr" => 0,
                    "yr2" => 0,
                    "dur1" => 0,
                    "dur2" => 0,
                    "filter_text" => $filter_text
                ];  
        }
        
        return view('admin.sales')->with('data',$data);
    }

    public function delete()
    {
        if(isset(request()->transaction_list_id))
        {
            App\Models\Transaction_list::where('id',request()->transaction_list_id)->update(['deleted_by' => Auth::user()->name,'deleted_at' => date('Y-m-d H:i:s')]);
        }
        else
        {
            App\Models\Transaction::where('transaction_id',request()->transaction_id)->update(['deleted_by' => Auth::user()->name,'deleted_at' => date('Y-m-d H:i:s')]);
        }
        

        switch(request()->filter)
          {
                case 1:
                    $filter_text = "Date - ".date('F d, Y',strtotime(request()->dt));
                break;

                case 2:
                    $filter_text = "Month of ".date('F',mktime(0, 0, 0, request()->mon, 10))." ".date('Y',strtotime(request()->yr));
                break;

                case 3:
                    $filter_text = "Year ".date('Y',strtotime(request()->yr2));
                break;

                case 4:
                    $filter_text = "Duration From ".date('F d, Y',strtotime(request()->dur1))." to ".date('F d, Y',strtotime(request()->dur2));
                break;
          }

            

          $data = [
                    "filter" => request()->filter,
                    "dt" => request()->dt,
                    "mon" => request()->mon,
                    "yr" => request()->yr,
                    "yr2" => request()->yr2,
                    "dur1" => request()->dur1,
                    "dur2" => request()->dur2,
                    "filter_text" => $filter_text
                ]; 

        return view('admin.sales')->with('data',$data);
    }

    public function salesjson($filter,$dt,$mon,$yr,$yr2,$dur1,$dur2)
    {
        switch($filter)
        {
            case 1:
                $sales = App\Models\View_sale::whereDate('created_at',$dt)->get();
            break;

            case 2:
                $sales = App\Models\View_sale::whereMonth('created_at',$mon)->whereYear('created_at',$yr)->get();
            break;

            case 3:
                $sales = App\Models\View_sale::whereYear('created_at',$yr2)->get();
            break;

            case 4:
                $from = date('Y-m-d',strtotime($dur1));
                $to = date('Y-m-d',strtotime($dur2));
                $sales = App\Models\View_sale::whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get();
            break;
        }
        
        return $sales;
    }

    public function saleslistjson($id)
    {
        $sales = App\Models\Transaction_list::where('transaction_id',$id)->where('status','processed')->get();
        return $sales;
    }

    public function annualsalesjson($yr)
    {
        $sale = App\Models\View_annual_sale::select('sales_month','profit','amt')->where('sales_year',$yr)->get();
        return $sale;
    }
}
