<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<!-- <div class="card card-primary" style="background-color: #e4f4f5;"> -->
<div class="card card-primary" style="background-color: aliceblue;">
    <div class="card-header" style="height: 50px;">
        <h3 class="card-title">SUPPLIER PAYMENT</h3>
        <a href="<?= base_url('payment/index') ?>" type="button" class="btn btn-sm mb-2 float-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </a>
    </div>

    <div class="card-body">
        <?= form_open('', ['class' => 'formsimpanpayment']) ?>
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-sm-6">
                <!-- <div class="card p-3" style="background-color: #d8f0f0;"> -->
                    <div class="form group row">
                        <div class="col-sm-2">Supplier ID</div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" value="<?= $payment['kode_supplier'] ?>" readonly>
                                <div class="errorSupplier invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2">Supplier Name</div>
                        <div class="col-sm-9">
                            <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" value="<?= $payment['nama_supplier'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2">Address</div>
                        <div class="col-sm-9">
                            <input type="text" name="address1" id="address1" class="form-control form-control-sm" value="<?= $payment['address1'] ?>" readonly>
                        </div>
                    </div>
                    <div class=" form group row mt-1">
                        <div class="col-sm-2"> </div>
                        <div class="col-sm-9">
                            <input type="text" name="address2" id="address2" class="form-control form-control-sm" value="<?= $payment['address2'] ?>" readonly>
                        </div>
                    </div>
                    <div class=" form group row mt-1">
                        <div class="col-sm-2"> </div>
                        <div class="col-sm-9">
                            <input type="text" name="address3" id="address3" class="form-control form-control-sm" value="<?= $payment['address3'] ?>" readonly>
                        </div>
                    </div>
                <!-- </div> -->
            </div>

            <div class="col-sm-5 offset-1">
                <!-- <div class="card p-3" style="background-color: #d8f0f0 ;"> -->
                    <div class="form group row">
                        <div class="col-sm-2">Form No</div>
                        <div class="col-sm-3">
                            <input type="text" name="no_payment" id="no_payment" class="form-control form-control-sm text-bold text-danger" value="<?= $payment['no_payment'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2">Payment Date</div>
                        <div class="col-sm-3">
                            <input type="date" name="tgl_payment" id="tgl_payment" class="form-control form-control-sm" value="<?= $payment['tgl_payment'] ?>" autofocus>
                        </div>
                    </div>

                    <div class="form group row mt-1">
                        <div class="col-sm-2">Cheque No</div>
                        <div class="col-sm-3">
                            <input type="text" name="no_giro" id="no_giro" class="form-control form-control-sm" value="<?= $payment['no_giro'] ?>">
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2">Cheque Date</div>
                        <div class="col-sm-3">
                            <input type="date" name="tgl_giro" id="tgl_giro" class="form-control form-control-sm" value="<?= $payment['tgl_giro'] ?>">
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2">Paid From</div>
                        <div class="col-sm-6">
                            <select name="kode_account" id="kode_account" class="form-control form-control-sm">
                                <option value="<?= $payment['kode_account'] ?>"><?= $payment['nama_account'] ?></option>
                                <?php foreach ($account as $acct) : ?>
                                    <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="matauang" id="matauang" value="<?= $payment['currency']?>">
                            <div class="errorAccount invalid-feedback" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2" id="textkurs">Exchg Rate</div>
                        <div class="col-sm-2" id="inputkurs">
                            <input type="text" class="form-control form-control-sm text-right autonum" name="kurs" id="kurs" value="<?= $payment['nilai_tukar'] ?>" >
                        </div>
                    </div>

                <!-- </div> -->
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12 mt-2">
                <table class="table table-sm table-bordered" width="100%">
                    <thead class="bg-primary text-white">
                        <tr align="center">
                            <td width="5%">No</td>
                            <td>Invoice No</td>
                            <td width="10%">Date</td>
                            <td width="10%">Total Invoice</td>
                            <td width="10%">Total Retur</td>
                            <td width="10%">Owing</td>
                            <td widht="2%">Pay</td>
                            <td width="10%">Discount</td>
                            <td width="10%">PPH Ps23</td>
                            <td width="10%">Ongkir</td>
                            <td width="10%">Total Paid</td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $total_potongan = 0;
                        $total_bayar = 0;
                        $total_pph23 = 0;
                        $total_ongkir = 0;
                        $total_balance = 0;
                        $no = 1;
                        $i = 0;

                        foreach ($dpayment as $dtl) :  ?>
                            <?php $i++;
                            $total_balance  += $dtl['owing'];
                            $total_potongan += $dtl['potongan'];
                            $total_pph23    += $dtl['pph23'];
                            $total_ongkir   += $dtl['ongkir'];
                            $total_bayar    += $dtl['jumlah_bayar'];
                            $owing = $dtl['total_invoice'];
                            ?>

                            <tr>
                                <td>
                                    <input type=" text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" style="height: 28px;" readonly>
                                </td>
                                <td>
                                    <input type="text" name="no_invoice<?= $i ?>" id="no_invoice<?= $i ?>" class="form-control form-control-sm" value="<?= $dtl['no_invoice'] ?>" readonly>
                                    <input type="hidden" name="id_payment<?= $i ?>" id="id_payment<?= $i ?>" value="<?= $dtl['id_payment'] ?>">
                                    <input type="hidden" id="ctr<?= $i ?>" value="<?= $i ?>">
                                </td>
                                <td><input type="text" name="tgl_invoice<?= $i ?>" id="tgl_invoice<?= $i ?>" class="form-control form-control-sm text-center" value="<?= $dtl['tgl_invoice'] ?>" readonly></td>
                                <td><input type="text" name="total_invoice<?= $i ?>" id="total_invoice<?= $i ?>" class="form-control form-control-sm text-right" value="<?= number_format($dtl['total_invoice'], 2) ?>" readonly></td>
                                <td><input type="text" name="total_retur<?= $i ?>" id="total_retur<?= $i ?>" class="form-control form-control-sm text-right" value="<?= number_format($dtl['total_retur'], 2) ?>" readonly></td>
                                <td><input type="text" name="owing<?= $i ?>" id="owing<?= $i ?>" class="form-control form-control-sm text-right" value="<?= number_format($owing, 2) ?>" readonly></td>
                                <td align="center"><input type="checkbox" name="centangpay<?= $i ?> " id="centang<?= $i ?>" data-ctr=<?= $i ?> class="centangpay form-control form-control-sm" checked> </td>
                                <td><input type="text" name="potongan<?= $i ?>" id="potongan<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right potongan autonum2" value="<?= number_format($dtl['potongan'], 2) ?>"></td>
                                <td><input type="text" name="pph23<?= $i ?>" id="pph23<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right pph23 autonum2" value="<?= number_format($dtl['pph23'], 2) ?>"></td>
                                <td><input type="text" name="ongkir<?= $i ?>" id="ongkir<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right ongkir autonum2" value="<?= number_format($dtl['ongkir'], 2) ?>"></td>
                                <td><input type="text" name="jumlah_bayar<?= $i ?>" id="jumlah_bayar<?= $i ?>" class="form-control form-control-sm text-right jumlah_bayar autonum2" onkeyup="hitungtotal()" value="<?= number_format($dtl['jumlah_bayar'], 2) ?>"></td>
                            </tr>
                        <?php endforeach; ?>

                        <?php foreach ($doutstanding as $dout) :  ?>
                            <?php $i++;
                            $owing = ($dout['total_invoice'] - $dout['total_potongan'] - $dout['total_bayar'] - $dout['total_retur']);
                            ?>
                            <tr>
                                <td>
                                    <input type=" text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" readonly>
                                </td>
                                <td>
                                    <input type=" text" name="no_invoice<?= $i ?>" id="no_invoice<?= $i ?>" class="form-control form-control-sm" value="<?= $dout['no_invoice'] ?>" readonly>
                                    <input type="hidden" id="ctr<?= $i ?>" value="<?= $i ?>">
                                </td>
                                <td><input type="text" name="tgl_invoice<?= $i ?>" id="tgl_invoice<?= $i ?>" class="form-control form-control-sm text-center" value="<?= $dout['tgl_invoice'] ?>" readonly></td>
                                <td><input type="text" name="total_invoice<?= $i ?>" id="total_invoice<?= $i ?>" class="form-control form-control-sm text-right" value="<?= number_format($dout['total_invoice'], 2) ?>" readonly></td>
                                <td><input type="text" name="total_retur<?= $i ?>" id="total_retur<?= $i ?>" class="form-control form-control-sm text-right" value="<?= number_format($dout['total_retur'], 2) ?>" readonly></td>
                                <td><input type="text" name="owing<?= $i ?>" id="owing<?= $i ?>" class="form-control form-control-sm text-right" value="<?= number_format($owing, 2) ?>" readonly></td>
                                <td align="center"><input type="checkbox" name="centangpay<?= $i ?> " id="centang<?= $i ?>" data-ctr=<?= $i ?> class="centangpay form-control form-control-sm"> </td>
                                <td><input type="text" name="potongan<?= $i ?>" id="potongan<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right potongan autonum2" value="0"></td>
                                <td><input type="text" name="pph23<?= $i ?>" id="pph23<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right pph23 autonum2" value="0"></td>
                                <td><input type="text" name="ongkir<?= $i ?>" id="ongkir<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right ongkir autonum2" value="0"></td>
                                <td><input type="text" name="jumlah_bayar<?= $i ?>" id="jumlah_bayar<?= $i ?>" class="form-control form-control-sm text-right jumlah_bayar autonum2" onkeyup="hitungtotal()" value="0"></td>
                            </tr>
                        <?php endforeach; ?>


                    </tbody>
                    <tr>
                        <td colspan="7" class="text-right">TOTAL :</td>
                        <td>
                            <input type="text" name="total_potongan" id="total_potongan" class="form-control form-control-sm text-right" value="<?= number_format($total_potongan, 2) ?>" readonly>
                        </td>
                        <td>
                            <input type="text" name="total_pph23" id="total_pph23" class="form-control form-control-sm text-right" value="<?= number_format($total_pph23, 2) ?>" readonly>
                        </td>
                        <td>
                            <input type="text" name="total_ongkir" id="total_ongkir" class="form-control form-control-sm text-right" value="<?= number_format($total_ongkir, 2) ?>" readonly>
                        </td>
                        <td><input type="text" name="total_bayar" id="total_bayar" class="form-control form-control-sm text-right" value="<?= number_format($total_bayar, 2) ?>" readonly>
                            <input type="hidden" id="totalitem" name="totalitem" value="<?= $i ?>">
                        </td>
                    </tr>
                </table>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm tombolSimpanPayment ml-2"><i class="fa fa-edit"></i> Update Data</button>
                </div>

            </div>
        </div>
    </div>
    <?= form_close() ?>
    <div class="viewmodal" style="display: none;"></div>
    <div class="viewmodalpembayaran" style="display: none;"></div>
</div>



<script>
    $(document).on('click', '.centangpay', function(e) {
        let ctr = $(this).data('ctr');
        let jumlah_bayar = $('#owing' + ctr).val();
        if ($(this).prop("checked") == true) {
            $('#jumlah_bayar' + ctr).val(number_format(jumlah_bayar, 2));
            $('#potongan' + ctr).val(0);
            $('#pph23' + ctr).val(0);
            $('#ongkir' + ctr).val(0);
            hitungtotal();
        } else {
            $('#jumlah_bayar' + ctr).val(0);
            $('#potongan' + ctr).val(0);
            $('#ongkir' + ctr).val(0);
            $('#pph23' + ctr).val(0);
            hitungtotal();
        }
    });

    $(document).on('keyup', '.potongan', function(e) {
        let ctrx = $(this).data('ctrx');
        let owg = parseFloat($('#owing' + ctrx).val().replace(/[^0-9.]/g, ''))
        let pot = parseFloat($('#potongan' + ctrx).val().replace(/[^0-9.]/g, ''))
        let p23 = parseFloat($('#pph23' + ctrx).val().replace(/[^0-9.]/g, ''))
        let okr = parseFloat($('#ongkir' + ctrx).val().replace(/[^0-9.]/g, ''))
        let jumlah_bayar = owg - pot - p23 + okr;
        $('#jumlah_bayar' + ctrx).val(number_format(jumlah_bayar, 2));
        hitungtotal();
    });

    $(document).on('keyup', '.pph23', function(e) {
        let ctrx = $(this).data('ctrx');
        let owg = parseFloat($('#owing' + ctrx).val().replace(/[^0-9.]/g, ''))
        let pot = parseFloat($('#potongan' + ctrx).val().replace(/[^0-9.]/g, ''))
        let p23 = parseFloat($('#pph23' + ctrx).val().replace(/[^0-9.]/g, ''))
        let okr = parseFloat($('#ongkir' + ctrx).val().replace(/[^0-9.]/g, ''))
        let jumlah_bayar = owg - pot - p23 + okr;
        $('#jumlah_bayar' + ctrx).val(number_format(jumlah_bayar, 2));
        hitungtotal();
    });

    $(document).on('keyup', '.ongkir', function(e) {
        let ctrx = $(this).data('ctrx');
        let owg = parseFloat($('#owing' + ctrx).val().replace(/[^0-9.]/g, ''))
        let pot = parseFloat($('#potongan' + ctrx).val().replace(/[^0-9.]/g, ''))
        let p23 = parseFloat($('#pph23' + ctrx).val().replace(/[^0-9.]/g, ''))
        let okr = parseFloat($('#ongkir' + ctrx).val().replace(/[^0-9.]/g, ''))
        let jumlah_bayar = owg - pot - p23 + okr;
        $('#jumlah_bayar' + ctrx).val(number_format(jumlah_bayar, 2));
        hitungtotal();
    });

    function hitungtotal() {
        let total_bayar = 0;
        let total_potongan = 0;
        let total_pph23 = 0;
        let total_ongkir = 0;
        let totitem = $('#totalitem').val();

        for (j = 1; j <= totitem; j++) {
            let jumlah_bayar = 0;
            let potongan = 0;
            let pph23 = 0;
            let ongkir = 0;

            potongan = $('#potongan' + j).val();
            pph23 = $('#pph23' + j).val();
            ongkir = $('#ongkir' + j).val();
            jumlah_bayar = $('#jumlah_bayar' + j).val();

            total_potongan = total_potongan + parseFloat(potongan.replace(/[^0-9.]/g, ''));
            total_pph23 = total_pph23 + parseFloat(pph23.replace(/[^0-9.]/g, ''));
            total_ongkir = total_ongkir + parseFloat(ongkir.replace(/[^0-9.]/g, ''));
            total_bayar = total_bayar + parseFloat(jumlah_bayar.replace(/[^0-9.]/g, ''));
        }
        $('#total_bayar').val(number_format(total_bayar, 2));
        $('#total_potongan').val(number_format(total_potongan, 2));
        $('#total_pph23').val(number_format(total_pph23, 2));
        $('#total_ongkir').val(number_format(total_ongkir, 2));
    }

    $(document).ready(function() {
        $('#tgl_payment').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#no_giro').focus();
            }
        });
        $('#no_giro').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#tgl_giro').focus();
            }
        });

        $('#tgl_giro').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#kode_account').focus();
            }
        });
        $('#kode_account').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#kode_supplier').focus();
            }
        });
    });


    $('.tombolSimpanPayment').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpanpayment')[0];
        let data = new FormData(form);
        $.ajax({
            type: "post",
            url: "<?= base_url('payment/updatedata') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanPayment').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanPayment').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanPayment').html('UPDATE DATA');
                $('.tombolSimpanPayment').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;
                    if (dataError.errorSupplier) {
                        $('.errorSupplier').html(dataError.errorSupplier).show();
                        $('#kode_supplier').addClass('is-invalid');
                    } else {
                        $('.errorSupplier').fadeOut();
                        $('#kode_supplier').removeClass('is-invalid');
                        $('#kode_supplier').addClass('is-valid');
                    }
                    if (dataError.errorAccount) {
                        $('.errorAccount').html(dataError.errorAccount).show();
                        $('#kode_account').addClass('is-invalid');
                    } else {
                        $('.errorAccount').fadeOut();
                        $('#kode_account').removeClass('is-invalid');
                        $('#kode_account').addClass('is-valid');
                    }
                }


                if (response.error2) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal',
                        html: response.error2,
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
                            window.location = "<?= base_url('payment') ?>";
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