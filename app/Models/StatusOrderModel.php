<?php

namespace App\Models;

use App\Models\Admin\PesanModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StatusOrderModel extends Model
{
    use HasFactory;
    
    protected $table = "tbl_status_order";
    protected $fillable = [
        'id_user',
        'status',
        'kode_inv'
    ];

    public function pesan(){
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
     public static function getEnumValues($column)
    {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM " . DB::getTablePrefix() . (new self)->getTable() . " WHERE Field = '{$column}'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enumValues = [];
        foreach (explode(',', $matches[1]) as $value) {
            $enumValues[] = trim($value, "'");
        }
        return $enumValues;
    }
}
