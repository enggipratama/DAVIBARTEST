@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ $title }}</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Davibar House</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">Profile</h3>
                    <a href="{{ route('statustransaksi') }}" class="btn btn-danger fa fa-arrow-left text-center">
                        Kembali</a>
                </div>
                <div class="card-body">
                    <div class="text-center chat-image mb-5">
                        <div class="avatar avatar-xxl chat-profile mb-3 brround">
                            @if (Session::get('user')->user_foto == 'undraw_profile.svg' || Session::get('user')->user_foto == '')
                                <img src="{{ url('/assets/default/users/undraw_profile.svg') }}" alt="profile-user">
                            @else
                                <img src="{{ asset('storage/users/' . Session::get('user')->user_foto) }}"
                                    alt="profile-user">
                            @endif
                        </div>
                        <div class="main-chat-msg-name me-4">
                            <h5 class="mb-1 text-dark fw-semibold">{{ Session::get('user')->user_nmlengkap }}</h5>
                            <h5 class="text-muted mb-1 text-dark fw-semibold">Sebagai :
                                {{ Session::get('user')->role_title }}</h5>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Alamat</label>
                        <div class=" input-group" id="alamat">
                            <a class="input-group-text bg-white">
                                <i class="fa fa-home"></i>
                            </a>
                            <textarea class="form-control" id="alamat" rows="2" name="alamat" disabled>{{ Session::get('user')->user_alamat }}</textarea>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">No Telpon</label>
                        <div class=" input-group" id="notlp">
                            <a class="input-group-text bg-white">
                                <i class="fa fa-phone"></i>
                            </a>
                            <input class="form-control" id="notlp" type="text" name="notlp"
                                value="{{ Session::get('user')->user_notlp }}" disabled>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Email</label>
                        <div class=" input-group" id="email">
                            <a class="input-group-text bg-white">
                                <i class="fa fa-envelope"></i>
                            </a>
                            <input class="form-control" id="email" type="text" name="email"
                                value="{{ Session::get('user')->user_email }}" disabled>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">List Barang</h3>
                    <h3 class="card-title">Kode : <span
                            style="color: rgb(15, 209, 41);">{{ $results->first()->kode_inv }}</span>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-1" class="table table-bordered text-nowrap border-bottom">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">Gambar</th>
                                    <th class="border-bottom-0">Nama</th>
                                    <th class="border-bottom-0">Harga</th>
                                    <th class="border-bottom-0">Jumlah</th>
                                    <th class="border-bottom-0">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalHarga = 0; // Initialize total harga variable outside the loop
                                @endphp
                                @foreach ($results as $result)
                                    <tr>
                                        <td class="text-center">
                                            <a data-bs-effect="effect-super-scaled" data-bs-toggle="modal"
                                                href="#Gmodaldemo8" onclick="gambar({{ $result->barang_gambar }})">
                                                <span class="avatar avatar-lg cover-image rounded-3"
                                                    style="background: url({{ $result->barang_gambar == 'image.png' ? url('/assets/default/barang/' . $result->barang_gambar) : asset('storage/barang/' . $result->barang_gambar) }}) center center; display: inline-block;"></span>
                                            </a>
                                        </td>
                                        <td>{{ $result->barang_nama }}</td>
                                        <td>Rp. {{ number_format($result->barang_harga, 0) }}</td>
                                        <td>{{ $result->pesan_jumlah }} {{ $result->satuan_nama }}</td>
                                        <td>Rp. {{ number_format($result->pesan_jumlah * $result->barang_harga, 0) }}</td>
                                    </tr>
                                    @php
                                        $totalHarga += $result->pesan_jumlah * $result->barang_harga; // Accumulate the total harga
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-header justify-content-between">
                    <h3 class="card-title">
                        <div id="total-harga">Total Harga: Rp. {{ number_format($totalHarga, 0) }}</div>
                    </h3>
                    <div class="d-flex justify-content-center">
                        <span id="statusBadge" class="badge bg-warning badge-sm me-1 mb-1 mt-1">
                            {{ $results->first()['status'] }}
                        </span>
                    </div>
                </div>
                <div class="card-header justify-content-between">
                    <a href="{{ route('cetakStruk', ['id' => $results->first()->kode_inv]) }}" class="btn btn-success" target="_blank">Print Invoice</a>
                    @if (Session::get('user')->role_id != 3)
                        <div class="d-flex">
                            <form method="post"
                                action="{{ route('update.status', ['id' => $results->first()->kode_inv]) }}">
                                @csrf
                                <select name="status" class="form-control">
                                    <option value="">Status</option>
                                    @foreach (App\Models\StatusOrderModel::getStatusOptions() as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ $results->first()['status'] == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                            <div class="ms-1">
                                <button class="btn btn-primary d-none" id="btnLoaderU" type="button" disabled="">
                                    <span class="spinner-border spinner-border-sm me-1" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <a href="javascript:void(0)" onclick="confirm()" id="btnSimpanU"
                                    class="btn btn-primary">Update</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- ROW -->
@endsection

<script>
    function submit() {
        var selectedStatus = document.querySelector('select[name="status"]').value;
        if (selectedStatus) {
            fetch('{{ route('update.status', ['id' => $results->first()->kode_inv]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: selectedStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    setLoadingH(false);
                    swal({
                        title: "Berhasil Diupdate!",
                        type: "success"
                    });
                })
                .catch(error => {
                    setLoadingH(false);
                    swal({
                        title: "Gagal Update!",
                        type: "warning"
                    });
                });
        }
        updateStatus()
    }

    function confirm() {
        setLoadingH(true);
        swal({
            title: "Update Status Pesanan?",
            type: "warning",
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Batal'
        }, function(isConfirmed) {
            if (isConfirmed) {
                submit();
            } else {
                setLoadingH(false);
            }
        });
    }

    function setLoadingH(bool) {
        if (bool) {
            $('#btnLoaderU').removeClass('d-none');
            $('#btnSimpanU').addClass('d-none');
        } else {
            $('#btnSimpanU').removeClass('d-none');
            $('#btnLoaderU').addClass('d-none');
        }
    }

    function updateStatus() {
    // Lakukan permintaan AJAX ke server untuk mendapatkan status terbaru
    $.ajax({
        url: '{{ route('update.status', ['id' => $results->first()->kode_inv]) }}', // Ganti dengan URL sesuai kebutuhan Anda
        method: 'GET',
        success: function(response) {
            // Ambil status dari respons server
            var newStatus = document.querySelector('select[name="status"]').value;

            // Cetak nilai status ke konsol untuk pemantauan
            console.log("Current status:", newStatus);

            // Memperbarui status badge
            $('#statusBadge').removeClass().addClass('badge badge-sm me-1 mb-1 mt-1');

            if (newStatus == 'Pending') {
                $('#statusBadge').addClass(' bg-warning ').text(newStatus);
            } else if (newStatus == 'Dikirim') {
                $('#statusBadge').addClass(' bg-success ').text(newStatus);
            } else if (newStatus == 'Dibatalkan') {
                $('#statusBadge').addClass(' bg-danger ').text(newStatus);
            } else if (newStatus == 'Selesai') {
                $('#statusBadge').addClass(' bg-primary ').text(newStatus);
            }
        },
        error: function(error) {
            console.error("Error fetching status:", error);
        }
    });
}

</script>
