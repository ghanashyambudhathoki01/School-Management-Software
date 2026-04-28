<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - School Management ERP</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen bg-gradient-to-br from-indigo-950 via-indigo-900 to-purple-900 flex items-center justify-center p-4 font-sans">
    <div class="relative w-full max-w-md">
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm mb-4">
                <i class="fas fa-graduation-cap text-3xl text-indigo-300"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">Gorkhabyte Academy</h1>
        </div>
        <div class="bg-white/10 backdrop-blur-xl rounded-2xl border border-white/20 p-8 shadow-2xl">
            <h2 class="text-xl font-semibold text-white mb-1">Forgot Password</h2>
            <p class="text-indigo-300 text-sm mb-6">Enter your email to receive a reset link</p>
            @if(session('success'))
                <div
                    class="mb-4 px-4 py-3 bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 rounded-xl text-sm">
                    {{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-indigo-200 mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                        placeholder="Enter your email">
                    @error('email')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                </div>
                <button type="submit"
                    class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl transition shadow-lg">Send
                    Reset Link</button>
            </form>
            <p class="mt-4 text-center"><a href="{{ route('login') }}"
                    class="text-indigo-300 hover:text-white text-sm transition"><i class="fas fa-arrow-left mr-1"></i>
                    Back to Login</a></p>
        </div>
    </div>
</body>

</html>