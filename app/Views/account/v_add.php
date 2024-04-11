<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<!-- <h4><i class="fa fa-fw fa-table mt-3"></i>Input Kasir</h4> -->
<br>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title mt-n1">Chart Of Account</h3>
                <a href="<?= base_url('account') ?>" type="button" class="btn btn-sm mb-2 mt-n1 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>


            <div class="card-body" style="font-size: 12px">
                <?= form_open('', ['class' => 'formsimpanaccount']) ?>
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form group row mt-1">
                            <label for="kode_group" class="col-sm-2 col-form-label" style="font-weight: normal">Account Group</label>
                            <div class="col-sm-4">
                                <select name="kode_group" id="kode_group" class="form-control form-control-sm" style="font-size: 12px; height: 28px;">
                                    <option value=""></option>
                                    <?php foreach ($groupacc as $grp) : ?>
                                        <option value="<?= $grp['kode_group'] ?>"><?= $grp['nama_group'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorKodeGroup invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="form group row mt-1">
                            <label for="kode_account" class="col-sm-2 col-form-label" style="font-weight: normal">Account No</label>
                            <div class="col-sm-2">
                                <input type="text" name="kode_account" id="kode_account" class="form-control form-control-sm text-md text-bold text-danger" style="font-size: 12px; height: 28px;">
                                <div class="errorKodeAccount invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="form group row mt-1">
                            <label for="nama_account" class="col-sm-2 col-form-label" style="font-weight: normal">Account Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama_account" id="nama_account" class="form-control form-control-sm" style="font-size: 12px; height: 28px;">
                                <div class="errorNamaAccount invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>


                        <div class="form group row mt-1">
                            <label for="type_account" class="col-sm-2 col-form-label" style="font-weight: normal">Account Type</label>
                            <div class="col-sm-2">
                                <select name="type_account" id="type_account" class="form-control form-control-sm" style="font-size: 12px; height: 28px;">
                                    <option value="DETAIL">DETAIL</option>
                                    <option value="HEADER">HEADER</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form group row mt-1">
                            <label for="currency" class="col-sm-2 col-form-label" style="font-weight: normal">Currency</label>
                            <div class="col-sm-2">
                                <select name="currency" id="currency" class="form-control form-control-sm" style="font-size: 12px; height: 28px;">
                                    <?php foreach ($currency as $cur) : ?>
                                        <option value="<?= $cur['currency'] ?>"><?= $cur['currency'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>


                        
                        <div class="form group row mt-1">
                            <div class="col-sm-2" id="textkurs"></div>
                            <div class="col-sm-2" id="inputkurs"></div>
                        </div>
                        
                        <div class="form group row mt-2">
                            <label for="saldo_awal" class="col-sm-2 col-form-label" style="font-weight: normal">Opening Balance</label>
                            <div class="col-sm-3">
                                <input type="text" name="saldo_awal" id="saldo_awal" class="form-control form-control-sm text-right" style="font-size: 12px; height: 28px;">
                            </div>
                            <label for="tgl_awal" class="col-sm-1 col-form-label text-right" style="font-weight: normal">As Of :</label>
                            <div>
                                <input type="date" name="tgl_awal" id="tgl_awal" class="form-control form-control-sm" style="font-size: 12px; height: 28px;" value = <?= date("2022-12-31") ?> >
                            </div>
                        </div>                         
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-xs btn-primary tombolSimpanAccount mt-1 mb-2">Save Data</button>

                <?= form_close() ?>
            </div>

        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>

<script>

    $('#kode_account').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#nama_account').focus();
        }
    });

    $('#nama_account').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#kode_group').focus();
        }
    });
    
    $('#kode_group').change(function(e) {
            e.preventDefault();
            $('#type_account').focus();
    });
    
    $('#type_account').change(function(e) {
            e.preventDefault();
            $('#currency').focus();
    });

    $('#currency').on('change', function() {
        let currency = $(this).val();
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('currency/cari_currency') ?>",
            data: {
                currency: currency
            },
            success: function(data) {
                $.each(data, function(currency,nilai_tukar) {
                    const matauang = data.currency;
                    const nilaitukar = data.nilai_tukar;
                    if (matauang != 'IDR') {
                       html = '<input type="text" class="form-control form-control-sm text-right" name="kurs" id="kurs" style="font-size: 12px; height: 28px;">';
                       document.getElementById("textkurs").innerHTML = "Exchange Rate";
                       $('#inputkurs').html(html);
                       $('#kurs').val(nilaitukar);

                    } else {
                       html = '<input type="hidden" class="form-control form-control-sm text-right" name="kurs" id="kurs" style="font-size: 12px; height: 28px;">';
                       document.getElementById("textkurs").innerHTML = "";
                       $('#inputkurs').html(html);                       
                       $('#kurs').val(nilaitukar);
                    }
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    });

   

    $('.tombolSimpanAccount').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpanaccount')[0];
        let data = new FormData(form);
        $.ajax({
            type: "post",
            url: "<?= base_url('account/simpandata') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanAccount').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanAccount').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanAccount').html('SIMPAN DATA');
                $('.tombolSimpanAccount').prop('disabled', false);
            },

            success: function(response) {
                if (response.error) {
                    let dataError = response.error;

                    if (dataError.errorKodeAccount) {
                        $('.errorKodeAccount').html(dataError.errorKodeAccount).show();
                        $('#kode_account').addClass('is-invalid');
                    } else {
                        $('.errorKodeAccount').fadeOut();
                        $('#kode_account').removeClass('is-invalid');
                        $('#kode_account').addClass('is-valid');
                    }

                    if (dataError.errorNamaAccount) {
                        $('.errorNamaAccount').html(dataError.errorNamaAccount).show();
                        $('#nama_account').addClass('is-invalid');
                    } else {
                        $('.errorNamaAccount').fadeOut();
                        $('#nama_account').removeClass('is-invalid');
                        $('#nama_account').addClass('is-valid');
                    }

                    if (dataError.errorKodeGroup) {
                        $('.errorKodeGroup').html(dataError.errorKodeGroup).show();
                        $('#kode_group').addClass('is-invalid');
                    } else {
                        $('.errorKodeGroup').fadeOut();
                        $('#kode_group').removeClass('is-invalid');
                        $('#kode_group').addClass('is-valid');
                    }

                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        html: response.sukses,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.value) {
                            window.location = "<?= base_url('account') ?>";
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