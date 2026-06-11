<!DOCTYPE html>
<html>
<head>
    <title>Register - GarasiGamer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center min-h-screen">
    <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl w-full max-w-md p-8 m-4">
        <div class="text-center mb-6">
            <i class="fas fa-gamepad text-5xl text-indigo-600"></i>
            <h1 class="text-2xl font-bold mt-2 text-gray-800">Daftar Akun Admin</h1>
            <p class="text-gray-500">GarasiGamer - Rental PS</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('email')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required
                       class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('password')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                       class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 rounded-lg transition">
                Daftar sebagai Admin
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-indigo-600 text-sm">Sudah punya akun? Login</a>
        </div>
        <p class="text-xs text-center text-gray-400 mt-6">Setelah daftar, Anda langsung bisa login sebagai admin.</p>
    </div>
</body>
</html>
