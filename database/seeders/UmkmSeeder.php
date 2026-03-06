<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create a couple of sample UMKM entries (one verified, one pending)
        \App\Models\Umkm::factory()->create(['is_verified' => true]);
        \App\Models\Umkm::factory()->create(['is_verified' => false]);
    }
}
