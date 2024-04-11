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
                                        <input type="text" class="form-control form-control-sm  kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier">
                                        <div class="input-group-append">
                                            <button type="button" class="input-group-text bg-primary tombol-supplier" id="basic-addon2" data-toggle="modal" data-target="#modal-supplier"><i class="fas fa-search"></i></button>
                                        </div>
                                        <div class="errorKodeSupplier invalid-feedback" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">SUPPLIER NAME</div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm " readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">ADDRESS </div>
                                <div class="col-md-8">
                                    <input type="text" name="address1" id="address1" class="form-control form-control-sm " readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address2" id="address2" class="form-control form-control-sm " readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address3" id="address3" class="form-control form-control-sm " readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-3">RETURN NO</div>
                                <div class="col-md-3">
                                    <input type="text" name="no_retur" id="no_retur" class="form-control form-control-sm  font-weight-bold" value="<?= $no_retur ?>" readonly>
                                    <input type="hidden" name="no_random" id="no_random" value="<?= $no_random ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">RETURN DATE</div>
                                <div class="col-md-3">
                                    <input type="date" name="tgl_retur" id="tgl_retur" class="form-control form-control-sm " value="<?= $tgl_retur ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">NO INVOICE</div>
                                <div class="col-md-6">
                                    <select name="no_invoice" id="no_invoice" class="form-control form-control-sm ">
                                    </select>
                                    <div class="errorNoInvoice invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">CURRENCY</div>
                                <div class="col-md-2">
                                    <input type="text" name="currency" id="currency" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-md-2 text-right">KURS</div>
                                <div class="col-md-2">
                                    <input type="text" name="kurs" id="kurs" class="form-control form-control-sm text-right autonum" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">DESCRIPTION</div>
                                <div class="col-md-9">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm " onkeyup="this.value = this.value.toUpperCase()">
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

        <!-- MODAL SEARCH -->
        <div class="modal fade" id="modal-supplier" data-backdrop="static" data-keyboard="false" style="width:100%">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary" style="height: 50px; font-size: 18px">
                        <p class="modal-title text-white text-bold" id="exampleModalLabel" style="margin-top: -5px;">SUPPLIER</p>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>
                    </div>
                    <div class="modal-body" style="background-color: aliceblue;">
                        <table class="table table-bordered table-hover table-sm" id="example3" name="tabel1">
                            <thead>
                                <tr class="bg-primary text-center">
                                    <th width="10%">SUPPLIER#</th>
                                    <th>SUPPLIER NAME</th>
                                    <th>ADDRESS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($supplier as $itm) : ?>
                                    <tr>
                                        <td><?= $itm['kode_supplier'] ?></td>
                                        <td><?= $itm['nama_supplier'] ?></td>
                                        <td><?= $itm['address1'] ?></td>
                                        <td align="center">
                                            <button class="btn btn-primary btn-xs" id="select" data-kode_supplier="<?= $itm['kode_supplier'] ?>">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).on('click', '#select', function(e) {
        e.preventDefault();
        var kode_supplier = $(this).data('kode_supplier');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('supplier/cari_kodesupplier') ?>",
            dataType: "JSON",
            data: {
                kode_supplier: kode_supplier
            },
            cache: false,
            success: function(data) {
                $.each(data, function(kode_supplier, nama_supplier, address1, address2, address3, currency) {
                    $('[id="kode_supplier"]').val(data.kode_supplier);
                    $('[id="nama_supplier"]').val(data.nama_supplier);
                    $('[id="address1"]').val(data.address1);
                    $('[id="address2"]').val(data.address2);
                    $('[id="address3"]').val(data.address3);
                    $('[id="currency"]').val(data.currency);
                    if (data.currency == 'IDR') {
                        $('[id="kurs"]').val(1);
                    } else {
                        $('[id="kurs"]').val('');
                    }
                    $("#tgl_retur").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

        $('#modal-supplier').on('hidden.bs.modal', function(event) {
            $('#no_invoice').focus();
        })
        $('#modal-supplier').modal('hide');

        $.ajax({
            type: "POST",
            url: "<?= base_url('PurchRtn/ambil_pi') ?>",
            data: {
                kode_supplier: kode_supplier
            },
            dataType: "JSON",
            success: function(response) {
                $('#no_invoice').html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    });


    $('#due_date').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#kode_barang').focus();
        }
    });

    $(document).on('keydown', '#kode_supplier', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var kode_supplier = $("#kode_supplier").val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('supplier/cari_kodesupplier') ?>",
                dataType: "JSON",
                data: {
                    kode_supplier: kode_supplier
                },
                cache: false,
                success: function(data) {
                    $.each(data, function(kode_supplier, nama_supplier, address1, address2, address3,currency) {
                        $('[id="kode_supplier"]').val(data.kode_supplier);
                        $('[id="nama_supplier"]').val(data.nama_supplier);
                        $('[id="address1"]').val(data.address1);
                        $('[id="address2"]').val(data.address2);
                        $('[id="address3"]').val(data.address3);
                        $('[id="currency"]').val(data.currency);
                        if (data.currency == 'IDR') {
                            $('[id="kurs"]').val(1);
                        } else {
                            $('[id="kurs"]').val('');
                        }

                        $("#no_invoice").focus();
                    });
                },
                error: function() {
                    alert("Kode Supplier ini tidak ditemukan");
                }
            });
            $.ajax({
                type: "POST",
                url: "<?= base_url('PurchRtn/ambil_pi') ?>",
                data: {
                    kode_supplier: kode_supplier
                },
                dataType: "JSON",
                success: function(response) {
                    $('#no_invoice').html(response);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        }
    });


    $(document).ready(function() {
        dataDetailInv();
        $('#kode_supplier').focus();
    });

    function dataDetailInv() {
        no_retur = $('#no_random').val();
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
                no_random: $('#no_random').val(),
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

        let norandom     = $('#no_random').val();
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
            url: "<?= base_url('PurchRtn/simpandata') ?>",
            data: {
                no_random: norandom,
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
                    ambilDataPurch(no_invoice);
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


    function ambilDataPurch(no_invoice) {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('PurchRtn/get_byinvoice') ?>",
            data: {
                no_invoice: no_invoice
            },
            success: function(data) {
                let kurs = data.kurs;
                let currency = data.currency;
                $('#kurs').val(kurs);
                $('#currency').val(currency);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    }
</script>

<?= $this->endSection() ?>