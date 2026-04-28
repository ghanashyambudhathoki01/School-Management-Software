<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin account
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('super@#12'),
                'role' => 'super_admin',
                'access_status' => 'active',
                'account_start_date' => now(),
                'account_expiry_date' => null, // Super admin never expires
                'phone' => '9800000000',
            ]
        );

        // Create School Management (Admin) account
        $management = User::updateOrCreate(
            ['email' => 'management@gmail.com'],
            [
                'name' => 'School Management',
                'password' => Hash::make('management@#12'),
                'role' => 'school_admin',
                'access_status' => 'active',
                'account_start_date' => now(),
                'account_expiry_date' => now()->addYear(),
                'access_duration' => 365,
                'phone' => '9800000001',
            ]
        );

        // Create Teacher account
        $teacherUser = User::updateOrCreate(
            ['email' => 'teacher@gmail.com'],
            [
                'name' => 'Default Teacher',
                'password' => Hash::make('teacher@#12'),
                'role' => 'teacher',
                'access_status' => 'active',
                'account_start_date' => now(),
                'account_expiry_date' => now()->addYear(),
                'access_duration' => 365,
                'phone' => '9800000002',
            ]
        );

        // Ensure Teacher profile exists for the teacher user
        \App\Models\Teacher::updateOrCreate(
            ['user_id' => $teacherUser->id],
            [
                'employee_id' => 'EMP-' . str_pad($teacherUser->id, 5, '0', STR_PAD_LEFT),
                'first_name' => 'Default',
                'last_name' => 'Teacher',
                'email' => $teacherUser->email,
                'phone' => $teacherUser->phone,
                'joining_date' => now(),
                'status' => 'active',
            ]
        );
    }
}
