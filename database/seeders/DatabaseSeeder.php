<?php

namespace Database\Seeders;

use App\Models\Karyawan;
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
        // User::factory(10)->create();

        Karyawan::create([
            'nik' => '12345678',
            'nama_lengkap' => 'Wildan',
            'jabatan' => 'Jenderal',
            'no_hp' => '08123456789',
            'password' => bcrypt('wildan1234'),
            'remember_token' => 'null',
        ]);
    }
}
