<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center mt-1">
    <div class="col-md-12" style="font-size: 12px;">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title">ITEM RECEIVED</h3>
                <a href="<?= base_url('StockIn') ?>" type="button" class="btn btn-sm mb-2 mt-n2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>
            <div class="card-body">
                <div class="row p-3">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-2">SUPPLIER ID</div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" style="font-size: 12px;height: 26px;" value="<?= $stkin['kode_supplier'] ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">SUPPLIER NAME</div>
                            <div class="col-md-8">
                                <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $stkin['nama_supplier'] ?>" readonly>
                                <input type="hidden" name="status" id="status">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">ADDRESS</div>
                            <div class="col-md-8">
                                <input type="text" name="address1" id="address1" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $stkin['address1'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input type="text" name="address2" id="address2" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $stkin['address2'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">RECEIPT NO</div>
                            <div class="col-md-4">
                                <input type="text" name="no_bukti" id="no_bukti" class="form-control form-control-sm text-bold text-danger" style="font-size: 12px;height: 26px;" value="<?= $stkin['no_bukti'] ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">RECEIVE DATE</div>
                            <div class="col-md-4">
                                <input type="date" name="tgl_bukti" id="tgl_bukti" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $stkin['tgl_bukti'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">NO PO</div>
                            <div class="col-md-6">
                                <input type="text" name="no_po" id="no_po" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $stkin['no_po'] ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">DESCRIPTION</div>
                            <div class="col-md-8">
                                <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $stkin['keterangan'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-2">
                        <div class="bg-primary text-center">ITEM NO</div>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm kode_barang" aria-describedby="basic-addon2" name="kode_barang" id="kode_barang" style="font-size: 12px;height: 26px;" onkeyup="this.value = this.value.toUpperCase()">
                            <input type="hidden" name="id_barang" id="id_barang">
                            <div class="input-group-append">
                                <button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon2" style="font-size: 12px;height: 26px;"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-primary text-center">ITEM NAME</div>
                        <div>
                            <input type="text" class="form-control form-control-sm" name="nama_barang" id="nama_barang" style="font-size: 12px;height: 26px;" readonly>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="bg-primary text-center">QTY</div>
                        <div>
                            <input type="text" class="form-control  form-control-sm text-right autonum2" name="qty" id="qty" style="font-size: 12px;height: 26px;">
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="bg-primary text-center">UNIT</div>
                        <div>
                            <input type="text" class="form-control form-control-sm" name="kode_satuan" id="kode_satuan" style="font-size: 12px;height: 26px;" readonly>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <span>&nbsp</span>
                            <button type="button" class="btn btn-success btn-xs d-block tombolTambah" id="btnTambah"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 dataDetailInv" id="dataDetailInv">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-success btn-xs ml-3 tombolSimpanInv" type="button" id="btnSimpanInv">
                        SAVE DATA
                    </button>
                </div>
            </div>
        </div>        
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>


<script>

    $(document).ready(function() {
        dataDetailInv();
        $('#tgl_bukti').focus();
    });

    function dataDetailInv() {
        no_bukti = $('#no_bukti').val();
        // status = $('#status').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('StockIn/dataDetail') ?>",
            data: {
                no_bukti: no_bukti,
                // status: status
            },
            dataType: "json",
            beforeSend: function() {
                $('.dataDetailInv').html('<i class="fa-spin fa-spinner"></i>')
            },
            success: function(response) {
                if (response.data) {
                    $('.dataDetailInv').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        $('.tombol-supplier').click(function(e) {
            e.preventDefault();
            $('#modal-supplier').modal('show');
            $('#modal-supplier').on('shown.bs.modal', function() {
                $("#modal-supplier [type='search']").focus();
            })
        });

        $('.tombol-barang').click(function(e) {
            e.preventDefault();
            cekKode();
        });

        $('#kode_barang').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekKode2();
            }
        });

        $('#kode_supplier').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#tgl_bukti').focus();
            }
        });
        $('#tgl_bukti').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#keterangan').focus();
            }
        });
        $('#keterangan').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#kode_barang').focus();
            }
        });

        $('#qty').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#btnTambah').focus();
            }
        });

        $('#btnTambah').click(function(e) {
            e.preventDefault();
            masukCart();
        });
    });


    function cekKode() {
        $.ajax({
            url: "<?= site_url('StockIn/viewDataBarang') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewmodal').html(response.viewmodal).show();
                $('#modalbarang').modal('show');
                $('#modalbarang').on('shown.bs.modal', function() {
                    $("#modalbarang [type='search']").focus();
                })
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    }

    function cekKode2() {
        let kode_barang = $('#kode_barang').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('Barang/cari_kodebarang2') ?>",
            data: {
                kode_barang: kode_barang,
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $.each(data, function(id_barang,kode_barang, nama_barang, kode_satuan) {
                    $('[id="id_barang"]').val(data.id_barang);
                    $('[id="kode_barang"]').val(data.kode_barang);
                    $('[id="nama_barang"]').val(data.nama_barang);
                    $('[id="kode_satuan"]').val(data.kode_satuan);
                    $("#qty").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    }

    function masukCart() {
        $.ajax({
            type: "post",
            url: "<?= site_url('StockIn/simpanTemp') ?>",
            data: {
                no_bukti: $('#no_bukti').val(),
                id_barang: $('#id_barang').val(),
                kode_barang: $('#kode_barang').val(),
                nama_barang: $('#nama_barang').val(),
                kode_satuan: $('#kode_satuan').val(),
                qty: $('#qty').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses == 'berhasil') {
                    dataDetailInv();
                    kosong();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function kosong() {
        $('#kode_barang').val('');
        $('#nama_barang').val('');
        $('#kode_satuan').val('');
        $('#qty').val('');
        $('#kode_barang').focus();
    }

    $('.tombolSimpanInv').click(function(e) {
        e.preventDefault();
        let nobukti = $('#no_bukti').val();
        let tglbukti = $('#tgl_bukti').val();
        let keterangan = $('#keterangan').val();
        let kodesupplier = $('#kode_supplier').val();
        let nopo = $('#no_po').val();

        $.ajax({
            type: "post",
            url: "<?= base_url('StockIn/updatedata') ?>",
            data: {
                no_bukti: nobukti,
                tgl_bukti: tglbukti,
                kode_supplier: kodesupplier,
                no_po: nopo,
                keterangan: keterangan,
            },
            dataType: "json",
            beforeSend: function() {
                $('.tombolSimpanInv').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanInv').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanInv').html('SAVE DATA');
                $('.tombolSimpanInv').prop('disabled', false);
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    html: response.sukses,
                }).then((result) => {
                    if (result.value) {
                        window.location = "<?= base_url('StockIn') ?>";
                    }
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);

            }
        });
    });

    $('#no_po').on('change', function() {
        let no_po = $(this).val();
        let no_bukti = $('#no_bukti').val();
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('StockIn/get_datapo') ?>",
            data: {
                no_po: no_po,
                no_bukti: no_bukti
            },
            success: function(response) {
                if (response.sukses == 'berhasil') {
                    dataDetailInv();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    });
</script>

<?= $this->endSection() ?>


