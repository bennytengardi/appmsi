<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center mt-1">
    <div class="col-md-12">
        <div class="card card-primary" style="background-color: lightskyblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">PURCHASE ORDER</h3>
                <a href="<?= base_url('PurchOrd') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>
            <div class="card-body">
                <div class="card" style="background-color: #aliceblue">
                    <div class="row p-3">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-2">SUPPLIER ID</div>
                                <div class="col-md-3">
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
                                <div class="col-md-2">SUPPLIER NAME</div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" readonly>
                                    <input type="hidden" name="status" id="status">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">ADDRESS</div>
                                <div class="col-md-8">
                                    <input type="text" name="address1" id="address1" class="form-control form-control-sm" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address2" id="address2" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address3" id="address3" class="form-control form-control-sm" readonly>
                                </div>
                            </div>


                        </div>

                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-3">NO. PO</div>
                                <div class="col-md-5">
                                    <input type="text" name="no_po" id="no_po" class="form-control form-control-sm text-bold text-danger">
                                    <div class="errorNoPo invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">DATE PO</div>
                                <div class="col-md-3">
                                    <input type="date" name="tgl_po" id="tgl_po" class="form-control form-control-sm  " value="<?= $tgl_po ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">PAYMENT</div>
                                <div class="col-md-5">
                                    <input type="text" name="termin" id="termin" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">CURRENCY</div>
                                <div class="col-md-2">
                                    <input type="text" name="currency" id="currency" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">DESCRIPTION</div>
                                <div class="col-md-9">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="background-color: #aliceblue;">
                    <div class="row p-3">
                        <div class="col-md-2">
                            <div class="bg-primary text-center">ITEM NO</div>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm   kode_barang" aria-describedby="basic-addon2" name="kode_barang" id="kode_barang" onkeyup="this.value = this.value.toUpperCase()">
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon2"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="bg-primary text-center">ITEM NAME</div>
                                <input type="text" class="form-control form-control-sm text-sm " name="nama_barang" id="nama_barang"  readonly>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="bg-primary text-center">QTY</div>
                                <input type="text" class="form-control  form-control-sm   text-right  autonum2" name="qty" id="qty">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="bg-primary text-center">UNIT</div>
                                <input type="text" class="form-control  form-control-sm  " name="kode_satuan" id="kode_satuan" onkeyup="this.value = this.value.toUpperCase()" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="bg-primary text-center">PRICE</div>
                                <input type="text" class="form-control  form-control-sm   text-right  autonum2" name="harga" id="harga">
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
                    <div class="col-md-12 dataDetailPo" id="dataDetailPo">
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
                    <div class="modal-header bg-primary" style="height: 50px;">
                        <p class="modal-title text-white text-bold" id="exampleModalLabel" style="margin-top: -5px;">LIST SUPPLIER</p>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>
                    </div>
                    <div class="modal-body" style="background-color: aliceblue;">
                        <table class="table table-bordered table-hover table-sm" id="example3" name="tabel1">
                            <thead>
                                <tr class="bg-primary text-center">
                                    <th width="10%">SUPPLIER ID</th>
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
                $.each(data, function(kode_supplier, nama_supplier, address1, address2, address3, status, currency) {
                    $('[id="kode_supplier"]').val(data.kode_supplier);
                    $('[id="nama_supplier"]').val(data.nama_supplier);
                    $('[id="address1"]').val(data.address1);
                    $('[id="address2"]').val(data.address2);
                    $('[id="address3"]').val(data.address3);
                    $('[id="currency"]').val(data.currency);
                    $('[id="status"]').val(data.status);
                    $("#no_po").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        $('#modal-supplier').on('hidden.bs.modal', function(event) {
            $('#no_po').focus();
        })
        $('#modal-supplier').modal('hide');
    });

    $('#keterangan').keydown(function(e) {
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
                    $.each(data, function(kode_supplier, nama_supplier, address1, address2, address3, status, currency) {
                        $('[id="kode_supplier"]').val(data.kode_supplier);
                        $('[id="nama_supplier"]').val(data.nama_supplier);
                        $('[id="address1"]').val(data.address1);
                        $('[id="address2"]').val(data.address2);
                        $('[id="address3"]').val(data.address3);
                        $('[id="currency"]').val(data.currency);
                        $('[id="status"]').val(data.status);
                        $("#no_po").focus();
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
        dataDetailPo();
        $('#kode_supplier').focus();
    });

    function dataDetailPo() {
        no_po = $('#no_po').val();
        status = $('#status').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('PurchOrd/dataDetail') ?>",
            data: {
                no_po: no_po,
                status: status
            },
            dataType: "json",
            beforeSend: function() {
                $('.dataDetailPo').html('<i class="fa-spin fa-spinner"></i>')
            },
            success: function(response) {
                if (response.data) {
                    $('.dataDetailPo').html(response.data);
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
                $('#no_po').focus();
            }
        });

        $('#no_po').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#tgl_po').focus();
            }
        });

        $('#tgl_po').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#termin').focus();
            }
        });

        $('#termin').keydown(function(e) {
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
            url: "<?= site_url('PurchOrd/viewDataBarang') ?>",
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
            url: "<?= site_url('Barang/cari_kodebarang') ?>",
            data: {
                kode_barang: kode_barang,
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $.each(data, function(id_barang,kode_barang, nama_barang, kode_satuan, hargabeli) {
                    $('[id="id_barang"]').val(data.id_barang);
                    $('[id="kode_barang"]').val(data.kode_barang);
                    $('[id="nama_barang"]').val(data.nama_barang);
                    $('[id="kode_satuan"]').val(data.kode_satuan);
                    // $('[id="harga"]').val(data.hargabeli);

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
            url: "<?= site_url('PurchOrd/simpanTemp') ?>",
            data: {
                no_po: $('#no_po').val(),
                id_barang: $('#id_barang').val(),
                kode_barang: $('#kode_barang').val(),
                nama_barang: $('#nama_barang').val(),
                kode_satuan: $('#kode_satuan').val(),
                qty: $('#qty').val(),
                harga: $('#harga').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses == 'berhasil') {
                    dataDetailPo();
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
        let kodesupplier = $('#kode_supplier').val();
        let nopo = $('#no_po').val();
        let tglpo = $('#tgl_po').val();
        let tglkirim = $('#tgl_kirim').val();
        let ket = $('#keterangan').val();
        let termin = $('#termin').val();
        let totaldpp = $('#total_dpp').val();
        let totalppn = $('#total_ppn').val();
        let totalpph = $('#total_pph').val();
        let totalpo = $('#total_po').val();


        $.ajax({
            type: "post",
            url: "<?= base_url('PurchOrd/simpandata') ?>",
            data: {
                kode_supplier: kodesupplier,
                no_po: nopo,
                tgl_po: tglpo,
                termin: termin,
                tgl_kirim: tglkirim,
                keterangan: ket,
                total_dpp: totaldpp,
                total_ppn: totalppn,
                total_pph: totalpph,
                total_po: totalpo,
            },
            dataType: "json",
            beforeSend: function() {
                $('.tombolSimpanInv').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanInv').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanInv').html('SIMPAN DATA');
                $('.tombolSimpanInv').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;
                    console.log(dataError);
                    if (dataError.errorKodeSupplier) {
                        $('.errorKodeSupplier').html(dataError.errorKodeSupplier).show();
                        $('#kode_supplier').addClass('is-invalid');
                    } else {
                        $('.errorKodeSupplier').fadeOut();
                        $('#kode_supplier').removeClass('is-invalid');
                        $('#kode_supplier').addClass('is-valid');
                    }

                    if (dataError.errorNoPo) {
                        $('.errorNoPo').html(dataError.errorNoInvoice).show();
                        $('#no_po').addClass('is-invalid');
                    } else {
                        $('.errorNoPo').fadeOut();
                        $('#no_po').removeClass('is-invalid');
                        $('#no_po').addClass('is-valid');
                    }

                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        html: response.sukses,
                    }).then((result) => {
                        if (result.value) {
                            window.location = "<?= base_url('PurchOrd') ?>";
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