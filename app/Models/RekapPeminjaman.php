<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LaporanPeminjaman extends Model
{
    use LogsActivity;

    use HasFactory;
    protected $table = 'rekap_peminjaman';
    protected $fillable = [
        'IDRekapPeminjaman',
        'TglDibentuk',
        'JumlahDataPeminjaman',
        'JumlahPeminjaman',
        'IDBukuFavorite',
        'NikTopMember',
        'MeanRentangPinjam',
    ];
    protected $guarded = [
        'IDRekapPeminjaman',
        'created_at',
        'updated_at'
    ];

    protected  $primaryKey = 'IDRekapPeminjaman';

    public $incrementing = false;

    protected static $logName = 'rekap_peminjaman';
    protected static $logFillable = true;
    protected static $logUnguarded = true;
    protected static $logOnlyDirty = true;

    // public function getDescriptionForEvent (string $eventName) : string
    // {
    //     return $this->IDRekapPeminjaman." {$eventName} By : ".Auth::user()->name;
    // }
}
