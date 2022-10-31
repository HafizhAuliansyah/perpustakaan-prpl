<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class PeminjamanSeeder extends Seeder
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
            $peminjaman = new Peminjaman();
            $peminjaman->IDPeminjaman = "D".date("dmY").strval(000 + $i);
            $peminjaman->IDBuku = "P".date("dmY").strval(000 + $i);
            $peminjaman->NIK = $faker->unique()->numberBetween(1000000000000000, 1000000000000010);
            $peminjaman->TglPeminjaman = "31-10-2022";
            $peminjaman->StatusPeminjaman = "belum kembali";
            $peminjaman->TglPengembalian = "31-10-2022";
            $peminjaman->save();
        }
    }
}
