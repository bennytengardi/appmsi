<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title mt-n1">JURNAL MEMORIAL</h3>
                <a href="<?= base_url('jurnal') ?>" type="button" class="btn btn-sm mt-n1 mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <div class="row" style="font-size: 12px;">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-1">Voucher No</div>
                            <div class="col-sm-2">
                                <input type="text" name="no_voucher" id="no_voucher" class="form-control form-control-sm text-bold text-danger" value="<?= $mjurnal['no_voucher'] ?>"  style="font-size: 12px; height: 26px" readonly>
                                <input type="hidden" name="counter" id="counter">
                                <div class="errorNoVoucher invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-1">Voucher Date</div>
                            <div class="col-sm-1">
                                <input type="date" name="tgl_voucher" id="tgl_voucher" class="form-control form-control-sm"  style="font-size: 12px; height: 26px" value="<?= $mjurnal['tgl_voucher'] ?>">
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="row mt-3" style="font-size: 12px;">
                    <div class="col-md-1">
                        <div class="text-center bg-primary" style="height: 22px;">Account#</div>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm  kode_acct" aria-describedby="basic-addon2" name="kode_acct" id="kode_acct" style="font-size: 12px;height: 26px">
                            <div class="input-group-append">
                                <button type="button" class="input-group-text bg-primary tombol-account" id="basic-addon2"  style="font-size: 12px;height: 26px"><i class="fas fa-search" ></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center bg-primary" style="height: 22px;">Account Name</div>
                        <input type="text" class="form-control form-control-sm" name="nama_acct" id="nama_acct" style="font-size: 12px;height: 26px" readonly>
                    </div>
                    <div class="col-md-1">
                        <div class="text-center bg-primary" style="height: 22px;">Debet (IDR)</div>
                        <input type="text" class="form-control form-control-sm text-right" name="dbt" id="dbt" style="font-size: 12px;height: 26px">
                    </div>
                    <div class="col-md-1">
                        <div class="text-center bg-primary" style="height: 22px;">Credit (IDR)</div>
                        <input type="text" class="form-control form-control-sm text-right" name="crd" id="crd" style="font-size: 12px;height: 26px">
                    </div>
                    <div class="col-md-1" id="rate1">
                        <div class="text-center bg-primary" style="height: 22px;">Rate</div>
                        <input type="text" class="form-control form-control-sm text-right" name="rat" id="rat" style="font-size: 12px;height: 24px">
                    </div>
                    <div class="col-md-1" id="pdb">
                        <div class="text-center bg-primary" style="height: 22px;">Prime (Db)</div>
                        <input type="text" class="form-control form-control-sm text-right" name="prmdb" id="prmdb" style="font-size: 12px;height: 24px" readonly>
                    </div>
                    <div class="col-md-1" id="pcr">
                        <div class="text-center bg-primary" style="height: 22px;">Prime (Cr)</div>
                        <input type="text" class="form-control form-control-sm text-right" name="prmcr" id="prmcr" style="font-size: 12px;height: 24px" readonly>
                    </div>                    
                    <div class="col-md-2">
                        <div class="text-center bg-primary" style="height: 22px;">Descriptions</div>
                        <input type="text" class="form-control form-control-sm" name="ket" id="ket"  style="font-size: 12px;height: 26px">
                    </div>
                    <div class="col-md-1">
                        <div>&nbsp</div>
                        <button type="button" class="btn btn-success btn-xs d-block tombolTambah" style="font-size: 12px;" id="btnTambah"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 dataDetailInv" id="dataDetailInv">
                    </div>
                </div>
                
                <div class="form-group">
                    <button class="btn btn-primary btn-sm tombolSimpanInv" type="button" id="btnSimpanInv">
                        Save Data
                    </button>
                </div>
            </div>
        </div>
        <div class="viewmodal" style="display: none;"></div>
    </div>
</div>

<script>
    $(document).ready(function() {
        dataDetailInv();
        $('#tgl_voucher').focus();
    });

    function dataDetailInv() {
        no_voucher = $('#no_voucher').val();
        $('#rate1').hide();
        $('#pdb').hide();
        $('#pcr').hide();

        $.ajax({
            type: "post",
            url: "<?= site_url('jurnal/dataDetail') ?>",
            data: {
                no_voucher: no_voucher
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
            $('#dbt').focus();
        });

        $('#kode_acct').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekKode();
                $('#dbt').focus();
            }
        });

        $('#dbt').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#crd').focus();
            }
        });
        $('#crd').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#rat').focus();
            }
        });

        $('#rat').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#ket').focus();
            }
        });

        $('#rat').keydown(function(e) {
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
    
    $(document).on('click', '.centang', function(e) {
        if ($(this).prop("checked") == true) {
           
        } else {
           
        }
    });
    
    $('#dbt').on('keyup', function() {
        hitungPrime();
    });

    $('#crd').on('keyup', function() {
        hitungPrime();
    });

    $('#rat').on('keyup', function() {
        hitungPrime();
    });

    function cekKode() {
        let kode_acct = $('#kode_acct').val();
        if (kode_acct.length == 0) {
            $.ajax({
                url: "<?= site_url('Jurnal/viewDataAccount') ?>",
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
                    $.each(data, function(kode_account, nama_account,nilai_tukar) {
                        $('[id="kode_acct"]').val(data.kode_account);
                        $('[id="nama_acct"]').val(data.nama_account);
                        $('[id="rat"]').val(data.nilai_tukar);
                        if (data.currency != 'IDR') {
                            $('#rate1').show();
                            $('#pdb').show();
                            $('#pcr').show();
                        } else {
                            $('#rate1').hide();
                            $('#pdb').hide();
                            $('#pcr').hide();

                        }
                        $("#dbt").focus();
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
            url: "<?= site_url('jurnal/viewDataAccount') ?>",
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
        $('#modalaccount').on('hidden.bs.modal', function(event) {
            $('#dbt').focus();
        })
        $('#modalaccount').modal('hide');

        // $('#dbt').focus();
        return false;

    }



    function masukCart() {
        let kode_acct = $('#kode_acct').val();
        let no_voucher = $('#no_voucher').val();
        let nama_acct = $('#nama_acct').val();
        let dbt = $('#dbt').val();
        let crd = $('#crd').val();
        let prmdb = $('#prmdb').val();
        let prmcr = $('#prmcr').val();
        let rat = $('#rat').val();
        let ket = $('#ket').val();

        $.ajax({
            type: "post",
            url: "<?= site_url('jurnal/simpanTemp') ?>",
            data: {
                no_voucher: no_voucher,
                kode_acct: kode_acct,
                nama_acct: nama_acct,
                dbt: dbt,
                crd: crd,
                prmdb: prmdb,
                prmcr: prmcr,
                rat: rat,
                ket: ket,
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
        $('#dbt').val('');
        $('#crd').val('');
        $('#rat').val('');
        $('#ket').val('');
        $('#prmdb').val('');
        $('#prmcr').val('');
        $('#kode_acct').focus();
    }

    $('.tombolSimpanInv').click(function(e) {
        e.preventDefault();

        let novoucher = $('#no_voucher').val();
        let tglvoucher = $('#tgl_voucher').val();
        let totaldbt = $('#totaldebet').val();
        let totalcrd = $('#totalcredit').val();

        if (totaldbt != totalcrd) {
            Swal.fire({
                icon: 'warning',
                title: 'Gagal',
                text: 'Jurnal Transaksi ini Belum Balance !!!',
            }).then((result) => {
                if (result.value) {
                    return false;
                }
            });
            // alert('tidak balance');
            // return false;
        } else {

            $.ajax({
                type: "post",
                url: "<?= base_url('jurnal/updatedata') ?>",
                data: {
                    no_voucher: novoucher,
                    tgl_voucher: tglvoucher,
                    total_debet: totaldbt,
                    total_credit: totalcrd,
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Gagal',
                            html: response.error,
                        }).then((result) => {
                            if (result.value) {
                                window.location.reload();
                            }
                        });
                    }

                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            html: response.sukses,
                        }).then((result) => {
                            if (result.value) {
                                window.location = "<?= base_url('jurnal') ?>";
                            }
                        });
                    }
                },

                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            });
        }
    });
    
    function hitungPrime() {
        let debet = ($('#dbt').val() == "") ? 0 : $('#dbt').val();
        let credit = ($('#crd').val() == "") ? 0 : $('#crd').val();
        let rate  = ($('#rat').val() == "") ? 0 : $('#rat').val();
        let primedb = debet / rate;
        let primecr = credit / rate;        
        $('#prmdb').val(number_format(primedb,2));
        $('#prmcr').val(number_format(primecr,2));
    }

</script>

<?= $this->endSection() ?>