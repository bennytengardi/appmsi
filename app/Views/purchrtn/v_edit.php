<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>


<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-primary" style="background-color: lightskyblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">PURCHASE RETURN</h3>
                <a href="<?= base_url('PurchRtn') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <div class="card p-3" style="background-color: #d0ecff;">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-3">SUPPLIER ID</div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm  kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" value="<?= $pr['kode_supplier'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">SUPPLIER NAME</div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm"  value="<?= $pr['nama_supplier'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">ADDRESS </div>
                                <div class="col-md-8">
                                    <input type="text" name="address1" id="address1" class="form-control form-control-sm"  value="<?= $pr['address1'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address2" id="address2" class="form-control form-control-sm"  value="<?= $pr['address2'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address3" id="address3" class="form-control form-control-sm"  value="<?= $pr['address3'] ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-3">RETURN NO</div>
                                <div class="col-md-3">
                                    <input type="text" name="no_retur" id="no_retur" class="form-control form-control-sm  font-weight-bold" value="<?= $pr['no_retur'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">RETURN DATE</div>
                                <div class="col-md-3">
                                    <input type="date" name="tgl_retur" id="tgl_retur" class="form-control form-control-sm " value="<?= $pr['tgl_retur'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">NO INVOICE</div>
                                <div class="col-md-4">
                                    <input type="text" name="no_invoice" id="no_invoice" class="form-control form-control-sm " value="<?= $pr['no_invoice'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">CURRENCY</div>
                                <div class="col-md-2">
                                    <input type="text" name="currency" id="currency" class="form-control form-control-sm" value="<?= $pr['currency'] ?>" readonly>
                                </div>
                                <div class="col-md-2 text-right">KURS</div>
                                <div class="col-md-2">
                                    <input type="text" name="kurs" id="kurs" class="form-control form-control-sm text-right autonum" value="<?= $pr['kurs'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">DESCRIPTION</div>
                                <div class="col-md-9">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" value="<?= $pr['keterangan'] ?>" onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- <hr style="margin-top: -2px"> -->

                <div class="card p-3" style="background-color: #d0ecff;">
                    <div class="row">
                        <div class="col-md-2 ml-2">
                            <div class="bg-primary text-center">ITEM NO</div>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm  kode_barang" aria-describedby="basic-addon2" name="kode_barang" id="kode_barang" onkeyup="this.value = this.value.toUpperCase()">
                                <input type="hidden" name="id_barang" id="id_barang">
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon2"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="bg-primary text-center">ITEM NAME</div>
                                <input type="text" class="form-control form-control-sm " name="nama_barang" id="nama_barang" readonly>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="bg-primary text-center">QTY</div>
                                <input type="text" class="form-control  form-control-sm  text-right autonum2" name="qty" id="qty">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="bg-primary text-center">UNIT</div>
                                <input type="text" class="form-control form-control-sm " name="kode_satuan" id="kode_satuan" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="bg-primary text-center">PRICE</div>
                                <input type="text" class="form-control  form-control-sm  text-right autonum" name="harga" id="harga">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <div>&nbsp</div>
                                <button type="button" class="btn btn-success btn-sm d-block tombolTambah" id="btnTambah"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 dataDetailInv" id="dataDetailInv">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm tombolSimpanInv" type="button" id="btnSimpanInv">
                        SAVE DATA
                    </button>
                </div>

            </div>
        </div>

        <div class="viewmodal" style="display: none;"></div>

<script>

    $(document).ready(function() {
        dataDetailInv();
        $('#kode_supplier').focus();
    });

    function dataDetailInv() {
        no_retur = $('#no_retur').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('PurchRtn/dataDetail') ?>",
            data: {
                no_retur: no_retur
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

        $('#tgl_retur').keydown(function(e) {
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
                $('#harga').focus();
            }
        });
        $('#harga').keydown(function(e) {
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
            url: "<?= site_url('SalesInv/viewDataBarang') ?>",
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
        let id_barang = $('#id_barang').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('Barang/cari_idbarang') ?>",
            data: {
                id_barang: id_barang,
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $.each(data, function(id_barang,kode_barang, nama_barang, kode_satuan, hargajual) {
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
            url: "<?= site_url('PurchRtn/simpanTemp') ?>",
            data: {
                no_random: $('#no_retur').val(),
                id_barang:   $('#id_barang').val(),
                kode_barang:   $('#kode_barang').val(),
                nama_barang: $('#nama_barang').val(),
                kode_satuan: $('#kode_satuan').val(),
                qty: $('#qty').val(),
                harga: $('#harga').val(),
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
        $('#harga').val('');
        $('#kode_barang').focus();
    }

    $('.tombolSimpanInv').click(function(e) {
        e.preventDefault();
        let noretur      = $('#no_retur').val();
        let tglretur     = $('#tgl_retur').val();
        let kodesupplier = $('#kode_supplier').val();
        let noinvoice    = $('#no_invoice').val();
        let keterangan   = $('#keterangan').val();
        let kurs         = $('#kurs').val();
        let totaldpp     = $('#total_dpp').val();
        let totalppn     = $('#total_ppn').val();
        let totalretur   = $('#total_retur').val();

        $.ajax({
            type: "post",
            url: "<?= base_url('PurchRtn/updateData') ?>",
            data: {
                no_retur: noretur,
                tgl_retur: tglretur,
                kode_supplier: kodesupplier,
                no_invoice: noinvoice,
                keterangan: keterangan,
                kurs: kurs,
                total_dpp: totaldpp,
                total_ppn: totalppn,
                total_retur: totalretur,
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal',
                        html: response.error,
                    }).then((result) => {
                        if (result.value) {
                            window.location.reload();
                        }
                    });
                }

                if (response.sukses) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        html: response.sukses,
                    }).then((result) => {
                        if (result.value) {
                            window.location = "<?= base_url('PurchRtn') ?>";
                        }
                    });
                }
            },

            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });

    });

    $('#no_invoice').on('change', function() {
        let no_invoice = $(this).val();
        let no_random = $('#no_random').val();
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('PurchRtn/get_datainvoice') ?>",
            data: {
                no_invoice: no_invoice,
                no_random: no_random
            },
            success: function(response) {
                if (response.sukses == 'berhasil') {
                    dataDetailInv();
                    $('#keterangan').focus()
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    });


    function ambilDataSalesInv(no_invoice) {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('PurchRtn/get_byinvoice') ?>",
            data: {
                no_invoice: no_invoice
            },
            success: function(data) {
                let sisatagihan = number_format(data.total_invoice - data.total_retur - data.total_bayar, 0);
                $('#total_invoice').val(sisatagihan)
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    }
</script>

<?= $this->endSection() ?>