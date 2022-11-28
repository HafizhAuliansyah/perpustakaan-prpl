<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Denda extends Model
{
    use LogsActivity;

    use HasFactory;
    protected $table = 'denda';
    protected $fillable = [
        'IDDenda',
        'IDPeminjaman',
        'Keterangan',
        'Status',
        'Nominal'
    ];
    protected $guarded = [
        'IDDenda',
        'created_at',
        'updated_at'
    ];

    protected  $primaryKey = 'IDDenda';
    public $incrementing = false;

    protected static $logName = 'denda';
    protected static $logFillable = true;
    protected static $logUnguarded = true;
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent (string $eventName) : string
    {
        return $this->IDDenda." {$eventName} By : ".Auth::user()->name;
    }
}
