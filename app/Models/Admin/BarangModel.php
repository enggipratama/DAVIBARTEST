<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;
    protected $table = "tbl_barang";
    protected $primaryKey = 'barang_id';
    protected $fillable = [
        'jenisbarang_id',
        'satuan_id',
        'merk_id',
        'barang_kode',
        'barang_nama',
        'barang_slug',
        'barang_harga',
        'barang_stok',
        'barang_gambar',
    ]; 

    public function barangMasuk(){
        return $this->hasMany(BarangmasukModel::class,'barang_kode','barang_kode');
    }
    public function barangKeluar(){
        return $this->hasMany(BarangkeluarModel::class,'barang_kode','barang_kode');
    }
    public function satuan(){
        return $this->hasOne(SatuanModel::class,'satuan_id','satuan_id');
    }
}