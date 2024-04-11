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
                                    <input type="text" class="form-control form-control-sm kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" style="font-size: 12px;height: 28px;">
                                    <div class="input-group-append">
                                        <button type="button" class="input-group-text bg-primary tombol-supplier" id="basic-addon2" data-toggle="modal" data-target="#modal-supplier" style="font-size: 12px;height: 28px;"><i class="fas fa-search"></i></button>
                                    </div>
                                    <div class="errorKodeSupplier invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">NAMA SUPPLIER</div>
                            <div class="col-md-8">
                                <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" readonly>
                                <input type="hidden" name="status" id="status">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">ALAMAT</div>
                            <div class="col-md-8">
                                <input type="text" name="address1" id="address1" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input type="text" name="address2" id="address2" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">DIVISI</div>
                            <div class="col-md-3">
                                <select name="kode_divisi" id="kode_divisi" class="form-control form-control-sm" style="font-size: 12px;height: 28px;">
                                    <option value="">Pilih Divisi</option>
                                    <?php foreach ($divisi as $sls) : ?>
                                        <option value="<?= $sls['kode_divisi'] ?>"><?= $sls['kode_divisi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorKodeDivisi invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">KETERANGAN</div>
                            <div class="col-md-10">
                                <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" style="font-size: 12px;height: 28px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">FORM NO</div>
                            <div class="col-md-4">
                                <input type="text" name="no_invoice" id="no_invoice" class="form-control form-control-sm text-bold text-danger" style="font-size: 12px;height: 28px;" value="<?= $no_invoice ?>" readonly>
                                <div class="errorNoInvoice invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">TGL INVOICE</div>
                            <div class="col-md-4">
                                <input type="date" name="tgl_invoice" id="tgl_invoice" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $tgl_invoice ?>">
                                <input type="hidden" name="kode_accinv" id="kode_accinv">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">NO INVOICE</div>
                            <div class="col-md-8">
                                <input type="text" name="invoice_supp" id="invoice_supp" class="form-control form-control-sm" style="font-size: 12px;height: 28px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">CURRENCY</div>
                            <div class="col-md-2">
                                <input type="text" name="currency" id="currency" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4" id="textkurs" ></div>
                            <div class="col-sm-2" id="inputkurs" ></div>
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
                            <div class="col-md-4">ACCOUNT</div>
                            <div class="col-md-8">
                                <select name="kode_account" id="kode_account" class="form-control form-control-sm" style="font-size: 12px;height: 28px;">
                                    <option value=""></option>
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
                $.each(data, function(kode_supplier, nama_supplier, address1, address2, currency, status, nilai_tukar) {
                    $('[id="kode_supplier"]').val(data.kode_supplier);
                    $('[id="nama_supplier"]').val(data.nama_supplier);
                    $('[id="address1"]').val(data.address1);
                    $('[id="address2"]').val(data.address2);
                    $('[id="currency"]').val(data.currency);
                    $('[id="status"]').val(data.status);
                    if(data.status == "PKP") {
                        $('[id="vat"]').val(11);
                    } else {
                        $('[id="vat"]').val(0);
                    }

                    if (data.currency != 'IDR') {
                       html = '<input type="text" class="form-control form-control-sm text-right" name="kurs" id="kurs"  style="font-size: 12px;height: 26px;">';
                       document.getElementById("textkurs").innerHTML = "EXCHANGE RATE";
                       $('#inputkurs').html(html);
                       $('#kurs').val(data.nilai_tukar);
                    } else {
                        html = '<input type="hidden" class="form-control form-control-sm text-right" name="kurs" id="kurs" style="font-size: 12px;height: 26px;">';
                        document.getElementById("textkurs").innerHTML = "";
                        $('#inputkurs').html(html);
                        $('#kurs').val(1);
                    }
                    $("#invoice_supp").focus();
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
            url: "<?= base_url('PurchInv/ambilPurchOrd') ?>",
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
                    $.each(data, function(kode_supplier, nama_supplier, address1, address2, currency, status, nilai_tukar) {
                        $('[id="kode_supplier"]').val(data.kode_supplier);
                        $('[id="nama_supplier"]').val(data.nama_supplier);
                        $('[id="address1"]').val(data.address1);
                        $('[id="address2"]').val(data.address2);
                        $('[id="currency"]').val(data.currency);
                        $('[id="status"]').val(data.status);
                        if (data.currency != 'IDR') {
                            html = '<input type="text" class="form-control form-control-sm border-secondary text-right" name="kurs" id="kurs">';
                            document.getElementById("textkurs").innerHTML = "Exchange Rate";
                            $('#inputkurs').html(html);
                            $('#kurs').val(data.nilai_tukar);
                        } else {
                            html = '<input type="hidden" class="form-control form-control-sm border-secondary text-right" name="kurs" id="kurs">';
                            document.getElementById("textkurs").innerHTML = "";
                            $('#inputkurs').html(html);
                            $('#kurs').val(1);
                        }
                        $("#invoice_supp").focus();
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
        let kodedivisi  = $('#kode_divisi').val();
        let invsupp     = $('#invoice_supp').val();
        let kurs        = $('#kurs').val();
        let totalamount = $('#total_amount').val();
        let totaldiscount = $('#total_discount').val();
        let totaldpp = $('#total_dpp').val();
        let vat = $('#vat').val();
        let totalppn = $('#total_ppn').val();
        let totalinvoice = $('#total_invoice').val();
        let kodeaccinv = $('#kode_accinv').val();
        let keterangan = $('#keterangan').val()
        let kodeacct = $('#kode_account').val()

        $.ajax({
            type: "post",
            url: "<?= base_url('PurchInv/simpandata') ?>",
            data: {
                kode_supplier: kodesupplier,
                no_invoice: noinvoice,
                tgl_invoice: tglinvoice,
                kode_divisi: kodedivisi,
                invoice_supp: invsupp,
                kurs: kurs,
                total_amount: totalamount,
                total_discount: totaldiscount,
                total_dpp: totaldpp,
                vat: vat,
                total_ppn: totalppn,
                total_invoice: totalinvoice,
                kode_accinv: kodeaccinv,
                keterangan: keterangan,
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