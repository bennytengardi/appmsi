<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<!-- <h4><i class="fa fa-fw fa-table mt-3"></i>Input Kasir</h4> -->
<br>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary" style="background-color: lightblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">EDIT SALESMAN</h3>
                <a href="<?= base_url('salesman') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>
            <div class="card-body">
                <?= form_open('', ['class' => 'formsimpansalesman']) ?>
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-sm-12">

                        <div class="form group row mt-1">
                            <label for="kode_salesman" class="col-sm-3 col-form-label" style="font-weight: normal;">KODE SALESMAN</label>
                            <div class="col-sm-2">
                                <input type="text" name="kode_salesman" id="kode_salesman" style="font-size: 16px; font-weight: bold" class="form-control " value="<?= $salesman['kode_salesman'] ?>" readonly>
                                <div class="errorKodeSalesman invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="form group row mt-1">
                            <label for="nama_salesman" class="col-sm-3 col-form-label" style="font-weight: normal;">NAMA SALESMAN</label>
                            <div class="col-sm-5">
                                <input type="text" name="nama_salesman" id="nama_salesman" class="form-control" value="<?= $salesman['nama_salesman'] ?>" autofocus>
                                <div class="errorNamaSalesman invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-success tombolSimpanSalesman mt-2">UPDATE DATA</button>

                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>

<script>
    $('.tombolSimpanSalesman').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpansalesman')[0];
        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "<?= base_url('salesman/updatedata') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanSalesman').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanSalesman').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanSalesman').html('UPDATE DATA');
                $('.tombolSimpanSalesman').prop('disabled', false);
            },

            success: function(response) {
                if (response.error) {
                    let dataError = response.error;

                    if (dataError.errorNamaSalesman) {
                        $('.errorNamaSalesman').html(dataError.errorNamaSalesman).show();
                        $('#nama_salesman').addClass('is-invalid');
                    } else {
                        $('.errorNamaSalesman').fadeOut();
                        $('#nama_salesman').removeClass('is-invalid');
                        $('#nama_salesman').addClass('is-valid');
                    }
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        html: response.sukses,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.value) {
                            window.location = "<?= base_url('salesman') ?>";
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