<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BarangkeluarModel;
use App\Models\Admin\BarangmasukModel;
use App\Models\Admin\BarangModel;
use App\Models\Admin\PesanModel;
use App\Models\Admin\WebModel;
use App\Models\StatusOrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use PDF;

class PendapatanController extends Controller
{
    public function index(Request $request)
    {
        $data["title"] = "Lap Pendapatan";
        return view('Admin.Laporan.Pendapatan.index', $data);
    }
    public function print(Request $request)
    {
        $data = $this->prepareData($request);
        return view('Admin.Laporan.Pendapatan.print', $data);
    }

    public function pdf(Request $request)
    {
        $data = $this->prepareData($request);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Admin.Laporan.Pendapatan.pdf', $data);

        if ($request->tglawal) {
            return $pdf->download('lap-pendapatan-' . $request->tglawal . '-' . $request->tglakhir . '.pdf');
        } else {
            return $pdf->download('lap-pendapatan-semua-tanggal.pdf');
        }
    }
    private function prepareData(Request $request){
        $data['data'] = BarangModel::leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')
            ->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')
            ->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')
            ->orderBy('barang_id', 'DESC')->get();

        $data["title"] = "Print Stok Barang";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;

        // Tambahkan logika baru di sini
        $stokData = [];
        $totalStokRPTotal = 0; // Inisialisasi total untuk totalStokRP
        foreach ($data['data'] as $row) {
            // Logika untuk menghitung jmlmasuk
            if ($request->tglawal == '') {
                $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')
                    ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')
                    ->where('tbl_barangmasuk.barang_kode', '=', $row->barang_kode)
                    ->sum('tbl_barangmasuk.bm_jumlah');
            } else {
                $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')
                    ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')
                    ->whereBetween('bm_tanggal', [$request->tglawal, $request->tglakhir])
                    ->where('tbl_barangmasuk.barang_kode', '=', $row->barang_kode)
                    ->sum('tbl_barangmasuk.bm_jumlah');
            }

            // Logika untuk menghitung jmlkeluar
            if ($request->tglawal) {
                $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')
                    ->whereBetween('bk_tanggal', [$request->tglawal, $request->tglakhir])
                    ->where('tbl_barangkeluar.barang_kode', '=', $row->barang_kode)
                    ->sum('tbl_barangkeluar.bk_jumlah');
            } else {
                $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')
                    ->where('tbl_barangkeluar.barang_kode', '=', $row->barang_kode)
                    ->sum('tbl_barangkeluar.bk_jumlah');
            }

            if ($request->tglawal) {
                $pesan_jumlah = PesanModel::where('pesan_idbarang', $row->barang_id)
                    ->join('tbl_status_order', 'tbl_status_order.id', '=', 'tbl_pesan.pesan_idtransaksi')
                    ->whereBetween(DB::raw('DATE(tbl_pesan.created_at)'), [$request->tglawal, $request->tglakhir])
                    ->whereIn('tbl_status_order.status', ['Dikirim', 'Selesai'])
                    ->sum('tbl_pesan.pesan_jumlah');
            } else {
                $pesan_jumlah = PesanModel::where('pesan_idbarang', $row->barang_id)
                    ->join('tbl_status_order', 'tbl_status_order.id', '=', 'tbl_pesan.pesan_idtransaksi')
                    ->whereIn('tbl_status_order.status', ['Dikirim', 'Selesai'])
                    ->sum('tbl_pesan.pesan_jumlah');
            }
            $totalstatus = StatusOrderModel::with('pesan')
                ->whereHas('pesan', function ($query) use ($row) {
                    $query->where('pesan_idbarang', $row->barang_id);
                })
                ->whereIn('status', ['Dikirim', 'Selesai'])
                ->first();
                
            $totalstok = $row->barang_stok + ($jmlmasuk - $jmlkeluar);

            if ($totalstatus) {
                $totalreal = $totalstok - $pesan_jumlah;
            } else {
                $totalreal = $totalstok ;
            }

            $totalStokRP = $row->barang_harga * ($jmlkeluar + $pesan_jumlah);
            $totalStokRPTotal += $totalStokRP;
            // Tambahkan totalreal ke dalam array stokData
            $stokData[] = [
                'barang_id' => $row->barang_id,
                'totalreal' => $totalreal,
                'barang_kode' => $row->barang_kode,
                'barang_nama' => $row->barang_nama,
                'barang_stok' => $row->barang_stok,
                'barang_harga' => $row->barang_harga,
                'jmlmasuk' => $jmlmasuk,
                'jmlkeluar' => $jmlkeluar + $pesan_jumlah,
                'satuan' => $row->satuan->satuan_nama,
                'totalStokRP' => $totalStokRP,
                
            ];
        }
        // Tambahkan stokData dan totalStokRPTotal ke dalam array $data
            $data['totalStokRP'] = $totalStokRP;
            $data['stokData'] = $stokData;
            $data['totalpesan']=$pesan_jumlah;
            $data['totalStokRPTotal'] = $totalStokRPTotal;
            return $data;
    }
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangModel::leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')->orderBy('barang_id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('barang', function ($row) {
                    $barang = $row->barang_id == '' ? '-' : $row->barang_nama;
                    return $barang;
                })
                ->addColumn('totalpesan', function ($row) use ($request) {
                    if ($request->tglawal) {
                        $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')->whereBetween('bk_tanggal', [$request->tglawal, $request->tglakhir])->where('tbl_barangkeluar.barang_kode', '=', $row->barang_kode)->sum('tbl_barangkeluar.bk_jumlah');
                    } else {
                        $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')->where('tbl_barangkeluar.barang_kode', '=', $row->barang_kode)->sum('tbl_barangkeluar.bk_jumlah');
                    }
                if ($request->tglawal) {
                    $pesan_jumlah = PesanModel::where('pesan_idbarang', $row->barang_id)
                        ->join('tbl_status_order', 'tbl_status_order.id', '=', 'tbl_pesan.pesan_idtransaksi')
                        ->whereBetween(DB::raw('DATE(tbl_pesan.created_at)'), [$request->tglawal, $request->tglakhir])
                        ->whereIn('tbl_status_order.status', ['Dikirim', 'Selesai'])
                        ->sum('tbl_pesan.pesan_jumlah');
                } else {
                    $pesan_jumlah = PesanModel::where('pesan_idbarang', $row->barang_id)
                        ->join('tbl_status_order', 'tbl_status_order.id', '=', 'tbl_pesan.pesan_idtransaksi')
                        ->whereIn('tbl_status_order.status', ['Dikirim', 'Selesai'])
                        ->sum('tbl_pesan.pesan_jumlah');
                }
                    
                if ($pesan_jumlah + $jmlkeluar <= 0) {
                    $result = '<div class="d-flex justify-content-center"><span class="badge bg-danger badge-sm me-1 mb-1 mt-1"> ' . $pesan_jumlah + $jmlkeluar. '</span></div>';
                } elseif ($pesan_jumlah + $jmlkeluar > 100) {
                    $result = '<div class="d-flex justify-content-center"><span class="badge bg-success badge-sm me-1 mb-1 mt-1"> ' . $pesan_jumlah + $jmlkeluar . '</span></div>';
                } else {
                    $result = '<div class="d-flex justify-content-center"><span class="badge bg-info badge-sm me-1 mb-1 mt-1"> ' . $pesan_jumlah + $jmlkeluar . '</span></div>';
                }
                
                return $result;
                })
                
                ->addColumn('totalstok', function ($row) use ($request) {
                    if ($request->tglawal == '') {
                        $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')->where('tbl_barangmasuk.barang_kode', '=', $row->barang_kode)->sum('tbl_barangmasuk.bm_jumlah');
                    } else {
                        $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')->whereBetween('bm_tanggal', [$request->tglawal, $request->tglakhir])->where('tbl_barangmasuk.barang_kode', '=', $row->barang_kode)->sum('tbl_barangmasuk.bm_jumlah');
                    }

                        $totalstok = $row->barang_stok + $jmlmasuk;

                        if($totalstok <= 0){
                            $result = '<div class="d-flex justify-content-center"><span class="badge bg-danger badge-sm  me-1 mb-1 mt-1">'.$totalstok.'</span></div>';
                        }elseif ($totalstok > 100){
                            $result = '<div class="d-flex justify-content-center"><span class="badge bg-success badge-sm  me-1 mb-1 mt-1">'.$totalstok.'</span></div>';
                        }else{
                            $result = '<div class="d-flex justify-content-center"><span class="badge bg-info badge-sm  me-1 mb-1 mt-1">'.$totalstok.'</span></div>';
                        }
                    
                    return $result;
                })
                ->addColumn('stoksisa', function ($row) use ($request) {
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

                    $totalpesan = PesanModel::where('pesan_idbarang', $row->barang_id)
                    ->join('tbl_status_order', 'tbl_status_order.id', '=', 'pesan_idtransaksi')
                    ->whereIn('tbl_status_order.status', ['Dikirim', 'Selesai'])
                    ->sum('pesan_jumlah');

                    $totalstatus = StatusOrderModel::with('pesan')
                        ->whereHas('pesan', function ($query) use ($row) {
                            $query->where('pesan_idbarang', $row->barang_id);
                        })
                        ->whereIn('status', ['Dikirim', 'Selesai'])
                        ->first();
                        $totalstok = $row->barang_stok + ($jmlmasuk - $jmlkeluar);

                        if ($totalstatus) {
                            $totalreal = $totalstok - $totalpesan;
                        } else {
                            $totalreal = $totalstok - 0;
                        }
                        if($totalreal <= 0){
                            $result = '<div class="d-flex justify-content-center"><span class="badge bg-danger badge-sm  me-1 mb-1 mt-1">'.$totalreal.'</span></div>';
                        }elseif ($totalreal > 100){
                            $result = '<div class="d-flex justify-content-center"><span class="badge bg-success badge-sm  me-1 mb-1 mt-1">'.$totalreal.'</span></div>';
                        }else{
                            $result = '<div class="d-flex justify-content-center"><span class="badge bg-info badge-sm  me-1 mb-1 mt-1">'.$totalreal.'</span></div>';
                        }
                    
                    return $result;
                })
                ->rawColumns(['stoksisa', 'totalstok', 'totalpesan'])->make(true);
        }
    }
}