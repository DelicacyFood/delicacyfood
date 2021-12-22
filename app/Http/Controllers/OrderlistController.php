<?php

namespace App\Http\Controllers;

use App\Models\Orderlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderlistController extends Controller
{
    public function confirmOrder($totalPrice)
    {
        // $tanggal_pemesanan = date("Y-m-d");
        // Orderlist
        // $orderlist = new Orderlist;
        // $orderlist->orderlist_id = DB::selectOne("select getNewId('orderlist') as value from dual")->value;
        // $orderlist->total_bayar = $totalPrice;
        // $orderlist->order_date = $tanggal_pemesanan;
        // $orderlist->status_layanan;
        // $orderlist->status_proses = 'Payment Completed';
        // $orderlist->save();

        session()->forget('cart');
    }
}
