<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School Management ERP</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen bg-gradient-to-br from-indigo-950 via-indigo-900 to-purple-900 flex items-center justify-center p-4 font-sans">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 rounded-full bg-purple-500/10 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 rounded-full bg-indigo-500/10 blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm mb-4">
                <i class="fas fa-graduation-cap text-3xl text-indigo-300"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">Gorkhabyte Academy</h1>
            <p class="text-indigo-300 mt-1">School Management System</p>
        </div>

        <div class="bg-white/10 backdrop-blur-xl rounded-2xl border border-white/20 p-8 shadow-2xl">
            <h2 class="text-xl font-semibold text-white mb-1">Welcome Back</h2>
            <p class="text-indigo-300 text-sm mb-6">Sign in to your account</p>

            @if(session('error'))
                <div
                    class="mb-4 px-4 py-3 bg-red-500/20 border border-red-400/30 text-red-200 rounded-xl text-sm flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div
                    class="mb-4 px-4 py-3 bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 rounded-xl text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-indigo-200 mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-indigo-400"><i
                                class="fas fa-envelope"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-11 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition"
                            placeholder="Enter your email" id="login-email">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-indigo-200 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-indigo-400"><i
                                class="fas fa-lock"></i></span>
                        <input type="password" name="password" required
                            class="w-full pl-11 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition"
                            placeholder="Enter your password" id="login-password">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-indigo-200 cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="rounded bg-white/10 border-white/20 text-indigo-500 focus:ring-indigo-400">
                        Remember me
                    </label>
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-indigo-300 hover:text-white transition">Forgot password?</a>
                </div>

                <button type="submit" id="login-submit"
                    class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl transition shadow-lg shadow-indigo-600/30 flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>
        </div>

        <p class="text-center mt-6 text-indigo-400 text-sm">&copy; {{ date('Y') }} Gorkhabyte Academy. All rights
            reserved.</p>
    </div>
</body>

</html>