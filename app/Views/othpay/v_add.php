<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
    <div class="card-header" style="height: 40px;">
        <h3 class="card-title mt-n1">PENGELUARAN KAS/BANK</h3>
        <a href="<?= base_url('OthPay') ?>" type="button" class="btn btn-sm mb-2 mt-n1 float-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </a>
    </div>
    <div class="card-body" style="font-size: 13px;">
        <div class="row">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-3">PAID FROM</div>
                    <div class="col-sm-8">
                        <select name="kode_account" id="kode_account" class="form-control form-control-sm" style="font-size: 13px;height: 26px;"  autofcus>
                            <option value=""></option>
                            <?php foreach ($account as $acc) : ?>
                                <option value="<?= $acc['kode_account'] ?>"><?= $acc['nama_account'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="errorKodeAccount invalid-feedback" style="display: none;"></div>
                    </div>
                </div>
                <div class="row mt-0">
                    <div class="col-sm-3">NO VOUCHER</div>
                    <div class="col-sm-5">
                        <input type="text" name="no_bukti" id="no_bukti" class="form-control form-control-sm text-bold text-danger" style="font-size: 13px;height: 26px;" value="<?= $no_bukti ?>" readonly>
                        <input type="hidden" name="no_random" id="no_random" value="<?= $no_random ?>">
                        <div class="errorNoBukti invalid-feedback" style="display: none;"></div>
                    </div>
                </div>
                <div class="row mt-0">
                    <div class="col-sm-3">DATE</div>
                    <div class="col-sm-4">
                        <input type="date" name="tgl_bukti" id="tgl_bukti" class="form-control form-control-sm " style="font-size: 13px;height: 26px;" value="<?= $tgl_bukti ?>">
                    </div>
                </div>
                <div class="row mt-0">
                    <div class="col-sm-3" id="textkurs"></div>
                    <div class="col-sm-3" id="inputkurs"></div>
                </div>
                
            </div>
            <div class="col-sm-6 offset-1">
                    <div class="row">
                    <div class="col-sm-2">NO CHEQUE</div>
                    <div class="col-sm-3">
                        <input type="text" name="no_cheque" id="no_cheque" class="form-control form-control-sm " style="font-size: 13px;height: 26px;" onkeyup="this.value = this.value.toUpperCase()">
                    </div>
                </div>
                <div class="row mt-0">
                    <div class="col-md-2">DIVISI</div>
                    <div class="col-md-3">
                        <select name="kode_divisi" id="kode_divisi" class="form-control form-control-sm" style="font-size: 13px;height: 26px;">
                            <option value=""></option>
                            <?php foreach ($divisi as $sls) : ?>
                                <option value="<?= $sls['kode_divisi'] ?>"><?= $sls['kode_divisi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="errorKodeDivisi invalid-feedback" style="display: none;"></div>
                    </div>
                </div>
                
                <div class="row mt-0">
                    <div class="col-sm-2">PAYEE</div>
                    <div class="col-sm-6">
                        <input type="text" name="kepada" id="kepada" class="form-control form-control-sm " style="font-size: 13px;height: 26px;" onkeyup="this.value = this.value.toUpperCase()">
                        <div class="errorKepada invalid-feedback" style="display: none;"></div>
                    </div>
                </div>

                <div class="row mt-0">
                    <div class="col-sm-2">DESCRIPTION</div>
                    <div class="col-sm-9">
                        <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm " style="font-size: 13px;height: 26px;">
                        <div class="errorKeterangan invalid-feedback" style="display: none;"></div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-2">
                <div class="text-center bg-primary" style="height: 22px;">ACCOUNT#</div>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm  kode_acct" aria-describedby="basic-addon2" name="kode_acct" id="kode_acct" style="font-size: 13px;height: 26px;">
                    <div class="input-group-append">
                        <button type="button" class="input-group-text bg-primary tombol-account" id="basic-addon2" style="font-size: 13px;height: 26px;"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="text-center bg-primary" style="height: 22px;">ACCOUNT NAME</div>
                <input type="text" class="form-control form-control-sm " name="nama_acct" id="nama_acct"  style="font-size: 13px;height: 26px;" readonly>
            </div>


            <div class="col-md-2">
                <div class="text-center bg-primary" style="height: 22px;">AMOUNT</div>
                <input type="text" class="form-control form-control-sm text-right" name="jumlah" id="jumlah" style="font-size: 13px;height: 26px;">
            </div>

            <div class="col-md-4">
                <div class="text-center bg-primary" style="height: 22px;">DESCRIPTION</div>
                <input type="text" class="form-control form-control-sm " name="remark" id="remark" style="font-size: 13px;height: 26px;">
            </div>

            <div class="col-md-1">
                <div class="form-group">
                    <div>&nbsp</div>
                    <button type="button" class="btn btn-xs btn-primary d-block tombolTambah" id="btnTambah"><i class="fa fa-plus"></i></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 dataDetailInv" id="dataDetailInv">

            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-primary btn-xs text-xs tombolSimpanInv" type="button" id="btnSimpanInv"><i class="fa fa-save"></i>
                SAVE DATA
            </button>
        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>

<script>

    $('#kode_account').change(function(e) {
        $('#tgl_bukti').focus();
    });

    $('#tgl_bukti').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#no_cheque').focus();
        }
    });

    $('#no_cheque').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#kode_divisi').focus();
        }
    });

    $('#kode_divisi').change(function(e) {
        e.preventDefault();
        $('#kepada').focus();
    });

    $('#kepada').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#keterangan').focus();
        }
    });
    $('#keterangan').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#kode_acct').focus();
        }
    });


    $(document).ready(function() {
        dataDetailInv();
        $('#kode_account').focus();
    });

    function dataDetailInv() {
        no_bukti = $('#no_random').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('OthPay/dataDetail') ?>",
            data: {
                no_bukti: no_bukti
            },
            dataType: "json",
            beforeSend: function() {
                $('.dataDetailInv').html('<i class="fa-spin fa-spinner"></i>')
            },
            success: function(response) {
                if (response.data) {
                    $('.dataDetailInv').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        $('.tombol-account').click(function(e) {
            e.preventDefault();
            cekKode2();
        });

        $('#kode_acct').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekKode();
            }
        });

        $('#jumlah').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#remark').focus();
            }
        });

        $('#remark').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#btnTambah').focus();
            }
        });

        $('#btnTambah').click(function(e) {
            e.preventDefault();
            masukCart();
        });
    });

    $('#kode_account').on('change', function() {
        var kode_account = $(this).val();
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('account/cari_kodeaccount') ?>",
            data: {
                kode_account: kode_account
            },
            success: function(data) {
                $.each(data, function(currency,nilai_tukar) {
                    const matauang = data.currency;
                    const nilaitukar = data.nilai_tukar;
                    if (matauang != 'IDR') {
                       html = '<input type="text" class="form-control form-control-sm text-right" name="kurs" id="kurs">';
                       document.getElementById("textkurs").innerHTML = "KURS";
                       $('#inputkurs').html(html);
                       $('#kurs').val(nilaitukar);

                    } else {
                       html = '<input type="hidden" class="form-control form-control-sm text-right" name="kurs" id="kurs">';
                       document.getElementById("textkurs").innerHTML = "";
                       $('#inputkurs').html(html);                       
                       $('#kurs').val(nilaitukar);
                    }
                    $('#no_bukti').focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    });


    function cekKode() {
        let kode_acct = $('#kode_acct').val();
        if (kode_acct.length == 0) {
            $.ajax({
                url: "<?= site_url('OthPay/viewDataAccount') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.viewmodal).show();
                    $('#modalaccount').modal('show');
                    $('#modalaccount').on('shown.bs.modal', function() {
                        $("#modalaccount [type='search']").focus();
                    })
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        } else {
            $.ajax({
                type: "post",
                url: "<?= site_url('Account/cari_kodeacct') ?>",
                data: {
                    kode_acct: kode_acct,
                },
                dataType: "json",
                cache: false,
                success: function(data) {
                    $.each(data, function(kode_account, nama_account) {
                        $('[id="kode_acct"]').val(data.kode_account);
                        $('[id="nama_acct"]').val(data.nama_account);
                        $("#jumlah").focus();
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

            return false;
        }
    }

    function cekKode2() {
        let kode_account = $('#kode_account').val();
        $.ajax({
            url: "<?= site_url('OthPay/viewDataAccount') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewmodal').html(response.viewmodal).show();
                $('#modalaccount').modal('show');
                $('#modalaccount').on('shown.bs.modal', function() {
                    $("#modalaccount [type='search']").focus();
                })
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

        return false;

    }

    function masukCart() {
        let kode_acct = $('#kode_acct').val();
        let no_random =  $('#no_random').val();
        let no_bukti = $('#no_bukti').val();
        let nama_acct = $('#nama_acct').val();
        let jumlah = $('#jumlah').val();
        let remark = $('#remark').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('OthPay/simpanTemp') ?>",
            data: {
                no_bukti: no_bukti,
                no_random: no_random,
                kode_acct: kode_acct,
                nama_acct: nama_acct,
                jumlah: jumlah,
                remark: remark,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses == 'berhasil') {
                    dataDetailInv();
                    kosong();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }


    function kosong() {
        $('#kode_acct').val('');
        $('#nama_acct').val('');
        $('#jumlah').val('');
        $('#remark').val('');
        $('#kode_acct').focus();
    }

    $('.tombolSimpanInv').click(function(e) {
        e.preventDefault();
        let norandom =  $('#no_random').val();
        let nobukti = $('#no_bukti').val();
        let tglbukti = $('#tgl_bukti').val();
        let nocheque = $('#no_cheque').val();
        let kodeaccount = $('#kode_account').val();
        let kodedivisi = $('#kode_divisi').val();
        let ket = $('#keterangan').val();
        let kpd = $('#kepada').val();
        let tot = $('#total').val();
        let kur = $('#kurs').val();

        $.ajax({
            type: "post",
            url: "<?= base_url('OthPay/simpandata') ?>",
            data: {
                no_random: norandom,
                no_bukti: nobukti,
                tgl_bukti: tglbukti,
                kode_account: kodeaccount,
                kode_divisi: kodedivisi,
                no_cheque: nocheque,
                kepada: kpd,
                keterangan: ket,
                nilai_tukar: kur,
                total: tot,
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;
                    if (dataError.errorNoBukti) {
                        $('.errorNoBukti').html(dataError.errorNoBukti).show();                        
                    } else {
                        $('.errorNoBukti').fadeOut();
                    }

                    if (dataError.errorKodeAccount) {
                       $('.errorKodeAccount').html(dataError.errorKodeAccount).show();
                    } else {
                        $('.errorKodeAccount').fadeOut();
                    }
                    if (dataError.errorKodeDivisi) {
                        $('.errorKodeDivisi').html(dataError.errorKodeDivisi).show();
                    } else {
                        $('.errorKodeDivisi').fadeOut();
                    }

                } else {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            html: response.sukses,
                        }).then((result) => {
                            if (result.value) {
                                window.location = "<?= base_url('OthPay') ?>";
                            }
                        });
                    }
                }
            },

            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });
        
    });
    
    $('#no_bukti').on('mouseenter', function() {
        $('.errorNoBukti').fadeOut();
    });
    $('#kode_account').on('change', function() {
        $('.errorKodeAccount').fadeOut();
        $('#kepada').focus();
    });
    $('#kode_divisi').on('change', function() {
        $('.errorKodeDivisi').fadeOut();
        $('#kepada').focus();
    });
</script>

<?= $this->endSection() ?>