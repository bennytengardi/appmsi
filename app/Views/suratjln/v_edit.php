<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-primary" style="background-color: lightskyblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">DELIVERY ORDER</h3>
                <a href="<?= base_url('SuratJln/index2/' . $msj['id_sj']) ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <div class="card" style="background-color: #d0ecff">
                    <div class="row p-3">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-md-3">CUSTOMER ID</div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm kode_customer " aria-describedby="basic-addon2" name="kode_customer" id="kode_customer" value="<?= $msj['kode_customer'] ?>" onkeyup="this.value = this.value.toUpperCase()">
                                        <div class="input-group-append">
                                            <button type="button" class="input-group-text bg-primary tombol-customer" id="basic-addon2" data-toggle="modal" data-target="#modal-customer"><i class="fas fa-search"></i></button>
                                        </div>
                                        <div class="errorKodeCustomer invalid-feedback" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">CUSTOMER NAME</div>
                                <div class="col-md-9">
                                    <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm" value="<?= $msj['nama_customer'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">ADDRESS </div>
                                <div class="col-md-9">
                                    <input type="text" name="address1" id="address1" class="form-control form-control-sm" value="<?= $msj['address1'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-9">
                                    <input type="text" name="address2" id="address2" class="form-control form-control-sm" value="<?= $msj['address2'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-9">
                                    <input type="text" name="address3" id="address3" class="form-control form-control-sm" value="<?= $msj['address3'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">DIVISI</div>
                                <div class="col-md-3">
                                    <select name="kode_divisi" id="kode_divisi" class="form-control form-control-sm">
                                        <?php foreach ($divisi as $kat) : ?>
                                            <?php if ($kat['kode_divisi'] == $msj['kode_divisi']) : ?>
                                                <option value="<?= $kat['kode_divisi'] ?>" selected><?= $kat['kode_divisi'] ?>
                                                </option>
                                            <?php else : ?>
                                                <option value="<?= $kat['kode_divisi'] ?>"><?= $kat['kode_divisi'] ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-5 offset-1">
                            <div class="row">
                                <div class="col-md-3">NO. DO</div>
                                <div class="col-md-5">
                                    <input type="text" name="no_suratjln" id="no_suratjln" class="form-control form-control-sm text-bold text-danger text-md" value="<?= $msj['no_suratjln'] ?>" readonly>
                                    <input type="hidden" name="id_sj" id="id_sj" value="<?= $msj['id_sj'] ?>">
                                    <div class="errorNoSj invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">DATE DO</div>
                                <div class="col-md-3">
                                    <input type="date" name="tgl_suratjln" id="tgl_suratjln" class="form-control form-control-sm" value="<?= $msj['tgl_suratjln'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">NO. SO</div>
                                <div class="col-md-5">
                                    <input type="text" name="no_so" id="no_so" class="form-control form-control-sm" value="<?= $msj['no_so'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">NO. PO</div>
                                <div class="col-md-5">
                                    <input type="text" name="no_po" id="no_po" class="form-control form-control-sm" value="<?= $msj['no_po'] ?>">
                                </div>
                            </div>
                            <div class="form group row">
                                <div class="col-md-3">MARKETING</div>
                                <div class="col-sm-8">
                                    <input type="text" name="project" id="project" class="form-control form-control-sm" value="<?= $msj['project'] ?>">
                                </div>
                            </div>
                            <div class="form group row">
                                <div class="col-md-3">DESCRIPTION</div>
                                <div class="col-sm-8">
                                    <input type="text" name="remark" id="remark" class="form-control form-control-sm" value="<?= $msj['remark'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="background-color: #d0ecff;">
                    <div class="row p-2">
                        <div class="col-md-2 ml-2">
                            <div class="bg-primary text-center">ITEM NO</div>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm kode_barang" aria-describedby="basic-addon2" name="kode_barang" id="kode_barang" onkeyup="this.value = this.value.toUpperCase()">
                                <input type="hidden" name="id_barang" id="id_barang">
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon2"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="bg-primary text-center">ITEM NAME</div>
                                <input type="text" class="form-control form-control-sm" name="nama_barang" id="nama_barang" readonly>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="bg-primary text-center">QTY</div>
                                <input type="text" class="form-control form-control-sm text-right autonum2" name="qty" id="qty">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="bg-primary text-center">UNIT</div>
                                <input type="text" class="form-control form-control-sm" name="kode_satuan" id="kode_satuan" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="bg-primary text-center">NOTE</div>
                                <input type="text" class="form-control form-control-sm" name="catatan" id="catatan">
                            </div>
                        </div>


                        <div class="col-md-1">
                            <div class="form-group">
                                <div>&nbsp</div>
                                <button type="button" class="btn btn-primary btn-sm" id="btnTambah"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
                <div class="row">
                    <div class="col-md-12 dataDetailSj" id="dataDetailSj">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary tombolSimpanInv" type="button" id="btnSimpanInv">
                        UPDATE DATA
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
                <table class="table table-bordered table-hover table-sm" id="example3" name="tabel1">
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
        dataDetailSj();
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
                $.each(data, function(kode_customer, nama_customer, address1, address2, address3) {
                    $('[id="kode_customer"]').val(data.kode_customer);
                    $('[id="nama_customer"]').val(data.nama_customer);
                    $('[id="address1"]').val(data.address1);
                    $('[id="address2"]').val(data.address2);
                    $('[id="address3"]').val(data.address3);
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

        $('#modal-customer').on('hidden.bs.modal', function(event) {
            $('#nosj').focus();
        })
        $('#modal-customer').modal('hide');
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
                url: "<?php echo base_url('Customer/cari_kodecustomer') ?>",
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
                        $("#nosj").focus();
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('Kode Customer ini tidak ada dalam master customer');
                }
            });
            return false;
        }
    });

    function dataDetailSj() {
        no_suratjln = $('#no_suratjln').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('SuratJln/dataDetail') ?>",
            data: {
                no_suratjln: no_suratjln
            },
            dataType: "json",
            beforeSend: function() {
                $('.dataDetailSj').html('<i class="fa-spin fa-spinner"></i>')
            },
            success: function(response) {
                if (response.data) {
                    $('.dataDetailSj').html(response.data);
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
                cekKode();
            }
        });
        $('#no_suratjln').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#tgl_suratjln').focus();
            }
        });
        $('#tgl_suratjln').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#no_po').focus();
            }
        });
        $('#no_po').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#project').focus();
            }
        });
        $('#project').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#remark').focus();
            }
        });
        $('#remark').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#kode_barang').focus();
            }
        });
        $('#qty').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#catatan').focus();
            }
        });
        $('#catatan').keydown(function(e) {
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
            url: "<?= site_url('SuratJln/viewDataBarang') ?>",
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
                $.each(data, function(id_barang, kode_barang, nama_barang, kode_satuan, hargajual) {
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
            url: "<?= site_url('SuratJln/simpanTemp') ?>",
            data: {
                no_random: $('#no_suratjln').val(),
                id_barang: $('#id_barang').val(),
                kode_barang: $('#kode_barang').val(),
                nama_barang: $('#nama_barang').val(),
                kode_satuan: $('#kode_satuan').val(),
                qty: $('#qty').val(),
                catatan: $('#catatan').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses == 'berhasil') {
                    dataDetailSj();
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
        $('#catatan').val('');
        $('#kode_barang').focus();
    }


    $('.tombolSimpanInv').click(function(e) {
        e.preventDefault();
        let id_sj = $('#id_sj').val();
        let no_suratjln = $('#no_suratjln').val();
        let tgl_suratjln = $('#tgl_suratjln').val();
        let kodecustomer = $('#kode_customer').val();
        let kode_divisi = $('#kode_divisi').val();
        let nopo = $('#no_po').val();
        let project = $('#project').val();
        let remark = $('#remark').val();
        $.ajax({
            type: "post",
            url: "<?= base_url('SuratJln/updatedata') ?>",
            data: {
                no_suratjln: no_suratjln,
                tgl_suratjln: tgl_suratjln,
                kode_customer: kodecustomer,
                kode_divisi: kode_divisi,
                no_po: nopo,
                project: project,
                remark: remark,
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
                } else {
                    // if (response.sukses) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        html: response.sukses,
                    }).then((result) => {
                        if (result.value) {
                            window.location = "<?= base_url('SuratJln/index2') ?>" + "/" + id_sj;
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
    $('#no_suratjln').on('keyup', function() {
        $('.errorNoSj').fadeOut();
    });
</script>

<?= $this->endSection() ?>