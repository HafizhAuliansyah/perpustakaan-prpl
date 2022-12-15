<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class Buku extends Model
{
    use LogsActivity;

    use HasFactory;

    protected $table = 'buku';
    protected  $primaryKey = 'IDBuku';
    public $incrementing = false;
    protected $fillable = [
        'IDBuku',
        'created_at',
        'updated_at',
        'NamaBuku',
        'Deskripsi',
        'GenreBuku',
        'Bahasa',
        'JumlahHalaman',
        'StatusBuku',
        'Penerbit',
        'Penulis',
        'LetakRak',
        'TglMasukBuku',
        'Cover',
        'QRCode'
    ];
    protected $guarded = [
        'IDBuku',
        'created_at',
        'updated_at'
    ];

    protected static $logName = 'Buku';
    protected static $logFillable = true;
    protected static $logUnguarded = true;
    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent (string $eventName) : string
    {
        return $this->IDBuku." {$eventName} By : ".Auth::user()->id;
    }
}
