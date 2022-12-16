<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class RekapPeminjaman extends Model
{
    use LogsActivity;

    use HasFactory;
    protected $table = 'rekap_peminjaman';
    protected $fillable = [
        'IDRekapPeminjaman',
        'TglDibentuk',
        'JumlahDataPeminjaman',
        'JumlahPeminjam',
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

    protected static $logName = 'rekap_peminjaman';
    protected static $logFillable = true;
    protected static $logUnguarded = true;
    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent (string $eventName) : string
    {
        return $this->IDRekapPeminjaman." {$eventName} By : ".Auth::user()->name." with ID: ".Auth::user()->id;
    }
}
