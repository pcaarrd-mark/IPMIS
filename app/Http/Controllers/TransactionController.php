<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;


class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function temp()
    {
        $temp = App\Models\Transaction::where('counter_id',Auth::user()->id)->where('transaction_id',request()->transaction_id)->count();
        if($temp > 0)
        {
            //CHECK IF PRODUCT IS ALREADY AT THE LIST

            $list = App\Models\Transaction_list::where('transaction_id',request()->transaction_id)->where('product_id',request()->product_id)->first();

            if($list)
            {
                $list = App\Models\Transaction_list::where('transaction_id',request()->transaction_id)->where('product_id',request()->product_id)->update([
                                        "quantity" => $list['quantity'] + request()->qty
                                      ]);
            }
            else
            {
                $new_temp_list = new App\Models\Transaction_list;
                $new_temp_list->product_id = request()->product_id;
                $new_temp_list->transaction_id = request()->transaction_id;
                $new_temp_list->product_desc = request()->product_desc;
                $new_temp_list->quantity = request()->qty;
                $new_temp_list->purc_price = request()->purc_price;
                $new_temp_list->product_amt = request()->product_amt;
                $new_temp_list->save();
            }
            
        }
        else
        {
            $new_temp = new App\Models\Transaction;
            $new_temp->counter_id = Auth::user()->id;
            $new_temp->transaction_id = request()->transaction_id;
            $new_temp->save();

            $new_temp_list = new App\Models\Transaction_list;
            $new_temp_list->product_id = request()->product_id;
            $new_temp_list->transaction_id = request()->transaction_id;
            $new_temp_list->product_desc = request()->product_desc;
            $new_temp_list->quantity = request()->qty;
            $new_temp_list->purc_price = request()->purc_price;
            $new_temp_list->product_amt = request()->product_amt;
            $new_temp_list->save();
        }
    }

    public function json()
    {
        $temp = App\Models\Transaction::where('counter_id',Auth::user()->id)->where('status','temp')->first();
        if(isset($temp))
        {
            $templist = App\Models\Transaction_list::where('transaction_id',$temp['transaction_id'])->get();

            return $templist;
        }
        else
        {
            return array();
        }
    }

    public function process()
    {
        //$save = saveInventoryHistory(request()->transaction_id,'decrease',$trans_quantity,$stocks,$new_stocks,request()->inv_remarks);

        $temp = App\Models\Transaction::where('transaction_id',request()->transaction_id)
                ->update([
                            'status' => 'processed',
                            'customer_cash' => request()->customer_cash,
                        ]);

        $temp = App\Models\Transaction_list::where('transaction_id',request()->transaction_id)
                ->update([
                            'status' => 'processed',
                        ]);

        //GET ALL TRANSACTION DEDUC
        $templist = App\Models\Transaction_list::where('transaction_id',request()->transaction_id)->get();

        foreach ($templist as $lists) {

            //GET CURRENT STOCK
            $stocks_before = App\Models\Product::where('id',$lists->product_id)->first();

            $stocks_after = $stocks_before['stocks'] - $lists->quantity;

            $save = saveInventoryHistory($lists->product_id,'decrease',$lists->quantity,$stocks_before['stocks'],$stocks_after,"TRANSACTION ID : ".request()->transaction_id);

            if($save)
            {
               //UPDATE STOCKS
                $product = App\Models\Product::where('id',$lists->product_id)
                    ->update([ 'stocks' => $stocks_after]);
            }
        }

        return redirect('home');
    }


    public function void()
    {
        App\Models\Transaction::where('transaction_id',request()->void_transaction_id)
            ->update([
                        'deleted_at' => date('Y-m-d H:i:s'),
                        'deleted_by' => Auth::user()->name,
                    ]);
        App\Models\Transaction_list::where('transaction_id',request()->void_transaction_id)->delete();
        return redirect('home');
    }

    public function itemvoid()
    {
        App\Models\Transaction_list::where('id',request()->transaction_item_id)
                    ->update([
                        'deleted_at' => date('Y-m-d H:i:s'),
                        'deleted_by' => Auth::user()->name,
                    ]);
    }


}
