<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPeminjaman extends Model
{
    use HasFactory;
    protected $table = 'laporan_peminjaman';
    protected $fillable = [
        'IDLaporan',
        'TglDibentuk',
        'JumlahDataPeminjaman',
        'JumlahPeminjaman',
        'IDBukuFavorite',
        'NikTopMember',
        'MeanRentangPinjam'
    ];
    protected $guarded = [
        'IDLaporan',
        'created_at',
        'updated_at'
    ];

    protected  $primaryKey = 'IDLaporan';

    public $incrementing = false;
}
