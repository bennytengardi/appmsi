<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<!-- <h4><i class="fa fa-fw fa-table mt-3"></i>Input Kasir</h4> -->
<br>

<div class="card card-primary" style="background-color: #d7ecff;">
    <div class="card-header" style="height: 50px;">
        <h3 class="card-title">TAMBAH USER</h3>
        <a href="<?= base_url('user') ?>" type="button" class="btn btn-sm mb-2 float-right">
            <i class="fa fa-times-circle"></i></button></a>
    </div>


    <div class="card-body">
        <?= form_open_multipart('', ['class' => 'formsimpanuser']) ?>
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-sm-9">

                <div class="form group row mt-2">
                    <label for="username" class="col-sm-2 col-form-label" style="font-weight: normal;">USERNAME</label>
                    <div class="col-sm-3">
                        <input type="text" name="username" id="username" class="form-control form-control-sm border-secondary">
                        <div class="errorUserName invalid-feedback" style="display: none;"></div>
                    </div>
                </div>


                <div class="form group row mt-2">
                    <label for="nama_user" class="col-sm-2 col-form-label" style="font-weight: normal;">FULL NAME</label>
                    <div class="col-sm-6">
                        <input type="text" name="fullname" id="fullname" class="form-control form-control-sm border-secondary" onkeyup="this.value = this.value.toUpperCase()">
                        <div class="errorFullName invalid-feedback" style="display: none;"></div>
                    </div>
                </div>

                <div class="form group row mt-2">
                    <label class="col-sm-2 col-form-label" style="font-weight: normal;">LEVEL</label>
                    <div class="col-sm-3">
                        <select name="level" class="form-control form-control-sm border-secondary">
                            <option value="">--- pilih level ---</option>
                            <option value="1">Admin</option>
                            <option value="2">Operator</option>
                        </select>
                    </div>
                </div>

                <div class="form group row mt-2">
                    <label for="password" class="col-sm-2 col-form-label" style="font-weight: normal;">PASSWORD</label>
                    <div class="col-sm-3">
                        <input type="text" name="password" id="password" class="form-control form-control-sm border-secondary">
                    </div>
                </div>

                <div class="form group row mt-2">
                    <label for="uploadgambar" class="col-sm-2 col-form-label" style="font-weight: normal;">UPLOAD GBR (<i>jika ada</i>)</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="uploadgambar" class="custom-file-input" id="uploadgambar">
                                <label class="custom-file-label">Choose file</label>
                            </div>
                            <div class="invalid-feedback errorUploadGambar" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <label style="font-weight: normal;">GAMBAR PROFILE</label>
                <img src="<?= base_url('fotouser/noimage.jpg') ?>" id="gambar_load" class="img-bordered-sm" width="250px" height="250px">
                <br>
                <button type="submit" class="btn btn-primary btn-sm tombolSimpanBarang mt-5">SIMPAN DATA</button>

            </div>
        </div>

        <?= form_close() ?>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
    $(document).ready(function() {
        tampilKategori();
        tampilSatuan();
    });


    $('#uploadgambar').change(function() {
        bacaGambar(this);
    });

    $('.tombolSimpanBarang').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpanuser')[0];
        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "<?= base_url('user/simpandata') ?>",
            data: data,
            dataType: "json",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanBarang').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanBarang').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanBarang').html('SIMPAN DATA');
                $('.tombolSimpanBarang').prop('disabled', false);
            },

            success: function(response) {
                if (response.error) {
                    let dataError = response.error;

                    if (dataError.errorUserName) {
                        $('.errorUserName').html(dataError.errorUserName).show();
                        $('#username').addClass('is-invalid');
                    } else {
                        $('.errorUserName').fadeOut();
                        $('#username').removeClass('is-invalid');
                        $('#username').addClass('is-valid');
                    }
                    if (dataError.errorFullName) {
                        $('.errorFullName').html(dataError.errorFullName).show();
                        $('#fullname').addClass('is-invalid');
                    } else {
                        $('.errorFullName').fadeOut();
                        $('#fullname').removeClass('is-invalid');
                        $('#fullname').addClass('is-valid');
                    }


                    if (dataError.errorUploadGambar) {
                        $('.errorUploadGambar').html(dataError.errorUploadGambar).show();
                        $('#uploadgambar').addClass('is-invalid');
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