<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Admin\WebModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class WebController extends Controller
{
    public function index()
    {
        $data["title"] = "Web";
        $data["data"] = WebModel::all();
        return view('Master.Web.index', $data);
    }

    public function update(Request $request, WebModel $web)
    {

        //check if image is uploaded
        if ($request->hasFile('photo')) {

            //upload new image
            $image = $request->file('photo');
            $image->storeAs('public/web', $image->hashName());

            //delete old image
            Storage::delete('public/web/' . $web->web_logo);

            //update post with new image
            $web->update([
                'web_logo' => $image->hashName(),
                'web_nama' => $request->nmweb,
                'web_alamat' => $request->nmalamat,
                'web_tlpn' => $request->nmtlpn,
                'web_deskripsi' => $request->desk,
                'web_bca' => $request->bca,
                'web_mandiri' => $request->mandiri,
                'web_bri' => $request->bri,
                'web_ewallet' => $request->ewallet,
                'web_bca_an' => $request->bca_an,
                'web_mandiri_an' => $request->mandiri_an,
                'web_bri_an' => $request->bri_an,
                'web_ewallet_an' => $request->ewallet_an,
            ]);
        } else {
            $web->update([
                'web_nama' => $request->nmweb,
                'web_alamat' => $request->nmalamat,
                'web_tlpn' => $request->nmtlpn,
                'web_deskripsi'   => $request->desk,
                'web_bca' => $request->bca,
                'web_mandiri' => $request->mandiri,
                'web_bri' => $request->bri,
                'web_ewallet' => $request->ewallet,
                'web_bca_an' => $request->bca_an,
                'web_mandiri_an' => $request->mandiri_an,
                'web_bri_an' => $request->bri_an,
                'web_ewallet_an' => $request->ewallet_an,
            ]);
        }

        $data['title'] = "Web";
        Session::flash('status', 'success');
        Session::flash('msg', 'Berhasil diubah!');

        //redirect to index
        return redirect()->route('web.index')->with($data);
    }

}
