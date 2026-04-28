<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Teacher
        $teacherUser = User::updateOrCreate(
            ['email' => 'teacher@gmail.com'],
            [
                'name' => 'Default Teacher',
                'password' => Hash::make('teacher@#12'),
                'role' => 'teacher',
                'access_status' => 'active',
                'account_start_date' => now(),
            ]
        );

        \App\Models\Teacher::updateOrCreate(
            ['user_id' => $teacherUser->id],
            [
                'first_name' => 'Default',
                'last_name' => 'Teacher',
                'employee_id' => 'EMP001',
                'email' => 'teacher@gmail.com',
                'status' => 'active',
                'designation' => 'Senior Teacher',
                'salary_amount' => 50000,
            ]
        );

        // 2. Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('super@#12'),
                'role' => 'super_admin',
                'access_status' => 'active',
                'account_start_date' => now(),
            ]
        );

        // 3. School Management (School Admin)
        User::updateOrCreate(
            ['email' => 'management@gmail.com'],
            [
                'name' => 'School Management',
                'password' => Hash::make('management@#12'),
                'role' => 'school_admin',
                'access_status' => 'active',
                'account_start_date' => now(),
            ]
        );
    }
}
