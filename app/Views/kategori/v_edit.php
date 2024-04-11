<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="row justify-content-center ">
    <div class="col-md-6">
        <div class="card card-primary" style="background-color: #d7ecff;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">TABEL KATEGORI</h3>
                <a href="<?= base_url('Kategori') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>


            <div class="card-body">
                <?= form_open('', ['class' => 'formsimpankategori']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form group row mt-2">
                            <label for="kode_kategori" class="col-sm-3 col-form-label" style="font-weight: normal;">KODE KATEGORI</label>
                            <div class="col-sm-4">
                                <input type="text" name="kode_kategori" id="kode_kategori" class="form-control form-control-sm border-secondary" value="<?= $kategori['kode_kategori'] ?>" readonly>
                            </div>
                        </div>

                        <div class="form group row mt-2">
                            <label for="nama_kategori" class="col-sm-3 col-form-label" style="font-weight: normal;">NAMA KATEGORI</label>
                            <div class="col-sm-6">
                                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control form-control-sm border-secondary" value="<?= $kategori['nama_kategori'] ?>" onkeyup="this.value = this.value.toUpperCase()" autofocus>
                                <div class="errorNamaKategori invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="form group row mt-2">
                            <label for="kode_accjual" class="col-sm-3 col-form-label" style="font-weight: normal;">ACCOUNT PENJUALAN</label>
                            <div class="col-sm-8">
                                <select name="kode_accjual" id="kode_accjual" class="form-control form-control-sm border-secondary">
                                    <?php foreach ($account as $grp) : ?>
                                        <?php if ($grp['kode_account'] == $kategori['kode_accjual']) : ?>
                                            <option value="<?= $kategori['kode_accjual'] ?>" selected><?= $grp['nama_account'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $grp['kode_account'] ?>"><?= $grp['nama_account'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorKodeAccJual invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="form group row mt-2">
                            <label for="kode_acchpp" class="col-sm-3 col-form-label" style="font-weight: normal;">ACCOUNT HPP</label>
                            <div class="col-sm-8">
                                <select name="kode_acchpp" id="kode_acchpp" class="form-control form-control-sm border-secondary">
                                    <?php foreach ($account as $grp) : ?>
                                        <?php if ($grp['kode_account'] == $kategori['kode_acchpp']) : ?>
                                            <option value="<?= $kategori['kode_acchpp'] ?>" selected><?= $grp['nama_account'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $grp['kode_account'] ?>"><?= $grp['nama_account'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorKodeAccHpp invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="row mt-4 mb-3">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary btn-sm tombolSimpanKategori">UPDATE</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
    $('.tombolSimpanKategori').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpankategori')[0];
        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "<?= base_url('kategori/updatedata') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanKategori').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanKategori').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanKategori').html('UPDATE');
                $('.tombolSimpanKategori').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;

                    if (dataError.errorNamaKategori) {
                        $('.errorNamaKategori').html(dataError.errorNamaKategori).show();
                        $('#nama_kategori').addClass('is-invalid');
                    } else {
                        $('.errorNamaKategori').fadeOut();
                        $('#nama_kategori').removeClass('is-invalid');
                        $('#nama_kategori').addClass('is-valid');
                    }
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        html: response.sukses,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.value) {
                            window.location = "<?= base_url('kategori') ?>";
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