@extends('Master.Layouts.app', ['title' => $data['title']])

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ $data['title'] }}</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Davibar House</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW -->
    <div class="row row-sm">
        <!-- Daftar Produk -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">List Produk</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-1" class="table table-bordered text-nowrap border-bottom">
                            <thead>
                                <th class="border-bottom-0">Gambar</th>
                                <th class="border-bottom-0">Nama</th>
                                <th class="border-bottom-0">Stok</th>
                                <th class="border-bottom-0">Harga</th>
                                <th class="border-bottom-0">Jumlah</th>
                                <th class="border-bottom-0">Pilih</th>
                            </thead>
                            <tbody>
                                @foreach ($arr as $product)
                                    <tr>
                                        <td class="text-center">
                                            <a data-bs-effect="effect-super-scaled" data-bs-toggle="modal"
                                                href="#Gmodaldemo8" onclick="gambar({{ $product['gambar'] }})">
                                                <span class="avatar avatar-lg cover-image rounded-3"
                                                    style="background: url({{ $product['gambar'] == 'image.png' ? url('/assets/default/barang/' . $product['gambar']) : asset('storage/barang/' . $product['gambar']) }}) center center; display: inline-block;"></span>
                                            </a>
                                        </td>
                                        <td>{{ $product['nama'] }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <span
                                                    class="badge @if ($product['total_real'] <= 0) bg-danger
                                                        @elseif($product['total_real'] < 100) bg-success 
                                                        @else bg-info @endif badge-sm  me-1 mb-1 mt-1">
                                                    @if ($product['total_real'] <= 0)
                                                        Stok Kosong
                                                    @else
                                                        {{ $product['total_real'] }} {{ $product['satuan'] }}
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td>Rp. {{ number_format($product['harga'], 0) }}</td>
                                        <td>
                                            <input type="number" name="quantity" id="quantity_{{ $product['barang_id'] }}"
                                                value="0" min="1" max="{{ $product['total_real'] }}"
                                                data-max-stok="{{ $product['total_real'] }}"
                                                onchange="updateAddToCartButton({{ $product['barang_id'] }})"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                style="width: 50px;">
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @if ($product['total_real'] > 0)
                                                    <button class="btn" id="addToCartButton_{{ $product['barang_id'] }}"
                                                        onclick="addToCart({{ $product['barang_id'] }}, '{{ $product['nama'] }}', {{ $product['harga'] }})"
                                                        disabled>Pilih</button>
                                                @else
                                                    <span class="badge bg-danger badge-sm  me-1 mb-1 mt-1">
                                                        Stok Kosong
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                updateAddToCartButton({{ $product['barang_id'] }});
                                            });

                                            function updateAddToCartButton(product_id) {
                                                var quantityInput = document.getElementById('quantity_' + product_id);
                                                var addToCartButton = document.getElementById('addToCartButton_' + product_id);
                                                var maxStok = parseInt(quantityInput.getAttribute('data-max-stok'));
                                                var quantityValue = parseInt(quantityInput.value);

                                                if (quantityValue > maxStok || quantityValue <= 0) {
                                                    addToCartButton.disabled = true;
                                                    addToCartButton.innerHTML = 'Input Jumlah';
                                                    addToCartButton.classList.remove('btn-success', 'btn-danger');
                                                    addToCartButton.classList.add('btn-primary');
                                                } else {
                                                    addToCartButton.disabled = false;
                                                    addToCartButton.innerHTML = 'Pilih';
                                                    addToCartButton.classList.remove('btn-primary', 'btn-danger');
                                                    addToCartButton.classList.add('btn-success');
                                                }
                                                if (quantityValue > maxStok) {
                                                    addToCartButton.disabled = true;
                                                    addToCartButton.innerHTML = 'Melebihi';
                                                    addToCartButton.classList.remove('btn-primary', 'btn-success');
                                                    addToCartButton.classList.add('btn-danger');
                                                }
                                                if (maxStok === 0) {
                                                    addToCartButton.disabled = true;
                                                    addToCartButton.innerHTML = 'Stok Kosong';
                                                    addToCartButton.classList.remove('btn-primary', 'btn-success');
                                                    addToCartButton.classList.add('btn-danger');
                                                }
                                            }
                                        </script>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Rincian Order -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">Rincian Order</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="rincian-order-table" class="table table-bordered text-nowrap border-bottom">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-header justify-content-between">
                    <h3 class="card-title">
                        <div id="total-harga">
                            <span>Total : <span id="total-harga-value" style="color: rgb(15, 209, 41);">Rp. 0 </span></span>
                            @if (in_array(Session::get('user')->role_id, ['1', '2', '4']))
                                <br>
                                <br>
                                <span>Disc: <span id="diskon-value" style="color: rgb(209, 77, 15);">Rp. -0</span></span>
                            @endif
                        </div>
                    </h3>
                </div>
                @if (in_array(Session::get('user')->role_id, ['1', '2', '4']))
                    <div class="card-header justify-content-around">
                        <div class="input-group">
                            <span class="input-group-text">Diskon Rp.</span>
                            <input nama="diskon" min="0" value="0" type="number" class="form-control"
                                id="diskon" placeholder="Diskon" style="width: 150px;" oninput="updateTotalHarga()">
                        </div>
                    </div>
                @endif
                <div class="card-header justify-content-around">
                    <button class="btn btn-warning d-none" id="btnLoaderU" type="button" disabled="">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading..
                    </button>
                    <a href="javascript:void(0)" onclick="check()" id="btnSimpanU" class="btn btn-primary">Checkout
                    </a>
                </div>
            </div>
        </div>
        <!-- Modal Rincian Order -->
        <script>
            var cartItems = {};

            function addToCart(barang_id, barang_nama, barang_harga) {
                var quantityInput = document.getElementById('quantity_' + barang_id);
                var quantity = parseInt(quantityInput.value, 10);
                var maxStok = parseInt(quantityInput.getAttribute('data-max-stok'), 10);
                var totalHarga = quantity * barang_harga;

                if (cartItems[barang_id]) {
                    var remainingQuantity = maxStok - cartItems[barang_id].quantity;
                    if (quantity > remainingQuantity) {
                        swal({
                            title: 'Melebihi stok yang tersedia',
                            text: 'Stok yang tersedia: ' + remainingQuantity,
                            type: "warning",
                        });
                        return;
                    }
                    cartItems[barang_id].quantity += quantity;
                } else {
                    cartItems[barang_id] = {
                        nama: barang_nama,
                        harga: barang_harga,
                        quantity: quantity,
                    };
                    swal({
                        title: 'Produk ditambahkan',
                        text: 'Nama: ' + barang_nama + '\nJumlah: ' + quantity,
                        type: "success",
                    });
                }
                var newTotalHarga = Object.values(cartItems).reduce(function(total, item) {
                    return total + item.quantity * item.harga;
                }, 0);
                updateCartView();
                var totalHargaElement = document.getElementById('total-harga-value');
                totalHargaElement.innerHTML = '<span style="color: rgb(15, 209, 41);"> Rp.' + newTotalHarga
                    .toLocaleString() + '</span>';
            }

            function numberFormat(angka) {
                return 'Rp. ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            function updateCartView() {
                var cartItemsHTML = '';
                for (var itemId in cartItems) {
                    var item = cartItems[itemId];
                    var formattedHarga = numberFormat(item.harga);
                    cartItemsHTML += `<tr>
                            <td>${item.nama}</td>
                            <td>${formattedHarga}</td>
                            <td>${item.quantity}</td>
                            <td class="d-flex justify-content-center">
                                <button class="btn btn-danger fa fa-trash" onclick="removeFromCart(this, ${itemId}, ${item.quantity * item.harga})"></button>
                            </td>
                        </tr>`;
                }
                document.getElementById('cart-items').innerHTML = cartItemsHTML;
            }

            function removeFromCart(button, barang_id, totalHarga) {
                var row = button.parentNode.parentNode;
                row.parentNode.removeChild(row);
                var totalHargaSebelumnya = Object.values(cartItems).reduce(function(total, item) {
                    return total + item.quantity * item.harga;
                }, 0);
                var newTotalHarga = totalHargaSebelumnya - totalHarga;
                newTotalHarga = Math.max(0, newTotalHarga);
                var totalHargaElement = document.getElementById('total-harga-value');
                totalHargaElement.innerHTML = '<span style="color: rgb(15, 209, 41);"> Rp.' + newTotalHarga
                    .toLocaleString() + '</span>';
                delete cartItems[barang_id];
                updateCartView();
            }

            function check() {
                setLoadingH(true);
                var cartItems = $("#rincian-order-table tbody#cart-items tr").map(function() {
                    var rowData = $(this).find('td').map(function() {
                        return $(this).text().trim();
                    }).get();
                    return rowData;
                }).get();

                if (cartItems.length === 0 || cartItems.every(item => Object.values(item).every(val => val === ""))) {
                    validasi();
                    setLoadingH(false);
                    return false;
                } else {
                    confirmCheckout();
                }
            }

            function confirmCheckout() {
                swal({
                    title: "Pesan Sekarang?",
                    type: "warning",
                    confirmButtonText: 'Pesan',
                    showCancelButton: true,
                    cancelButtonText: 'Batal'
                }, function(isConfirmed) {
                    if (isConfirmed) {
                        addToPesan();
                    } else {
                        setLoadingH(false);
                    }
                });
            }

            function addToPesan() {
                var diskoninput = document.getElementById('diskon');
                var diskon = diskoninput ? parseInt(diskoninput.value, 10) : 0;
                const tableData = [];
                var fd = new FormData();

                for (var itemId in cartItems) {
                    var item = cartItems[itemId];
                    tableData.push([item.quantity, itemId]);
                }

                fd.append('_token', '{{ csrf_token() }}');
                fd.append('data', tableData);
                fd.append('diskon', diskon); // Tambahkan nilai diskon ke FormData

                $.ajax({
                    type: 'POST',
                    url: "{{ route('addPesan') }}",
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    data: fd,
                    success: function(response) {
                        window.location.href = "{{ route('statustransaksi') }}";
                    },
                    error: function(error) {
                        console.error(error);
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

            function validasi(message, type) {
                swal({
                    title: "Item Order Kosong",
                    type: "warning"
                });
            }

            function updateTotalHarga() {
                var diskonInput = document.getElementById('diskon');
                var diskonValue = parseInt(diskonInput.value) || 0;

                var newTotalHarga = Object.values(cartItems).reduce(function(total, item) {
                    return total + item.quantity * item.harga;
                }, 0);

                // Kurangkan diskon dari total harga
                newTotalHarga -= diskonValue;

                // Tampilkan total harga yang baru
                var totalHargaElement = document.getElementById('total-harga-value');
                totalHargaElement.innerHTML = 'Rp. ' + newTotalHarga.toLocaleString();
                var diskonValueElement = document.getElementById('diskon-value');
                diskonValueElement.innerHTML = 'Rp. -' + diskonValue.toLocaleString();
            }
        </script>
    @endsection

    @section('scripts')
        <style>
            #table-1_filter input {
                width: 150px !important;
            }
        </style>
        <script>
            $(document).ready(function() {
                $('#table-1').DataTable({
                    "paging": true,
                    "scrollX": true,
                    "searching": true,
                    "info": true,
                    "autoWidth": false,
                    "lengthMenu": [
                        [5, 10, 25, 50, 100],
                        [5, 10, 25, 50, 100]
                    ],
                    "pageLength": 5,
                    lengthChange: true,
                });
            });
        </script>
    @endsection
