<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 60px;">
                    <p style="font-size: 18px;">GANTI NO INVOICE</p>
                </div>
                <div class="card-body">
                    <?= form_open('', ['class' => 'formproses']) ?>
                    <br>

                    <div class="row">
                        <div class="col-md-5">No Invoice yg Mau Diganti</div>
                        <div class="col-md-7">
                            <input type="text" name="noinvlama" id="noinvlama" class="form-control form-control-sm text-bold text-danger" onkeyup="this.value = this.value.toUpperCase()" autofocus>
                            <div class="errorNoInvLama invalid-feedback" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">No Invoice yg Baru</div>
                        <div class="col-md-7">
                            <input type="text" name="noinvbaru" id="noinvbaru" class="form-control form-control-sm text-bold text-danger">
                            <div class="errorNoInvBaru invalid-feedback" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group text-center">
                            <button class="btn btn-success btn-sm tombolproses  mt-3" id="proses" type="submit" >Proses</button>
                            <a href="<?= base_url() ?>/admin" class="btn btn-danger btn-sm mt-3">Batal</a>
                        </div>
                    </div>    
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#noinvlama').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            cekKode();
        }
    });

    $('#noinvbaru').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#proses').focus();
        }
    });

    function cekKode() {
        let noinvlama = $('#noinvlama').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('SalesInv/cari_noinvoice') ?>",
            data: {
                no_invoice: noinvlama,
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                if(data) {
                    $("#noinvbaru").focus();
                } else {
                    alert('No Invoice ini tidak ada');
                    $("#noinvlama").focus();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    }



    $('.tombolproses').click(function(e) {
        e.preventDefault();
        let form = $('.formproses')[0];
        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "<?= base_url('GantiNoInvoice/proses') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolproses').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolproses').prop('disabled', true);
            },
            complete: function() {
                $('.tombolproses').html('PROSES');
                $('.tombolproses').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;
                    if (dataError.errorNoInvLama) {
                        $('.errorNoInvLama').html(dataError.errorNoInvLama).show();
                        $('#noinvlama').addClass('is-invalid');
                    } else {
                        $('.errorNoInvLama').fadeOut();
                        $('#noinvlama').removeClass('is-invalid');
                        $('#noinvlama').addClass('is-valid');
                    }
                    if (dataError.errorNoInvBaru) {
                        $('.errorNoInvBaru').html(dataError.errorNoInvBaru).show();
                        $('#noinvbaru').addClass('is-invalid');
                    } else {
                        $('.errorNoInvBaru').fadeOut();
                        $('#noinvbaru').removeClass('is-invalid');
                        $('#noinvbaru').addClass('is-valid');
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