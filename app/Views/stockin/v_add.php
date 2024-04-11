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
                                    <input type="text" class="form-control form-control-sm kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" style="font-size: 12px;height: 26px;">
                                    <div class="input-group-append">
                                        <button type="button" class="input-group-text bg-primary tombol-supplier" id="basic-addon2" data-toggle="modal" data-target="#modal-supplier" style="font-size: 12px;height: 26px;"><i class="fas fa-search"></i></button>
                                    </div>
                                    <div class="errorKodeSupplier invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">SUPPLIER NAME</div>
                            <div class="col-md-8">
                                <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" readonly>
                                <input type="hidden" name="status" id="status">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">ADDRESS</div>
                            <div class="col-md-8">
                                <input type="text" name="address1" id="address1" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input type="text" name="address2" id="address2" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">RECEIPT NO</div>
                            <div class="col-md-4">
                                <input type="text" name="no_bukti" id="no_bukti" class="form-control form-control-sm text-bold text-danger" style="font-size: 12px;height: 26px;" value="<?= $no_bukti ?>" readonly>
                                <div class="errorNoInvoice invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">RECEIVE DATE</div>
                            <div class="col-md-4">
                                <input type="date" name="tgl_bukti" id="tgl_bukti" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $tgl_bukti ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">NO PO</div>
                            <div class="col-md-6">
                                <select name="no_po" id="no_po" class="form-control form-control-sm" style="font-size: 12px;height: 26px;">
                                </select>
                                <div class="errorNoPo invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">DESCRIPTION</div>
                            <div class="col-md-8">
                                <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" style="font-size: 12px;height: 26px;">
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

<!-- MODAL SEARCH -->
<div class="modal fade" id="modal-supplier" data-backdrop="static" data-keyboard="false" style="width:100%">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="height: 40px;">
                <h3 class="card-title mt-n1">LIST SUPPLIER</h3>
                <a href="<?= base_url('PurchOrd') ?>" type="button" class="btn btn-sm mb-2 mt-n2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>
            <div class="modal-body" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
                <table class="table table-bordered table-hover table-sm" id="example7" name="tabel1" style="font-size: 12px;">
                    <thead>
                        <tr class="bg-primary text-center">
                            <th width="6%">SUPPLIER ID</th>
                            <th>SUPPLIER NAME</th>
                            <th>ADDRESS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php foreach ($supplier as $itm) : ?>
                            <tr>
                                <td class="pb-0"><?= $itm['kode_supplier'] ?></td>
                                <td class="pb-0"><?= $itm['nama_supplier'] ?></td>
                                <td class="pb-0"><?= $itm['address1'] ?></td>
                                <td class="pb-0 text-center">
                                    <button class="btn btn-primary btn-xs" id="select" style="height: 18px;font-size: 10px;" data-kode_supplier="<?= $itm['kode_supplier'] ?>">
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
                $.each(data, function(kode_supplier, nama_supplier, address1, address2) {
                    $('[id="kode_supplier"]').val(data.kode_supplier);
                    $('[id="nama_supplier"]').val(data.nama_supplier);
                    $('[id="address1"]').val(data.address1);
                    $('[id="address2"]').val(data.address2);
                    $("#tgl_bukti").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        $('#modal-supplier').on('hidden.bs.modal', function(event) {
            $('#no_bukti').focus();
        })
        $('#modal-supplier').modal('hide');

        $.ajax({
            type: "POST",
            url: "<?= base_url('StockIn/ambilPurchOrd') ?>",
            data: {
                kode_supplier: kode_supplier
            },
            dataType: "JSON",
            success: function(response) {
                $('#no_po').html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

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
                    $.each(data, function(kode_supplier, nama_supplier, address1, address2) {
                        $('[id="kode_supplier"]').val(data.kode_supplier);
                        $('[id="nama_supplier"]').val(data.nama_supplier);
                        $('[id="address1"]').val(data.address1);
                        $('[id="address2"]').val(data.address2);
                        $("#tgl_bukti").focus();
                    });
                },
                error: function() {
                    alert("Kode Supplier ini tidak ditemukan");
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
        let kodesupplier = $('#kode_supplier').val();
        let nopo = $('#no_po').val();
        let keterangan = $('#keterangan').val();

        $.ajax({
            type: "post",
            url: "<?= base_url('StockIn/simpandata') ?>",
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
                if (response.error) {
                    let dataError = response.error;
                    if (dataError.errorKodeSupplier) {
                        $('.errorKodeSupplier').html(dataError.errorKodeSupplier).show();
                        $('#kode_supplier').addClass('is-invalid');
                    } else {
                        $('.errorKodeSupplier').fadeOut();
                        $('#kode_supplier').removeClass('is-invalid');
                        $('#kode_supplier').addClass('is-valid');
                    }

                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        html: response.sukses,
                    }).then((result) => {
                        if (result.value) {
                            window.location = "<?= base_url('StockIn') ?>";
                        }
                    });
                }
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