<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class Peminjaman extends Model
{
    use LogsActivity;

    use HasFactory;
    protected $table = 'peminjaman';
    protected $fillable = [
        'IDPeminjaman',
        'IDBuku',
        'NIK',
        'TglPeminjaman',
        'StatusPeminjaman',
        'TglPengembalian',
        'TglSelesai',
    ];

    protected $guarded = [
        'IDPeminjaman',
        'created_at',
        'updated_at'
    ];

    protected $primaryKey = 'IDPeminjaman';

    public $incrementing = false;

    protected static $logName = 'peminjaman';
    protected static $logFillable = true;
    protected static $logUnguarded = true;
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent (string $eventName) : string
    {
        return $this->IDPeminjaman." {$eventName} By : ".Auth::user()->name." with ID: ".Auth::user()->id;
    }
}
