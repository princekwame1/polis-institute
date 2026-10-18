<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Create the first admin account from the ADMIN_* values in .env.
     *
     * An existing account with the same email is left untouched, so
     * re-running the seeder never resets a password changed in the dashboard.
     */
    public function run(): void
    {
        $admin = config('prolis.admin');
        $password = $admin['password'] ?: Str::password(16, symbols: false);

        $user = User::firstOrCreate(
            ['email' => $admin['email']],
            [
                'name' => $admin['name'],
                'password' => $password,
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
        );

        if (! $user->wasRecentlyCreated) {
            $this->command?->info("Admin account {$admin['email']} already exists. Left unchanged.");

            return;
        }

        $this->command?->info("Admin account created: {$admin['email']}");

        if (! $admin['password']) {
            $this->command?->warn("No ADMIN_PASSWORD set in .env. Generated password: {$password}");
        }
    }
}
