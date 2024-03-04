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
use App\Models\StatusOrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $arr[] = [
                'barang_id' => $dbarang->barang_id,
                'gambar' => $dbarang->barang_gambar,
                'nama' => $dbarang->barang_nama,
                'harga' => $dbarang->barang_harga,
                'satuan' => $dbarang->satuan->satuan_nama,
                'total_stok' => $dbarang->barang_stok + ($jmlmasuk - $jmlkeluar),
                
            ];
        }
        return view('Admin.Pesan.index', ['data' => $data, 'arr' => $arr]);
    }

    public function addToPesan(Request $request){
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
        ]);

        foreach($resultArray as $d){

            PesanModel::create([
                'pesan_idtransaksi' => $transaksi->id,
                "pesan_idbarang" => $d['idBarang'],
                'pesan_jumlah' => $d['jml'],
            ]);
        }

        return response()->json(['success', "berhasil"]);
    }
    public function status(){
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

            $arr[] = [
                'namauser'=> Session::get('user')->user_nmlengkap,
                'alamat'=> Session::get('user')->user_alamat,
                'status'=> $dt->status,
                'date'=> $dt->created_at,
                'id_user' => $dt->id_user,
                'id' => $dt->id,
                'total_harga' => $total_harga,
                'total_jumlah' => $total_jumlah,
                'kode_pesan' => $dt->kode_inv
            ];
        }

        // dd($arr);

        return view ('Admin.Pesan.statustransaksi', ['data' => $data, 'arr' => $arr, 'title' => $data['title']]);
    }

    public function detail($id){
        
        $data["title"] = "Detail Pesanan";
        $user_id_login = Session::get('user')->user_id;
        
        $results = StatusOrderModel::where('id_user', $user_id_login)
            ->where('tbl_status_order.kode_inv', $id)
            ->join('tbl_pesan', function ($join) {
                $join->on('tbl_status_order.id', '=', 'tbl_pesan.pesan_idtransaksi')
                    ->whereColumn('tbl_status_order.id', '=', 'tbl_pesan.pesan_idtransaksi');
            })
            ->join('tbl_barang', 'tbl_barang.barang_id', '=', 'tbl_pesan.pesan_idbarang')
            ->join('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')
            ->select('*') 
            ->get();

            // dd($results);

        return view('Admin.Pesan.detail', ['data' => $data, 'results' => $results, 'title' => $data['title']]);
    }      
    public function updateStatus(Request $request, $id)
        {
            // Validasi permintaan jika diperlukan
            $request->validate([
                'status' => 'required|in:Pending,Dikirim,Selesai,Dibatalkan', // Sesuaikan dengan nilai enum status Anda
            ]);
            $results = StatusOrderModel::where('tbl_status_order.kode_inv', $id)->first();
            // Ambil nilai status dari permintaan
            $newStatus = $request->input('status');
            // Lakukan perubahan status pada data di database, misalnya:
            $results->update(['status' => $newStatus]);
            return response()->json(['message' => 'Status berhasil diperbarui']);
        }
      
}
