<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AksesModel;
use App\Models\Admin\BarangkeluarModel;
use App\Models\Admin\BarangmasukModel;
use App\Models\Admin\BarangModel;
use App\Models\Admin\JenisBarangModel;
use App\Models\Admin\PesanModel;
use App\Models\Admin\RoleModel;
use App\Models\Admin\SatuanModel;
use App\Models\Admin\WebModel;
use App\Models\StatusOrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PesanController extends Controller
{
    
    public function index()
    {
        $data["title"] = "Pesan";
        $dataBarang = BarangModel::orderBy('created_at', 'desc')->paginate();
        
        $arr = [];
        foreach ($dataBarang as $dbarang) {
            $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')->where('tbl_barangmasuk.barang_kode', '=', $dbarang->barang_kode)->sum('tbl_barangmasuk.bm_jumlah');
    
            $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')->where('tbl_barangkeluar.barang_kode', '=', $dbarang->barang_kode)->sum('tbl_barangkeluar.bk_jumlah');
    
            $totalpesan = PesanModel::where('pesan_idbarang', $dbarang->barang_id)
                ->join('tbl_status_order', 'tbl_status_order.id', '=', 'pesan_idtransaksi')
                ->whereIn('tbl_status_order.status', ['Dikirim', 'Selesai'])
                ->sum('pesan_jumlah');
    
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
        }
        return view('Admin.Pesan.index', ['data' => $data, 'arr' => $arr]);
    }

    public function addToPesan(Request $request) {
        $userId = Session::get('user')->user_id;
    
        $dataArray = explode(",", $request->data);
        $resultArray = [];
    
        for ($i = 0; $i < count($dataArray); $i += 2) {
            $resultArray[] = [
                "jml" => $dataArray[$i],
                "idBarang" => $dataArray[$i + 1],
            ];
        }
    
        $randomCode = mt_rand(10000, 99999);
        $kodeInv = "DVBR-" . $randomCode;
        $transaksi = StatusOrderModel::create([
            'id_user' => $userId, 
            'kode_inv' => $kodeInv,
            'status_tanggal' => now(),
            'diskon' => $request->diskon,
        ]);
    
        foreach ($resultArray as $d) {
            PesanModel::create([
                'pesan_idtransaksi' => $transaksi->id,
                "pesan_idbarang" => $d['idBarang'],
                'pesan_jumlah' => $d['jml'], // Gunakan nilai diskon di sini
            ]);
        }
    
        return response()->json(['success' => true, "berhasil"]);
    }
    
    public function status()
{
    $data["title"] = "Status Pesanan";

    $dataTransaksi = StatusOrderModel::with('pesan', 'pesan.barang')->orderBy('created_at', 'desc')->get();

    $arr = [];

    foreach ($dataTransaksi as $dt) {
        $total_harga = 0; // Inisialisasi total harga untuk setiap transaksi
        $total_jumlah = 0; // Inisialisasi total jumlah untuk setiap transaksi

        foreach ($dt->pesan as $detail) {
            foreach ($detail->barang as $d) {
                $total_harga += ($detail->pesan_jumlah * intval($d->barang_harga));
                $total_jumlah += $detail->pesan_jumlah;
            }
        }

        $ownerName = '';
        $ownerAddress = '';
        $status = '';

        // Ambil data pemilik pesanan dan status dari tabel yang sesuai
        if (in_array(Session::get('user')->role_id, ['1', '2', '4'])) {
            // Jika pemilik pesanan adalah pengguna, dapatkan namanya dan alamatnya
            $owner = DB::table('tbl_user')->where('user_id', $dt->id_user)->first();
            if ($owner) {
                $ownerName = $owner->user_nmlengkap;
                $ownerAddress = $owner->user_alamat;
            }

            // Ambil status pesanan
            $status = $dt->status;
        } else if (Session::get('user')->user_id === $dt->id_user) {
            // Jika bukan role 1, 2, atau 4, tampilkan data sesuai yang dimiliki user
            $ownerName = Session::get('user')->user_nmlengkap;
            $ownerAddress = Session::get('user')->user_alamat;
            $status = $dt->status;
        }

        $arr[] = [
            'namauser' => $ownerName,
            'alamat' => $ownerAddress,
            'status' => $status,
            'date' => $dt->status_tanggal,
            'date_pesan' => $dt->created_at,
            'id_user' => $dt->id_user,
            'id' => $dt->id,
            'total_harga' => $total_harga,
            'total_jumlah' => $total_jumlah,
            'kode_pesan' => $dt->kode_inv,
            'diskon'=> $dt->diskon
        ];
    }
// dd($dataTransaksi);
    return view('Admin.Pesan.statustransaksi', ['data' => $data, 'arr' => $arr, 'title' => $data['title']]);
}


public function detail($id)
    {
        $data = "Detail Pesanan";
        $statusOrder = $this->getStatusOrder($id);

        if (!$statusOrder) {
            return response()->view('errors.404');
        }

        $userInfo = $this->getUserInfo($statusOrder->id_user);
        $items = $this->getItems($statusOrder->id);

        return view('Admin.Pesan.detail', compact('data', 'statusOrder', 'userInfo', 'items'));
    }
    public function updateStatus(Request $request, $id)
    {
            $request->validate([
                'status' => 'required|in:Pending,Dikirim,Selesai,Dibatalkan',
            ]);
            $results = StatusOrderModel::where('tbl_status_order.kode_inv', $id)->first();
            $newStatus = $request->input('status');
            $results->update([
                'status' => $newStatus,
                'status_tanggal' => now(),
            ]);
            return response()->json(['message' => 'Status berhasil diperbarui']);
        }
        public function cetakStruk($id)
        {
            $data = WebModel::first();
            $statusOrder = $this->getStatusOrder($id);
    
            if (!$statusOrder) {
                return response()->view('errors.404');
            }
    
            $userInfo = $this->getUserInfo($statusOrder->id_user);
            $items = $this->getItems($statusOrder->id);
    
            return view('Admin.Pesan.struk', compact('data', 'statusOrder', 'userInfo', 'items'));
        }

        private function getStatusOrder($id)
    {
        return DB::table('tbl_status_order')
            ->where('tbl_status_order.kode_inv', $id)
            ->first();
    }

    // Metode untuk mendapatkan data user info
    private function getUserInfo($userId)
    {
        return DB::table('tbl_user')
            ->join('tbl_role', 'tbl_user.role_id', '=', 'tbl_role.role_id')
            ->where('tbl_user.user_id', $userId)
            ->first();
    }

    // Metode untuk mendapatkan data items
    private function getItems($orderId)
    {
        return DB::table('tbl_pesan')
            ->join('tbl_barang', 'tbl_barang.barang_id', '=', 'tbl_pesan.pesan_idbarang')
            ->join('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')
            ->where('tbl_pesan.pesan_idtransaksi', $orderId)
            ->select('tbl_barang.*', 'tbl_satuan.satuan_nama', 'tbl_pesan.pesan_jumlah')
            ->get();
    }
      
}
