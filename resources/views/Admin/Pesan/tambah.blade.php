<!-- MODAL TAMBAH -->
<div class="modal fade" data-bs-backdrop="static" id="modaldemo8">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Konfirmasi Pesanan</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <h4 class="text-center mt-2">
                            <div id="judul">Davibar House</div>
                        </h4>
                        <h4 class="text-center mt-2">
                            <div id="info"></div>
                        </h4>
                        <div class="modal-body">
                            <div class="form-group">
                                <h3 class="card-title ">
                                    <div id="nama">Nama : {{ Session::get('user')->user_nama }}</div>
                                </h3>
                            </div>
                            <div class="form-group">
                                <h3 class="card-title ">
                                    <div id="nama">No Telpon : {{ Session::get('user')->user_notlp }}</div>
                                </h3>
                            </div>
                            <div class="form-group">
                                <h3 class="card-title ">
                                    <div id="nama">Alamat : {{ Session::get('user')->user_alamat }}</div>
                                </h3>
                            </div>
                            <div class="form-group">
                                <label for="note" class="form-label">Note :</label>
                                <textarea name="note" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table id="rincian-order-table-2"
                                    class="table table-bordered text-nowrap border-bottom">
                                    <thead>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <h3 class="card-title">
                                <div id="total-harga-2">Total Harga: Rp. 0</div>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary d-none" id="btnLoader" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <a href="javascript:void(0)" onclick="checkForm()" id="btnSimpan" class="btn btn-primary">Konfirmasi
                    Pesan <i class="fe fe-check"></i></a>
                {{-- <a href="javascript:void(0)" class="btn btn-light" onclick="reset()" data-bs-dismiss="modal">Batal <i
                        class="fe fe-x"></i></a> --}}
                <a href="javascript:void(0)" class="btn btn-light" data-bs-dismiss="modal">Batal <i
                        class="fe fe-x"></i></a>
            </div>
        </div>
    </div>
</div>

@section('formTambahJS')
    <script>
        function reset() {
            // Hapus semua item dari tabel
            var table = document.getElementById("rincian-order-table");
            var table2 = document.getElementById("rincian-order-table-2");
            var tbody = table.getElementsByTagName("tbody")[0];
            var tbody2 = table2.getElementsByTagName("tbody")[0];
            tbody.innerHTML = "";
            tbody2.innerHTML = "";

            // Reset total harga
            document.getElementById("total-harga").innerText = "Total Harga: Rp. 0";
            document.getElementById("total-harga-2").innerText = "Total Harga: Rp. 0";
        }

        function checkForm() {
            var rowCount = $('#rincian-order-table-2 tbody tr').length;
            setLoading(true);

            if (rowCount > 0) {
                // Inisialisasi variabel untuk menyimpan isi td
                var tdContent = "";
                // Iterasi melalui setiap baris <tr>
                $('#rincian-order-table-2 tbody tr').each(function() {
                    // Mengambil nilai dari elemen <td> pertama (index 0)
                    var firstTdValue = $(this).find('td:eq(0)').text();
                });
                swal({
                    title: "Terkirim!",
                    text: "Pesanan Sedang Diproses..",
                    icon: "success",
                    button: "OK",
                });
                submitForm()
            } else {
                // Menampilkan pesan kesalahan menggunakan SweetAlert
                swal({
                    title: "Silahkan Pilih Barang!",
                    type: "error",
                    button: "OK",
                });
                setLoading(false);
            }
        }

        function submitForm() {
            const kode = generateRandomKode();
            // const jumlah = $("input[name='nama']").val();
            // const jenisbarang = $("select[name='jenisbarang']").val();
            // const satuan = $("select[name='satuan']").val();
            // const merk = $("select[name='merk']").val();
            // const harga = $("input[name='harga']").val();
            // const foto = $('#GetFile')[0].files;
            // var fd = new FormData();
            // Append data 
            fd.append('kode', kode);
            // fd.append('nama', nama);
            // fd.append('jenisbarang', jenisbarang);
            // fd.append('satuan', satuan);
            // fd.append('merk', merk);
            // fd.append('harga', harga);
            $.ajax({
                type: 'POST',
                url: "{{ route('pesan.store') }}",
                processData: false,
                contentType: false,
                dataType: 'json',
                data: fd,
                success: function(data) {
                    $('#modaldemo8').modal('toggle');
                    swal({
                        title: "Berhasil ditambah!",
                        type: "success"
                    });
                    table.ajax.reload(null, false);
                    reset();
                }
            });
        }

        function generateRandomKode() {
            // Menghasilkan kode acak dengan panjang 8 karakter
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let kode = '';

            for (let i = 0; i < 8; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                kodeode += characters.charAt(randomIndex);
            }

            return kodeode;
        }

        function setLoading(bool) {
            if (bool == true) {
                $('#btnLoader').removeClass('d-none');
                $('#btnSimpan').addClass('d-none');
            } else {
                $('#btnSimpan').removeClass('d-none');
                $('#btnLoader').addClass('d-none');
            }
        }
    </script>
@endsection
