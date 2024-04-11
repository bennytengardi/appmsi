<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>

<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card card-primary" style="background-color: lightskyblue">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">SALDO AWAL</h3>
                <a href="<?= base_url('supplier') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <div class="card" style="background-color: #d7ecff; height:100px;">
                    <div class="container p-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form group row">
                                    <label for="kode_supplier" class="col-sm-2 col-form-label ml-4" style="font-weight: normal; ">SUPPLIER ID</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm border-secondary" name="kode_supplier" id="kode_supplier" value="<?= $supplier['kode_supplier'] ?>" style="height: 30px;" readonly>
                                    </div>
                                </div>

                                <div class="form group row">
                                    <label for="nama_supplier" class="col-sm-2 col-form-label ml-4" style="font-weight: normal;margin-top: -2px">SUPPLIER NAME</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm border-secondary" value="<?= $supplier['nama_supplier'] ?>" style="height:28px;" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- <hr style="margin-top: -2px"> -->
                <div class="card" style="background-color: #d7ecff; height:80px; margin-top: -2px">
                    <div class="container p-2">
                        <div class="row" style="margin-top: 0px;">
                            <div class="col-md-4 ml-4">
                                <div class="form-group">
                                    <label for="no_invoice" style="font-weight: normal;">NO INVOICE</label>
                                    <input type="text" class="form-control form-control-sm border-secondary" name="no_invoice" id="no_invoice" onkeyup="this.value = this.value.toUpperCase()" autofocus>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label style="font-weight: normal;">DATE INVOICE</label>
                                    <input type="date" class="form-control form-control-sm border-secondary" name="tgl_invoice" id="tgl_invoice">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="total_invoice" style="font-weight: normal;">TOTAL INVOICE</label>
                                    <input type="text" class="form-control  form-control-sm border-secondary text-right autonum" name="total_invoice" id="total_invoice">
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label style="font-weight: normal;">ACTION</label>
                                    <button type="button" class="btn btn-primary btn-sm d-block tombolTambah" id="btnTambah"><i class="fa fa-plus"></i></button>
                                </div>
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
    </div>
</div>
</div>


<script>
    $(document).ready(function() {
        dataDetailInv();
        $('#no_invoice').focus();
    });


    function dataDetailInv() {
        kode_supplier = $('#kode_supplier').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('supplier/dataDetail') ?>",
            data: {
                kode_supplier: kode_supplier
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
        $('#no_invoice').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekKode();
            }
        });

        $('#no_invoice').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#tgl_invoice').focus();
            }
        });
        $('#tgl_invoice').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#total_invoice').focus();
            }
        });

        $('#total_invoice').keydown(function(e) {
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
        let no_invoice = $('#no_invoice').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('purchinv/cari_noinvoice') ?>",
            data: {
                no_invoice: no_invoice,
            },
            dataType: "json",
            cache: false,
            success: function(response) {
                if (response.sukses == 'berhasil') {
                    alert('No Invoice Sudah Ada');
                    kosong()

                }
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
            url: "<?= site_url('supplier/simpanTemp') ?>",
            data: {
                kode_supplier: $('#kode_supplier').val(),
                no_invoice: $('#no_invoice').val(),
                tgl_invoice: $('#tgl_invoice').val(),
                total_invoice: $('#total_invoice').val(),

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
        $('#no_invoice').val('');
        $('#tgl_invoice').val('');
        $('#total_invoice').val('');
        $('#no_invoice').focus();
    }

    $('.tombolSimpanInv').click(function(e) {
        e.preventDefault();
        let noinvoice = $('#no_invoice').val();
        let tglinvoice = $('#tgl_invoice').val();
        let kodesupplier = $('#kode_supplier').val();
        let totalinvoice = $('#total_invoice').val();
        let totalbayar = $('#total_bayar').val();

        $.ajax({
            type: "post",
            url: "<?= base_url('supplier/updatesaldoawal') ?>",
            data: {
                no_invoice: noinvoice,
                tgl_invoice: tglinvoice,
                kode_supplier: kodesupplier,
                total_invoice: totalinvoice,
                total_bayar: totalbayar
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
                        title: 'Berhasil',
                        html: response.sukses,
                    }).then((result) => {
                        if (result.value) {
                            window.location = "<?= base_url('supplier') ?>";
                        }
                    });
                }
            },

            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });

    });
</script>

<?= $this->endSection() ?>