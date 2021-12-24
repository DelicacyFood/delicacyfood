<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\History_Topup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function topup()
    {
        return view('pages.topup.topup');
    }

    public function history_topup()
    {
        // if (session()->has('hasLogin')) {
        //     if (session()->get('role') == 'customer') {
        //         echo "<script>alert('You're not allowed!')</script>";
        //         return view('pages.dashboard');
        //     }
        return view('pages.topup.history_topup');
        // }
        // echo "<script>alert('You're not allowed!')</script>";
        // return view('pages.dashboard');
    }

    // Masukkin topup ke history_topup
    public function isi_saldo(Request $request)
    {
        $temp1 = DB::selectOne("select getNewId('history_topup') as value from dual");

        // Driver
        $history_topup = new History_Topup;
        $history_topup->driver_id = $temp1->value;
        $history_topup->driver_name = $request->username;
        $history_topup->phone = $request->phone;
        $driver->city = $request->city;
        $driver->password = Hash::make($request->password);

        $driver->save();

        return redirect('auth/login_driver')->with('success', 'Registration Success! Please Login');
    }


    // Store ke Saldo Customer
    public function store_saldo(Request $request)
    {
        $credentials = $request->validate([
            'saldo' => 'required',
        ]);
        $username_customer = $request->session()->get('username');
        $user_id_customer = $request->session()->get('user_id');
        $saldo_customer = $credentials['saldo'];

        $procedureName = 'topupSaldo';

        $bindings = [
            'username'  => $username_customer,
            'saldo'  => $saldo_customer,
            'user_id_in' => $user_id_customer,
        ];

        $result = DB::executeProcedure($procedureName, $bindings);

        // dd($result);
        // $dummy_var = DB::selectOne("select topupSaldo('$username_customer',$saldo_customer) as value from dual")->value;

        return redirect('pages/dashboard')->with('success', 'Registration Success! Please Login');
    }
}
