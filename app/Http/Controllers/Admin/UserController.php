<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controller quản lý Người dùng (User)
 * Chỉ admin mới được truy cập
 */
class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng
     */
    public function index()
    {
        $users = User::with('role')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Hiển thị form tạo người dùng mới
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Lưu người dùng mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ], [
            'name.required' => 'Tên người dùng không được để trống.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'role_id.required' => 'Vui lòng chọn quyền.',
            'role_id.exists' => 'Quyền không hợp lệ.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Thêm người dùng thành công!');
    }

    /**
     * Hiển thị form sửa người dùng
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Cập nhật người dùng
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ], [
            'name.required' => 'Tên người dùng không được để trống.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'role_id.required' => 'Vui lòng chọn quyền.',
            'role_id.exists' => 'Quyền không hợp lệ.',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
        ];

        // Chỉ cập nhật mật khẩu nếu có nhập
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'Cập nhật người dùng thành công!');
    }

    /**
     * Xóa người dùng
     */
    public function destroy(User $user)
    {
        // Không cho phép xóa chính mình
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Bạn không thể xóa chính tài khoản của mình.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Xóa người dùng thành công!');
    }
}

