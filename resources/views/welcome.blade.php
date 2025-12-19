<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Restaurant Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f6fa;
            color: #2c3e50;
        }

        /* Header */
        .navbar {
            padding: 20px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 22px;
            color: #e74c3c;
        }

        .btn-login {
            background-color: #e74c3c;
            border: none;
            padding: 10px 22px;
            border-radius: 30px;
            font-weight: 500;
        }

        .btn-login:hover {
            background-color: #c0392b;
        }

        /* Hero */
        .hero {
            padding: 100px 0;
            background: linear-gradient(
                rgba(0,0,0,0.55),
                rgba(0,0,0,0.55)
            ),
            url("https://images.unsplash.com/photo-1555396273-367ea4eb4db5") center/cover;
            color: #fff;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 700;
        }

        .hero p {
            font-size: 18px;
            margin-top: 20px;
            color: #e0e0e0;
        }

        /* Features */
        .feature-section {
            padding: 80px 0;
        }

        .feature-card {
            background: #fff;
            border-radius: 16px;
            padding: 35px;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
        }

        .feature-card h5 {
            font-weight: 600;
            margin-top: 15px;
        }

        /* CTA */
        .cta {
            background: #e74c3c;
            color: #fff;
            padding: 70px 0;
            text-align: center;
        }

        .cta h2 {
            font-weight: 700;
        }

        footer {
            background: #111;
            color: #aaa;
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>

{{-- HEADER --}}
<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">
            🍽️ Restaurant Manager
        </a>

        <a href="{{ route('login') }}" class="btn btn-login text-white">
            Đăng nhập
        </a>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1>
                    Giải pháp quản lý <br>
                    nhà hàng hiện đại
                </h1>
                <p>
                    Quản lý món ăn, bàn ăn, đơn hàng, nhân viên và doanh thu
                    trong một hệ thống duy nhất – nhanh chóng, chính xác, chuyên nghiệp.
                </p>
                <a href="{{ route('login') }}" class="btn btn-login text-white mt-4">
                    Truy cập hệ thống
                </a>
            </div>
        </div>
    </div>
</section>

{{-- FEATURES --}}
<section class="feature-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Tính năng nổi bật</h2>
            <p class="text-muted">Được thiết kế cho nhà hàng thực tế</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <h3>🍔</h3>
                    <h5>Quản lý món ăn</h5>
                    <p class="text-muted">
                        Cập nhật thực đơn, giá bán và trạng thái món nhanh chóng.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <h3>🧾</h3>
                    <h5>Đơn hàng & hóa đơn</h5>
                    <p class="text-muted">
                        Theo dõi đơn hàng theo thời gian thực, giảm sai sót.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <h3>📊</h3>
                    <h5>Báo cáo doanh thu</h5>
                    <p class="text-muted">
                        Thống kê chi tiết theo ngày, tháng, năm.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta">
    <div class="container">
        <h2>Sẵn sàng quản lý nhà hàng chuyên nghiệp?</h2>
        <p class="mt-3">
            Đăng nhập để bắt đầu sử dụng hệ thống ngay hôm nay.
        </p>
        <a href="{{ route('login') }}" class="btn btn-light mt-3 px-4 py-2">
            Đăng nhập hệ thống
        </a>
    </div>
</section>

<footer>
    © {{ date('Y') }} Restaurant Management System – Laravel
</footer>

</body>
</html>
