<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class LocalTestAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! app()->environment('local')) {
            throw new RuntimeException('Local test accounts may only be seeded locally.');
        }
        $accounts = [
            ['role' => 'student', 'name' => 'Alex Rivera', 'email' => 'student@example.test', 'student_id' => 'TEST-STU-001', 'employee_id' => null, 'password' => env('TEST_STUDENT_PASSWORD')],
            ['role' => 'teacher', 'name' => 'Prof. Mira Santos', 'email' => 'teacher@example.test', 'student_id' => null, 'employee_id' => 'TEST-TCH-001', 'password' => env('TEST_TEACHER_PASSWORD')],
            ['role' => 'admin', 'name' => 'System Administrator', 'username' => 'tidmac', 'email' => 'admin@example.test', 'student_id' => null, 'employee_id' => null, 'password' => env('TEST_ADMIN_PASSWORD')],
        ];
        foreach ($accounts as $account) {
            if (! is_string($account['password']) || strlen($account['password']) < 12) {
                throw new RuntimeException('Set all TEST_*_PASSWORD environment values to at least 12 characters.');
            }
            User::updateOrCreate(['email' => $account['email']], [...$account, 'password' => Hash::make($account['password'])]);
        }
    }
}
