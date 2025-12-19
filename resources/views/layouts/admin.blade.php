<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Quản lý Nhà hàng</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Sidebar Animation Styles -->
    <style>
        /* ============================ */
/*      SIDEBAR CORE FIX        */
/* ============================ */

#sidebar {
    transition: width .3s ease;
    overflow: visible !important;
}

/* Collapsed width */
.sidebar-collapsed {
    width: 5rem !important;
}

/* ============================ */
/*  FIX ALIGN ICON + TEXT      */
/* ============================ */

.menu-link {
    display: flex;
    align-items: center;          /* 🔥 Fix căn giữa icon + chữ */
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    transition: all .25s ease;
}

/* Icon chuẩn */
.menu-link .icon {
    width: 20px !important;
    height: 20px !important;
    flex-shrink: 0 !important;    /* Không cho icon bị kéo méo */
}

/* Text chuẩn */
.menu-text {
    white-space: nowrap;
    transition: opacity .25s, transform .25s, width .25s;
}

/* ============================ */
/* COLLAPSED MODE               */
/* ============================ */

.sidebar-collapsed .menu-link {
    justify-content: center;
    padding: 0.75rem 0 !important;
    gap: 0 !important;
}

.sidebar-collapsed .menu-text {
    opacity: 0;
    width: 0;
    overflow: hidden;
    pointer-events: none;
    margin: 0;
}

/* Allow full expand on hover */
.sidebar-collapsed:hover {
    width: 16rem !important;
}

.sidebar-collapsed:hover .menu-link {
    justify-content: flex-start;
    padding: 0.75rem 1rem !important;
    gap: 0.75rem !important;
}

.sidebar-collapsed:hover .menu-text {
    opacity: 1;
    width: auto;
    pointer-events: auto;
}

/* ============================ */
/* SUBMENU FIX                 */
/* ============================ */

.submenu {
    overflow: hidden;
    max-height: 0;
    transition: max-height .3s ease;
}

.submenu.open {
    max-height: 500px;
}

.sidebar-collapsed .submenu {
    display: none !important;
}

.sidebar-collapsed:hover .submenu {
    display: block !important;
}

/* Hide arrow when collapsed */
.sidebar-collapsed [data-arrow] {
    display: none !important;
}

.sidebar-collapsed:hover [data-arrow] {
    display: block !important;
}

/* ============================ */
/* HOVER EFFECT                */
/* ============================ */

.menu-link:hover {
    background: rgba(255,255,255,0.1);
    padding-left: 1.3rem !important;
}

.sidebar-collapsed .menu-link:hover {
    padding-left: 0 !important;
}

.sidebar-collapsed:hover .menu-link:hover {
    padding-left: 1.3rem !important;
}

/* ============================ */
/* LOGO FIX                    */
/* ============================ */

.sidebar-collapsed .logo-area {
    justify-content: center !important;
}

.sidebar-collapsed:hover .logo-area {
    justify-content: space-between !important;
}

/* ============================ */
/* USER INFO FIX               */
/* ============================ */

.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.sidebar-collapsed .user-info {
    justify-content: center !important;
}

.sidebar-collapsed:hover .user-info {
    justify-content: flex-start !important;
}

/* Icon rotation */
.rotate-180 {
    transform: rotate(180deg);
}

        
    </style>

</head>

<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 flex flex-col shadow-xl text-white transition-all duration-300" style="background: linear-gradient(to bottom, #9333ea, #2563eb, #4338ca) !important;">
            <!-- Logo & Toggle -->
            <div class="p-4 border-b border-white/20 flex items-center justify-between">
                <h1 class="text-lg font-bold flex items-center gap-2 tracking-wide menu-text">
                    <svg class="w-6 h-6 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    <span class="menu-text">Royal Restaurant</span>
                </h1>
                <button onclick="toggleSidebar()" class="p-1.5 rounded-lg hover:bg-white/10 transition-colors">
    <svg id="sidebarToggleIcon"
         class="w-5 h-5 text-white transition-transform duration-300"
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 19l-7-7 7-7" />
    </svg>
</button>

            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                @php
                    $currentRoute = request()->route()->getName();
                    $isActive = fn($route) => str_starts_with($currentRoute, $route) ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white';
                @endphp

                @if(Auth::user()->role_id == 1)
                    <a href="{{ route('admin.dashboard') }}" class="menu-link flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 {{ str_starts_with($currentRoute, 'admin.dashboard') ? 'active-item' : '' }}">
                        <svg class="w-5 h-5 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"
          d="M3 3h7v7H3V3zm11 0h7v4h-7V3zM3 14h4v7H3v-7zm8 0h10v7H11v-7z"/>
</svg>

                        <span class="menu-text">Tổng quan</span>
                    </a>
                @endif

                @if(Auth::user()->role_id == 1)
                    <div class="pt-3">
                        <button onclick="toggleSubmenu('submenu-thucdon')" class="menu-link w-full flex items-center justify-between gap-3 px-4 py-3 rounded-lg text-white/90">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                                <span class="menu-text text-xs font-semibold uppercase tracking-wide">Thực đơn</span>
                            </div>
                           <svg data-arrow="submenu-thucdon"
     class="w-3 h-3 text-white/80 transition-transform duration-300
     {{ str_starts_with($currentRoute, 'admin.categories') || str_starts_with($currentRoute, 'admin.foods') ? 'rotate-180' : '' }}"
     fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M19 9l-7 7-7-7"/>
</svg>


                        </button>
                        <div id="submenu-thucdon" class="submenu {{ str_starts_with($currentRoute, 'admin.categories') || str_starts_with($currentRoute, 'admin.foods') ? 'open' : '' }}">
                            <div class="pl-4 pt-1 space-y-1">
                                <a href="{{ route('admin.categories.index') }}" class="menu-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white/90 {{ str_starts_with($currentRoute, 'admin.categories') ? 'active-item' : '' }}">
                                    <svg class="w-5 h-5 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M4 3v6a2 2 0 002 2h1v10h2V11h1a2 2 0 002-2V3h-2v6h-2V3H8zm10 0h2v18h-2V3zm4 5h2v13h-2V8z"/>
</svg>

                                    <span class="menu-text">Danh mục món</span>
                                </a>
                                <a href="{{ route('admin.foods.index') }}" class="menu-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white/90 {{ str_starts_with($currentRoute, 'admin.foods') ? 'active-item' : '' }}">
                                    <svg class="w-5 h-5 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                    </svg>
                                    <span class="menu-text">Món ăn</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('admin.users.index') }}" class="menu-link flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 {{ str_starts_with($currentRoute, 'admin.users') ? 'active-item' : '' }}">
                        <svg class="w-5 h-5 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="menu-text">Người dùng</span>
                    </a>
                @endif

                {{-- ADMIN: role_id = 1 --}}
                @if(Auth::user()->role_id == 1)
                    <a href="{{ route('admin.tables.index') }}" class="menu-link flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 {{ str_starts_with($currentRoute, 'admin.tables') ? 'active-item' : '' }}">
                        <svg class="w-5 h-5 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
          d="M3 21v-6m18 6v-6M3 10h18M7 21v-11h10v11M9 3v3m6-3v3"/>
</svg>

                        <span class="menu-text">Bàn</span>
                    </a>
                    <a href="{{ route('admin.reservations.index') }}" class="menu-link flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 {{ str_starts_with($currentRoute, 'admin.reservations') ? 'active-item' : '' }}">
                        <svg class="w-5 h-5 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="menu-text">Đặt bàn</span>
                    </a>
                    <a href="{{ route('waiter.orders.index') }}" class="menu-link flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 {{ str_starts_with($currentRoute, 'waiter.orders') ? 'active-item' : '' }}">
                       <svg class="w-5 h-5 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
          d="M3 17h18m-9-11a6 6 0 016 6H6a6 6 0 016-6zm0-3v3"/>
</svg>

                        <span class="menu-text">Màn hình Phục vụ</span>
                    </a>
                @endif

                {{-- WAITER: role_id = 3 --}}
                @if(Auth::user()->role_id == 3)
                    <a href="{{ route('waiter.orders.index') }}" class="menu-link flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 {{ str_starts_with($currentRoute, 'waiter.orders') ? 'active-item' : '' }}">
                        <svg class="w-5 h-5 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
          d="M3 17h18m-9-11a6 6 0 016 6H6a6 6 0 016-6zm0-3v3"/>
</svg>

                        <span class="menu-text">Màn hình Phục vụ</span>
                    </a>
                @endif

                @if(in_array(Auth::user()->role_id, [1, 2]))
                    <a href="{{ route('cashier.orders.index') }}" class="menu-link flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 {{ str_starts_with($currentRoute, 'cashier.orders') ? 'active-item' : '' }}">
                        <svg class="w-5 h-5 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="menu-text">Màn hình Thu ngân</span>
                    </a>
                @endif

                @if(in_array(Auth::user()->role_id, [1, 4]))
                    <a href="{{ route('kitchen.orders.index') }}" class="menu-link flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 {{ str_starts_with($currentRoute, 'kitchen.orders') ? 'active-item' : '' }}">
                        <svg class="w-5 h-5 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
          d="M6.5 10.5v7.5a2 2 0 002 2h7a2 2 0 002-2v-7.5M4 10.5h16M12 3c-2.7 0-5 2-5 4.5 0 .6.1 1.1.3 1.6h9.4c.2-.5.3-1 .3-1.6C17 5 14.7 3 12 3z"/>
</svg>

                        <span class="menu-text">Màn hình Bếp</span>
                    </a>
                @endif

                @if(Auth::user()->role_id == 1)
                    <a href="{{ route('admin.reports.index') }}" class="menu-link flex items-center gap-3 px-4 py-3 rounded-lg text-white/90 {{ str_starts_with($currentRoute, 'admin.reports') ? 'active-item' : '' }}">
                        <svg class="w-5 h-5 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="menu-text">Báo cáo</span>
                    </a>
                @endif
            </nav>

            <!-- User Info Footer -->
            <div class="p-4 border-t border-white/20 bg-white/5">
                <div class="user-info flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10 transition-all">
                    <div class="w-10 h-10 rounded-full bg-white/20 text-white font-bold flex items-center justify-center backdrop-blur-sm flex-shrink-0">
                        <span class="text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0 menu-text">
                        <p class="text-sm font-medium truncate text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white/70 truncate">{{ auth()->user()->role->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <script>
                // Toggle sidebar collapsed state (click button)
                function toggleSidebar() {
                    const sidebar = document.getElementById("sidebar");
                    const icon = document.getElementById("sidebarToggleIcon");
                    
                    sidebar.classList.toggle("sidebar-collapsed");
                    icon.classList.toggle("rotate-180");
                }

                // Toggle submenu (for "Thực đơn" section)
                function toggleSubmenu(id) {
                    const el = document.getElementById(id);
                    const arrow = document.querySelector(`[data-arrow="${id}"]`);
                    
                    el.classList.toggle("open");
                    arrow.classList.toggle("rotate-180");
                }
            </script>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                        @hasSection('breadcrumb')
                            <nav class="mt-1 text-sm text-gray-500">
                                @yield('breadcrumb')
                            </nav>
                        @endif
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                            {{ ucfirst(auth()->user()->role->name ?? 'N/A') }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-800 transition">
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

