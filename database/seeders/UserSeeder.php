<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $admin = User::create([
            'user_name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456789@'),
            'role' => 'admin'
        ]);

        if ($admin) {
            Profile::create(['user_id' => $admin->id]);
        }
    }
}
