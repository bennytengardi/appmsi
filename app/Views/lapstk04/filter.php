<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 16px;">LAPORAN KARTU STOCK</p>
                </div>
                <div class="card-body">
                    <?= form_open('LapStk04/preview') ?>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>KODE BARANG</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm kode_baku" aria-describedby="basic-addon2" name="kode_baku" id="kode_baku" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-primary tombol-baku" id="basic-addon2" data-toggle="modal" data-target="#modal-baku"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="errorkode_lama invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="form-group col-md-9">
                            <label>NAMA BARANG</label>
                            <input type="text" name="nama_baku" id="nama_baku" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>DARI TANGGAL</label>
                            <input type="date" name="dari" id="dari" value="<?= $dari ?>" class="form-control form-control-sm">
                        </div>

                        <div class=" form-group col-md-4">
                            <label>S/D TANGGAL</label>
                            <input type="date" name="sampai" id="sampai" value="<?= $sampai ?>" class="form-control form-control-sm">
                        </div>

                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-success mt-3" name="btnCetak" type="submit"><i class="fa fa-print"></i> TAMPILKAN</button>
                        <button class="btn btn-sm btn-primary mt-3" name="btnExport" type="submit"><i class="fa fa-file-excel"></i> EXPORT TO EXCEL</button>
                        <a href="<?= base_url() ?>/admin" class="btn btn-sm btn-danger mt-3">KELUAR</a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="viewmodal" style="display: none;"></div>

<!-- MODAL SEARCH -->
<div class="modal fade" id="modal-baku" data-backdrop="static" data-keyboard="false" style="width:100%">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="height: 50px; font-size: 18px">
                <p class="modal-title text-white text-bold" id="exampleModalLabel" style="margin-top: -5px;">DATA BARANG</p>
                <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body" style="background-color: aliceblue;">
                <table class="table table-bordered table-hover table-sm" id="example3" name="tabel1" style="font-size: 14px;">
                    <thead>
                        <tr class="bg-primary text-center">
                            <th width="10%">KODE BARANG</th>
                            <th>NAMA BARANG</th>
                            <th>SATUAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($baku as $itm) : ?>
                            <tr>
                                <td><?= $itm['kode_baku'] ?></td>
                                <td><?= $itm['nama_baku'] ?></td>
                                <td><?= $itm['kode_satuan'] ?></td>
                                <td align="center">
                                    <button class="btn btn-primary btn-xs" id="select" data-kode_baku="<?= $itm['kode_baku'] ?>">
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
        var kode_baku = $(this).data('kode_baku');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('baku/cari_kodebaku') ?>",
            dataType: "JSON",
            data: {
                kode_baku: kode_baku
            },
            cache: false,
            success: function(data) {
                $.each(data, function(kode_baku, nama_baku, kode_satuan) {
                    $('[id="kode_baku"]').val(data.kode_baku);
                    $('[id="nama_baku"]').val(data.nama_baku);
                    $("#dari").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

        $('#modal-baku').on('hidden.bs.modal', function(event) {
            $('#dari').focus();
        })
        $('#modal-baku').modal('hide');
    });

    $('.tombol-baku').click(function(e) {
        e.preventDefault();
        $('#modalbaku').on('shown.bs.modal', function() {
            $("#modalbaku [type='search']").focus();
        })
    })

    $('#kode_baku').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            cekKode();
        }
    });

    $('#dari').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#sampai').focus();
        }
    });

    function cekKode() {
        let kode_baku = $('#kode_baku').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('Barang/cari_kodebaku') ?>",
            data: {
                kode_baku: kode_baku,
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $.each(data, function(kode_baku, nama_baku, kode_satuan) {
                    $('[id="kode_baku"]').val(data.kode_baku);
                    $('[id="nama_baku"]').val(data.nama_baku);
                    $("#dari").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('Kode Barang ini tidak ada dalam master baku!!');
            }
        });
        //    return false;
    }
</script>


<?= $this->endSection() ?>