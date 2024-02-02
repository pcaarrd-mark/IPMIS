<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $category = App\Models\Category::get();

        return view('admin.inventory')->with('category',$category);
    }

    public function productnew()
    {
        $err = "";
        $product = new App\Models\Product;

        //DESC MUST BE UNIQUE
        $prod = $product::where('product_desc',request()->new_product)->count();
        if($prod > 0)
            $err .= "<b>".request()->new_product."</b> already exist! Product description must be unique<br>";

        //BARCODE MUST BE UNIQUE
        $prod = $product::where('product_barcode',request()->new_barcode)->count();
        if($prod > 0)
            $err .= "<b>".request()->new_barcode."</b> already exist! Barcode must be unique<br>";

        if($err != "")
        {
            return view('admin.error')->with("message",$err);
        }
        else
        {
            $product->product_desc = request()->new_product;
            $product->product_barcode = request()->new_barcode;
            $product->category_id = request()->new_category;
            $product->purc_price = request()->new_pur_price;
            $product->product_amt = request()->new_sale_price;
            $product->stocks = request()->new_initial_stocks;
            $product->save();
            $prod_id = $product->id;

            //ADD INITIAL INVENTORY
            //SAVE HISTORY
            $save = saveInventoryHistory($prod_id,'increase',request()->new_initial_stocks,0,request()->new_initial_stocks,'initial stock');

            Log::channel('audit')->info(Auth::user()->name.' - Added new product : '.request()->new_product);

            return redirect("/admin/inventory");
        }
    }

    public function update()
    {
        $err = "";
        $product = new App\Models\Product;

        //DESC MUST BE UNIQUE
        $prod = $product::where('product_desc',request()->edit_product)->first();
        if($prod)
        {
            if($prod['id'] != request()->edit_product_id)
                $err .= "<b>".request()->edit_product."</b> already exist! Product description must be unique<br>";
        }

        //BARCODE MUST BE UNIQUE
        $prod = $product::where('product_barcode',request()->edit_barcode)->first();
        if($prod)
        {
            if($prod['id'] != request()->edit_product_id)
                $err .= "<b>".request()->edit_barcode."</b> already exist! Barcode must be unique<br>";
        }
            

        if($err != "")
        {
            return view('admin.error')->with("message",$err);
        }
        else
        {
            $prod = $product::where('id',request()->edit_product_id)->first();

            Log::channel('audit')->info(Auth::user()->name.' - Updated a product : <original data> Description : '.$prod['product_desc'].' Barcode : '.$prod['product_barcode'].' Category : '.$prod['category_id'].' Purchase Price : '.$prod['purc_price'].' Sale Price '.$prod['product_amt'].' <new data> Description : '.request()->edit_product.' Barcode : '.request()->edit_barcode.' Category : '.request()->edit_category.' Purchase Price : '.request()->edit_pur_price.' Sale Price '.request()->edit_sale_price);

            $product->where('id',request()->edit_product_id)
                    ->update([
                                'product_desc' => request()->edit_product,
                                'product_barcode' => request()->edit_barcode,
                                'category_id' => request()->edit_category,
                                'purc_price' => request()->edit_pur_price,
                                'product_amt' => request()->edit_sale_price,
                            ]);



            return redirect("/admin/inventory");
        }
    }

    public function delete()
    {
        //GET PRODUCT INFO
        $prod = App\Models\Product::where('id',request()->del_product_id)->first();

        Log::channel('audit')->info(Auth::user()->name.' - Deleted product : '.$prod['product_desc']);

        App\Models\Product::where('id',request()->del_product_id)->delete();

        return redirect('admin/inventory');
    }

    public function json($id = null)
    {
        if($id == null)
        {
            $product = App\Models\View_product::get();
        }
        else
        {
            $product = App\Models\View_product::where('id',$id)->first();
        }
        

        return $product;
    }

    public function jsonhistory($id)
    {
        $product = App\Models\View_inventory_history::where('product_id',$id)->get();
        
        if($product)    
            return $product;
    }


    public function create()
    {
        //GET LAST UPDATED STOCKS
        $product = App\Models\Product::where('id',request()->inv_product_id)->first();
        $stocks = $product['stocks'];

        $trans_quantity = request()->inv_quantity;

        //CHECK TRANSACTION
        if(request()->inv_type == 'increase')
        {
            $new_stocks = $stocks + $trans_quantity;
        }
        else
        {
            $new_stocks = $stocks - $trans_quantity;
        }

        

        //SAVE HISTORY
        $save = saveInventoryHistory(request()->inv_product_id,request()->inv_type,$trans_quantity,$stocks,$new_stocks,request()->inv_remarks);

        if($save)
        {
           //UPDATE STOCKS
            $product = App\Models\Product::where('id',request()->inv_product_id)
                ->update([ 'stocks' => $new_stocks]);

            return redirect('admin/inventory');
        }
        else
        {
            return view('admin.error')->with("message","<b>Ooops!</b> Something went wrong!");
        }
    }

}
