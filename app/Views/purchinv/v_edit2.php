<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<!-- <br>  -->
<div class="row justify-content-center mt-4">
    <div class="col-md-12">
        <div class="card card-primary" style="background-color: lightskyblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">PURCHASE INVOICE</h3>
                <a href="<?= base_url('PurchInv') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>
            <div class="card-body">
                <div class="card" style="background-color: aliceblue">
                    <div class="row p-3">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-2">Supplier ID</div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" value="<?= $pi['kode_supplier'] ?>" readonly>
                                        <div class="input-group-append">
                                            <button type="button" class="input-group-text bg-primary tombol-supplier" id="basic-addon2" data-toggle="modal" data-target="#modal-supplier"><i class="fas fa-search"></i></button>
                                        </div>
                                        <div class="errorKodeSupplier invalid-feedback" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">Supplier Name</div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" value="<?= $pi['nama_supplier'] ?>" readonly>
                                    <input type="hidden" name="status" id="status" value="<?= $pi['status'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">Address</div>
                                <div class="col-md-8">
                                    <input type="text" name="address1" id="address1" class="form-control form-control-sm" value="<?= $pi['address1'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address2" id="address2" class="form-control form-control-sm" value="<?= $pi['address2'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">Divisi</div>
                                <div class="col-md-3">
                                    <select name="kode_divisi" id="kode_divisi" class="form-control form-control-sm">
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
                                <div class="col-md-2">Keterangan</div>
                                <div class="col-md-10">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" value="<?= $pi['keterangan'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Form No</div>
                                <div class="col-md-4">
                                    <input type="text" name="no_invoice" id="no_invoice" class="form-control form-control-sm text-bold text-danger" value="<?= $pi['no_invoice'] ?>" readonly>
                                    <div class="errorNoInvoice invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">Invoice Date</div>
                                <div class="col-md-4">
                                    <input type="date" name="tgl_invoice" id="tgl_invoice" class="form-control form-control-sm" value="<?= $pi['tgl_invoice'] ?>">
                                    <input type="hidden" name="kode_accinv" id="kode_accinv" value="<?= $pi['kode_accinv'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">No Invoice</div>
                                <div class="col-md-8">
                                    <input type="text" name="invoice_supp" id="invoice_supp" class="form-control form-control-sm" value="<?= $pi['invoice_supp'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">Currency</div>
                                <div class="col-md-2">
                                    <input type="text" name="currency" id="currency" class="form-control form-control-sm" value="<?= $pi['currency'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <?php if ($pi['currency'] != 'IDR') { ?>
                                    <div class="col-sm-4" id="textkurs">Exchange Rate</div>
                                    <div class="col-sm-2" id="inputkurs">
                                        <input type="text" class="form-control form-control-sm text-right" name="kurs" id="kurs" value="<?= $pi['kursbeli'] ?>" >
                                    </div>
                                <?php } else { ?>
                                    <div class="col-sm-4" id="textkurs"></div>
                                    <div class="col-sm-2" id="inputkurs">
                                        <input type="hidden" class="form-control form-control-sm text-right" name="kurs" id="kurs" value="<?= $pi['kursbeli'] ?>" >
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-md-4">Account</div>
                                <div class="col-md-8">
                                    <select name="kode_account" id="kode_account" class="form-control form-control-sm">
                                        <option value="<?= $pi['kode_account'] ?>"><?= $pi['nama_account'] ?></option>
                                        <?php foreach ($account as $acct) : ?>
                                            <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="background-color: aliceblue;">
                    <div class="row p-3">
                        <div class="col-md-2">
                            <div class="bg-primary text-center">ITEM NO</div>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm kode_barang" aria-describedby="basic-addon2" name="kode_barang" id="kode_barang" onkeyup="this.value = this.value.toUpperCase()">
                                <input type="hidden" name="id_barang" id="id_barang">
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon2"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="bg-primary text-center">ITEM NAME</div>
                            <div>
                                <input type="text" class="form-control form-control-sm" name="nama_barang" id="nama_barang" readonly>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="bg-primary text-center">QTY</div>
                            <div>
                                <input type="text" class="form-control  form-control-sm text-right" name="qty" id="qty">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="bg-primary text-center">UNIT</div>
                            <div>
                                <input type="text" class="form-control form-control-sm" name="kode_satuan" id="kode_satuan" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="bg-primary text-center">UNIT PRICE</div>
                            <div>
                                <input type="text" class="form-control  form-control-sm text-right autonum2" name="harga" id="harga">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <span>&nbsp</span>
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
                    <button class="btn btn-success btn-sm tombolSimpanInv" type="button" id="btnSimpanInv">
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
                        <p class="modal-title text-white text-bold" id="exampleModalLabel" style="margin-top: -5px;">DATA SUPPLIER</p>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>
                    </div>
                    <div class="modal-body" style="background-color: aliceblue;">
                        <table class="table table-bordered table-hover table-sm" id="example3" name="tabel1">
                            <thead>
                                <tr class="bg-primary text-center">
                                    <th width="15%">SUPPLIER ID</th>
                                    <th>SUPPLIER NAME</th>
                                    <th>ADDRESS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($supplier as $itm) : ?>
                                    <tr>
                                        <td align="center"><?= $itm['kode_supplier'] ?></td>
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

    $(document).ready(function() {
        dataDetailInv();
        hitungTotalBelanja();
        $('#kode_supplier').focus();
    });
    
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
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        $('#modal-supplier').on('hidden.bs.modal', function(event) {
            $('#no_invoice').focus();
        })
        $('#modal-supplier').modal('hide');
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
        $('#tgl_invoice').focus();
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

</script>

<?= $this->endSection() ?>