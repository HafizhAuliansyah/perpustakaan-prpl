<?php

namespace Database\Seeders;

use App\Models\Buku;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prefix = "B".date("dmY");
        $id = [$prefix."1", $prefix."2", $prefix."3"];
        $NamaBuku = ['Buku 1', 'Buku 2', 'Buku 3'];
        $Deskripsi = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore iure aliquid iusto veritatis tempore saepe aliquam? Illum beatae dolor possimus delectus pariatur ullam ex cumque accusamus voluptas voluptatibus magnam a consequuntur est quasi rem sit corrupti vitae doloremque atque nemo accusantium, molestias commodi tempora eius. Cumque quam possimus error voluptate.";
        $GenreBuku = ['Horror', 'Aksi', 'Fiksi', 'Drama', 'Romansa', 'Komedi', 'Sport', 'Teknologi', 'Sejarah', 'Politik'];
        $Bahasa = ['Indonesia', 'Inggris', 'Jepang', 'China', 'Arab', 'Prancis'];
        $JumlahHalaman = [rand(10, 500), rand(10,500), rand(10, 500)];
        $StatusBuku =  ['Dipinjam', 'Tersedia', 'Tersedia'];
        $Penerbit = ['Penerbit 1', 'Penerbit 2', 'Penerbit 3'];
        $Penulis =  ['Penulis 1', 'Penulis 2', 'Penulis 3'];
        $LetakRak = ['A1', 'B2', 'C3'];
        $TglMasukBuku = date('d/m/Y');
        for ($i=0; $i < 3; $i++) { 
            $buku = new Buku();
            $buku->IDBuku = $id[$i];
            $buku->NamaBuku = $NamaBuku[$i];
            $buku->Deskripsi = $Deskripsi[$i];
            $buku->GenreBuku = $GenreBuku[$i];
            $buku->Bahasa = $Bahasa[$i];
            $buku->JumlahHalaman = $JumlahHalaman[$i];
            $buku->StatusBuku = $StatusBuku[$i];
            $buku->Penerbit = $Penerbit[$i];
            $buku->Penulis = $Penulis[$i];
            $buku->LetakRak = $LetakRak[$i];
            $buku->TglMasukBuku = $TglMasukBuku;
            $buku->save();
        }
    }
}
