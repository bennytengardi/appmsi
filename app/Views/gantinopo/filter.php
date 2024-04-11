<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 60px;">
                    <p style="font-size: 18px;">GANTI NO PO</p>
                </div>
                <div class="card-body">
                    <?= form_open('', ['class' => 'formproses']) ?>
                    <br>

                    <div class="row">
                        <div class="col-md-5">No PO yg Mau Diganti</div>
                        <div class="col-md-7">
                            <input type="text" name="nopolama" id="nopolama" class="form-control form-control-sm text-bold text-danger" onkeyup="this.value = this.value.toUpperCase()" autofocus>
                            <div class="errorNoPoLama invalid-feedback" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">No PO yg Baru</div>
                        <div class="col-md-7">
                            <input type="text" name="nopobaru" id="nopobaru" class="form-control form-control-sm text-bold text-danger">
                            <div class="errorNoPoBaru invalid-feedback" style="display: none;"></div>
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
    $('#nopolama').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            cekKode();
        }
    });

    $('#nopobaru').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#proses').focus();
        }
    });

    function cekKode() {
        let nopolama = $('#nopolama').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('PurchOrd/cari_nopo') ?>",
            data: {
                no_po: nopolama,
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                if(data) {
                    $("#nopobaru").focus();
                } else {
                    alert('No PO ini tidak ada');
                    $("#nopolama").focus();
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
            url: "<?= base_url('GantiNoPo/proses') ?>",
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
                    if (dataError.errorNoPoLama) {
                        $('.errorNoPoLama').html(dataError.errorNoPoLama).show();
                        $('#nopolama').addClass('is-invalid');
                    } else {
                        $('.errorNoPoLama').fadeOut();
                        $('#nopolama').removeClass('is-invalid');
                        $('#nopolama').addClass('is-valid');
                    }
                    if (dataError.errorNoPoBaru) {
                        $('.errorNoPoBaru').html(dataError.errorNoPoBaru).show();
                        $('#nopobaru').addClass('is-invalid');
                    } else {
                        $('.errorNoPoBaru').fadeOut();
                        $('#nopobaru').removeClass('is-invalid');
                        $('#nopobaru').addClass('is-valid');
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