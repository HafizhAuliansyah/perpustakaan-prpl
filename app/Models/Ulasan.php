<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class Ulasan extends Model
{
    use LogsActivity;

    use HasFactory;
    protected $table = 'ulasan';
    protected $guarded = [
        'id'
    ];
    protected static $logName = 'ulasan';
    protected static $logFillable = true;
    protected static $logUnguarded = true;
    protected static $logOnlyDirty = true;

    // public function getDescriptionForEvent (string $eventName) : string
    // {
    //     return "ID : ".$this->id." {$eventName} By : ".Auth::user()->name." with ID: ".Auth::user()->id;
    // }
}
