<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BarangkeluarModel;
use App\Models\Admin\BarangmasukModel;
use App\Models\Admin\BarangModel;
use App\Models\Admin\CustomerModel;
use App\Models\Admin\JenisBarangModel;
use App\Models\Admin\MerkModel;
use App\Models\Admin\PesanModel;
use App\Models\Admin\RoleModel;
use App\Models\Admin\SatuanModel;
use App\Models\Admin\UserModel;
use App\Models\StatusOrderModel;
use Illuminate\Http\Request;
use App\Models\Admin\WebModel;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data["title"] = "Dashboard";
        $data["jenis"] = JenisBarangModel::orderBy('jenisbarang_id', 'DESC')->count();
        $data["satuan"] = SatuanModel::orderBy('satuan_id', 'DESC')->count();
        $data["merk"] = MerkModel::orderBy('merk_id', 'DESC')->count();
        $data["barang"] = BarangModel::leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')->orderBy('barang_id', 'DESC')->count();
        $data["customer"] = CustomerModel::orderBy('customer_id', 'DESC')->count();
        $data["bm"] = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')->orderBy('bm_id', 'DESC')->count();
        $data["bk"] = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')->orderBy('bk_id', 'DESC')->count();
        $data["user"] = UserModel::leftJoin('tbl_role', 'tbl_role.role_id', '=', 'tbl_user.role_id')->select()->orderBy('user_id', 'DESC')->count();
        $data["userLogin"] = $request->session()->get('user');

        $dataBarang = BarangModel::orderBy('created_at', 'desc')->paginate(8);

        $arr = [];

        foreach ($dataBarang as $dbarang) {
            $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')->where('tbl_barangmasuk.barang_kode', '=', $dbarang->barang_kode)->sum('tbl_barangmasuk.bm_jumlah');
    
            $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')->where('tbl_barangkeluar.barang_kode', '=', $dbarang->barang_kode)->sum('tbl_barangkeluar.bk_jumlah');
    
            $totalpesan = PesanModel::where('pesan_idbarang', $dbarang->barang_id)
                ->join('tbl_status_order', 'tbl_status_order.id', '=', 'pesan_idtransaksi')
                ->whereIn('tbl_status_order.status', ['Dikirim', 'Selesai'])
                ->sum('pesan_jumlah');

            $statusValues = StatusOrderModel::getEnumValues('status');

            $totalstatus = StatusOrderModel::with('pesan')
                ->whereHas('pesan', function ($query) use ($dbarang) {
                    $query->where('pesan_idbarang', $dbarang->barang_id);
                })
                ->whereIn('status', ['Dikirim', 'Selesai'])
                ->first();
    
            $totalstok = $dbarang->barang_stok + ($jmlmasuk - $jmlkeluar);
    
            if ($totalstatus) {
                $totalreal = $totalstok - $totalpesan;
            } else {
                $totalreal = $totalstok - 0;
            }
    
            $arr[] = [
                'barang_id' => $dbarang->barang_id,
                'gambar' => $dbarang->barang_gambar,
                'nama' => $dbarang->barang_nama,
                'harga' => $dbarang->barang_harga,
                'satuan' => $dbarang->satuan->satuan_nama,
                'total_stok' => $totalstok,
                'total_real' => $totalreal
            ];
            
            $statusToCount = ['Pending', 'Dikirim', 'Selesai', 'Dibatalkan'];
            foreach ($statusToCount as $status) {
                ${$status . 'Count'} = 0;
            }
            // Menghitung jumlah setiap status
            foreach ($statusToCount as $status) {
                ${$status . 'Count'} = StatusOrderModel::where('status', $status)->count();
            }            
            // Menggabungkan variabel-variabel jumlah status ke dalam array $data
            $data['PendingCount'] = $PendingCount;
            $data['DikirimCount'] = $DikirimCount;
            $data['SelesaiCount'] = $SelesaiCount;
            $data['DibatalkanCount'] = $DibatalkanCount;
        }
        // dd($data);
        return view('Admin.Dashboard.index', ['data' => $data, 'arr' => $arr, 'statusValues' => $statusToCount]);
    }
}

        