<!DOCTYPE html>
<html>
<head>
    <title>Login - GarasiGamer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center min-h-screen">
    <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl w-full max-w-md p-8 m-4">
        <div class="text-center mb-6">
            <i class="fas fa-gamepad text-5xl text-indigo-600"></i>
            <h1 class="text-2xl font-bold mt-2 text-gray-800">GarasiGamer</h1>
            <p class="text-gray-500">Rental PS Premium</p>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="mt-1 w-full border rounded-lg px-3 py-2" required autofocus>
                @error('email')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-lg">Masuk Dashboard</button>
        </form>
        <p class="text-xs text-center text-gray-400 mt-6">Demo: admin@garasigamer.com / admin123</p>
        <div class="text-center mt-3"><a href="{{ route('register') }}" class="text-indigo-600 text-sm">Buat Akun Admin Baru</a></div>
    </div>
</body>
</html>
