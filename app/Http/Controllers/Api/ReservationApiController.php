<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class ReservationApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'guests' => 'required|integer|min:1',
            'date' => 'required|date',
            'time' => 'required|string',
            'table_id' => 'required|integer|exists:restaurant_tables,id',
        ]);

        // Tìm bàn
        $table = RestaurantTable::find($request->table_id);

        if (!$table) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bàn.'
            ]);
        }

        // Nếu bàn đang "reserved", không cho đặt
        if ($table->status === 'reserved') {
            return response()->json([
                'success' => false,
                'message' => 'Bàn này đã được đặt.'
            ]);
        }

        // Tạo đặt bàn với status mặc định là "pending"
        $reservationData = $request->all();
        $reservationData['status'] = 'pending';
        $reservation = Reservation::create($reservationData);

        // Cập nhật trạng thái bàn
        $table->update(['status' => 'reserved']);

        return response()->json([
            'success' => true,
            'message' => 'Đặt bàn thành công!',
            'reservation' => $reservation
        ]);
    }
}
