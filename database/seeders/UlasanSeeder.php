<?php

namespace Database\Seeders;
use App\Models\Ulasan;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UlasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for($i = 0; $i < 2000; $i++){
            $ulasan = new Ulasan();
            $ulasan->masukan = $faker->text;
            $ulasan->save();
        }
    }
}
