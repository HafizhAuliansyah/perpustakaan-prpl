<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;
    protected $table = 'denda';
    protected $fillable = [
        'IDDenda',
        'IDPeminjaman',
        'Keterangan',
        'Nominal'
    ];
    protected $guarded = [
        'IDDenda',
        'created_at',
        'updated_at'
    ];

    protected  $primaryKey = 'IDDenda';
    public $incrementing = false;
}
