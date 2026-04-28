<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="max-w-5xl mx-auto p-6">

        <!-- Header -->
        <h1 class="text-4xl font-bold mb-2">🎓 School Management ERP</h1>
        <p class="text-gray-600 mb-6">
            A production-grade School Management ERP built with Laravel 12, MySQL, and Tailwind CSS.
        </p>

        <!-- Getting Started -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-3">🚀 Getting Started</h2>

            <h3 class="font-semibold mt-4">1. Install Dependencies</h3>
            <pre class="bg-gray-900 text-green-400 p-4 rounded overflow-x-auto"><code>composer install
npm install</code></pre>

            <h3 class="font-semibold mt-4">2. Environment Setup</h3>
            <pre class="bg-gray-900 text-green-400 p-4 rounded overflow-x-auto"><code>cp .env.example .env
php artisan key:generate</code></pre>

            <h3 class="font-semibold mt-4">3. Database Setup</h3>
            <pre class="bg-gray-900 text-green-400 p-4 rounded overflow-x-auto"><code>php artisan migrate --seed</code></pre>

            <p class="mt-2"><strong>Default Admin:</strong> admin@gorkhabyteacademy.com / password</p>

            <h3 class="font-semibold mt-4">4. Run Application</h3>
            <pre class="bg-gray-900 text-green-400 p-4 rounded overflow-x-auto"><code>php artisan serve
npm run dev</code></pre>

            <h3 class="font-semibold mt-4">5. Storage Link</h3>
            <pre class="bg-gray-900 text-green-400 p-4 rounded overflow-x-auto"><code>php artisan storage:link</code></pre>
        </section>

        <!-- Modules -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-3">🛠️ Core Modules</h2>
            <ul class="list-disc pl-6 space-y-1">
                <li><strong>Super Admin:</strong> User management & subscription control</li>
                <li><strong>Academic:</strong> Students, teachers, attendance, timetable, exams</li>
                <li><strong>Finance:</strong> Fees, payroll, accounting</li>
                <li><strong>Documents:</strong> Notices & certificate generation</li>
            </ul>
        </section>

        <!-- Features -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-3">🔒 Features</h2>

            <div class="grid md:grid-cols-2 gap-6">

                <div>
                    <h3 class="font-semibold mb-2">🔐 Security & Access</h3>
                    <ul class="list-disc pl-6 text-sm space-y-1">
                        <li>Role-Based Access Control (RBAC)</li>
                        <li>Multi-user system</li>
                        <li>Data encryption</li>
                        <li>Cloud-based access</li>
                        <li>High uptime system</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">🎓 Student Management</h3>
                    <ul class="list-disc pl-6 text-sm space-y-1">
                        <li>Student Information System (SIS)</li>
                        <li>Academic & behavior tracking</li>
                        <li>Certificate generation</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">👨‍🏫 Staff & Payroll</h3>
                    <ul class="list-disc pl-6 text-sm space-y-1">
                        <li>Teacher & staff management</li>
                        <li>Payroll management & automation</li>
                        <li>Attendance management</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">📅 Academic Operations</h3>
                    <ul class="list-disc pl-6 text-sm space-y-1">
                        <li>Timetable & scheduling</li>
                        <li>Exam planning system</li>
                        <li>Real-time attendance reports</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">💰 Finance</h3>
                    <ul class="list-disc pl-6 text-sm space-y-1">
                        <li>Fee management</li>
                        <li>Online payments</li>
                        <li>Invoice generation</li>
                        <li>Financial reports</li>
                        <li>Fine management</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">📦 Inventory</h3>
                    <ul class="list-disc pl-6 text-sm space-y-1">
                        <li>Inventory & asset management</li>
                        <li>Stock tracking</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">📊 Analytics</h3>
                    <ul class="list-disc pl-6 text-sm space-y-1">
                        <li>Analytics dashboard</li>
                        <li>Custom reports</li>
                        <li>Performance insights</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">📱 Communication</h3>
                    <ul class="list-disc pl-6 text-sm space-y-1">
                        <li>SMS & email notifications</li>
                        <li>Mobile app support</li>
                        <li>24/7 support</li>
                    </ul>
                </div>

            </div>
        </section>

        <!-- Tech Stack -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-3">⚙️ Tech Stack</h2>
            <ul class="list-disc pl-6">
                <li>Laravel 12</li>
                <li>MySQL</li>
                <li>Tailwind CSS</li>
                <li>Vite</li>
            </ul>
        </section>

        <!-- Footer -->
        <footer class="text-center text-gray-500 text-sm mt-10">
            © 2026 School Management ERP. All rights reserved.
        </footer>

    </div>

</body>
</html>