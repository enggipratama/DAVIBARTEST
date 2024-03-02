<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangmasukModel extends Model
{
    use HasFactory;
    protected $table = "tbl_barangmasuk";
    protected $primaryKey = 'bm_id';
    protected $fillable = [
        'bm_kode',
        'barang_kode',
        'customer_id',
        'bm_tanggal',
        'bm_jumlah',
    ]; 
    public function satuan(){
        return $this->hasOne(SatuanModel::class,'satuan_id','satuan_id');
    }
}