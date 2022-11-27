<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Member extends Model
{
    use LogsActivity;

    use HasFactory;
    protected $table = 'member';
    protected  $primaryKey = 'NIK';
    public $incrementing = false;

    protected $fillable = [
        'NIK',
        'Nama',
        'StatusMember',
        'NomorTelepon',
        'Email',
    ];
    protected static $logName = 'member';
    protected static $logFillable = true;
    protected static $logUnguarded = true;
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent (string $eventName) : string
    {
        return $this->NIK." {$eventName} By : ".Auth::user()->name;
    }
}
