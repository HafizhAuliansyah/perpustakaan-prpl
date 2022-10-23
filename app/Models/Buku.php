<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table = 'buku';
    protected  $primaryKey = 'IDBuku';
    public $incrementing = false;
    protected $fillable = [
        'IDBuku',
        'created_at',
        'updated_at',
        'NamaBuku',
        'Deskripsi',
        'GenreBuku',
        'Bahasa',
        'JumlahHalaman',
        'StatusBuku',
        'Penerbit',
        'Penulis',
        'LetakRak',
        'TglMasukBuku'
    ];
    protected $guarded = [
        'IDBuku',
        'created_at',
        'updated_at'
    ];
}
