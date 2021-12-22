<?php

namespace App\Http\Controllers;

use App\Models\Orderlist;
use App\Cart;
use App\Models\Ordermenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderlistController extends Controller
{
    public function confirmOrder(Request $request)
    {
        $tanggal_pemesanan = date("Y-m-d");
        $role_temp = session()->get('role');
        if ($role_temp == 'customer') {
            $temp_param = 'true';
            $customer_id = session()->get('user_id');
        } else if ($role_temp == 'waiter') {
            $temp_param = 'false';
            $waiter_id = session()->get('user_id');
        }
        // Insert Data Sales to Orderlist Table
        $orderlist = new Orderlist;
        $orderlist->orderlist_id = DB::selectOne("select getNewId('orderlist') as value from dual")->value;

        $oldCart = session()->get('cart');
        $cart = new Cart($oldCart);
        $orderlist->total_bayar = $cart->totalPrice;

        $orderlist->order_date = $tanggal_pemesanan;

        if ($temp_param == 'true') {
            $users_id = $customer_id;
            $orderlist->customer_user_id = $users_id;
            $orderlist->waiter_user_id = NULL;
        } else if ($temp_param == 'false') {
            $users_id = $waiter_id;
            $orderlist->waiter_user_id = $users_id;
            $orderlist->customer_user_id = NULL;
        }
        $orderlist->driver_id = NULL;

        if ($request->status_layanan == 'Take Away') {
            $orderlist->status_layanan = 'Take Away';
        } elseif ($request->status_layanan == 'Delivery') {
            $orderlist->status_layanan = 'Delivery';
        }

        $orderlist->status_proses = 'Payment Completed';
        $orderlist->save();

        session()->forget('cart');
        return redirect()->route('dashboard');
    }

    public function orderlist()
    {
        $orderlist = DB::table('orderlist')->get();
        return view('pages.orderlist', compact('orderlist'));
    }
}
