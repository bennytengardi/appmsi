<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="row justify-content-center ">
    <div class="col-md-6">
        <div class="card card-primary" style="background-color: #d7ecff;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">Tabel Satuan</h3>
                <a href="<?= base_url('satuan') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>


            <div class="card-body">
                <?= form_open('', ['class' => 'formsimpansatuan']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form group row mt-2">
                            <div class="col-sm-2 col-form-label">Kode Satuan</div>
                            <div class="col-sm-2">
                                <input type="text" name="kode_satuan" id="kode_satuan" class="form-control form-control-sm border-secondary"  value="<?= $satuan['kode_satuan'] ?>" readonly>
                                <div class="errorKodeSatuan invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>


                        <div class="form group row mt-2">
                            <div class="col-sm-2 col-form-label">Nama Satuan</div>
                            <div class="col-sm-5">
                                <input type="text" name="nama_satuan" id="nama_satuan" class="form-control form-control-sm border-secondary"  value="<?= $satuan['nama_satuan'] ?>" onkeyup="this.value = this.value.toUpperCase()" autofocus>
                                <div class="errorNamaSatuan invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 mb-3">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary btn-sm tombolSimpanSatuan">Update</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
    $('.tombolSimpanSatuan').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpansatuan')[0];
        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "<?= base_url('satuan/updatedata') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanSatuan').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanSatuan').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanSatuan').html('UPDATE');
                $('.tombolSimpanSatuan').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;

                    if (dataError.errorNamaSatuan) {
                        $('.errorNamaSatuan').html(dataError.errorNamaSatuan).show();
                        $('#nama_satuan').addClass('is-invalid');
                    } else {
                        $('.errorNamaSatuan').fadeOut();
                        $('#nama_satuan').removeClass('is-invalid');
                        $('#nama_satuan').addClass('is-valid');
                    }
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        html: response.sukses,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.value) {
                            window.location = "<?= base_url('satuan') ?>";
                        }
                    });
                }
            },

            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });
    });
</script>

<?= $this->endSection() ?>