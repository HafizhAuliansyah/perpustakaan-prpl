<?php

namespace Database\Seeders;

use App\Helpers\BukuHelper;
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
        $prefix = "B".date("dmY")."00";
        $id = [$prefix."1", $prefix."2", $prefix."3"];
        $NamaBuku = ['Buku 1', 'Buku 2', 'Buku 3'];
        $Deskripsi = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui itaque voluptatem eaque exercitationem fugiat et tempore quo quaerat ut veniam a in, consequatur laudantium explicabo illo numquam temporibus assumenda labore architecto cumque fuga, sit tenetur! Eveniet perferendis tempore asperiores, omnis ipsa nostrum! Aspernatur saepe sit vitae non pariatur voluptatibus magni.";
        $GenreBuku = ['Horror', 'Aksi', 'Fiksi', 'Drama', 'Romansa', 'Komedi', 'Sport', 'Teknologi', 'Sejarah', 'Politik'];
        
        $Bahasa = ['Indonesia', 'Inggris', 'Jepang', 'China', 'Arab', 'Prancis'];
        $JumlahHalaman = [rand(10, 500), rand(10,500), rand(10, 500)];
        $StatusBuku =  ['Dipinjam', 'Tersedia', 'Tersedia'];
        $Penerbit = ['Penerbit 1', 'Penerbit 2', 'Penerbit 3'];
        $Penulis =  ['Penulis 1', 'Penulis 2', 'Penulis 3'];
        $LetakRak = ['A1','A2','A3','B1', 'B2', 'B3', 'C1', 'C2', 'C3'];
        $TglMasukBuku = date('d/m/Y');
        $path = storage_path() . "/books.json";
        $data_buku= json_decode(file_get_contents($path), true); 

        for ($i=0; $i < count($data_buku); $i++) { 
            $Genre = $GenreBuku[array_rand($GenreBuku)];
            for ($j=0; $j < 10; $j++) { 
                $buku = new Buku();
                $buku->IDBuku = BukuHelper::generateBookID();
                $buku->NamaBuku = $data_buku[$i]['title'];
                $buku->Deskripsi = $Deskripsi;
                // Random Genre
                
                $buku->GenreBuku = $Genre;

                $buku->Bahasa = $data_buku[$i]['language'];
                $buku->JumlahHalaman = $data_buku[$i]['pages'];
                $buku->StatusBuku = "Tersedia";
                $buku->Penerbit = $data_buku[$i]['country'];
                $buku->Penulis =  $data_buku[$i]['author'];

                // Random letak rak
                $Rak = $LetakRak[array_rand($LetakRak)];
                $buku->LetakRak = $Rak;

                $buku->TglMasukBuku = $TglMasukBuku;
                $buku->save();
            }
            
        }
    }
}
