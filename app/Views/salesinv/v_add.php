<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>


<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-primary" style="background-color: lightskyblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">SALES INVOICE</h3>
                <a href="<?= base_url('SalesInv') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <div class="card" style="background-color: #d0ecff;">
                    <div class="row p-3">
                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-md-3">CUSTOMER ID</div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm kode_customer " aria-describedby="basic-addon2" name="kode_customer" id="kode_customer" onkeyup="this.value = this.value.toUpperCase()">
                                        <div class="input-group-append">
                                            <button type="button" class="input-group-text bg-primary tombol-customer" id="basic-addon2" data-toggle="modal" data-target="#modal-customer"><i class="fas fa-search"></i></button>
                                        </div>
                                        <div class="errorKodeCustomer invalid-feedback" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">CUSTOMER NAME</div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm" readonly>
                                    <input type="hidden" name="status" id="status" class="form-control form-control-sm" readonly>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-3">ADDRESS </div>
                                <div class="col-md-8">
                                    <input type="text" name="address1" id="address1" class="form-control form-control-sm" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-8">
                                    <input type="text" name="address2" id="address2" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">DIVISI</div>
                                <div class="col-md-3">
                                    <select name="kode_divisi" id="kode_divisi" class="form-control form-control-sm">
                                        <option value="">Pilih Divisi</option>
                                        <?php foreach ($divisi as $sls) : ?>
                                            <option value="<?= $sls['kode_divisi'] ?>"><?= $sls['kode_divisi'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="errorKodeDivisi invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">JENIS TRANSAKSI</div>
                                <div class="col-sm-3">
                                    <select name="kodejual" id="kodejual" class="form-control form-control-sm">
                                        <option value="SALES">Penjualan</option>
                                        <option value="DP">Uang Muka</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-md-3">NO INVOICE</div>
                                <div class="col-md-5">
                                    <input type="text" name="no_invoice" id="no_invoice" class="form-control form-control-sm text-bold text-danger">
                                    <input type="hidden" name="no_random" id="no_random" value="<?= $no_random ?>">
                                    <div class="errorNoInvoice invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">DATE INVOICE</div>
                                <div class="col-md-3">
                                    <input type="date" name="tgl_invoice" id="tgl_invoice" class="form-control form-control-sm" value="<?= $tgl_invoice ?>">
                                    <input type="hidden" name="kode_accjual" id="kode_accjual">
                                    <input type="hidden" name="kode_acchpp" id="kode_acchpp">
                                    <input type="hidden" name="kode_accinv" id="kode_accinv">
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-3">NO DO</div>
                                <div class="col-md-5">
                                    <select name="no_suratjln" id="no_suratjln" class="form-control form-control-sm">
                                    </select>
                                    <div class="errorNoSj invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">PEMBAYARAN</div>
                                <div class="col-md-9">
                                    <input type="text" name="pembayaran" id="pembayaran" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">DESCRIPTION</div>
                                <div class="col-md-9">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">MARKETING</div>
                                <div class="col-md-4">
                                    <select name="kode_salesman" id="kode_salesman" class="form-control form-control-sm">
                                        <option value=""></option>
                                        <?php foreach ($salesman as $sls) : ?>
                                            <option value="<?= $sls['kode_salesman'] ?>"><?= $sls['nama_salesman'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>        
                        </div>
                    </div>
                </div>

                <div class="card" style="background-color: #d0ecff;">
                    <div class="row p-2">
                        <div class="col-md-2 ml-2">
                            <div class="text-center bg-primary">ITEM NO</div>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm kode_barang" aria-describedby="basic-addon2" name="kode_barang" id="kode_barang" onkeyup="this.value = this.value.toUpperCase()">
                                <input type="hidden" name="id_barang" id="id_barang">
                                <div class="input-group-append">
                                    <!--<button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon2"><i class="fas fa-search"></i></button>-->
                                    <button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon3" data-toggle="modal" data-target="#modal-barang"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="text-center bg-primary">ITEM NAME</div>
                                <input type="text" class="form-control form-control-sm" name="nama_barang" id="nama_barang" readonly>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="text-center bg-primary">QTY</div>
                                <input type="text" class="form-control form-control-sm text-right autonum2" name="qty" id="qty">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="text-center bg-primary">UNIT</div>
                                <input type="text" class="form-control form-control-sm" name="kode_satuan" id="kode_satuan" readonly>
                                <input type="hidden" name="cogs" id="cogs">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form group">
                                <div class="text-center bg-primary">PRICE</div>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm text-right autonum2 harga" aria-describedby="basic-addon2" name="harga" id="harga">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <div>&nbsp</div>
                                <button type="button" class="btn btn-success btn-sm d-block tombolTambah" id="btnTambah"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
                <div class="row">
                    <div class="col-md-12 dataDetailInv" id="dataDetailInv">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary tombolSimpanInv" type="button" id="btnSimpanInv">
                        SAVE DATA
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>
<!-- MODAL CUSTOMER -->
<div class="modal fade" id="modal-customer" data-backdrop="static" data-keyboard="false" style="width:100%">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="height: 50px;">
                <p class="modal-title text-white text-bold" id="exampleModalLabel">LIST CUSTOMER</p>
                <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body" style="background-color: aliceblue;">
                <table class="table table-bordered table-hover table-sm" id="example3" name="tabel1" style="font-size: 13px;">
                    <thead>
                        <tr class="bg-primary text-center">
                            <th width="10%">CUST ID</th>
                            <th>CUSTOMER NAME</th>
                            <th>ADDRESS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customer as $itm) : ?>
                            <tr>
                                <td><?= $itm['kode_customer'] ?></td>
                                <td><?= $itm['nama_customer'] ?></td>
                                <td><?= $itm['address1'] ?></td>
                                <td align="center">
                                    <button class="btn btn-primary btn-xs" id="select" data-kode_customer="<?= $itm['kode_customer'] ?>">
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
    $(document).ready(function() {
        dataDetailInv();
        hitungTotalBelanja();
        $('#kode_customer').focus();
    });
    
    $(document).on('click', '#select', function(e) {
        e.preventDefault();
        var kode_customer = $(this).data('kode_customer');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Customer/cari_kodecustomer') ?>",
            dataType: "JSON",
            data: {
                kode_customer: kode_customer
            },
            cache: false,
            success: function(data) {
                $.each(data, function(kode_customer, nama_customer, address1, address2, status, termin) {
                    $('[id="kode_customer"]').val(data.kode_customer);
                    $('[id="nama_customer"]').val(data.nama_customer);
                    $('[id="status"]').val(data.status);
                    $('[id="address1"]').val(data.address1);
                    $('[id="address2"]').val(data.address2);
                    $("#no_invoice").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        $('#modal-customer').on('hidden.bs.modal', function(event) {
            $('#no_invoice').focus();
        })
        $('#modal-customer').modal('hide');

        $.ajax({
            type: "POST",
            url: "<?= base_url('SalesInv/ambilSuratJln') ?>",
            data: {
                kode_customer: kode_customer
            },
            dataType: "JSON",
            success: function(response) {
                $('#no_suratjln').html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });


    $(document).on('keydown', '#kode_customer', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var kode_customer = $("#kode_customer").val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Customer/cari_kodecustomer') ?>",
                dataType: "JSON",
                data: {
                    kode_customer: kode_customer
                },
                cache: false,
                success: function(data) {
                    $.each(data, function(kode_customer, nama_customer, address1, address2,status, termin) {
                        $('[id="kode_customer"]').val(data.kode_customer);
                        $('[id="nama_customer"]').val(data.nama_customer);
                        $('[id="status"]').val(data.status);
                        $('[id="address1"]').val(data.address1);
                        $('[id="address2"]').val(data.address2);
                       $("#no_po").focus();
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('Kode Customer ini tidak ada dalam master customer');
                }
            });
            return false;
        }
    });
    
 
    function dataDetailInv() {
        no_invoice = $('#no_random').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('SalesInv/dataDetail') ?>",
            data: {
                no_invoice: no_invoice
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
        $('.tombol-customer').click(function(e) {
            e.preventDefault();
            $('#modal-customer').modal('show');
            $('#modal-customer').on('shown.bs.modal', function() {
                $("#modal-customer [type='search']").focus();
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

        $('#no_suratjln').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#pembayaran').focus();
            }
        });

        $('#pembayaran').keydown(function(e) {
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

    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };

        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

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
                $.each(data, function(id_barang,kode_barang, nama_barang, kode_satuan, hargajual, hargabeli, nilaikurs) {
                    $('[id="id_barang"]').val(data.id_barang);
                    $('[id="kode_barang"]').val(data.kode_barang);
                    $('[id="nama_barang"]').val(data.nama_barang);
                    $('[id="kode_satuan"]').val(data.kode_satuan);
                    $('[id="cogs"]').val(number_format(data.hargabeli * data.nilaikurs, 2, '.', ','));
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
            url: "<?= site_url('SalesInv/simpanTemp') ?>",
            data: {
                no_random: $('#no_random').val(),
                id_barang:   $('#id_barang').val(),
                kode_barang:   $('#kode_barang').val(),
                nama_barang: $('#nama_barang').val(),
                kode_satuan: $('#kode_satuan').val(),
                qty: $('#qty').val(),
                harga: $('#harga').val(),
                cogs: $('#cogs').val(),
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
        $('#cogs').val('');
        $('#kode_barang').focus();
    }


    $('.tombolSimpanInv').click(function(e) {
        e.preventDefault();

        let norandom = $('#no_random').val();
        let noinvoice = $('#no_invoice').val();
        let tglinvoice = $('#tgl_invoice').val();
        let kodedivisi = $('#kode_divisi').val();
        let kodejual = $('#kodejual').val();
        let nosuratjln = $('#no_suratjln').val();
        let kodecustomer = $('#kode_customer').val();
        let pembayaran = $('#pembayaran').val();
        let description = $('#keterangan').val();
        let totalamount = $('#total_amount').val();
        let totaldiscount = $('#total_discount').val();
        let totaldp = $('#total_dp').val();
        let totaldpp = $('#total_dpp').val();
        let totalppn = $('#total_ppn').val();
        let ongkir = $('#ongkir').val();
        let totalinvoice = $('#total_invoice').val();       
        let totalhpp = $('#total_hpp').val();
        let kodeaccjual = $('#kode_accjual').val();
        let kodeacchpp = $('#kode_acchpp').val();
        let kodeaccinv = $('#kode_accinv').val();
        let kode_salesman = $('#kode_salesman').val();

        $.ajax({
            type: "post",
            url: "<?= base_url('SalesInv/simpandata') ?>",
            data: {
                no_random: norandom,
                no_invoice: noinvoice,
                tgl_invoice: tglinvoice,
                kode_divisi: kodedivisi,
                kodejual: kodejual,
                no_suratjln: nosuratjln,
                kode_customer: kodecustomer,
                pembayaran: pembayaran,
                description: description,
                total_amount: totalamount,
                total_discount: totaldiscount,
                total_dp: totaldp,
                total_dpp: totaldpp,
                total_ppn: totalppn,
                ongkir: ongkir,
                total_invoice: totalinvoice,
                total_hpp: totalhpp,
                kode_accjual: kodeaccjual,
                kode_acchpp: kodeacchpp,
                kode_accinv: kodeaccinv,
                kode_salesman: kode_salesman,
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;
                    if (dataError.errorKodeCustomer) {
                        $('.errorKodeCustomer').html(dataError.errorKodeCustomer).show();
                    } else {
                        $('.errorKodeCustomer').fadeOut();
                    }
                    if (dataError.errorNoSj) {
                        $('.errorNoSj').html(dataError.errorNoSj).show();
                    } else {
                        $('.errorNoSj').fadeOut();
                    }
                    if (dataError.errorNoInvoice) {
                        $('.errorNoInvoice').html(dataError.errorNoInvoice).show();
                    } else {
                        $('.errorNoInvoice').fadeOut();
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
                            window.location = "<?= base_url('SalesInv') ?>";
                        }
                    });
                }
            },

            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $('#kode_customer').on('mouseenter', function() {
        $('.errorKodeCustomer').fadeOut();
    });
    $('#no_suratjln').on('mouseenter', function() {
        $('.errorNoSj').fadeOut();
    });
    $('#no_invoice').on('mouseenter', function() {
        $('.errorNoInvoice').fadeOut();
    });
    
    $('#kode_divisi').on('change', function() {
        $('.errorKodeDivisi').fadeOut();
        let kode_divisi = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('SalesInv/cari_kodedivisi') ?>",
            dataType: "JSON",
            data: {
                kode_divisi: kode_divisi
            },
            cache: false,
            success: function(data) {
                $.each(data, function(kode_acctjual,kode_acchpp,kode_accinv) {
                    $('[id="kode_accjual"]').val(data.kode_accjual);
                    $('[id="kode_acchpp"]').val(data.kode_acchpp);
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
        let status   = $('#status').val();
        let totaldis = ($('#total_discount').val() == "") ? 0 : $('#total_discount').val();
        let totaldp = ($('#total_dp').val() == "") ? 0 : $('#total_dp').val();
        let totalongkir = ($('#ongkir').val() == "") ? 0 : $('#ongkir').val();

        $.ajax({
            url: "<?= site_url('SalesInv/hitungTotalBelanja') ?>",
            dataType: "json",
            data: {
                no_random: $('#no_random').val(),
                status: status,
                total_discount: totaldis,
                total_dp: totaldp,
                ongkir: totalongkir,
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

    $('#no_suratjln').on('change', function() {
        let no_suratjln = $(this).val();
        let no_random = $('#no_random').val();
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('SalesInv/get_datasj') ?>",
            data: {
                no_suratjln: no_suratjln,
                no_random: no_random
            },
            success: function(response) {
                if (response.sukses == 'berhasil') {
                    dataDetailInv();
                    hitungTotalBelanja();
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