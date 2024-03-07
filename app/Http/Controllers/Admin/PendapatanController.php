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
}