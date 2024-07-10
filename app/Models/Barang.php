<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kategori',
        'nama',
        'jumlah',
        'satuan',
    ];

    public function detailBarangMasuk()
    {
        return $this->hasMany(DetailBarangMasuk::class, 'id_barang', 'id');
    }

    public function detailBarangKeluar()
    {
        return $this->hasMany(DetailBarangKeluar::class, 'id_barang', 'id');
    }
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    public function getStokAttribute()
    {
        $jumlahBarangKeluar = $this->detailBarangKeluar()->sum('jumlah');
        return $this->jumlah - $jumlahBarangKeluar;
    }

    public function getSatuanStokAttribute()
    {
        return $this->satuan;
    }
}
