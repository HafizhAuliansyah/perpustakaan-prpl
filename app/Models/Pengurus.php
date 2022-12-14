<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Pengurus extends Authenticatable
{
    use LogsActivity;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'pengurus';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $guarded = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $logName = 'Pengurus';
    protected static $logFillable = true;
    protected static $logUnguarded = true;
    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent (string $eventName) : string
    {
        return $this->id." {$eventName}";
    }

}
