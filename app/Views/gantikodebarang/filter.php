<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 60px;">
                    <p style="font-size: 18px;">GANTI KODE BARANG</p>
                </div>
                <div class="card-body">
                    <?= form_open('', ['class' => 'formproses']) ?>
                    <br>

                    <div class="row">
                        <div class="col-md-5">Kode Barang yg Mau Diganti</div>
                        <div class="col-md-7">
                            <input type="text" name="kodelama" id="kodelama" class="form-control form-control-sm text-bold text-danger" onkeyup="this.value = this.value.toUpperCase()" autofocus>
                            <div class="errorKodeLama invalid-feedback" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">Kode Barang yg Baru</div>
                        <div class="col-md-7">
                            <input type="text" name="kodebaru" id="kodebaru" class="form-control form-control-sm text-bold text-danger">
                            <div class="errorKodeBaru invalid-feedback" style="display: none;"></div>
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
    $('#kodelama').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            cekKode();
        }
    });

    $('#kodebaru').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#proses').focus();
        }
    });

    function cekKode() {
        let kodelama = $('#kodelama').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('Barang/cari_kodebarang') ?>",
            data: {
                kode_barang: kodelama,
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                if(data) {
                    $("#kodebaru").focus();
                } else {
                    alert('Kode Barang ini tidak ada');
                    $("#kodelama").focus();
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
            url: "<?= base_url('GantiKodeBarang/proses') ?>",
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
                    if (dataError.errorKodeLama) {
                        $('.errorKodeLama').html(dataError.errorKodeLama).show();
                        $('#kodelama').addClass('is-invalid');
                    } else {
                        $('.errorKodeLama').fadeOut();
                        $('#kodelama').removeClass('is-invalid');
                        $('#kodelama').addClass('is-valid');
                    }
                    if (dataError.errorKodeBaru) {
                        $('.errorKodeBaru').html(dataError.errorKodeBaru).show();
                        $('#kodebaru').addClass('is-invalid');
                    } else {
                        $('.errorKodeBaru').fadeOut();
                        $('#kodebaru').removeClass('is-invalid');
                        $('#kodebaru').addClass('is-valid');
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