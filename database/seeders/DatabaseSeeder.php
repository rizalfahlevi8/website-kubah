<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User admin & operator gudang kubah masjid
        User::updateOrCreate(
            ['email' => 'admin@kubahmasjid.com'],
            [
                'name' => 'Admin Kubah Masjid',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'gudang@kubahmasjid.com'],
            [
                'name' => 'Operator Gudang Kubah',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Seeder barang dan mutasi stok kubah masjid
        $this->call([
            ItemSeeder::class,
            StockMovementSeeder::class,
        ]);
    }
}
