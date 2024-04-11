<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-5">
            <div class="card" style="height: 100%;background-color: #d7ecff;">
                <div class="card-header bg-gradient-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 16px;">LAPORAN BUKU BESAR</p>
                </div>
                <div class="card-body">
                    <?= form_open('LapKeu01/preview') ?>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <div>D/ KODE ACCOUNT</div>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm kode_account border-secondary" aria-describedby="basic-addon2" name="kode_account" id="kode_account" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-primary tombol-account" id="basic-addon2" data-toggle="modal" data-target="#modal-account"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-8">
                            <div>NAMA ACCOUNT</div>
                            <input type="text" name="nama_account" id="nama_account" class="form-control form-control-sm border-secondary" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <div>S/D KODE ACCOUNT</div>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm kode_account2 border-secondary" aria-describedby="basic-addon2" name="kode_account2" id="kode_account2" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-primary tombol-account2" id="basic-addon2" data-toggle="modal" data-target="#modal-account2"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-8">
                            <div>NAMA ACCOUNT</div>
                            <input type="text" name="nama_account2" id="nama_account2" class="form-control form-control-sm border-secondary" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <div>DARI TANGGAL</div>
                            <input type="date" name="dari" id="dari" value="<?= $dari ?>" class="form-control form-control-sm border-secondary">
                        </div>

                        <div class=" form-group col-md-3">
                            <div>S/D TANGGAL</label>
                                <input type="date" name="sampai" id="sampai" value="<?= $sampai ?>" class="form-control form-control-sm border-secondary">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-success mt-3" name="btnCetak" type="submit"><i class="fa fa-print"></i> PRINT</button>
                        <button class="btn btn-sm btn-primary mt-3" name="btnExport" type="submit"><i class="fa fa-file-excel"></i> EXCEL</button>
                        <a href="<?= base_url() ?>/admin" class="btn btn-sm btn-danger mt-3"><i class="fas fa-sign-out-alt"></i> KELUAR</a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="viewmodal" style="display: none;"></div>

    <!-- MODAL SEARCH -->
    <div class="modal fade" id="modal-account" data-backdrop="static" data-keyboard="false" style="width:100%">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="height: 50px; font-size: 18px">
                    <p class="modal-title text-white text-bold" id="exampleModalLabel" style="margin-top: -5px;">DATA PERKIRAAN</p>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body" style="background-color: aliceblue;">
                    <table class="table table-bordered table-hover table-sm" id="example3" name="tabel1">
                        <thead>
                            <tr class="bg-primary text-center">
                                <th width="15%">KODE ACCOUNT</th>
                                <th>NAMA ACCOUNT</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($account as $itm) : ?>
                                <tr>
                                    <td><?= $itm['kode_account'] ?></td>
                                    <td><?= $itm['nama_account'] ?></td>
                                    <td align="center">
                                        <button class="btn btn-primary btn-xs" id="select" data-kode_account="<?= $itm['kode_account'] ?>">
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

    <!-- MODAL SEARCH -->
    <div class="modal fade" id="modal-account2" data-backdrop="static" data-keyboard="false" style="width: 100%">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="height: 50px; font-size: 18px">
                    <p class="modal-title text-white text-bold" id="exampleModalLabel" style="margin-top: -5px;">DATA PERKIRAAN</p>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body" style="background-color: aliceblue;">
                    <table class="table table-bordered table-hover table-sm" id="example1" name="tabel2">
                        <thead>
                            <tr class="bg-primary text-center">
                                <th width="15%">KODE ACCOUNT</th>
                                <th>NAMA ACCOUNT</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($account as $itm2) : ?>
                                <tr>
                                    <td><?= $itm2['kode_account'] ?></td>
                                    <td><?= $itm2['nama_account'] ?></td>
                                    <td align="center">
                                        <button class="btn btn-primary btn-xs" id="select2" data-kode_account="<?= $itm2['kode_account'] ?>">
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
<script>
    $(document).on('click', '#select', function(e) {
        e.preventDefault();
        var kode_account = $(this).data('kode_account');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Account/cari_kodeaccount') ?>",
            dataType: "JSON",
            data: {
                kode_account: kode_account
            },
            cache: false,
            success: function(data) {
                $.each(data, function(kode_account, nama_account, kode_satuan) {
                    $('[id="kode_account"]').val(data.kode_account);
                    $('[id="nama_account"]').val(data.nama_account);
                    $("#dari").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

        $('#modal-account').on('hidden.bs.modal', function(event) {
            $('#dari').focus();
        })
        $('#modal-account').modal('hide');
    });

    $('.tombol-account').click(function(e) {
        e.preventDefault();
        $('#modal-account').on('shown.bs.modal', function() {
            $("#modal-account [type='search']").focus();
        })
    })

    $(document).on('click', '#select2', function(e) {
        e.preventDefault();
        var kode_account2 = $(this).data('kode_account');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Account/cari_kodeaccount') ?>",
            dataType: "JSON",
            data: {
                kode_account: kode_account2
            },
            cache: false,
            success: function(data) {
                $.each(data, function(kode_account, nama_account, kode_satuan) {
                    $('[id="kode_account2"]').val(data.kode_account);
                    $('[id="nama_account2"]').val(data.nama_account);
                    $("#dari").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

        $('#modal-account2').on('hidden.bs.modal', function(event) {
            $('#dari').focus();
        })
        $('#modal-account2').modal('hide');
    });

    $('.tombol-account2').click(function(e) {
        e.preventDefault();
        $('#modal-account2').on('shown.bs.modal2', function() {
            $("#modal-account2 [type='search']").focus();
        })
    })


    $('#kode_account').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            cekKode();
            $('#kode_account2').focus();
        }
    });
    $('#kode_account2').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            cekKode1();
            $('#dari').focus();
        }
    });

    $('#dari').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#sampai').focus();
        }
    });

    function cekKode() {
        let kode_account = $('#kode_account').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('Account/cari_kodeaccount') ?>",
            data: {
                kode_account: kode_account,
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $.each(data, function(kode_account, nama_account, kode_satuan, hargajual) {
                    $('[id="kode_account"]').val(data.kode_account);
                    $('[id="nama_account"]').val(data.nama_account);
                    $("#kode_account2").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('Kode Account ini tidak ada dalam master account!!');
            }
        });
        //    return false;
    }

    function cekKode1() {
        let kode_account = $('#kode_account2').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('Account/cari_kodeaccount') ?>",
            data: {
                kode_account: kode_account,
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $.each(data, function(kode_account, nama_account, kode_satuan, hargajual) {
                    $('[id="kode_account2"]').val(data.kode_account);
                    $('[id="nama_account2"]').val(data.nama_account);
                    $("#dari").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('Kode Barang ini tidak ada dalam master account!!');
            }
        });
        //    return false;
    }
</script>
<?= $this->endSection() ?>