<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BarangkeluarModel;
use App\Models\Admin\BarangmasukModel;
use App\Models\Admin\BarangModel;
use App\Models\Admin\WebModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PDF;

class LapStokBarangController extends Controller
{
    public function index(Request $request)
    {
        $data["title"] = "Lap Stok Barang";
        return view('Admin.Laporan.StokBarang.index', $data);
    }

    public function print(Request $request)
    {
        $data['data'] = BarangModel::leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')->orderBy('barang_id', 'DESC')->get();

        $data["title"] = "Print Stok Barang";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;
        return view('Admin.Laporan.StokBarang.print', $data);
    }

    public function pdf(Request $request)
    {
        $data['data'] = BarangModel::leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')->orderBy('barang_id', 'DESC')->get();

        $data["title"] = "PDF Stok Barang";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;
        $pdf = PDF::loadView('Admin.Laporan.StokBarang.pdf', $data);
        
        if($request->tglawal){
            return $pdf->download('lap-stok-'.$request->tglawal.'-'.$request->tglakhir.'.pdf');
        }else{
            return $pdf->download('lap-stok-semua-tanggal.pdf');
        }
        
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangModel::leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')->orderBy('barang_id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('stokawal', function ($row) {
                    
                    if($row->barang_stok <= 0){
                        $result = '<div class="d-flex justify-content-center"><span class="badge bg-danger badge-sm  me-1 mb-1 mt-1">'.$row->barang_stok.'</span></div>';
                    }else if($row->barang_stok > 100){
                        $result = '<div class="d-flex justify-content-center"><span class="badge bg-success badge-sm  me-1 mb-1 mt-1">'.$row->barang_stok.'</span></div>';
                    }else{
                        $result = '<div class="d-flex justify-content-center"><span class="badge bg-info badge-sm  me-1 mb-1 mt-1">'.$row->barang_stok.'</span></div>';
                    }
                    return $result;
                })
                ->addColumn('jmlmasuk', function ($row) use ($request) {
                    if ($request->tglawal == '') {
                        $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')->where('tbl_barangmasuk.barang_kode', '=', $row->barang_kode)->sum('tbl_barangmasuk.bm_jumlah');
                    } else {
                        $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')->whereBetween('bm_tanggal', [$request->tglawal, $request->tglakhir])->where('tbl_barangmasuk.barang_kode', '=', $row->barang_kode)->sum('tbl_barangmasuk.bm_jumlah');
                    }

                    if($jmlmasuk <= 0){
                        $result = '<div class="d-flex justify-content-center"><span class="badge bg-danger badge-sm  me-1 mb-1 mt-1">'.$jmlmasuk.'</span></div>';
                    }else if($jmlmasuk > 100){
                        $result = '<div class="d-flex justify-content-center"><span class="badge bg-success badge-sm  me-1 mb-1 mt-1">'.$jmlmasuk.'</span></div>';
                    }else{
                        $result = '<div class="d-flex justify-content-center"><span class="badge bg-info badge-sm  me-1 mb-1 mt-1">'.$jmlmasuk.'</span></div>';
                    }
                    return $result;
                })
                ->addColumn('jmlkeluar', function ($row) use ($request) {
                    if ($request->tglawal) {
                        $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')->whereBetween('bk_tanggal', [$request->tglawal, $request->tglakhir])->where('tbl_barangkeluar.barang_kode', '=', $row->barang_kode)->sum('tbl_barangkeluar.bk_jumlah');
                    } else {
                        $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')->where('tbl_barangkeluar.barang_kode', '=', $row->barang_kode)->sum('tbl_barangkeluar.bk_jumlah');
                    }

                    if($jmlkeluar <= 0){
                        $result = '<div class="d-flex justify-content-center"><span class="badge bg-danger badge-sm  me-1 mb-1 mt-1">'.$jmlkeluar.'</span></div>';
                    }else if($jmlkeluar > 100){
                        $result = '<div class="d-flex justify-content-center"><span class="badge bg-success badge-sm  me-1 mb-1 mt-1">'.$jmlkeluar.'</span></div>';
                    }else{
                        $result = '<div class="d-flex justify-content-center"><span class="badge bg-info badge-sm  me-1 mb-1 mt-1">'.$jmlkeluar.'</span></div>';
                    }
                    return $result;
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
                    if($totalstok < 0){
                        $result = '<div class="d-flex justify-content-center"><span class="badge bg-danger badge-sm  me-1 mb-1 mt-1">'.$totalstok.'</span></div>';
                    }else if($totalstok > 100){
                        $result = '<div class="d-flex justify-content-center"><span class="badge bg-success badge-sm  me-1 mb-1 mt-1">'.$totalstok.'</span></div>';
                    }else{
                        $result = '<div class="d-flex justify-content-center"><span class="badge bg-info badge-sm  me-1 mb-1 mt-1">'.$totalstok.'</span></div>';
                    }
                    
                    return $result;
                })
                ->rawColumns(['stokawal', 'jmlmasuk', 'jmlkeluar', 'totalstok'])->make(true);
        }
    }
}
