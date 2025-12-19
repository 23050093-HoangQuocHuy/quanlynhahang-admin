<?php

namespace App\Http\Controllers;

use App\Models\User;

class DevPasswordResetController extends Controller
{
    // ĐẶC BIỆT: chỉ dùng trong lúc phát triển
    public function reset()
    {
        // Reset password user admin@gmail.com về đúng chuỗi 123456 (plain text)
        $affected = User::where('email', 'admin@gmail.com')
            ->update(['password' => '123456']);

        if ($affected) {
            return "Đã reset mật khẩu cho admin@gmail.com thành: 123456";
        }

        return "Không tìm thấy user admin@gmail.com để reset mật khẩu";
    }
}
