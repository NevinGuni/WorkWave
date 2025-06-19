<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        
        $user = User::where('username', $username)->first();
        
        if ($user && $user->password === $password) {
            session(['user_id' => $user->user_id]);
            session(['username' => $user->username]);
            session(['role' => $user->role]);
            
            if ($user->role === 'admin') {
                session(['welcome_message' => 'Administrator login successful. Please proceed with your tasks.']);
                return redirect()->route('admin.dashboard');
            } else {
                session(['welcome_message' => 'Employee login successful. Please proceed with your tasks.']);
                return redirect()->route('employee.dashboard');
            }
        }
        
        return back()->with('error', 'Invalid username or password');
    }
    
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}