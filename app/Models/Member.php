<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'NIK',
        'Nama',
        'StatusMember',
        'NomorTelepon',
        'Email',
    ];

    protected $primaryKey = 'NIK';

    public $incrementing = false;
}
