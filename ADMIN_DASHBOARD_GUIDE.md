# Hướng dẫn Admin Dashboard - Quản lý Nhà hàng

## Tổng quan

Hệ thống Admin Dashboard đã được xây dựng với đầy đủ các chức năng quản lý nhà hàng, phân quyền người dùng và giao diện hiện đại sử dụng Tailwind CSS.

## Cấu trúc dự án

### Controllers

- **Admin Controllers** (`app/Http/Controllers/Admin/`):
  - `DashboardController.php` - Dashboard tổng quan
  - `CategoryController.php` - Quản lý danh mục món
  - `FoodController.php` - Quản lý món ăn
  - `TableController.php` - Quản lý bàn
  - `ReportController.php` - Báo cáo doanh thu

- **Waiter Controller** (`app/Http/Controllers/Waiter/`):
  - `OrderController.php` - Màn hình phục vụ (tạo order, thêm món, gửi bếp)

- **Kitchen Controller** (`app/Http/Controllers/Kitchen/`):
  - `KitchenOrderController.php` - Màn hình bếp (xem món cần nấu, đánh dấu hoàn thành)

- **Cashier Controller** (`app/Http/Controllers/Cashier/`):
  - `CashierOrderController.php` - Màn hình thu ngân (thanh toán, in hóa đơn)

### Middleware & Phân quyền

- **RoleMiddleware** (`app/Http/Middleware/RoleMiddleware.php`): Kiểm tra quyền truy cập dựa trên role
- **Config Roles** (`config/roles.php`): Định nghĩa các role constants

### Views

- **Layout**: `resources/views/layouts/admin.blade.php` - Layout chung cho tất cả trang admin
- **Admin Views**: `resources/views/admin/` - Các view cho admin
- **Waiter Views**: `resources/views/waiter/` - Các view cho waiter
- **Kitchen Views**: `resources/views/kitchen/` - Các view cho kitchen
- **Cashier Views**: `resources/views/cashier/` - Các view cho cashier

## Phân quyền người dùng

### Các Role

1. **admin** (Quản lý): Toàn quyền truy cập
2. **cashier** (Nhân viên Thu ngân): Xem order, thanh toán, in hóa đơn
3. **waiter** (Nhân viên Phục vụ): Quản lý bàn, tạo & cập nhật order, gửi bếp
4. **kitchen** (Nhân viên Bếp): Xem danh sách món cần chế biến, đánh dấu hoàn thành

### Routes và Phân quyền

- `/admin/*` - Chỉ admin
- `/admin/tables` - Admin + Waiter (waiter chỉ xem)
- `/waiter/orders/*` - Admin + Waiter
- `/kitchen/orders/*` - Admin + Kitchen
- `/cashier/orders/*` - Admin + Cashier

## Cài đặt và Sử dụng
 Tải và cài đặt laragon

### 1. Cấu hình Storage Link

Để hiển thị ảnh món ăn, cần chạy lệnh:

```bash
cd C:\laragon\www\quanlynhahang
php artisan serve
```

### 2. Đăng nhập

- URL: `http://127.0.0.1:8000//login`
- Sau khi đăng nhập, hệ thống sẽ redirect đến `/admin` (dashboard)

### 3. Các chức năng chính

#### Admin Dashboard (`/admin`)
- Tổng quan thống kê: tổng đơn hàng, doanh thu, đơn chờ xử lý, bàn đang dùng
- Top món ăn bán chạy
- Doanh thu theo ngày

#### Quản lý Danh mục (`/admin/categories`)
- CRUD danh mục món
- Xem số lượng món trong mỗi danh mục

#### Quản lý Món ăn (`/admin/foods`)
- CRUD món ăn
- Upload ảnh món
- Tìm kiếm và lọc theo danh mục

#### Quản lý Bàn (`/admin/tables`)
- Sơ đồ bàn dạng grid
- CRUD bàn (chỉ admin)
- Waiter có thể xem và chọn bàn để tạo order

#### Màn hình Phục vụ (`/waiter/orders`)
- Chọn bàn từ sơ đồ bàn
- Tạo order mới
- Thêm món vào order
- Cập nhật số lượng món
- Gửi bếp

#### Màn hình Bếp (`/kitchen/orders`)
- Xem danh sách món cần chế biến
- Đánh dấu bắt đầu nấu
- Đánh dấu hoàn thành món/order
- Tự động refresh mỗi 30 giây

#### Màn hình Thu ngân (`/cashier/orders`)
- Xem danh sách bàn cần thanh toán
- Xem chi tiết order
- In hóa đơn
- Thanh toán (cập nhật trạng thái order và bàn)

#### Báo cáo (`/admin/reports`)
- Báo cáo doanh thu theo khoảng thời gian
- Top món ăn bán chạy
- Doanh thu theo ngày
- Filter: hôm nay, tháng này, năm nay

## Lưu ý quan trọng

1. **Upload ảnh**: `Ảnh món ăn bằng cách nhập đường dẫn URL` .

2. **Phân quyền**: Tất cả routes đều được bảo vệ bởi middleware `auth` và `role`. Đảm bảo user đã đăng nhập và có role phù hợp.

3. **Trạng thái Order**:
   - `pending`: Order mới tạo, chưa gửi bếp
   - `cooking`: Đang nấu
   - `served`: Đã phục vụ xong, chờ thanh toán
   - `paid`: Đã thanh toán

4. **Trạng thái Bàn**:
   - `empty`: Trống
   - `serving`: Đang phục vụ
   - `reserved`: Đã đặt

## Cấu trúc Database

Các bảng chính:
- `users` - Người dùng (có `role_id`)
- `roles` - Vai trò (admin, cashier, waiter, kitchen)
- `categories` - Danh mục món
- `foods` - Món ăn
- `restaurant_tables` - Bàn
- `orders` - Đơn hàng
- `order_items` - Chi tiết món trong đơn hàng

## Giao diện

- Sử dụng Tailwind CSS 4.0
- Layout responsive, hỗ trợ mobile và tablet
- Sidebar tối với menu điều hướng
- Topbar hiển thị thông tin user và nút đăng xuất
- Màu sắc phân biệt trạng thái rõ ràng
  
## Tài liệu tham khảo
- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Laravel Livewire Documentation](https://laravel-livewire.com/docs)
---



