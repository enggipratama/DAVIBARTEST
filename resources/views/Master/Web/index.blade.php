@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Pengaturan Web</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Davibar House</li>
                <li class="breadcrumb-item text-gray">Settings</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <div class="row">
        <div class="col-12 col-md-12 col-lg-6 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="fw-bold mt-2">Profil Website</h6>
                </div>
                <div class="card-body">
                    @foreach ($data as $d)
                        <div class="text-center py-5 mb-4">
                            @if ($d->web_logo == '' || $d->web_logo == 'default.png')
                                <img src="{{ url('assets/default/web/default.png') }}" alt="logo" width="120">
                            @else
                                <img src="{{ asset('storage/web/' . $d->web_logo) }}" alt="logo" width="120">
                            @endif
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-between mx-4">
                        <h6 class="mr-4">Nama</h6>
                        <h6 class="font-weight-bold">{{ $d->web_nama }}</h6>
                    </div>

                    <hr class="">
                    <div>
                        <label class="form-label">Alamat</label>
                        <div class=" input-group" id="alamat">
                            <a class="input-group-text bg-white">
                                <i class="fa fa-home"></i>
                            </a>
                            <textarea class="form-control" id="alamat" rows="2" name="alamat" disabled>{{ $d->web_alamat == '' ? '-' : $d->web_alamat }}</textarea>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">No Telpon</label>
                        <div class=" input-group" id="notlp">
                            <a class="input-group-text bg-white">
                                <i class="fa fa-phone"></i>
                            </a>
                            <input class="form-control" id="notlp" type="text" name="notlp"
                                value="{{ $d->web_tlpn == '' ? '-' : $d->web_tlpn }}" disabled>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Deskripsi</label>
                        <div class=" input-group" id="deskripsi">
                            <a class="input-group-text bg-white">
                                <i class="fa fa-list"></i>
                            </a>
                            <input class="form-control" id="deskripsi" type="text" name="deskripsi"
                                value="{{ $d->web_deskripsi }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6 mb-4">
            <form action="{{ route('web.update', $d->web_id) }}" method="POST" name="myForm" enctype="multipart/form-data"
                onsubmit="return validateForm()">
                <div class="card shadow border-0">
                    <div class="card-header">
                        <h6 class="mt-2 fw-bold">Ubah Pengaturan</h6>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="alert alert-info alert-icon d-flex shadow" role="alert">
                            <div class="alert-icon-aside">
                                <i class="fa fa-exclamation-circle"></i>
                            </div>
                            <div class="alert-icon-content ms-1 mt-1">
                                <h6 class="alert-heading">Extensi Gambar</h6>
                                .jpg .jpeg .png
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="formFile" class="form-label mt-0">Logo</label>
                            <input class="form-control" id="GetFile" name="photo" type="file"
                                accept=".png,.jpeg,.jpg,.svg" onchange="VerifyFileNameAndFileSize()">
                        </div>

                        <div class="form-group">
                            <label>Nama Website</label>
                            <input type="text" class="form-control" name="nmweb" value="{{ $d->web_nama }}">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" class="form-control" name="nmalamat" value="{{ $d->web_alamat == '' ? '-' : $d->web_alamat }}">
                        </div>
                        <div class="form-group">
                            <label>No Telpon</label>
                            <input type="number" class="form-control" name="nmtlpn" value="{{ $d->web_tlpn == '0' ? '-' : $d->web_tlpn }}">
                        </div>

                        <div class="form-group">
                            <label>Deskripsi Website</label>
                            <textarea name="desk" rows="5" class="form-control">{{ $d->web_deskripsi }}</textarea>
                        </div>


                    </div>

                    <div class="card-footer">
                        <div class="mb-2">
                            <button type="submit" class="btn btn-success btn-md shadow">Simpan Perubahan
                                <i class="fa fa-check-circle"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function validateForm() {
            var nmweb = document.forms["myForm"]["nmweb"].value;
            var nmalamat = document.forms["myForm"]["nmalamat"].value;
            var nmtlpn = document.forms["myForm"]["nmtlpn"].value;

            if (nmweb == "") {
                validasi('Nama Website wajib di isi!', 'warning');
                $("input[name='nmweb']").addClass('is-invalid');
                return false;
            }
            if (nmalamat == "") {
                validasi('Alamat wajib di isi!', 'warning');
                $("input[name='nmalamat']").addClass('is-invalid');
                return false;
            }
            if (nmtlpn == "") {
                validasi('No Telpon wajib di isi!', 'warning');
                $("input[name='nmtlpn']").addClass('is-invalid');
                return false;
            }

        }

        function validasi(judul, status) {
            swal({
                title: judul,
                type: status,
                confirmButtonText: "Iya."
            });
        }

        function fileIsValid(fileName) {
            var ext = fileName.match(/\.([^\.]+)$/)[1];
            ext = ext.toLowerCase();
            var isValid = true;
            switch (ext) {
                case 'png':
                case 'jpeg':
                case 'jpg':
                case 'svg':

                    break;
                default:
                    this.value = '';
                    isValid = false;
            }
            return isValid;
        }

        function VerifyFileNameAndFileSize() {
            var file = document.getElementById('GetFile').files[0];


            if (file != null) {
                var fileName = file.name;
                if (fileIsValid(fileName) == false) {
                    validasi('Format bukan gambar!', 'warning');
                    document.getElementById('GetFile').value = null;
                    return false;
                }
                var content;
                var size = file.size;
                if ((size != null) && ((size / (1024 * 1024)) > 3)) {
                    validasi('Ukuran maximum 1024px', 'warning');
                    document.getElementById('GetFile').value = null;
                    return false;
                }

                var ext = fileName.match(/\.([^\.]+)$/)[1];
                ext = ext.toLowerCase();
                return true;

            } else
                return false;
        }
    </script>
@endsection
