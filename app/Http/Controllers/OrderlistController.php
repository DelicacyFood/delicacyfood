<?php

namespace App\Http\Controllers;

use App\Models\Orderlist;
use App\Cart;
use App\Models\Ordermenu;
use App\Models\Customer;
use App\Models\Driver;
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
        $request->session()->put('orderlist_id_confirm', $orderlist->orderlist_id);
        // Get Total Bayar
        $oldCart = session()->get('cart');
        $cart = new Cart($oldCart);
        $orderlist->total_bayar = $cart->totalPrice;

        $orderlist->order_date = $tanggal_pemesanan;

        // Get Customer and Waiter ID
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

        // Get Status Layanan
        if ($request->status_layanan == 'Take Away') {
            $orderlist->status_layanan = 'Take Away';
        } elseif ($request->status_layanan == 'Delivery') {
            $orderlist->status_layanan = 'Delivery';
        }

        // Get Status Prosess
        $orderlist->status_proses = 'Order Placed';
        $orderlist->save();


        // Insert Data Ordermenu to Ordermenu Table
        $temp_ordermenu_id = $orderlist->orderlist_id;
        $oldCart = session()->get('cart');
        $cart = new Cart($oldCart);
        foreach ($cart->items as $items) {
            $ordermenu = new Ordermenu;
            $ordermenu->orderlist_id = $temp_ordermenu_id;
            $ordermenu->menu_id = $items['item']['menu_id'];
            $ordermenu->jumlah_order = $items['qty'];
            $ordermenu->save();
        }

        return redirect()->route('invoice');
    }

    public function orderlist()
    {
        $orderlist = DB::table('orderlist')->get();
        // Get Driver Name
        return view('pages.orderlist.orderlist', compact('orderlist'));
    }


    public function detailOrderlist($orderlist_id)
    {
        $products = DB::select('select * from ordermenu inner join menu on ordermenu.menu_id = menu.menu_id
        where ordermenu.orderlist_id = ' . $orderlist_id);
        // dd($products);
        return view('pages.orderlist.detailorderlist', compact('products', 'orderlist_id'));
    }

    public function confirmPayment($orderlist_id)
    {
        $orderlist = Orderlist::find($orderlist_id);
        $orderlist->status_proses = 'Payment Completed';
        $orderlist->update();
        return redirect()->route('orderlist');
    }

    public function confirmPaymentCustomer($totalPrice)
    {
        $customer_user_id = session()->get('user_id');
        $customer = Customer::find($customer_user_id);
        $customer->saldo = $customer->saldo - $totalPrice;
        $customer->update();


        $orderlist_id = session()->get('orderlist_id_confirm');
        $orderlist = Orderlist::find($orderlist_id);
        $orderlist->status_proses = 'Payment Pending';
        $orderlist->update();
        session()->forget('cart');
        return redirect()->route('orderlist');
    }
    // public function deleteOrderlist($orderlist_id)
    // {
    //     $ordermenu = DB::select('select * from ordermenu where orderlist_id = ' . $orderlist_id);
    //     // $ordermenu_temp = Ordermenu::find($orderlist_id);
    //     // dd($ordermenu_temp);
    //     // $ordermenu_temp->delete();

    //     $orderlist = Orderlist::find($orderlist_id);
    //     dd($orderlist);
    //     $orderlist->delete();

    //     return redirect()->route('orderlist');
    // }

}
