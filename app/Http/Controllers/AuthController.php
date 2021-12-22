<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Controller Auth
    public function login()
    {
        if (session()->has('hasLogin')) {
            $customer = DB::selectOne("select totalCustomers as value from dual");
            $saldo = DB::table('customer')->get();
            $sales = DB::selectOne("select numberOfOrders as value from dual");
            echo "<script>alert('You already signed in')</script>";
            return view('pages.dashboard', compact('customer', 'sales'));
        }
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

    // Authenticate
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Session User_id, Username, hasLogin, and Role
        $request->session()->put('username', $credentials['username']);
        $username_user = $credentials['username'];
        $role_user = DB::selectOne("select getRoleUser('$username_user') as value from dual")->value;
        $user_id = DB::selectOne("select getUserId('$username_user') as value from dual")->value;
        if (Auth::attempt($credentials)) {
            $request->session()->put('hasLogin', 'true');
            $request->session()->put('role', $role_user);
            $request->session()->put('user_id', $user_id);
            $request->session()->regenerate();
            return redirect()->intended('pages/dashboard');
        }

        return back()->with('loginError', 'Login Failed!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('pages/dashboard');
    }

    // Register
    public function store(Request $request)
    {
        // Users
        $users = new Users;
        $temp1 = DB::selectOne("select getNewId('users') as value from dual");
        $users->user_id = $temp1->value;
        $users->password = Hash::make($request->password);
        $users->username = $request->username;
        $users->save();

        // Customer
        $customer = new Customer;
        $customer->user_id = $temp1->value;
        $customer->address = $request->alamat;
        $customer->saldo = $request->saldo;

        $customer->save();

        //$validatedData['password'] = bcrypt($validatedData['password']);

        // Jika menggunakan flash (baca flash storage di php)
        // $request->session()->flash('success', 'Registration Success! Please Login');

        return redirect('auth/login')->with('success', 'Registration Success! Please Login');
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }
}
