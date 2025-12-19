<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\RestaurantTable;
use App\Mail\ReservationConfirmed;
use App\Mail\ReservationRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Controller quản lý Đặt bàn (Reservation) - Admin
 */
class ReservationController extends Controller
{
    /**
     * Hiển thị danh sách tất cả lịch đặt bàn
     */
    public function index()
    {
        $reservations = Reservation::with('table')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Xác nhận đặt bàn và gửi email xác nhận
     */
    public function confirm($id)
    {
        $reservation = Reservation::with('table')->findOrFail($id);

        // Cập nhật trạng thái
        $reservation->update(['status' => 'confirmed']);

        // Gửi email xác nhận
        if ($reservation->email) {
            Mail::to($reservation->email)->send(new ReservationConfirmed($reservation));
        }

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Đã xác nhận đặt bàn và gửi email cho khách hàng.');
    }

    /**
     * Từ chối đặt bàn, gửi email từ chối và trả bàn về trạng thái empty
     */
    public function reject($id)
    {
        $reservation = Reservation::with('table')->findOrFail($id);

        // Cập nhật trạng thái reservation
        $reservation->update(['status' => 'rejected']);

        // Cập nhật trạng thái bàn về "empty"
        if ($reservation->table) {
            $reservation->table->update(['status' => 'empty']);
        }

        // Gửi email từ chối
        if ($reservation->email) {
            Mail::to($reservation->email)->send(new ReservationRejected($reservation));
        }

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Đã từ chối đặt bàn, trả bàn về trạng thái trống và gửi email cho khách hàng.');
    }
}

