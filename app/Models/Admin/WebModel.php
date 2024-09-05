<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebModel extends Model
{
    use HasFactory;
    protected $table = "tbl_web";
    protected $primaryKey = 'web_id';
    protected $fillable = [
        'web_nama',
        'web_logo',
        'web_alamat',
        'web_tlpn',
        'web_deskripsi',
        'web_bca',
        'web_mandiri',
        'web_bri',
        'web_ewallet',
        'web_bca_an',
        'web_mandiri_an',
        'web_bri_an',
        'web_ewallet_an',
    ];
}
