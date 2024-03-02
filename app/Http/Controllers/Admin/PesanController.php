<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AksesModel;
use App\Models\Admin\BarangkeluarModel;
use App\Models\Admin\BarangmasukModel;
use App\Models\Admin\BarangModel;
use App\Models\Admin\JenisBarangModel;
use App\Models\Admin\PesanModel;
use App\Models\Admin\SatuanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PesanController extends Controller
{
    public function index()
    {
        $data["title"] = "Pesan";
        // dd($data);
        return view('Admin.Pesan.index', $data);
        
    }
    public function status()
    {
        $data["title"] = "Status Pesanan";
        // dd($data);
        return view('Admin.Pesan.status', $data);
        
    }
    public function rincian()
    {
        $data["title"] = "Rincian Pesanan";
        // dd($data);
        return view('Admin.Pesan.rincian', $data);
        
    }
    public function getpesan($id)
    {
        $data = PesanModel::leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')->where('tbl_barang.barang_kode', '=', $id)->get();
        return json_encode($data);
    }
    public function proses_tambah(Request $request)
    {

        //create
        BarangModel::create([
            'pesan_kode' => $request->kode,
            // 'pesan_jumlah' => $request->jumlah,
            // 'pesan_status' => 'Menunggu Konfirmasi',
            // 'pesan_totalharga' => $request->harga,
            // 'pesan_idbarang' => $request->idbarang
        ]);

        return response()->json(['success' => 'Berhasil']);
    }
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangModel::leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')->orderBy('barang_id', 'DESC')->get();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('img', function ($row) {
                    $array = array(
                        "barang_gambar" => $row->barang_gambar,
                    );
                    if ($row->barang_gambar == "image.png") {
                        $img = '<a data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Gmodaldemo8" onclick=gambar(' . json_encode($array) . ')><span class="avatar avatar-lg cover-image" style="background: url(&quot;' . url('/assets/default/barang') . '/' . $row->barang_gambar . '&quot;) center center;"></span></a>';
                    } else {
                        $img = '<a data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Gmodaldemo8" onclick=gambar(' . json_encode($array) . ')><span class="avatar avatar-lg cover-image" style="background: url(&quot;' . asset('storage/barang/' . $row->barang_gambar) . '&quot;) center center;"></span></a>';
                    }

                    return $img;
                })
                
                ->addColumn('currency', function ($row) {
                    $currency = $row->barang_harga == '' ? '-' : 'Rp ' . number_format($row->barang_harga, 0) ;

                    return $currency;
                })
                ->addColumn('totalstok', function ($row) use ($request) {
                    if ($request->tglawal == '') {
                        $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')->where('tbl_barangmasuk.barang_kode', '=', $row->barang_kode)->sum('tbl_barangmasuk.bm_jumlah');
                    } else {
                        $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')->whereBetween('bm_tanggal', [$request->tglawal, $request->tglakhir])->where('tbl_barangmasuk.barang_kode', '=', $row->barang_kode)->sum('tbl_barangmasuk.bm_jumlah');
                    }
                    if ($request->tglawal) {
                        $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')->whereBetween('bk_tanggal', [$request->tglawal, $request->tglakhir])->where('tbl_barangkeluar.barang_kode', '=', $row->barang_kode)->sum('tbl_barangkeluar.bk_jumlah');
                    } else {
                        $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')->where('tbl_barangkeluar.barang_kode', '=', $row->barang_kode)->sum('tbl_barangkeluar.bk_jumlah');
                    }
                    $totalstok = $row->barang_stok + ($jmlmasuk - $jmlkeluar);
                
                    return $totalstok;
                })
                ->addColumn('inputjml', function($row) {
                    if ($row->data) {
                        return '<input type="number" name="inputjml[]" class="form-control" value="' +
                            $row->data + '" oninput="this.value = Math.abs(this.value)">';
                    } else {
                        return '<input type="number" name="inputjml[]" class="form-control" placeholder="0" oninput="this.value = Math.abs(this.value)">';
                    }
                })
                
                  ->rawColumns([ 'img', 'currency', 'totalstok','inputjml'])->make(true);
        }
        
    }
    
}