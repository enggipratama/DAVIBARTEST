<?php

namespace App\Models;

use App\Models\Admin\PesanModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class StatusOrderModel extends Model
{
    use HasFactory;

    protected $table = "tbl_status_order";
    protected $fillable = [
        'id_user',
        'diskon',
        'status',
        'status_tanggal',
        'kode_inv'
    ];

    public function pesan()
    {
        return $this->hasMany(PesanModel::class, 'pesan_idtransaksi');
    }

    const STATUS_PENDING = 'Pending';
    const STATUS_DITERIMA = 'Dikirim';
    const STATUS_SELESAI = 'Selesai';
    const STATUS_DIBATALKAN = 'Dibatalkan';
    // ... (lainnya)

    // Metode ini mengembalikan daftar nilai enum status
    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_DITERIMA => 'Dikirim',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
            // ... (lainnya)
        ];
    }

    // Metode untuk mendapatkan nilai enum dari kolom tertentu
    public static function getEnumValues($column)
    {
        $enumValues = [];
        $columnType = Schema::getColumnType('tbl_status_order', $column);

        if (substr($columnType, 0, 4) === 'enum') {
            $matches = [];
            preg_match_all("/'([^']+)'/", $columnType, $matches);
            $enumValues = $matches[1];
        }

        return $enumValues;
    }
}

