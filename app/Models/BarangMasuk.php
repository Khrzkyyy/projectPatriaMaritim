<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_barang_keluar',
        'id_user',
        'tanggal',
    ];

    public function detailBarangMasuk()
    {
        return $this->hasMany(DetailBarangMasuk::class, 'id_barang_masuk', 'id');
    }

    public function barangKeluar()
    {
        return $this->belongsTo(BarangKeluar::class, 'id_barang_keluar', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
