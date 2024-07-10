<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'tanggal',
    ];

    public function detailBarangKeluar()
    {
        return $this->hasMany(DetailBarangKeluar::class, 'id_barang_keluar', 'id');
    }
    
    public function barangMasuk()
    {
        return $this->hasOne(BarangMasuk::class, 'id_barang_keluar', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
