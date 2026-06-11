<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GarasiGamer - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="relative min-h-screen">
        <!-- Sidebar -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black/50 z-30" @click="sidebarOpen = false"></div>
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed top-0 left-0 h-full w-72 bg-slate-800 text-white shadow-xl z-40 transition-transform duration-300">
            <div class="p-5 border-b border-slate-700 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <i class="fas fa-gamepad text-2xl text-indigo-400"></i>
                    <span class="font-bold text-xl">GarasiGamer</span>
                </div>
                <button @click="sidebarOpen = false" class="text-gray-300 hover:text-white"><i class="fas fa-times text-xl"></i></button>
            </div>
            <nav class="mt-6 px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-700 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-700' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i> Dashboard PS
                </a>
                <a href="{{ route('admin.ps-types.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-700 {{ request()->routeIs('admin.ps-types.*') ? 'bg-slate-700' : '' }}">
                    <i class="fas fa-microchip w-5"></i> Tipe PS & Stok
                </a>
                <a href="{{ route('admin.games.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-700 {{ request()->routeIs('admin.games.*') ? 'bg-slate-700' : '' }}">
                    <i class="fas fa-gamepad w-5"></i> Daftar Game
                </a>
                <a href="{{ route('admin.rentals.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-700 {{ request()->routeIs('admin.rentals.create') ? 'bg-slate-700' : '' }}">
                    <i class="fas fa-calculator w-5"></i> Sewa PS
                </a>
                <a href="{{ route('admin.rentals.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-700 {{ request()->routeIs('admin.rentals.history') ? 'bg-slate-700' : '' }}">
                    <i class="fas fa-history w-5"></i> Riwayat Transaksi
                </a>
            </nav>
            <div class="absolute bottom-6 left-0 w-full px-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-red-600/80 hover:bg-red-700 py-2 rounded-lg flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Main content -->
        <div class="ml-0">
            <div class="bg-white shadow-sm p-4 flex items-center justify-between">
                <button @click="sidebarOpen = true" class="text-gray-700 text-2xl focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex items-center gap-3">
                    <i class="fas fa-user-shield text-indigo-600"></i>
                    <span class="text-sm text-gray-700">Admin: {{ Auth::user()->name }}</span>
                </div>
            </div>
            <div class="p-5 md:p-6">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">{{ session('error') }}</div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <script src="//unpkg.com/alpinejs" defer></script>
    @stack('scripts')
</body>
</html>
