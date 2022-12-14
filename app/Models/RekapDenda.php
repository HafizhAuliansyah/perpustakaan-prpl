<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapDenda extends Model
{
    use HasFactory;
    protected $table = 'rekap_denda';
    protected $fillable = [
        'IDRekapDenda',
        'TglDibentuk',
        'JumlahDataDenda',
        'JumlahNominal',
        'NominalTerbesar',
        'NominalTerkecil',
    ];
    protected $guarded = [
        'IDRekapDenda',
        'created_at',
        'updated_at'
    ];

    protected  $primaryKey = 'IDRekapDenda';

    public $incrementing = false;

    protected static $logName = 'rekap_denda';
    protected static $logFillable = true;
    protected static $logUnguarded = true;
    protected static $logOnlyDirty = true;

    // public function getDescriptionForEvent (string $eventName) : string
    // {
    //     return $this->IDRekapDenda." {$eventName} By : ".Auth::user()->name;
    // }
}
