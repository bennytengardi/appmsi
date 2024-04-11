<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="card card-primary" style="background-color: aliceblue;">
    <div class="card-header" style="height: 50px;">
        <h3 class="card-title">SALES RECEIPT</h3>
        <a href="<?= base_url('receipt/index') ?>" type="button" class="btn btn-sm mb-2 float-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </a>
    </div>

    <div class="card-body">
        <?= form_open('', ['class' => 'formsimpanreceipt']) ?>
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-sm-6">
                <!-- <div class="card p-3" style="background-color: #d8f0f0;"> -->
                    <div class="form group row">
                        <div class="col-sm-2">Customer ID</div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm kode_customer" aria-describedby="basic-addon2" name="kode_customer" id="kode_customer" value="<?= $receipt['kode_customer'] ?>" style="height: 28px;" readonly>
                                <div class="errorCustomer invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Customer Name</div>
                        <div class="col-sm-9">
                            <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm" value="<?= $receipt['nama_customer'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Address</div>
                        <div class="col-sm-9">
                            <input type="text" name="address1" id="address1" class="form-control form-control-sm" value="<?= $receipt['address1'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>

                    <div class=" form group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-9">
                            <input type="text" name="address2" id="address2" class="form-control form-control-sm" value="<?= $receipt['address2'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class=" form group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-9">
                            <input type="text" name="address3" id="address3" class="form-control form-control-sm" value="<?= $receipt['address3'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                <!-- </div> -->
            </div>

            <div class="col-sm-5 offset-1">
                <!-- <div class="card p-3" style="background-color: #d8f0f0 ;"> -->
                    <div class="form group row">
                        <div class="col-sm-2">Form No</div>
                        <div class="col-sm-3">
                            <input type="text" name="no_receipt" id="no_receipt" class="form-control form-control-sm text-bold text-md text-danger" value="<?= $receipt['no_receipt'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Payment Date</div>
                        <div class="col-sm-3">
                            <input type="date" name="tgl_receipt" id="tgl_receipt" class="form-control form-control-sm" value="<?= $receipt['tgl_receipt'] ?>" style="height: 28px;" autofocus>
                        </div>
                    </div>

                    <div class="form group row">
                        <div class="col-sm-2">Deposit To</div>
                        <div class="col-sm-6">
                            <select name="kode_account" id="kode_account" class="form-control form-control-sm">
                                <option value="<?= $receipt['kode_account'] ?>"><?= $receipt['nama_account'] ?></option>
                                <?php foreach ($account as $acct) : ?>
                                    <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="errorAccount invalid-feedback" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Cheque No</div>
                        <div class="col-sm-4">
                            <input type="text" name="no_giro" id="no_giro" class="form-control form-control-sm" value="<?= $receipt['no_giro'] ?>" style="height: 28px;">
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Cheque Date</div>
                        <div class="col-sm-3">
                            <input type="date" name="tgl_giro" id="tgl_giro" class="form-control form-control-sm" value="<?= $receipt['tgl_giro'] ?>" style="height: 28px;">
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
                            <td width="3%">No</td>
                            <td>Invoice No</td>
                            <td width="8%">Date</td>
                            <td width="9%">Total Invoice</td>
                            <td width="9%">Total Retur</td>
                            <td width="9%">Owing</td>
                            <td widht="1%">Pay</td>
                            <td width="9%">Discount</td>
                            <td width="9%">Admin</td>
                            <td width="9%">Pph-Ps23</td>
                            <td width="9%">Pph-Ps4</td>
                            <td width="9%">Payment Amount</td>
                         </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_potongan = 0;
                        $total_bayar = 0;
                        $total_admin = 0;
                        $total_pph23 = 0;
                        $total_pph4 = 0;
                        $total_balance = 0;
                        $no = 1;
                        $i = 0;

                        foreach ($dreceipt as $dtl) :  ?>
                            <?php $i++;
                            $total_balance  += $dtl['owing'];
                            $total_potongan += $dtl['potongan'];
                            $total_admin    += $dtl['admin'];
                            $total_pph23    += $dtl['pph23'];
                            $total_pph4     += $dtl['pph4'];
                            $total_bayar    += $dtl['jumlah_bayar'];
                            $owing = $dtl['total_invoice'];
                            ?>

                            <tr>
                                <td>
                                    <input type=" text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" style="height: 28px;" readonly>
                                </td>
                                <td>
                                    <input type="text" name="no_invoice<?= $i ?>" id="no_invoice<?= $i ?>" class="form-control form-control-sm" value="<?= $dtl['no_invoice'] ?>" style="height: 28px;" readonly>
                                    <input type="hidden" name="id_receipt<?= $i ?>" id="id_receipt<?= $i ?>" value="<?= $dtl['id_receipt'] ?>">
                                    <input type="hidden" id="ctr<?= $i ?>" value="<?= $i ?>">
                                </td>
                                <td><input type="text" name="tgl_invoice<?= $i ?>" id="tgl_invoice<?= $i ?>" class="form-control form-control-sm text-center" value="<?= $dtl['tgl_invoice'] ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" name="total_invoice<?= $i ?>" id="total_invoice<?= $i ?>" class="form-control form-control-sm text-right" value="<?= number_format($dtl['total_invoice'], 0) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" name="total_retur<?= $i ?>" id="total_retur<?= $i ?>" class="form-control form-control-sm text-right" value="<?= number_format($dtl['total_retur'], 0) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" name="owing<?= $i ?>" id="owing<?= $i ?>" class="form-control form-control-sm text-right" value="<?= number_format($owing, 0) ?>" style="height: 28px;" readonly></td>
                                <td align="center"><input type="checkbox" name="centangpay<?= $i ?> " id="centang<?= $i ?>" data-ctr=<?= $i ?> class="centangpay form-control form-control-sm border-secondary" style="height: 28px;" checked> </td>
                                <td><input type="text" name="potongan<?= $i ?>" id="potongan<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right potongan  border-secondary" value="<?= number_format($dtl['potongan'], 0) ?>" style="height: 28px;"></td>
                                <td><input type="text" name="admin<?= $i ?>" id="admin<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right admin  border-secondary" value="<?= number_format($dtl['admin'], 0) ?>" style="height: 28px;"></td>
                                <td><input type="text" name="pph23<?= $i ?>" id="pph23<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right pph23  border-secondary" value="<?= number_format($dtl['pph23'], 0) ?>" style="height: 28px;"></td>
                                <td><input type="text" name="pph4<?= $i ?>" id="pph4<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right pph4  border-secondary" value="<?= number_format($dtl['pph4'], 0) ?>" style="height: 28px;"></td>
                                <td><input type="text" name="jumlah_bayar<?= $i ?>" id="jumlah_bayar<?= $i ?>" class="form-control form-control-sm text-right jumlah_bayar  border-secondary" onkeyup="hitungtotal()" value="<?= number_format($dtl['jumlah_bayar'], 0) ?>" style="height: 28px;"></td>
                            </tr>
                        <?php endforeach; ?>

                        <?php foreach ($doutstanding as $dout) :  ?>
                            <?php $i++;
                            $owing = ($dout['total_invoice'] - $dout['total_potongan'] - $dout['total_bayar'] - $dout['total_retur'] - $dout['total_admin'] - $dout['total_pph23'] - $dout['total_pph4']);
                            ?>
                            <?php if ($owing > 0) { ?>
                                <tr>
                                    <td>
                                        <input type=" text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" style="height: 28px;" readonly>
                                    </td>
                                    <td>
                                        <input type=" text" name="no_invoice<?= $i ?>" id="no_invoice<?= $i ?>" class="form-control form-control-sm" value="<?= $dout['no_invoice'] ?>" style="height: 28px;" readonly>
                                        <input type="hidden" id="ctr<?= $i ?>" value="<?= $i ?>">
                                    </td>
                                    <td><input type="text" name="tgl_invoice<?= $i ?>" id="tgl_invoice<?= $i ?>" class="form-control form-control-sm text-center" value="<?= $dout['tgl_invoice'] ?>" style="height: 28px;" readonly></td>
                                    <td><input type="text" name="total_invoice<?= $i ?>" id="total_invoice<?= $i ?>" class="form-control form-control-sm text-right" value="<?= number_format($dout['total_invoice'], 0) ?>" style="height: 28px;" readonly></td>
                                    <td><input type="text" name="total_retur<?= $i ?>" id="total_retur<?= $i ?>" class="form-control form-control-sm text-right" value="<?= number_format($dout['total_retur'], 0) ?>" style="height: 28px;" readonly></td>
                                    <td><input type="text" name="owing<?= $i ?>" id="owing<?= $i ?>" class="form-control form-control-sm text-right" value="<?= number_format($owing, 0) ?>" style="height: 28px;" readonly></td>
                                    <td align="center"><input type="checkbox" name="centangpay<?= $i ?> " id="centang<?= $i ?>" data-ctr=<?= $i ?> class="centangpay form-control form-control-sm border-secondary" style="height: 28px;"> </td>
                                    <td><input type="text" name="potongan<?= $i ?>" id="potongan<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right potongan  border-secondary" value="0" style="height: 28px;"></td>
                                    <td><input type="text" name="admin<?= $i ?>" id="admin<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right admin  border-secondary" value="0" style="height: 28px;"></td>
                                    <td><input type="text" name="pph23<?= $i ?>" id="pph23<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right pph23  border-secondary" value="0" style="height: 28px;"></td>
                                    <td><input type="text" name="pph4<?= $i ?>" id="pph4<?= $i ?>" data-ctrx=<?= $i ?> class="form-control form-control-sm text-right pph4 border-secondary" value="0" style="height: 28px;"></td>
                                    <td><input type="text" name="jumlah_bayar<?= $i ?>" id="jumlah_bayar<?= $i ?>" class="form-control form-control-sm text-right jumlah_bayar  border-secondary" onkeyup="hitungtotal()" value="0" style="height: 28px;"></td>
                                </tr>
                            <?php } ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tr>
                        <td colspan="7" class="text-right">TOTAL:</td>                        
                        <td>
                            <input type="text" name="total_potongan" id="total_potongan" class="form-control form-control-sm text-right" value="<?= number_format($total_potongan, 0) ?>" style="height: 28px;" readonly>
                        </td>
                        <td>
                            <input type="text" name="total_admin" id="total_admin" class="form-control form-control-sm text-right" value="<?= number_format($total_admin, 0) ?>" style="height: 28px;" readonly>
                        </td>
                        <td>
                            <input type="text" name="total_pph23" id="total_pph23" class="form-control form-control-sm text-right" value="<?= number_format($total_pph23, 0) ?>" style="height: 28px;" readonly>
                        </td>
                        <td>
                            <input type="text" name="total_pph4" id="total_pph4" class="form-control form-control-sm text-right" value="<?= number_format($total_pph4, 0) ?>" style="height: 28px;" readonly>
                        </td>
                        <td><input type="text" name="total_bayar" id="total_bayar" class="form-control form-control-sm text-right" value="<?= number_format($total_bayar, 0) ?>" style="height: 28px;" readonly>
                            <input type="hidden" id="totalitem" name="totalitem" value="<?= $i ?>">
                        </td>
                    </tr>
                </table>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm tombolSimpanReceipt ml-2 mt-1"><i class="fa fa-edit"></i> Update Data</button>
                </div>

            </div>
        </div>
    </div>
    <?= form_close() ?>
</div>


<script>
    $(document).on('click', '.centangpay', function(e) {
        let ctr = $(this).data('ctr');
        let jumlah_bayar = $('#owing' + ctr).val();
        if ($(this).prop("checked") == true) {
            $('#jumlah_bayar' + ctr).val(number_format(jumlah_bayar, 0));
            $('#potongan' + ctr).val(0);
            $('#admin' + ctr).val(0);
            $('#pph23' + ctr).val(0);
            $('#pph4' + ctr).val(0);
            hitungtotal();
        } else {
            $('#jumlah_bayar' + ctr).val(0);
            $('#potongan' + ctr).val(0);
            $('#admin' + ctr).val(0);
            $('#pph23' + ctr).val(0);
            $('#pph4' + ctr).val(0);
            hitungtotal();
        }
    });

    $(document).on('keyup', '.potongan', function(e) {
        let ctrx = $(this).data('ctrx');
        let owg = parseFloat($('#owing' + ctrx).val().replace(/[^0-9.-]+/g, ''))
        let pot = parseFloat($('#potongan' + ctrx).val().replace(/[^0-9.-]+/g, ''))
        let adm = parseFloat($('#admin' + ctrx).val().replace(/[^0-9.-]+/g, ''))
        let p23 = parseFloat($('#pph23' + ctrx).val().replace(/[^0-9.-]+/g, ''))
        let p4  = parseFloat($('#pph4' + ctrx).val().replace(/[^0-9.-]+/g, ''))
        let jumlah_bayar = owg - pot - adm - p23 - p4;
        $('#jumlah_bayar' + ctrx).val(number_format(jumlah_bayar, 0));
        hitungtotal();
    });

    $(document).on('keyup', '.admin', function(e) {
        let ctrx = $(this).data('ctrx');
        let owg = parseFloat($('#owing' + ctrx).val().replace(/[^0-9.-]+/g, ''))
        let pot = parseFloat($('#potongan' + ctrx).val().replace(/[^0-9.-]+/g, ''))
        let adm = parseFloat($('#admin' + ctrx).val().replace(/[^0-9.-]+/g, ''))
        let p23 = parseFloat($('#pph23' + ctrx).val().replace(/[^0-9.-]+/g, ''))
        let p4  = parseFloat($('#pph4' + ctrx).val().replace(/[^0-9.-]+/g, ''))
        let jumlah_bayar = owg - pot - adm - p23 - p4;
        $('#jumlah_bayar' + ctrx).val(number_format(jumlah_bayar, 0));
        hitungtotal();
    });

    function hitungtotal() {
        let total_bayar = 0;
        let total_potongan = 0;
        let total_admin = 0;
        let total_pph23 = 0;
        let total_pph4 = 0;
        let totitem = $('#totalitem').val();

        for (j = 1; j <= totitem; j++) {
            let jumlah_bayar = 0;
            let potongan = 0;
            let admin = 0;
            let pph23 = 0;
            let pph4  = 0;

            potongan = $('#potongan' + j).val();
            admin = $('#admin' + j).val();
            pph23 = $('#pph23' + j).val();
            pph4 = $('#pph4' + j).val();
            jumlah_bayar = $('#jumlah_bayar' + j).val();

            total_potongan = total_potongan + parseFloat(potongan.replace(/[^0-9.-]+/g, ''));
            total_admin = total_admin + parseFloat(admin.replace(/[^0-9.-]+/g, ''));
            total_pph23 = total_pph23 + parseFloat(pph23.replace(/[^0-9.-]+/g, ''));
            total_pph4  = total_pph4 + parseFloat(pph4.replace(/[^0-9.-]+/g, ''));
            total_bayar = total_bayar + parseFloat(jumlah_bayar.replace(/[^0-9.-]+/g, ''));
        }

        $('#total_bayar').val(number_format(total_bayar, 0));
        $('#total_potongan').val(number_format(total_potongan, 0));
        $('#total_admin').val(number_format(total_admin, 0));
        $('#total_pph23').val(number_format(total_pph23, 0));
        $('#total_pph4').val(number_format(total_pph4, 0));
    }

    $(document).ready(function() {
        $('#tgl_receipt').keydown(function(e) {
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
                $('#kode_customer').focus();
            }
        });
    });


    $('.tombolSimpanReceipt').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpanreceipt')[0];
        let data = new FormData(form);
        $.ajax({
            type: "post",
            url: "<?= base_url('receipt/updatedata') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanReceipt').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanReceipt').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanReceipt').html('UPDATE DATA');
                $('.tombolSimpanReceipt').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;
                    if (dataError.errorCustomer) {
                        $('.errorCustomer').html(dataError.errorCustomer).show();
                        $('#kode_customer').addClass('is-invalid');
                    } else {
                        $('.errorCustomer').fadeOut();
                        $('#kode_customer').removeClass('is-invalid');
                        $('#kode_customer').addClass('is-valid');
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
                            window.location = "<?= base_url('receipt') ?>";
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