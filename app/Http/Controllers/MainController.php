<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    // Controller Main Page
    public function index()
    {
        return view('start');
    }

    public function menu()
    {
        $menu = DB::table('menu')->get();
        return view('menu', compact('menu'));
    }

    // Controller Modules
    public function sweetalert()
    {
        return view('modules.sweet-alert');
    }

    // Controller Pages
    public function dashboard()
    {
        $customer = DB::selectOne("select totalCustomers as value from dual");
        // $waiter = DB::table('menu')->get();
        $sales = DB::selectOne("select numberOfOrders as value from dual");
        // $users = DB::table('users')->get();
        return view('pages.dashboard', compact('customer', 'sales'));
    }

    public function topup()
    {
        return view('pages.topup');
    }

    public function ordermenu()
    {
        return view('pages.ordermenu');
    }

    public function orderlist()
    {
        return view('pages.orderlist');
    }

    public function home()
    {
        $last_orderlist_id = DB::selectOne("select getNewId('orderlist') as value from dual");
        $totalBayar = DB::selectOne("select hitungTotalBayar(1) as value from dual");
        return view('pages.home', compact('totalBayar'));
    }

    public function credits()
    {
        return view('pages.credits');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function history_topup()
    {
        return view('pages.history_topup');
    }

    public function jumlah_order()
    {
        return view('pages.jumlah_order');
    }

    // Controller Auth
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function update_password()
    {
        return view('auth.update_password');
    }

    public function edit_profile()
    {
        return view('auth.edit_profile');
    }
}
