<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo về yêu cầu đặt bàn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #ef4444;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .info-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #ef4444;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #6b7280;
        }
        .value {
            color: #111827;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 14px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background-color: #ef4444;
            color: white;
            border-radius: 20px;
            font-weight: bold;
            margin: 10px 0;
        }
        .message-box {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>❌ Thông báo về yêu cầu đặt bàn</h1>
    </div>

    <div class="content">
        <p>Xin chào <strong>{{ $reservation->fullname }}</strong>,</p>
        
        <p>Chúng tôi rất tiếc phải thông báo rằng yêu cầu đặt bàn của bạn không thể được chấp nhận vào thời điểm này.</p>

        <div class="message-box">
            <p><strong>Trạng thái:</strong> <span class="status-badge">ĐÃ TỪ CHỐI</span></p>
            <p>Rất tiếc, chúng tôi không thể đáp ứng yêu cầu đặt bàn của bạn. Vui lòng liên hệ trực tiếp với nhà hàng để được hỗ trợ đặt bàn vào thời gian khác.</p>
        </div>

        <div class="info-box">
            <h3 style="margin-top: 0;">Thông tin đặt bàn:</h3>
            
            <div class="info-row">
                <span class="label">Họ tên:</span>
                <span class="value">{{ $reservation->fullname }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Số điện thoại:</span>
                <span class="value">{{ $reservation->phone }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Ngày đặt:</span>
                <span class="value">{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Giờ đặt:</span>
                <span class="value">{{ $reservation->time }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Số khách:</span>
                <span class="value">{{ $reservation->guests }} người</span>
            </div>
            
            <div class="info-row">
                <span class="label">Bàn:</span>
                <span class="value">
                    @if($reservation->table)
                        {{ $reservation->table->name }}
                    @else
                        N/A
                    @endif
                </span>
            </div>
        </div>

        <p>Chúng tôi xin lỗi vì sự bất tiện này. Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi để được hỗ trợ tốt hơn.</p>

        <p>Trân trọng,<br>
        <strong>{{ config('app.name') }}</strong></p>
    </div>

    <div class="footer">
        <p>Email này được gửi tự động từ hệ thống quản lý nhà hàng.</p>
        <p>Vui lòng không trả lời email này.</p>
    </div>
</body>
</html>

