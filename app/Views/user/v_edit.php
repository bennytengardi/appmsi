<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<!-- <h4><i class="fa fa-fw fa-table mt-3"></i>Input Kasir</h4> -->
<br>

<div class="card card-primary" style="background-color: #d7ecff;">
    <div class="card-header" style="height: 50px;">
        <h3 class="card-title">EDIT USER</h3>
        <a href="<?= base_url('user') ?>" type="button" class="btn btn-sm mb-2 float-right">
            <i class="fa fa-times-circle"></i></button></a>
    </div>


    <div class="card-body">
        <?= form_open_multipart('', ['class' => 'formsimpanuser']) ?>
        <?= csrf_field() ?>
        <div class="row" style="font-size: 15px;">
            <div class="col-sm-9">
                <div class="form group row mt-2">
                    <label for="username" class="col-sm-2 col-form-label" style="font-weight: normal;">USERNAME</label>
                    <div class="col-sm-3">
                        <input type="text" name="username" id="username" class="form-control form-control-sm border-secondary" value="<?= $user['username'] ?>">
                        <div class="errorUserName invalid-feedback" style="display: none;"></div>
                    </div>
                </div>


                <div class="form group row mt-2">
                    <label for="nama_user" class="col-sm-2 col-form-label" style="font-weight: normal;">FULL NAME</label>
                    <div class="col-sm-6">
                        <input type="text" name="fullname" id="fullname" class="form-control form-control-sm border-secondary" value="<?= $user['fullname'] ?>">
                        <div class="errorFullName invalid-feedback" style="display: none;"></div>
                    </div>
                </div>

                <div class="form group row mt-2">
                    <label class="col-sm-2 col-form-label" style="font-weight: normal;">LEVEL</label>
                    <div class="col-sm-3">
                        <select name="level" id="level" class="form-control form-control-sm border-secondary">
                            <?php if ($user['level'] == 1) : ?>
                                <option value="1" selected>Admin</option>
                                <option value="2">Operator</option>
                            <?php else : ?>
                                <option value="2" selected>Operator</option>
                                <option value="1">Admin</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <!-- <div class="form group row mt-2">
                    <label for="password" class="col-sm-2 col-form-label" style="font-weight: normal;">PASSWORD</label>
                    <div class="col-sm-3">
                        <input type="text" name="password" id="password" class="form-control">
                    </div>
                </div> -->


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
                <label style="font-weight: normal;">PROFILE USER</label>
                <img src="<?= base_url('fotouser/' . $user['foto']) ?>" id="gambar_load" class="img-bordered-sm" width="250px" height="250px">

                <br>
                <button type="submit" class="btn btn-sm btn-primary tombolSimpanUser mt-5">UPDATE DATA</button>

            </div>
        </div>

        <?= form_close() ?>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
    $('#uploadgambar').change(function() {
        bacaGambar(this);
    });

    $('.tombolSimpanUser').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpanuser')[0];
        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "<?= base_url('user/updatedata') ?>",
            data: data,
            dataType: "json",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanUser').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanUser').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanUser').html('UPDATE DATA');
                $('.tombolSimpanUser').prop('disabled', false);
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
                            window.location = "<?= base_url('user') ?>";
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