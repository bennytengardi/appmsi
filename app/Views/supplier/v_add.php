<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br><br>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title mt-n1">SUPPLIER</h3>
                <a href="<?= base_url('supplier') ?>" type="button" class="btn btn-sm mb-2 mt-n1 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>

            <div class="card-body" style="font-size: 12px;">
                <?= form_open('', ['class' => 'formsimpansupplier']) ?>
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form group row mt-1">
                            <div class="col-md-2 mt-2">SUPPLIER ID</div>
                            <div class="col-md-2">
                                <input type="text" name="kode_supplier" id="kode_supplier" class="form-control form-control-sm text-md text-danger text-bold" style="font-size: 12px; height: 28px;"  value="<?= $kode_supplier ?>" readonly>
                                <div class="errorKodeSupplier invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="form group row mt-1">
                            <div class="col-md-2 mt-2">SUPPLIER NAME</div>
                            <div class="col-md-8">
                                <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" style="font-size: 12px; height: 28px;" onkeyup="this.value = this.value.toUpperCase()" autofocus>
                                <div class="errorNamaSupplier invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="form group row mt-1">
                            <div class="col-md-2 mt-2">ADDRESS</div>
                            <div class="col-md-8">
                                <input type="text" name="address1" id="address1" class="form-control form-control-sm" style="font-size: 12px; height: 28px;" onkeyup="this.value = this.value.toUpperCase()">
                            </div>
                        </div>
                        <div class="form group row mt-1">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input type="text" name="address2" id="address2" class="form-control form-control-sm" style="font-size: 12px; height: 28px;" onkeyup="this.value = this.value.toUpperCase()">
                            </div>
                        </div>
                        <div class="form group row mt-1">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input type="text" name="address3" id="address3" class="form-control form-control-sm" style="font-size: 12px; height: 28px;" onkeyup="this.value = this.value.toUpperCase()">
                            </div>
                        </div>

                        <div class="form group row mt-1">
                            <div class="col-md-2 mt-2">TELEPHONE#</div>
                            <div class="col-md-3">
                                <input type="text" name="telephone" id="telephone" class="form-control form-control-sm" style="font-size: 12px; height: 28px;">
                            </div>
                            <div class="col-md-2 mt-2">FACSIMILE#</div>
                            <div class="col-md-3">
                                <input type="text" name="facsimile" id="facsimile" class="form-control form-control-sm" style="font-size: 12px; height: 28px;">
                            </div>
                        </div>

                        <div class="form group row mt-1">
                            <div class="col-md-2 mt-2">NPWP</div>
                            <div class="col-md-3">
                                <input type="text" name="npwp" id="npwp" class="form-control form-control-sm" style="font-size: 12px; height: 28px;">
                            </div>
                            <div class="col-md-2 mt-2">EMAIL</div>
                            <div class="col-md-3">
                                <input type="text" name="email" id="email" class="form-control form-control-sm" style="font-size: 12px; height: 28px;">
                            </div>
                        </div>
                        <div class="form group row mt-1">
                            <div class="col-md-2 mt-2">CONTACT PERSON</div>
                            <div class="col-md-3">
                                <input type="text" name="personal_kontak" id="personal_kontak" class="form-control form-control-sm" style="font-size: 12px; height: 28px;" onkeyup="this.value = this.value.toUpperCase()">
                            </div>
                            <div class="col-md-2 mt-2">NO HANDPHONE</div>
                            <div class="col-md-3">
                                <input type="text" name="no_hp" id="no_hp" class="form-control form-control-sm" style="font-size: 12px; height: 28px;">
                            </div>
                        </div>
                        <div class="form group row mt-1">
                            <div class="col-sm-2 mt-2">TAX STATUS</div>
                            <div class="col-sm-3">
                                <select name="status" id="status" class="form-control form-control-sm" style="font-size: 12px; height: 28px;">
                                    <option value="NON PKP">NON PKP</option>
                                    <option value="PKP">PKP</option>
                                </select>
                            </div>    
                            <div class="col-md-2 mt-2">CURRENCY</div>
                                <div class="col-md-2">
                                    <select name="currency" id="currency" class="form-control form-control-sm" style="font-size: 12px; height: 28px;">
                                        <option value="IDR">IDR</option>
                                        <?php foreach ($currency as $curr) : ?>
                                            <option value="<?= $curr['currency'] ?>"><?= $curr['currency'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-xs btn-primary tombolSimpanSupplier mt-2">SAVE DATA</button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
    $(document).ready(function() {
        $('#nama_supplier').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#address1').focus();
            }
        });
        $('#address1').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#address2').focus();
            }
        });
        $('#address2').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#address3').focus();
            }
        });
        $('#address3').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#telephone').focus();
            }
        });
        $('#telephone').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#facsimile').focus();
            }
        });
        $('#facsimile').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#npwp').focus();
            }
        });
        $('#npwp').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#email').focus();
            }
        });
        $('#email').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#personal_kontak').focus();
            }
        });
        $('#personal_kontak').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#no_hp').focus();
            }
        });
        $('#no_hp').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#status').focus();
            }
        });
        $('#status').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#currency').focus();
            }
        });


        $('.tombolSimpanSupplier').click(function(e) {
            e.preventDefault();
            let form = $('.formsimpansupplier')[0];
            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: "<?= base_url('supplier/simpandata') ?>",
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('.tombolSimpanSupplier').html('<i class="fa fa-spin fa-spinner"></i>');
                    $('.tombolSimpanSupplier').prop('disabled', true);
                },
                complete: function() {
                    $('.tombolSimpanSupplier').html('SIMPAN DATA');
                    $('.tombolSimpanSupplier').prop('disabled', false);
                },

                success: function(response) {
                    if (response.error) {
                        let dataError = response.error;
                        if (dataError.errorNamaSupplier) {
                            $('.errorNamaSupplier').html(dataError.errorNamaSupplier).show();
                        } else {
                            $('.errorNamaSupplier').fadeOut();
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            html: response.sukses,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.value) {
                                window.location = "<?= base_url('supplier') ?>";
                            }
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>