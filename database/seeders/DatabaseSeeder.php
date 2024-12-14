<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
            'password'=>123456,
        ]);
        $users = User::factory(10)->create();

        Ticket::factory(100)->recycle($users)->create();
        User::create([
            'name'  => 'The Manager',
            'email' => 'manager@example.com',
            'password'=>bcrypt(123),
            'is_manager'=>true,
        ]);
    }
}
