<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanModel extends Model
{
    use HasFactory;
    protected $table = "tbl_pesan";
    protected $primaryKey = 'pesan_id';
    protected $fillable = [
            'pesan_kode',
            'pesan_jumlah',
            'pesan_status',
            'pesan_totalharga',
            'pesan_idbarang'
    ];
}