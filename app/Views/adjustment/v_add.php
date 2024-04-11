<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<!-- <h4><i class="fa fa-fw fa-table mt-3"></i>Input Kasir</h4> -->
<br>
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card card-primary" style="background-color: #d7ecff;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">ADJUSTMENT STOCK</h3>
                <a href="<?= base_url('Adjustment') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <?= form_open('', ['class' => 'formsimpanadjustment']) ?>
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-12">

                        <div class="form group row mt-1">
                            <div class="col-md-2">ADJUSTMENT#</div>
                            <div class="col-md-2">
                                <input type="text" name="no_adjustment" id="no_adjustment" class="form-control form-control-sm border-secondary text-bold text-danger text-md" value="<?= $no_adjustment ?>" readonly>
                            </div>
                        </div>

                        <div class="form group row mt-2">
                            <div class="col-md-2">DATE ADJUSTMENT</div>
                            <div class="col-md-2">
                                <input type="date" name="tgl_adjustment" id="tgl_adjustment" class="form-control form-control-sm border-secondary" value="<?= $tgl_adjustment ?>" autofocus>
                            </div>
                        </div>

                        <div class="form group row mt-2">
                            <div class="col-md-2">ITEM NO</div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm border-secondary kode_barang" aria-describedby="basic-addon2" name="kode_barang" id="kode_barang" autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon2" data-toggle="modal" data-target="#modal-barang"><i class="fas fa-search"></i></button>
                                    </div>
                                    <div class="errorkode_barang invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form group row mt-2">
                            <div class="col-md-2">ITEM NAME</div>
                            <div class="col-md-8">
                                <input type="text" name="nama_barang" id="nama_barang" class="form-control form-control-sm border-secondary" readonly>
                            </div>
                        </div>

                        <div class="form group row mt-2">
                            <div class="col-md-2">STOCK COMPUTER</div>
                            <div class="col-md-2">
                                <input type="text" name="stockcomp" id="stockcomp" class="form-control form-control-sm border-secondary text-right" readonly>
                            </div>
                        </div>

                        <div class="form group row mt-2">
                            <div class="col-md-2">STOCK OPNAME</div>
                            <div class="col-md-2">
                                <input type="text" name="stockfisik" id="stockfisik" class="form-control form-control-sm border-secondary text-right" autocomplete="off">
                            </div>
                        </div>

                        <div class="form group row mt-2">
                            <div class="col-md-2">QTY ADJUSTMENT</div>
                            <div class="col-md-2">
                                <input type="text" name="qty" id="qty" class="form-control form-control-sm border-secondary text-right" readonly>
                            </div>
                        </div>

                        <div class="form group row mt-2">
                            <div class="col-md-2">DESCRIPTIONS</div>
                            <div class="col-md-9">
                                <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm border-secondary">
                                <div class="errorketerangan invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-success btn-sm tombolSimpanAdjustment my-2">SAVE DATA</button>

                <?= form_close() ?>
            </div>

        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>


<!-- MODAL SEARCH -->
<div class="modal fade" id="modal-barang" data-backdrop="static" data-keyboard="false" style="width:100%">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="height: 50px; font-size: 18px">
                <p class="modal-title text-white text-bold" id="exampleModalLabel" style="margin-top: -5px;">LIST ITEM</p>
                <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body" style="background-color: aliceblue;">
                <table class="table table-bordered table-hover table-sm" id="example3" name="tabel1">
                    <thead>
                        <tr class="bg-primary text-center">
                            <th width="15%">ITEM NO</th>
                            <th>ITEM NAME</th>
                            <th width="10%">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($barang as $itm) : ?>
                            <tr>
                                <td><?= $itm['kode_barang'] ?></td>
                                <td><?= $itm['nama_barang'] ?></td>
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
                $.each(data, function(kode_barang, nama_barang, awal, masuk,keluar,returbeli,returjual,adjust) {
                    $('[id="kode_barang"]').val(data.kode_barang);
                    $('[id="nama_barang"]').val(data.nama_barang);
                    $('[id="stockcomp"]').val(parseInt(data.awal) + parseInt(data.masuk) + parseInt(data.returjual) - parseInt(data.keluar) - parseInt(data.returbeli) + parseInt(data.adjust));
                    $("#stockfisik").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

        $('#modal-barang').on('hidden.bs.modal', function(event) {
            $('#stockfisik').focus();
        })
        $('#modal-barang').modal('hide');
    });

    $(document).on('keydown', '#kode_barang', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var kode_barang = $("#kode_barang").val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('barang/cari_kodebarang') ?>",
                dataType: "JSON",
                data: {
                    kode_barang: kode_barang
                },
                cache: false,
                success: function(data) {
                    $.each(data, function(kode_barang, nama_barang, awal, masuk,keluar,returbeli,returjual,adjust) {
                        $('[id="kode_barang"]').val(data.kode_barang);
                        $('[id="nama_barang"]').val(data.nama_barang);
                        $('[id="stockcomp"]').val(parseInt(data.awal) + parseInt(data.masuk) + parseInt(data.returjual) - parseInt(data.keluar) - parseInt(data.returbeli) + parseInt(data.adjust));
                        $("#stockfisik").focus();
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        }
    });

    $('#stockfisik').keyup(function(e) {
        hitungadjust();
    });

    $('#tgl_adjustment').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#kode_barang').focus();
        }
    });

    $('#kode_barang').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#qty').focus();
        }
    });
    $('#qty').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#keterangan').focus();
        }
    });

    $('.tombolSimpanAdjustment').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpanadjustment')[0];
        let data = new FormData(form);
        $.ajax({
            type: "post",
            url: "<?= base_url('Adjustment/simpandata') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanAdjustment').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanAdjustment').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanAdjustment').html('SIMPAN DATA');
                $('.tombolSimpanAdjustment').prop('disabled', false);
            },

            success: function(response) {
                if (response.error) {
                    let dataError = response.error;

                    if (dataError.errorkode_barang) {
                        $('.errorkode_barang').html(dataError.errorkode_barang).show();
                        $('#kode_barang').addClass('is-invalid');
                    } else {
                        $('.errorkode_barang').removeClass('is-invalid');
                        $('#kode_barang').addClass('is-valid');
                    }
                    if (dataError.errorketerangan) {
                        $('.errorketerangan').html(dataError.errorketerangan).show();
                        $('#keterangan').addClass('is-invalid');
                    } else {
                        $('.errorketerangan').removeClass('is-invalid');
                        $('#keterangan').addClass('is-valid');
                    }

                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        html: response.sukses,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.value) {
                            window.location = "<?= base_url('Adjustment') ?>";
                        }
                    });
                }
            },

            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    function hitungadjust() {
        let stockcomp = $('#stockcomp').val();
        let stockfisik = ($('#stockfisik').val() == "") ? 0 : $('#stockfisik').val();
        adjustment = parseInt(stockfisik) - parseInt(stockcomp);
        $('#qty').val(adjustment);
    };
</script>

<?= $this->endSection() ?>