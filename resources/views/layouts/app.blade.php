<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'School Management ERP')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 3px solid #818cf8;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .print-full {
                width: 100% !important;
                margin: 0 !important;
            }
        }
    </style>
</head>

<body class="bg-[#f1f5f9] font-sans min-h-screen">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-[#1e1b4b] to-[#312e81] text-white transform transition-transform duration-300 lg:translate-x-0 -translate-x-full no-print">
            {{-- Logo --}}
            <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-xl text-indigo-300"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold tracking-tight">
                        @if(Auth::user()->isSuperAdmin())
                            Super Admin
                        @else
                            {{ \App\Models\Setting::get('school_name', 'Gorkhabyte Academy') }}
                        @endif
                    </h1>
                    <p class="text-xs text-indigo-300">Management System</p>
                </div>
            </div>

            {{-- User Info --}}
            <div class="px-6 py-4 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-full bg-indigo-500/30 flex items-center justify-center text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-indigo-300 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="px-3 py-4 space-y-1 overflow-y-auto max-h-[calc(100vh-200px)]">
                @if(Auth::user()->isSuperAdmin())
                    <a href="{{ route('super_admin.dashboard') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('super_admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('super_admin.users.index') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('super_admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog w-5"></i> User Management
                    </a>
                @endif

                @if(Auth::user()->isSuperAdmin() || Auth::user()->isSchoolAdmin())
                    <a href="{{ route('super_admin.settings.index') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('super_admin.settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog w-5"></i> General Settings
                    </a>
                @endif

                @if(Auth::user()->isSchoolAdmin())
                    <a href="{{ route('school_admin.dashboard') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('school_admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt w-5"></i> Dashboard
                    </a>
                @elseif(Auth::user()->isTeacher())
                    <a href="{{ route('teacher.dashboard') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt w-5"></i> Dashboard
                    </a>
                @endif

                @if(Auth::user()->isSchoolAdmin())
                    <div class="pt-3 pb-1 px-4">
                        <p class="text-xs font-semibold text-indigo-400 uppercase tracking-wider">Academic</p>
                    </div>
                    <a href="{{ route('students.index') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate w-5"></i> Students
                    </a>
                    <a href="{{ route('teachers.index') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher w-5"></i> Teachers
                    </a>
                    <a href="{{ route('classes.index') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                        <i class="fas fa-school w-5"></i> Classes
                    </a>
                    <a href="{{ route('sections.index') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('sections.*') ? 'active' : '' }}">
                        <i class="fas fa-layer-group w-5"></i> Sections
                    </a>
                    <a href="{{ route('subjects.index') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                        <i class="fas fa-book w-5"></i> Subjects
                    </a>
                @endif

                @if(Auth::user()->isSchoolAdmin() || Auth::user()->isTeacher())
                    <div class="pt-3 pb-1 px-4">
                        <p class="text-xs font-semibold text-indigo-400 uppercase tracking-wider">Operations</p>
                    </div>
                    <a href="{{ route('attendance.student') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-check w-5"></i> Attendance
                    </a>

                    @if(!Auth::user()->isTeacher())
                        <a href="{{ route('exams.index') }}"
                            class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('exams.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt w-5"></i> Examinations
                        </a>
                    @endif

                    <a href="{{ route('routines.class') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('routines.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt w-5"></i> Routines
                    </a>
                    <a href="{{ route('notices.index') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('notices.*') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn w-5"></i> Notices
                    </a>
                @endif

                @if(Auth::user()->isSchoolAdmin())
                    <div class="pt-3 pb-1 px-4">
                        <p class="text-xs font-semibold text-indigo-400 uppercase tracking-wider">Finance</p>
                    </div>
                    <a href="{{ route('fees.invoices') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('fees.*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar w-5"></i> Fee & Billing
                    </a>
                    <a href="{{ route('salary.index') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('salary.*') ? 'active' : '' }}">
                        <i class="fas fa-money-check-alt w-5"></i> Salary
                    </a>
                    <a href="{{ route('accounts.index') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie w-5"></i> Accounts
                    </a>

                    <div class="pt-3 pb-1 px-4">
                        <p class="text-xs font-semibold text-indigo-400 uppercase tracking-wider">Documents</p>
                    </div>
                    <a href="{{ route('certificates.index') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition {{ request()->routeIs('certificates.*') ? 'active' : '' }}">
                        <i class="fas fa-certificate w-5"></i> Certificates
                    </a>
                @endif
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 lg:ml-64">
            {{-- Top Bar --}}
            <header class="sticky top-0 z-40 bg-white border-b border-gray-200 no-print">
                <div class="flex items-center justify-between px-6 py-3">
                    <div class="flex items-center gap-4">
                        <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')"
                            class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-bars text-gray-600"></i>
                        </button>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                            <p class="text-xs text-gray-500">@yield('page-description', '')</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500 hidden md:block">{{ now()->format('D, M d Y') }}</span>
                        <div class="relative">
                            <div class="flex items-center gap-3 cursor-pointer"
                                onclick="document.getElementById('userDropdown').classList.toggle('hidden')">
                                <div
                                    class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                            </div>
                            <div id="userDropdown"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mx-6 mt-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center gap-2"
                    id="flash-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button onclick="this.parentElement.remove()" class="ml-auto"><i class="fas fa-times"></i></button>
                </div>
            @endif
            @if(session('error'))
                <div
                    class="mx-6 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button onclick="this.parentElement.remove()" class="ml-auto"><i class="fas fa-times"></i></button>
                </div>
            @endif
            @if($errors->any())
                <div class="mx-6 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Page Content --}}
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Auto-hide flash messages
        setTimeout(() => { const el = document.getElementById('flash-success'); if (el) el.remove(); }, 5000);
        // Close dropdown on outside click
        document.addEventListener('click', function (e) {
            const dd = document.getElementById('userDropdown');
            if (dd && !e.target.closest('.relative')) dd.classList.add('hidden');
        });
    </script>
    @stack('scripts')
</body>

</html>