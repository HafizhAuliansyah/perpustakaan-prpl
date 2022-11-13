<?php

namespace Database\Seeders;

use App\Models\Buku;
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
            // Random IDBuku
            $random_idbuku = "B".date("dmY")."00000";
            $random_num = rand(1, 1000);
            $counterlen = strlen((string)$random_num);
            $random_idbuku = substr_replace($random_idbuku, (string)$random_num, $counterlen * -1);

            $peminjaman = new Peminjaman();
            $peminjaman->IDPeminjaman = "D".date("dmY").strval(000 + $i);
            $peminjaman->IDBuku = $random_idbuku;
            $peminjaman->NIK = $faker->unique()->numberBetween(1000000000000001, 1000000000000010);
            $peminjaman->TglPeminjaman = "31-10-2022";
            $peminjaman->StatusPeminjaman = "belum kembali";
            $peminjaman->TglPengembalian = "31-10-2022";
            $peminjaman->save();

            // Update Status Buku yang Terpinjam
            $buku = Buku::find($random_idbuku);
            $buku->StatusBuku = "Dipinjam";
            $buku->save();
        }
    }
}
