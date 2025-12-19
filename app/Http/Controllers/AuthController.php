<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tìm user theo email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput()
                ->with('error', 'Sai email hoặc mật khẩu');
        }

        // So sánh mật khẩu (plain text hoặc hashed)
        // Kiểm tra cả plain text và hashed password
        $passwordMatch = ($request->password === $user->password) 
            || (password_verify($request->password, $user->password));

        if (!$passwordMatch) {
            return back()
                ->withInput()
                ->with('error', 'Sai email hoặc mật khẩu');
        }

        // Đăng nhập
        Auth::login($user);

        // Redirect theo role_id
        // Mapping: 1=admin, 2=cashier, 3=waiter, 4=kitchen
        switch ($user->role_id) {
            case 1: // Admin
                return redirect()->route('admin.dashboard');

            case 2: // Cashier
                return redirect()->route('cashier.orders.index');

            case 3: // Waiter
                return redirect()->route('waiter.orders.index');

            case 4: // Kitchen
                return redirect()->route('kitchen.orders.index');

            default:
                return redirect()->route('login')
                    ->with('error', 'Không xác định được quyền người dùng.');
        }
    }

    /**
     * Đăng xuất
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
