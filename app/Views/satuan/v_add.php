<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="row justify-content-center ">
    <div class="col-md-6">
        <div class="card card-primary" style="background-color: #d7ecff;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">Tabel Satuan</h3>
                <a href="<?= base_url('satuan') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>


            <div class="card-body">
                <?= form_open('', ['class' => 'formsimpansatuan']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form group row mt-2">
                            <div class="col-sm-2 col-form-label">Kode Satuan</div>
                            <div class="col-sm-2">
                                <input type="text" name="kode_satuan" id="kode_satuan" class="form-control form-control-sm border-secondary"  onkeyup="this.value = this.value.toUpperCase()" autofocus>
                                <div class="errorKodeSatuan invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>


                        <div class="form group row mt-2">
                            <div class="col-sm-2 col-form-label">Nama Satuan</div>
                            <div class="col-sm-5">
                                <input type="text" name="nama_satuan" id="nama_satuan" class="form-control form-control-sm border-secondary" onkeyup="this.value = this.value.toUpperCase()">
                                <div class="errorNamaSatuan invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 mb-3">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary btn-sm tombolSimpanSatuan">Simpan</button>
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
            url: "<?= base_url('satuan/simpandata') ?>",
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
                $('.tombolSimpanSatuan').html('SIMPAN');
                $('.tombolSimpanSatuan').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;

                    if (dataError.errorKodeSatuan) {
                        $('.errorKodeSatuan').html(dataError.errorKodeSatuan).show();
                        $('#kode_satuan').addClass('is-invalid');
                    } else {
                        $('.errorKodeSatuan').fadeOut();
                        $('#kode_satuan').removeClass('is-invalid');
                        $('#kode_satuan').addClass('is-valid');
                    }

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
                            window.location.reload();
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