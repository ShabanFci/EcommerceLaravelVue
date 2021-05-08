<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Order;
use Validator;

class OrderController extends Controller
{
    public function index(){

    	return response()->json(Order::with('product')->orderBy('id','DESC')->paginate(10) , 200);
    }

    public function deliverOrder(Order $order)
        {
            $order->is_delivered = true;
            $status = $order->save();

            return response()->json([
                'status'    => $status,
                'data'      => $order,
                'message'   => $status ? 'Order Delivered!' : 'Error Delivering Order'
            ]);
        }

   public function store(Request $request)
        {
            $this->validate($request,[
                
                'address' => 'required'
            ]);

            $order = Order::create([
                'product_id' => $request->product_id,
                'user_id' => Auth::user()->id,
                'quantity' => $request->quantity,
                'address' => $request->address
            ]);

            return response()->json([
                'status' => (bool) $order,
                'data'   => $order,
                'message' => $order ? 'Order Created!' : 'Error Creating Order'
            ]);
        }

    public function show(Order $order){

    	return response()->json($order , 200);
    }

    public function update(Request $request , Order $order){

    	$status = $order->update($request->only(['quantity']));
    	return response()->json([
            
            'status' => $status , 
            'message' => $status ? 'Order Updated' : 'Error While Updating The Order'

    	]);
    }

    public function destroy(Order $order){

    	$status = $order->delete();
    	return response()->json([
       
          'status' => $status , 
          'message' => $status ? 'Order Deleted' : 'Error While Deleting The Order'
    	]);
    }
    public function latestOrders(){

        $latestOrders = Order::With('product')->orderBy('id','DESC')->
                              Where('is_delivered',0)->Limit(5)->get();
        return response()->json($latestOrders);
    }
}
