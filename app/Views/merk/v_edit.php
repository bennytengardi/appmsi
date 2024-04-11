<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="row justify-content-center ">
    <div class="col-md-6">
        <div class="card card-primary" style="background-color: #d7ecff;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">TABEL MERK</h3>
                <a href="<?= base_url('Merk') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>


            <div class="card-body">
                <?= form_open('', ['class' => 'formsimpanmerk']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form group row mt-2">
                            <label for="kode_merk" class="col-sm-2 col-form-label" style="font-weight: normal;">KODE MERK</label>
                            <div class="col-sm-4">
                                <input type="text" name="kode_merk" id="kode_merk" class="form-control form-control-sm border-secondary" value="<?= $merk['kode_merk'] ?>" readonly>
                            </div>
                        </div>

                        <div class="form group row mt-4">
                            <label for="nama_merk" class="col-sm-2 col-form-label" style="font-weight: normal;">NAMA MERK</label>
                            <div class="col-sm-6">
                                <input type="text" name="nama_merk" id="nama_merk" class="form-control form-control-sm border-secondary" value="<?= $merk['nama_merk'] ?>" onkeyup="this.value = this.value.toUpperCase()" autofocus>
                                <div class="errorNamaMerk invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 mb-3">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary btn-sm tombolSimpanMerk">UPDATE</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
    $('.tombolSimpanMerk').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpanmerk')[0];
        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "<?= base_url('merk/updatedata') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanMerk').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanMerk').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanMerk').html('UPDATE');
                $('.tombolSimpanMerk').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;

                    if (dataError.errorNamaMerk) {
                        $('.errorNamaMerk').html(dataError.errorNamaMerk).show();
                        $('#nama_merk').addClass('is-invalid');
                    } else {
                        $('.errorNamaMerk').fadeOut();
                        $('#nama_merk').removeClass('is-invalid');
                        $('#nama_merk').addClass('is-valid');
                    }
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        html: response.sukses,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.value) {
                            window.location = "<?= base_url('merk') ?>";
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