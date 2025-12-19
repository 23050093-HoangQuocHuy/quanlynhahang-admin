<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Quản lý Nhà hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-500 via-blue-500 to-indigo-600 flex items-center justify-center p-4">
    <div class="w-full max-w-4xl">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
            <!-- Left Column - Login Form -->
            <div class="w-full md:w-1/2 p-8 md:p-12">
                <div class="max-w-sm mx-auto">
                    <!-- Heading -->
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">
                            👋 Chào mừng bạn trở lại!
                        </h1>
                        <p class="text-gray-600 text-lg">
                            Đăng nhập hệ thống Quản lý Nhà hàng
                        </p>
                    </div>

                    <!-- Error Message -->
                    @if (session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                {{ session('error') }}
                            </p>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required
                                autofocus
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 outline-none"
                                placeholder="Nhập email của bạn"
                            >
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Mật khẩu
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 outline-none"
                                placeholder="Nhập mật khẩu của bạn"
                            >
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit" 
                            class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition duration-200 shadow-lg hover:shadow-xl"
                        >
                            Đăng nhập
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Column - Illustration -->
            <div class="w-full md:w-1/2 bg-gradient-to-br from-purple-600 to-blue-600 p-8 md:p-12 flex items-center justify-center">
                <div class="text-center text-white">
                    <div class="mb-6">
                        <img 
                            src=https://i.pinimg.com/originals/e5/7b/98/e57b987df5b29f59db3eb669499154ee.jpg 
                            alt="Restaurant illustration" 
                            class="w-64 h-64 mx-auto rounded-full object-cover shadow-2xl"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                        >
                        <div style="display: none;" class="w-64 h-64 mx-auto rounded-full bg-white/20 flex items-center justify-center">
                            <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold mb-2">Quản lý hiệu quả</h2>
                    <p class="text-purple-100">Hệ thống quản lý nhà hàng chuyên nghiệp</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
