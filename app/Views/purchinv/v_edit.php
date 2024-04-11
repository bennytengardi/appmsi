<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center mt-1">
    <div class="col-md-12" style="font-size: 12px;">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title">PURCHASE INVOICE</h3>
                <a href="<?= base_url('PurchInv') ?>" type="button" class="btn btn-sm mb-2 mt-n2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>
            <div class="card-body">
                <div class="row px-3">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-2">KODE SUPPLIER</div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" style="font-size: 12px;height: 28px;" value="<?= $pi['kode_supplier'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">NAMA SUPPLIER</div>
                            <div class="col-md-8">
                                <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" style="font-size: 12px;height: 28px;"  value="<?= $pi['nama_supplier'] ?>" readonly>
                                <input type="hidden" name="status" id="status"  value="<?= $pi['status'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">ALAMAT</div>
                            <div class="col-md-8">
                                <input type="text" name="address1" id="address1" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $pi['address1'] ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input type="text" name="address2" id="address2" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $pi['address2'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">DIVISI</div>
                            <div class="col-md-3">
                                <select name="kode_divisi" id="kode_divisi" class="form-control form-control-sm" style="font-size: 12px;height: 28px;">
                                    <?php foreach ($divisi as $kat) : ?>
                                        <?php if ($kat['kode_divisi'] == $pi['kode_divisi']) : ?>
                                            <option value="<?= $kat['kode_divisi'] ?>" selected><?= $kat['kode_divisi'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $kat['kode_divisi'] ?>"><?= $kat['kode_divisi'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorKodeDivisi invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">KETERANGAN</div>
                            <div class="col-md-10">
                                <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $pi['keterangan'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">FORM NO</div>
                            <div class="col-md-4">
                                <input type="text" name="no_invoice" id="no_invoice" class="form-control form-control-sm text-bold text-danger" style="font-size: 12px;height: 28px;" value="<?= $pi['no_invoice'] ?>" readonly>
                                <div class="errorNoInvoice invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">TGL INVOICE</div>
                            <div class="col-md-4">
                                <input type="date" name="tgl_invoice" id="tgl_invoice" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $pi['tgl_invoice'] ?>">
                                <input type="hidden" name="kode_accinv" id="kode_accinv" value="<?= $pi['kode_accinv'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">NO INVOICE</div>
                            <div class="col-md-8">
                                <input type="text" name="invoice_supp" id="invoice_supp" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $pi['invoice_supp'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">CURRENCY</div>
                            <div class="col-md-2">
                                <input type="text" name="currency" id="currency" class="form-control form-control-sm" style="font-size: 12px;height: 28px;"  value="<?= $pi['currency'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <?php if ($pi['currency'] != 'IDR') { ?>
                                <div class="col-sm-4" id="textkurs">EXCHANGE RATE</div>
                                <div class="col-sm-2" id="inputkurs">
                                    <input type="text" class="form-control form-control-sm text-right" name="kurs" id="kurs" style="font-size: 12px;height: 28px;" value="<?= $pi['kursbeli'] ?>" >
                                </div>
                            <?php } else { ?>
                                <div class="col-sm-4" id="textkurs"></div>
                                <div class="col-sm-2" id="inputkurs">
                                    <input type="hidden" class="form-control form-control-sm text-right" name="kurs" id="kurs" style="font-size: 12px;height: 28px;" value="<?= $pi['kursbeli'] ?>" >
                                </div>
                            <?php } ?>
                        </div>                        
                            
                        <div class="row">
                            <div class="col-md-4">NO PO</div>
                            <div class="col-md-6">
                                <input type="text" name="no_po" id="no_po" class="form-control form-control-sm" style="font-size: 12px;height: 28px;"  value="<?= $pi['no_po'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">ACCOUNT</div>
                            <div class="col-md-8">
                                <select name="kode_account" id="kode_account" class="form-control form-control-sm" style="font-size: 12px;height: 28px;">
                                    <option value="<?= $pi2['kode_account'] ?>"><?= $pi2['nama_account'] ?></option>
                                    <?php foreach ($account as $acct) : ?>
                                        <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2">
                        <div class="bg-primary text-center" style="height: 22px">ITEM NO</div>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm kode_barang" aria-describedby="basic-addon2" name="kode_barang" id="kode_barang" style="font-size: 12px;height: 28px;" onkeyup="this.value = this.value.toUpperCase()">
                            <input type="hidden" name="id_barang" id="id_barang">
                            <div class="input-group-append">
                                <button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon2" style="font-size: 12px;height: 28px;"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="bg-primary text-center" style="height: 22px">ITEM NAME</div>
                        <div>
                            <input type="text" class="form-control form-control-sm" name="nama_barang" id="nama_barang" style="font-size: 12px;height: 28px;" readonly>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="bg-primary text-center" style="height: 22px">QTY</div>
                        <div>
                            <input type="text" class="form-control  form-control-sm text-right" name="qty" id="qty" style="font-size: 12px;height: 28px;">
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="bg-primary text-center" style="height: 22px">UNIT</div>
                        <div>
                            <input type="text" class="form-control form-control-sm" name="kode_satuan" id="kode_satuan" style="font-size: 12px;height: 28px;" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="bg-primary text-center" style="height: 22px">UNIT PRICE</div>
                        <div>
                            <input type="text" class="form-control  form-control-sm text-right autonum2" name="harga" id="harga" style="font-size: 12px;height: 28px;">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <span>&nbsp</span>
                            <button type="button" class="btn btn-success btn-sm d-block tombolTambah" id="btnTambah"  style="font-size: 12px;height: 26px;"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 dataDetailInv" id="dataDetailInv">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-success btn-xs tombolSimpanInv ml-3" type="button" id="btnSimpanInv">
                        SAVE DATA
                    </button>
                </div>
            </div>
        </div>


        <div class="viewmodal" style="display: none;"></div>

    </div>
</div>




<script>

    $('#due_date').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#kode_barang').focus();
        }
    });



    $(document).ready(function() {
        dataDetailInv();
        $('#kode_supplier').focus();
    });

    function dataDetailInv() {
        no_invoice = $('#no_invoice').val();
        status = $('#status').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('PurchInv/dataDetail') ?>",
            data: {
                no_invoice: no_invoice,
                status: status
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
                $('#tgl_invoice').focus();
            }
        });

       $('#keterangan').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#tgl_invoice').focus();
            }
        });

        $('#tgl_invoice').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#invoice_supp').focus();
            }
        });

        $('#invoice_supp').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#kurs').focus();
            }
        });

        $('#kurs').keydown(function(e) {
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
            url: "<?= site_url('PurchInv/viewDataBarang') ?>",
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
            url: "<?= site_url('PurchInv/simpanTemp') ?>",
            data: {
                vat: $('#vat').val(),
                no_invoice: $('#no_invoice').val(),
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
                    dataDetailInv();
                    hitungTotalBelanja();
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
        let noinvoice = $('#no_invoice').val();
        let tglinvoice = $('#tgl_invoice').val();
        let kodedivisi = $('#kode_divisi').val();
        let invsupp = $('#invoice_supp').val();
        let kurs     = $('#kurs').val();
        let totalamount = $('#total_amount').val();
        let totaldiscount = $('#total_discount').val();
        let totaldpp = $('#total_dpp').val();
        let totalppn = $('#total_ppn').val();
        let vat        = $('#vat').val();
        let totalinvoice = $('#total_invoice').val();
        let kodeaccinv = $('#kode_accinv').val();
        let keterangan = $('#keterangan').val();
        let kodeacct = $('#kode_account').val();


        $.ajax({
            type: "post",
            url: "<?= base_url('PurchInv/updatedata') ?>",
            data: {
                kode_supplier: kodesupplier,
                no_invoice: noinvoice,
                tgl_invoice: tglinvoice,
                kode_divisi: kodedivisi,
                invoice_supp: invsupp,
                keterangan: keterangan,
                kurs: kurs,
                total_amount: totalamount,
                total_discount: totaldiscount,
                total_dpp: totaldpp,
                vat: vat,
                total_ppn: totalppn,
                total_invoice: totalinvoice,
                kode_accinv: kodeaccinv,
                kode_account: kodeacct
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
                    console.log(dataError);
                    if (dataError.errorKodeSupplier) {
                        $('.errorKodeSupplier').html(dataError.errorKodeSupplier).show();
                        $('#kode_supplier').addClass('is-invalid');
                    } else {
                        $('.errorKodeSupplier').fadeOut();
                        $('#kode_supplier').removeClass('is-invalid');
                        $('#kode_supplier').addClass('is-valid');
                    }

                    if (dataError.errorNoInvoice) {
                        $('.errorNoInvoice').html(dataError.errorNoInvoice).show();
                        $('#no_invoice').addClass('is-invalid');
                    } else {
                        $('.errorNoInvoice').fadeOut();
                        $('#no_invoice').removeClass('is-invalid');
                        $('#no_invoice').addClass('is-valid');
                    }
                    if (dataError.errorKodeDivisi) {
                        $('.errorKodeDivisi').html(dataError.errorKodeDivisi).show();
                    } else {
                        $('.errorKodeDivisi').fadeOut();
                    }

                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        html: response.sukses,
                    }).then((result) => {
                        if (result.value) {
                            window.location = "<?= base_url('PurchInv') ?>";
                        }
                    });
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);

            }
        });
    });
    
    $('#kode_divisi').on('change', function() {
        $('.errorKodeDivisi').fadeOut();
        let kode_divisi = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('PurchInv/cari_kodedivisi') ?>",
            dataType: "JSON",
            data: {
                kode_divisi: kode_divisi
            },
            cache: false,
            success: function(data) {
                $.each(data, function(kode_accinv) {
                    $('[id="kode_accinv"]').val(data.kode_accinv);
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
        $('#keterangan').focus();
    });

    
    
    function hitungTotalBelanja() {
        let vat = ($('#vat').val() == "") ? 0 : $('#vat').val();
        let totaldis = ($('#total_discount').val() == "") ? 0 : $('#total_discount').val();
        let status = $('#status').val();

        $.ajax({
            url: "<?= site_url('PurchInv/hitungTotalBelanja') ?>",
            dataType: "json",
            data: {
                no_invoice: $('#no_invoice').val(),
                total_discount: totaldis,
                vat: vat,
                status: status
            },
            type: "post",

            success: function(response) {
                if (response.totalamount) {
                    $('#total_amount').val(response.totalamount);
                }
                if (response.totaldpp) {
                    $('#total_dpp').val(response.totaldpp);
                }
                if (response.totalppn) {
                    $('#total_ppn').val(response.totalppn);
                }
                if (response.totalinvoice) {
                    $('#total_invoice').val(response.totalinvoice);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $('#no_po').on('change', function() {
        let no_po = $(this).val();
        let no_invoice = $('#no_invoice').val();
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('PurchInv/get_datapo') ?>",
            data: {
                no_po: no_po,
                no_invoice: no_invoice
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