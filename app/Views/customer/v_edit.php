<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br><br>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title mt-n1">CUSTOMER</h3>
                <a href="<?= base_url('customer') ?>" type="button" class="btn btn-sm mb-2 mt-n1 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>
            <div class="card-body" style="font-size: 12px;">
                <?= form_open('', ['class' => 'formsimpancustomer']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form group row mt-1">
                            <div class="col-sm-2">CUSTOMER ID</div>
                            <div class="col-sm-2">
                                <input type="text" name="kode_customer" id="kode_customer" class="form-control form-control-sm text-bold text-md text-danger" style="font-size: 12px;height: 28px;" value="<?= $customer['kode_customer'] ?>" readonly>
                                <div class="errorKodeCustomer invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="form group row mt-1">
                            <div class="col-sm-2">CUSTOMER NAME</div>
                            <div class="col-sm-9">
                                <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm" value="<?= $customer['nama_customer'] ?>" style="font-size: 12px;height: 28px;" onkeyup="this.value = this.value.toUpperCase()" autofocus>
                                <div class="errorNamaCustomer invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="form group row mt-1">
                            <div class="col-sm-2">ADDRESS</div>
                            <div class="col-sm-9">
                                <input type="text" name="address1" id="address1" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $customer['address1'] ?>" onkeyup="this.value = this.value.toUpperCase()">
                                <div class="errorAddress1 invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="form group row mt-1">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-9">
                                <input type="text" name="address2" id="address2" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $customer['address2'] ?>" onkeyup="this.value = this.value.toUpperCase()">
                            </div>
                        </div>
                        <div class="form group row mt-1">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-9">
                                <input type="text" name="address3" id="address3" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $customer['address3'] ?>" onkeyup="this.value = this.value.toUpperCase()">
                            </div>
                        </div>
                        <div class="form group row mt-1">
                            <div class="col-sm-2">TELEPHONE#</div>
                            <div class="col-sm-3">
                                <input type="text" name="telephone" id="telephone" value="<?= $customer['telephone'] ?>" style="font-size: 12px;height: 28px;" class="form-control form-control-sm">
                            </div>
                            <div class="col-sm-2">FACSIMILE#</div>
                            <div class="col-sm-4">
                                <input type="text" name="facsimile" id="facsimile" value="<?= $customer['facsimile'] ?>" style="font-size: 12px;height: 28px;" class="form-control form-control-sm">
                            </div>
                        </div>


                        <div class="form group row mt-1">
                            <div class="col-sm-2">NPWP</div>
                            <div class="col-sm-3">
                                <input type="text" name="npwp" id="npwp" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $customer['npwp'] ?>">
                            </div>
                            <div class="col-sm-2">EMAIL</div>
                            <div class="col-sm-4">
                                <input type="text" name="email" id="email" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $customer['email'] ?>">
                            </div>
                        </div>
                        <div class="form group row mt-1">
                            <div class="col-sm-2">CONTACT PERSON</div>
                            <div class="col-sm-3">
                                <input type="text" name="personal_kontak" id="personal_kontak" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $customer['personal_kontak'] ?>" onkeyup="this.value = this.value.toUpperCase()">
                            </div>
                            <div class="col-sm-2">HANDPHONE#</div>
                            <div class="col-sm-4">
                                <input type="text" name="no_hp" id="no_hp" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $customer['no_hp'] ?>">
                            </div>
                        </div>
                        <div class="form group row mt-1">
                            <div class="col-sm-2">TAX STATUS</div>
                            <div class="col-sm-3">
                                <select name="status" id="status" class="form-control form-control-sm" style="font-size: 12px;height: 28px;">
                                    <?php if ($customer['status'] == 'NON PKP') : ?>
                                        <option value="NON PKP" selected>NON PKP</option>
                                        <option value="PKP">PKP</option>
                                    <?php else : ?>
                                        <option value="PKP" selected>PKP</option>
                                        <option value="NON PKP">NON PKP</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-sm-2">TERM OF PAYMENT</div>
                            <div class="col-sm-1">
                                <input type="text" name="termin" id="termin" class="form-control form-control-sm  text-right" style="font-size: 12px;height: 28px;" value="<?= $customer['termin'] ?>">
                            </div>
                            <div class="col-sm-1 mt-2">
                                DAYS
                            </div>
                        </div>                                  
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-xs tombolSimpanCustomer mt-1">UPDATE DATA</button>
                <?= form_close() ?>
            </div>

        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>

<script>
    $('#nama_customer').keydown(function(e) {
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
    $('#no_hp').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#status').focus();
        }
    });
    $('#status').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#termin').focus();
        }
    });

    $('.tombolSimpanCustomer').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpancustomer')[0];
        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "<?= base_url('customer/updatedata') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanCustomer').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanCustomer').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanCustomer').html('SIMPAN DATA');
                $('.tombolSimpanCustomer').prop('disabled', false);
            },

            success: function(response) {
                if (response.error) {
                    let dataError = response.error;
                    if (dataError.errorNamaCustomer) {
                        $('.errorNamaCustomer').html(dataError.errorNamaCustomer).show();
                    } else {
                        $('.errorNamaCustomer').fadeOut();
                    }
                    if (dataError.errorAddress1) {
                        $('.errorAddress1').html(dataError.errorAddress1).show();
                    } else {
                        $('.errorAddress1').fadeOut();
                    }

                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        html: response.sukses,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.value) {
                            window.location = "<?= base_url('customer') ?>";
                        }
                    });
                }
            },

            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $('#nama_customer').on('keyup', function() {
        $('.errorNamaCustomer').fadeOut();
    });
    $('#address1').on('keyup', function() {
        $('.errorAddress1').fadeOut();
    });

</script>

<?= $this->endSection() ?>
