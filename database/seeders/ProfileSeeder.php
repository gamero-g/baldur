<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profiles')->insert([
            [
                'perfil_id' => 1,
                'usuario_fk' => 1,
                'avatar' => 'baldurs-3.webp',
                'direccion' => 'Calle inventada 123'
            ],
            [
                'perfil_id' => 2,
                'usuario_fk' => 2,
                'avatar' => 'bg-2.webp',
                'direccion' => 'Ojala me vaya bien 123'
            ],
        ]);
    }
}
