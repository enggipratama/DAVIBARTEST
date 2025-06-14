<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\{
    AksesModel,
    BarangkeluarModel,
    BarangmasukModel,
    BarangModel,
    JenisBarangModel,
    PesanModel,
    RoleModel,
    SatuanModel,
    WebModel
};
use App\Models\StatusOrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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
            $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')
                ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')
                ->where('tbl_barangmasuk.barang_kode', '=', $dbarang->barang_kode)
                ->sum('tbl_barangmasuk.bm_jumlah');

            $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')
                ->where('tbl_barangkeluar.barang_kode', '=', $dbarang->barang_kode)
                ->sum('tbl_barangkeluar.bk_jumlah');

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
                'total_real' => $totalreal,
            ];
        }
        return view('Admin.Pesan.index', ['data' => $data, 'arr' => $arr]);
    }

    public function addToPesan(Request $request)
    {
        $userId = Session::get('user')->user_id;
        $dataArray = explode(",", $request->data);
        $resultArray = [];

        // Proses data pesanan
        for ($i = 0; $i < count($dataArray); $i += 2) {
            $resultArray[] = [
                "jml" => $dataArray[$i],
                "idBarang" => $dataArray[$i + 1],
            ];
        }

        // Buat kode invoice
        $randomCode = mt_rand(10000, 99999);
        $kodeInv = "DVBR-" . $randomCode;

        // Simpan transaksi ke database
        $transaksi = StatusOrderModel::create([
            'id_user' => $userId,
            'kode_inv' => $kodeInv,
            'status_tanggal' => now(),
            'diskon' => $request->diskon,
            'metode_bayar' => $request->metode_bayar,
        ]);

        // Simpan detail pesanan ke database
        foreach ($resultArray as $detail) {
            PesanModel::create([
                'pesan_idtransaksi' => $transaksi->id,
                'pesan_idbarang' => $detail['idBarang'],
                'pesan_jumlah' => $detail['jml'],
            ]);
        }


        return response()->json(['success' => true, 'message' => 'Berhasil']);
    }

    public function proses_hapus($kode_pesan)
    {
        $transaksi = StatusOrderModel::where('kode_inv', $kode_pesan)->first();

        if (!$transaksi) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }
        try {
            DB::beginTransaction();
            foreach ($transaksi->pesan as $pesan) {
                $pesan->delete();
            }
            $transaksi->delete();
            DB::commit();
            return response()->json(['success' => 'Berhasil menghapus transaksi']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menghapus transaksi'], 500);
        }
    }

    public function status()
    {
        $data["title"] = "Status Pesanan";

        $dataTransaksi = StatusOrderModel::with('pesan', 'pesan.barang')->orderBy('created_at', 'desc')->get();

        $arr = [];

        foreach ($dataTransaksi as $dt) {
            $arr[] = $this->getOrderData($dt);
        }

        return view('Admin.Pesan.statustransaksi', ['data' => $data, 'arr' => $arr, 'title' => $data['title']]);
    }

    public function detail($id)
    {
        $web = $this->getWeb(1);
        // dd($web);
        $data = "Detail Pesanan";
        $statusOrder = $this->getStatusOrder($id);

        if (!$statusOrder) {
            return response()->view('errors.404');
        }

        $userInfo = $this->getUserInfo($statusOrder->id_user);
        $items = $this->getItems($statusOrder->id);

        return view('Admin.Pesan.detail', compact('data', 'web', 'statusOrder', 'userInfo', 'items'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Dikirim,Selesai,Dibatalkan',
        ]);

        $result = StatusOrderModel::where('tbl_status_order.kode_inv', $id)->first();

        if (!$result) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        $newStatus = $request->input('status');
        $result->update([
            'status' => $newStatus,
            'status_tanggal' => now(),
        ]);
        $orderData = $this->getOrderData($result);

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

    private function getUserInfo($userId)
    {
        return DB::table('tbl_user')
            ->join('tbl_role', 'tbl_user.role_id', '=', 'tbl_role.role_id')
            ->where('tbl_user.user_id', $userId)
            ->first();
    }

    private function getItems($orderId)
    {
        return DB::table('tbl_pesan')
            ->join('tbl_barang', 'tbl_barang.barang_id', '=', 'tbl_pesan.pesan_idbarang')
            ->join('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')
            ->where('tbl_pesan.pesan_idtransaksi', $orderId)
            ->select('tbl_barang.*', 'tbl_satuan.satuan_nama', 'tbl_pesan.pesan_jumlah')
            ->get();
    }

    private function getWeb($web_id)
    {
        return DB::table('tbl_web')->where('web_id', $web_id)->first();
    }

    private function getOrderData($statusOrder)
    {
        $total_harga = 0;
        $total_jumlah = 0;

        foreach ($statusOrder->pesan as $detail) {
            foreach ($detail->barang as $d) {
                $total_harga += ($detail->pesan_jumlah * intval($d->barang_harga));
                $total_jumlah += $detail->pesan_jumlah;
            }
        }

        $ownerName = '';
        $ownerAddress = '';
        $status = '';

        if (in_array(Session::get('user')->role_id, ['1', '2', '4'])) {
            $owner = DB::table('tbl_user')->where('user_id', $statusOrder->id_user)->first();
            if ($owner) {
                $ownerName = $owner->user_nmlengkap;
                $ownerAddress = $owner->user_alamat;
            }
            $status = $statusOrder->status;
        } else if (Session::get('user')->user_id === $statusOrder->id_user) {
            $ownerName = Session::get('user')->user_nmlengkap;
            $ownerAddress = Session::get('user')->user_alamat;
            $status = $statusOrder->status;
        }
        return [
            'namauser' => $ownerName,
            'alamat' => $ownerAddress,
            'status' => $status,
            'statuspesan' => $statusOrder->status,
            'date' => $statusOrder->status_tanggal,
            'date_pesan' => $statusOrder->created_at,
            'id_user' => $statusOrder->id_user,
            'id' => $statusOrder->id,
            'total_harga' => $total_harga,
            'total_jumlah' => $total_jumlah,
            'kode_pesan' => $statusOrder->kode_inv,
            'diskon' => $statusOrder->diskon,
            'metode_bayar' => $statusOrder->metode_bayar,
            'bukti_bayar' => $statusOrder->bukti_bayar,
        ];
    }
    public function uploadBuktiTransfer(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $order = $this->getStatusOrder($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $fileName = "bukti-bayar-" . hash('sha256', time()) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/bukti_bayar', $fileName);
            if ($order->bukti_bayar) {
                Storage::delete('public/bukti_bayar/' . $order->bukti_bayar);
            }
            $update = StatusOrderModel::where('id', $order->id);

            $update->update([
                'bukti_bayar' => $fileName
            ]);
        }

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Bukti transfer berhasil diupload.');
    }

}
