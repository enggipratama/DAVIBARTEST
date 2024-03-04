<?php

namespace App\Models\Admin;

use App\Models\StatusOrderModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanModel extends Model
{
    use HasFactory;
    protected $table = "tbl_pesan";
    protected $primaryKey = 'pesan_id';
    protected $fillable = [
            'pesan_idbarang',
            'pesan_jumlah',
            'pesan_idtransaksi'
    ];


    public function transaksi(){
        return $this->belongsTo(StatusOrderModel::class);
    }

    public function barang(){
        return $this->hasMany(BarangModel::class, 'barang_id', 'pesan_idbarang');
    }
}