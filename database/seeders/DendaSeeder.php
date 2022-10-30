<?php

namespace Database\Seeders;

use App\Models\Denda;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class DendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for($i = 1; $i <= 10; $i++){
            $denda = new Denda();
            $denda->IDDenda = "D".date("dmY").strval(000 + $i);
            $denda->IDPeminjaman = "P".date("dmY").strval(000 + $i);
            $denda->Keterangan = 'active';
            $denda->Nominal = $faker->unique()->numberBetween(100000, 200000);
            $denda->save();
        }
    }
}
