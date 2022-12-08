<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class LaporanPeminjaman extends Model
{
    use LogsActivity;

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
    protected static $logName = 'laporanPeminjaman';
    protected static $logFillable = true;
    protected static $logUnguarded = true;
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent (string $eventName) : string
    {
        return $this->IDLaporan." {$eventName} By : ".Auth::user()->name;
    }
}
