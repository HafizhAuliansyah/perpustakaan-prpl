<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $fillable = [
        'IDPeminjaman',
        'IDBuku',
        'NIK',
        'TglPeminjaman',
        'StatusPeminjaman',
        'TglPengembalian',
    ];
    protected $guarded = [
        'IDPeminjaman',
        'created_at',
        'updated_at'
    ];

    protected  $primaryKey = 'IDPeminjaman';

    public $incrementing = false;
}
