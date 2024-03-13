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
        ]);

        // Simpan detail pesanan ke database
        foreach ($resultArray as $detail) {
            PesanModel::create([
                'pesan_idtransaksi' => $transaksi->id,
                'pesan_idbarang' => $detail['idBarang'],
                'pesan_jumlah' => $detail['jml'],
            ]);
        }

        // Kirim notifikasi Discord
        $webhookUrl = 'https://discord.com/api/webhooks/1217548176253521941/5duHhyzgi7a3w0F-RZdqvLd0M8tZWJf6kLykIErZ-axxDB3zSK_4bGHR9zn04RQBI1aJ';
        $pesan = "Kode Pesanan: `` " . $transaksi->kode_inv . " ``";

        $orderData = $this->getOrderData($transaksi);
        $response = Http::post($webhookUrl, [
            'embeds' => [
                [
                    'title' => 'Pesanan Baru!',
                    'description' => $pesan,
                    'color' => 3447003,
                    'fields' => [
                        [
                            'name' => 'Pelanggan',
                            'value' => $orderData['namauser'],
                            'inline' => true,
                        ],
                        [
                            'name' => 'Total Harga',
                            'value' => 'Rp. ' . number_format($orderData['total_harga'] - $orderData['diskon'], 0),
                            'inline' => true,
                        ],
                        [
                            'name' => 'Diskon',
                            'value' => 'Rp. -' . number_format($orderData['diskon'], 0),
                            'inline' => true,
                        ],
                        [
                            'name' => 'Alamat',
                            'value' => $orderData['alamat'],
                            'inline' => true,
                        ],
                        [
                            'name' => 'Detail Pesanan',
                            'value' => '[Lihat Detail](' . url('/admin/pesan/detail/' . $orderData['kode_pesan']) . ')',
                            'inline' => true,
                        ],
                    ],
                    'footer' => [
                        'text' => 'Tanggal Pesan: ' . $orderData['date_pesan'],
                    ],
                ],
            ],
        ]);
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
        // Kirim notifikasi Discord baru
        $webhookUrl = 'https://discord.com/api/webhooks/1217599206097813514/PFxbfyX13AFvP7L8Fk-KMkS7KkCl9GopK9eehbLGGOgswaJeB4opNiwvJsObJyRf5jdu';
        $pesan = "Kode Pesanan: `` " . $result->kode_inv . " ``";
        $response = Http::post($webhookUrl, [
            'embeds' => [
                [
                    'title' => 'Update Status!',
                    'description' => $pesan,
                    'color' => 3447003,
                    'fields' => [
                        [
                            'name' => 'Pelanggan',
                            'value' => $orderData['namauser'],
                            'inline' => true,
                        ],
                        [
                            'name' => 'Total Harga',
                            'value' => 'Rp. ' . number_format($orderData['total_harga'] - $orderData['diskon'], 0),
                            'inline' => true,
                        ],
                        [
                            'name' => 'Diskon',
                            'value' => 'Rp. -' . number_format($orderData['diskon'], 0),
                            'inline' => true,
                        ],
                        [
                            'name' => 'Alamat',
                            'value' => $orderData['alamat'],
                            'inline' => true,
                        ],
                        [
                            'name' => 'Diubah Oleh',
                            'value' => Session::get('user')->user_nmlengkap,
                            'inline' => true,
                        ],
                        [
                            'name' => 'Status',
                            'value' => "`` ".$newStatus." ``",
                            'inline' => true,
                        ],
                        [
                            'name' => 'Detail Pesanan',
                            'value' => '[Lihat Detail](' . url('/admin/pesan/detail/' . $orderData['kode_pesan']) . ')',
                            'inline' => true,
                        ],
                    ],
                    'footer' => [
                        'text' => 'Tanggal Pesan: ' . $orderData['date_pesan'],
                    ],
                ],
            ],
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
        ];
    }
}
