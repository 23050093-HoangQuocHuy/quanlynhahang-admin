<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware kiểm tra quyền truy cập dựa trên role_id của user
 * 
 * Mapping role name → role_id:
 * - admin => 1
 * - cashier => 2
 * - waiter => 3
 * - kitchen => 4
 * 
 * Sử dụng: ->middleware('role:admin') hoặc ->middleware('role:admin,waiter')
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Kiểm tra user đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $user = Auth::user();

        // Mapping role name → role_id
        // 1 = admin, 2 = cashier, 3 = waiter, 4 = kitchen
        $roleMap = [
            'admin' => 1,
            'cashier' => 2,
            'waiter' => 3,
            'kitchen' => 4,
        ];

        // Chuyển danh sách role từ name → id
        $allowedRoleIds = [];
        foreach ($roles as $roleName) {
            if (isset($roleMap[$roleName])) {
                $allowedRoleIds[] = $roleMap[$roleName];
            }
        }

        // Kiểm tra user có role_id không
        if (!$user->role_id) {
            abort(403, 'Tài khoản của bạn chưa được phân quyền.');
        }

        // Kiểm tra role_id có trong danh sách cho phép không
        if (!in_array($user->role_id, $allowedRoleIds)) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}
