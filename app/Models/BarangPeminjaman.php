<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangPeminjaman extends Model
{
    protected $table = 'barang_peminjaman';
    protected $fillable = [
        'name',
        'jumlah',
        'status',
    ];
}
