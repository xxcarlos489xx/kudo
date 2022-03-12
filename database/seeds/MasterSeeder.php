<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'id'        =>  DB::raw('uuid()'),
            'nombres'   => 'Admin Kudo',
            'estado'    => 1,
            'email'     => 'admin_two@kudo.pe',
            'fecha_nacimiento'  => '1989-11-01',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10)
        ]);
        DB::table('usuarios')->insert([
            'id'        =>  DB::raw('uuid()'),
            'nombres'   => 'Test Kudo',
            'estado'    => 1,
            'email'     => 'test@kudo.pe',
            'fecha_nacimiento'  => '1989-11-01',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10)
        ]);
    }
}
