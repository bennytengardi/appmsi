<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>


<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-primary" style="background-color: lightskyblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">SALES RETURN</h3>
                <a href="<?= base_url('SalesRtn') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <div class="card p-3" style="background-color: #d0ecff;">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-3">CUSTOMER ID</div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm  kode_customer" aria-describedby="basic-addon2" name="kode_customer" id="kode_customer">
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
                                    <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm " readonly>
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
                                <div class="col-md-5">
                                    <select name="no_invoice" id="no_invoice" class="form-control form-control-sm ">
                                    </select>
                                    <div class="errorNoInvoice invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">BALANCE</div>
                                <div class="col-md-4">
                                    <input type="text" name="total_invoice" id="total_invoice" class="form-control form-control-sm  text-right autonum" readonly>
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
        <div class="modal fade" id="modal-customer" data-backdrop="static" data-keyboard="false" style="width:100%">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary" style="height: 50px; font-size: 18px">
                        <p class="modal-title text-white text-bold" id="exampleModalLabel" style="margin-top: -5px;">CUSTOMER</p>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>
                    </div>
                    <div class="modal-body" style="background-color: aliceblue;">
                        <table class="table table-bordered table-hover table-sm" id="example3" name="tabel1">
                            <thead>
                                <tr class="bg-primary text-center">
                                    <th width="10%">CUSTOMER#</th>
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
    </div>
</div>


<script>
    $(document).on('click', '#select', function(e) {
        e.preventDefault();
        var kode_customer = $(this).data('kode_customer');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('customer/cari_kodecustomer') ?>",
            dataType: "JSON",
            data: {
                kode_customer: kode_customer
            },
            cache: false,
            success: function(data) {
                $.each(data, function(kode_customer, nama_customer, address1, address2, address3) {
                    $('[id="kode_customer"]').val(data.kode_customer);
                    $('[id="nama_customer"]').val(data.nama_customer);
                    $('[id="address1"]').val(data.address1);
                    $('[id="address2"]').val(data.address2);
                    $('[id="address3"]').val(data.address3);
                    $("#tgl_retur").focus();
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
            url: "<?= base_url('SalesRtn/ambil_si') ?>",
            data: {
                kode_customer: kode_customer
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

    $(document).on('keydown', '#kode_customer', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var kode_customer = $("#kode_customer").val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('customer/cari_kodecustomer') ?>",
                dataType: "JSON",
                data: {
                    kode_customer: kode_customer
                },
                cache: false,
                success: function(data) {
                    $.each(data, function(kode_customer, nama_customer, address1, address2, address3) {
                        $('[id="kode_customer"]').val(data.kode_customer);
                        $('[id="nama_customer"]').val(data.nama_customer);
                        $('[id="address1"]').val(data.address1);
                        $('[id="address2"]').val(data.address2);
                        $('[id="address3"]').val(data.address3);
                        $("#no_invoice").focus();
                    });
                },
                error: function() {
                    alert("Kode Customer ini tidak ditemukan");
                }
            });
            $.ajax({
                type: "POST",
                url: "<?= base_url('SalesRtn/ambil_si') ?>",
                data: {
                    kode_customer: kode_customer
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
        $('#kode_customer').focus();
    });

    function dataDetailInv() {
        no_retur = $('#no_random').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('SalesRtn/dataDetail') ?>",
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
            url: "<?= site_url('SalesRtn/viewDataBarang') ?>",
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
            url: "<?= site_url('SalesRtn/simpanTemp') ?>",
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
        let kodecustomer = $('#kode_customer').val();
        let noinvoice    = $('#no_invoice').val();
        let keterangan   = $('#keterangan').val();
        let totaldpp     = $('#total_dpp').val();
        let totalppn     = $('#total_ppn').val();
        let totalretur   = $('#total_retur').val();

        $.ajax({
            type: "post",
            url: "<?= base_url('SalesRtn/simpandata') ?>",
            data: {
                no_random: norandom,
                no_retur: noretur,
                tgl_retur: tglretur,
                kode_customer: kodecustomer,
                no_invoice: noinvoice,
                keterangan: keterangan,
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
                            window.location = "<?= base_url('SalesRtn') ?>";
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
            url: "<?= base_url('SalesRtn/get_datainvoice') ?>",
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
            url: "<?= base_url('SalesRtn/get_byinvoice') ?>",
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