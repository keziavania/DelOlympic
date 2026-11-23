<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database dengan akun demo untuk tiap role.
     * 
     * Akun demo untuk testing:
     *   Admin       : admin@delolympic.id    / password123
     *   Penyelenggara: panitia@delolympic.id / password123
     *   Peserta     : peserta@delolympic.id  / password123
     */
    public function run(): void
    {
        // ========= AKUN ADMIN =========
        User::firstOrCreate(
            ['email' => 'admin@delolympic.id'],
            [
                'name'        => 'Administrator Del Olympic',
                'password'    => Hash::make('password123'),
                'role'        => 'admin',
                'status_akun' => 'aktif',
            ]
        );

        // ========= AKUN PENYELENGGARA =========
        User::firstOrCreate(
            ['email' => 'panitia@delolympic.id'],
            [
                'name'        => 'Panitia POSI IT Del',
                'password'    => Hash::make('password123'),
                'role'        => 'penyelenggara',
                'status_akun' => 'aktif',
            ]
        );

        // ========= AKUN PESERTA =========
        User::firstOrCreate(
            ['email' => 'peserta@delolympic.id'],
            [
                'name'        => 'Mahasiswa Del',
                'password'    => Hash::make('password123'),
                'role'        => 'peserta',
                'status_akun' => 'aktif',
            ]
        );

        // ========= AKUN PESERTA (status menunggu, untuk testing) =========
        User::firstOrCreate(
            ['email' => 'pending@delolympic.id'],
            [
                'name'        => 'Akun Menunggu Approval',
                'password'    => Hash::make('password123'),
                'role'        => 'peserta',
                'status_akun' => 'menunggu',
            ]
        );

        $this->command->info('✅ Seeder berhasil! Akun demo telah dibuat.');
        $this->command->table(
            ['Role', 'Email', 'Password', 'Status'],
            [
                ['Admin',         'admin@delolympic.id',   'password123', 'aktif'],
                ['Penyelenggara', 'panitia@delolympic.id', 'password123', 'aktif'],
                ['Peserta',       'peserta@delolympic.id', 'password123', 'aktif'],
                ['Peserta',       'pending@delolympic.id', 'password123', 'menunggu'],
            ]
        );
    }
}
