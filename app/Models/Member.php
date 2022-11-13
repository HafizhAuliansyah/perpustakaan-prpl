<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
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
}
