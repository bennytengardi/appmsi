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
                    <?= form_open('LapStk02/preview') ?>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>KODE BARANG</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm kode_barang" aria-describedby="basic-addon2" name="kode_barang" id="kode_barang" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon2" data-toggle="modal" data-target="#modal-barang"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="errorkode_lama invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="form-group col-md-9">
                            <label>NAMA BARANG</label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control form-control-sm" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-5">
                            <label class="form-label">NAMA MERK</label>
                            <select name="kode_merk" id="kode_merk" class="form-control form-control-sm">
                                <option value="">--- Select Merk --- </option>
                                <?php foreach ($merk as $sls) : ?>
                                    <option value="<?= $sls['kode_merk'] ?>"><?= $sls['nama_merk'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>DARI TANGGAL</label>
                            <input type="date" name="dari" id="dari" value="<?= $dari ?>" class="form-control form-control-sm">
                        </div>

                        <div class=" form-group col-md-3">
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
<div class="modal fade" id="modal-barang" data-backdrop="static" data-keyboard="false" style="width:100%">
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
                        <?php foreach ($barang as $itm) : ?>
                            <tr>
                                <td><?= $itm['kode_barang'] ?></td>
                                <td><?= $itm['nama_barang'] ?></td>
                                <td><?= $itm['kode_satuan'] ?></td>
                                <td align="center">
                                    <button class="btn btn-primary btn-xs" id="select" data-kode_barang="<?= $itm['kode_barang'] ?>">
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
        var kode_barang = $(this).data('kode_barang');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('barang/cari_kodebarang') ?>",
            dataType: "JSON",
            data: {
                kode_barang: kode_barang
            },
            cache: false,
            success: function(data) {
                $.each(data, function(kode_barang, nama_barang, kode_satuan) {
                    $('[id="kode_barang"]').val(data.kode_barang);
                    $('[id="nama_barang"]').val(data.nama_barang);
                    $("#dari").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

        $('#modal-barang').on('hidden.bs.modal', function(event) {
            $('#dari').focus();
        })
        $('#modal-barang').modal('hide');
    });

    $('.tombol-barang').click(function(e) {
        e.preventDefault();
        $('#modalbarang').on('shown.bs.modal', function() {
            $("#modalbarang [type='search']").focus();
        })
    })

    $('#kode_barang').keydown(function(e) {
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
                $.each(data, function(kode_barang, nama_barang, kode_satuan) {
                    $('[id="kode_barang"]').val(data.kode_barang);
                    $('[id="nama_barang"]').val(data.nama_barang);
                    $("#dari").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('Kode Barang ini tidak ada dalam master barang!!');
            }
        });
        //    return false;
    }
</script>


<?= $this->endSection() ?>