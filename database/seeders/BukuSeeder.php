<?php

namespace Database\Seeders;

use App\Helpers\BukuHelper;
use App\Models\Buku;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Seeder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        
        $min_date = strtotime("2021-01-01");
        $max_date = strtotime(date('Y-m-d'));

        $LetakRak = ['A1','A2','A3','B1', 'B2', 'B3', 'C1', 'C2', 'C3'];
        $TglMasukBuku = date('d/m/Y');
        $path = storage_path() . "/books.json";
        $data_buku= json_decode(file_get_contents($path), true); 

        if(file_exists(public_path('images/buku/qr_code'))){
            array_map('unlink', glob(public_path('images/buku/qr_code/*.*')));
            rmdir(public_path('images/buku/qr_code'));
        }

        mkdir(public_path('images/buku/qr_code'));
        for ($i=0; $i < count($data_buku); $i++) { 
            // Random Created Date
            $rand_date = rand($min_date, $max_date);
            $TglMasukBuku = date('Y-m-d', $rand_date);
            $Genre = $GenreBuku[array_rand($GenreBuku)];
            for ($j=0; $j < 10; $j++) { 
                $buku = new Buku();
                $newID = BukuHelper::generateBookID();
                $buku->IDBuku = $newID;
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
                $buku->Cover = '/default.jpg';
                $qrPath = public_path('images/buku/qr_code/'.$newID.'.svg');
                QrCode::format('svg')->backgroundColor(255,255,255)->size(200)->generate($newID, $qrPath);
                $buku->QRCode = $newID.'.jpg';
                $buku->created_at = $TglMasukBuku;
                $buku->save();
            }
            
        }
    }
}
