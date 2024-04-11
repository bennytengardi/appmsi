<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="card card-primary" style="background-color: aliceblue;">
    <div class="card-header" style="height: 50px;">
        <h3 class="card-title">CUSTOMER RECEIPT</h3>
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
                                <input type="text" class="form-control form-control-sm kode_customer" aria-describedby="basic-addon2" name="kode_customer" id="kode_customer" autofocus>
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-primary tombol-customer" id="basic-addon2" data-toggle="modal" data-target="#modal-customer"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="errorCustomer invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Customer Name</div>
                        <div class="col-sm-9">
                            <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Address </div>
                        <div class="col-sm-9">
                            <input type="text" name="address1" id="address1" class="form-control form-control-sm" readonly>
                        </div>
                    </div>

                    <div class=" form group row">
                        <div class="col-sm-2"> </div>
                        <div class="col-sm-9">
                            <input type="text" name="address2" id="address2" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class=" form group row">
                        <div class="col-sm-2"> </div>
                        <div class="col-sm-9">
                            <input type="text" name="address3" id="address3" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
            <div class="col-sm-5 offset-1">
                <!-- <div class="card p-3" style="background-color: #d8f0f0;"> -->
                    <div class="form group row">
                        <div class="col-sm-2">Form No</div>
                        <div class="col-sm-3">
                            <input type="text" name="no_receipt" id="no_receipt" class="form-control form-control-sm text-md text-bold text-danger" value="<?= $no_receipt ?>" readonly>
                            <input type="hidden" name="counter" id="counter">
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Payment Date</div>
                        <div class="col-sm-3">
                            <input type="date" name="tgl_receipt" id="tgl_receipt" class="form-control form-control-sm" value="<?= $tgl_receipt ?>">
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Deposit To</div>
                        <div class="col-sm-6">
                            <select name="kode_account" id="kode_account" class="form-control form-control-sm">
                                <option value=""></option>
                                <?php foreach ($account as $acct) : ?>
                                    <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="kode_voucher" id="kode_voucher">
                            <div class="errorAccount invalid-feedback" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Cheque No</div>
                        <div class="col-sm-4">
                            <input type="text" name="no_giro" id="no_giro" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Cheque Date</div>
                        <div class="col-sm-3">
                            <input type="date" name="tgl_giro" id="tgl_giro" class="form-control form-control-sm" value="<?= $tgl_giro ?>">
                        </div>
                    </div>
                <!-- </div> -->
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-lg-12 mt-2">
                <table class="table table-sm table-bordered" style="background: aliceblue;" >
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

                    <?php $total_po = 0;
                    $i = 0; ?>
                    <tbody id="show_receipt">
                    </tbody>

                    <tr>
                        <td colspan="7" class="text-right">TOTAL:</td>
                        <td>
                            <input type="text" name="total_potongan" id="total_potongan" class="form-control form-control-sm text-right border-secondary" style="height: 28px;" value="0" readonly>
                        </td>
                        <td>
                            <input type="text" name="total_admin" id="total_admin" class="form-control form-control-sm text-right border-secondary" style="height: 28px;" value="0" readonly>
                        </td>
                        <td>
                            <input type="text" name="total_pph23" id="total_pph23" class="form-control form-control-sm text-right border-secondary" style="height: 28px;" value="0" readonly>
                        </td>
                        <td>
                            <input type="text" name="total_pph4" id="total_pph4" class="form-control form-control-sm text-right border-secondary" style="height: 28px;" value="0" readonly>
                        </td>
                        <td><input type="text" name="total_bayar" id="total_bayar" class="form-control form-control-sm text-right border-secondary" style="height: 28px;" value="0" readonly>
                            <input type="hidden" id="totalitem" name="totalitem">
                        </td>
                    </tr>

                </table>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm  tombolSimpanReceipt ml-2 mt-1"><i class="fa fa-save"></i> Save Data</button>
                </div>

            </div>
        </div>
    </div>
    <?= form_close() ?>
    <div class="viewmodal" style="display: none;"></div>
    <div class="viewmodalpembayaran" style="display: none;"></div>
</div>

<!-- MODAL SEARCH -->
<div class="modal fade" id="modal-customer" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="height: 50px">
                <p class="modal-title text-white text-md text-bold" id="exampleModaldiv">LIST CUSTOMER</p>
                <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body" style="background-color: aliceblue;">
                <table class="table table-bordered table-hover table-sm" id="example3" name="tabel1">
                    <thead>
                        <tr class="bg-primary text-center">
                            <th>CUSTOMER ID</th>
                            <th>CUSTOMER NAME</th>
                            <th>ADDRESS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customer as $itm) : ?>
                            <tr>
                                <td><?= $itm['kode_customer'] ?></td>
                                <td><?= $itm['nama_customer'] ?></td>
                                <td><?= $itm['address1'] ?></td>
                                <td align="center">
                                    <button class="btn btn-primary btn-xs" id="select" data-kode_customer="<?= $itm['kode_customer'] ?>" data-nama_customer="<?= $itm['nama_customer'] ?>" data-address1="<?= $itm['address1'] ?>" data-address2="<?= $itm['address2'] ?>" data-address3="<?= $itm['address3'] ?>">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $('#kode_account').change(function(e) {
        $('#tgl_receipt').focus();
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
                $.each(data, function(kodek) {
                    const kode_voucher = data.kodek;
                    $('#kode_voucher').val(kode_voucher);
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    });


    $('.tombol-customer').click(function(e) {
        e.preventDefault();
        $('#modal-customer').modal('show');
        $('#modal-customer').on('shown.bs.modal', function() {
            $("#modal-customer [type='search']").focus();
        })
    });

    $(document).on('click', '#select', function(e) {
        e.preventDefault();
        var kode_customer = $(this).data('kode_customer');
        var nama_customer = $(this).data('nama_customer');
        var address1 = $(this).data('address1');
        var address2 = $(this).data('address2');
        var address3 = $(this).data('address3');

        $('[id="kode_customer"]').val(kode_customer);
        $('[id="nama_customer"]').val(nama_customer);
        $('[id="address1"]').val(address1);
        $('[id="address2"]').val(address2);
        $('[id="address3"]').val(address3);
        $('#modal-customer').on('hidden.bs.modal', function(event) {
            $('#kode_account').focus();
        })
        $('#modal-customer').modal('hide');

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('Receipt/get_data_si') ?>",
            data: {
                kode_customer: kode_customer
            },
            success: function(data) {
                var html = '';
                var i = 0;
                var no = 1;
                for (i = 0; i < data.length; i++) {
                    $owing = data[i].total_invoice - data[i].total_retur - data[i].total_bayar;
                    $totalinvoice = data[i].total_invoice;
                    $totalretur = data[i].total_retur;
                    html += '<tr>' +
                        '<td align="center"  vertical-align: center;">' + no++ +
                        '</td>' + '<td style="vertical-align: center;">' + data[i].no_invoice + '</td>' +
                        '<td class="text-center" style="vertical-align: center;">' + data[i].tgl_invoice + '</td>' +
                        '<td class="text-right" style="vertical-align: center;">' + number_format($totalinvoice, 0, '.', ',') + '</td>' +
                        '<td class="text-right" style="vertical-align: center;">' + number_format($totalretur, 0, '.', ',') + '</td>' +
                        '<td class="text-right" style="vertical-align: center;">' + number_format($owing, 0, '.', ',') + '</td>' +
                        '<td align="center">' + '<input type="checkbox" class="centangpay form-control form-control-xs" style="height: 28px;" id="centang' + (i + 1) + '" name="centangpay' + (i + 1) + '" data-ctr = ' + (i + 1) + '>' + '</td>' +
                        '<td>' + '<input type="text" name="potongan' + (i + 1) + '" id="potongan' + (i + 1) + '" class="form-control form-control-sm text-right  border-secondary potongan" onkeyup="hitungTotalBayar()" style="height: 28px;">' + '</td>' +
                        '<td>' + '<input type="text" name="admin' + (i + 1) + '" id="admin' + (i + 1) + '" class="form-control form-control-sm text-right  border-secondary admin"  onkeyup="hitungTotalBayar()" style="height: 28px;">' + '</td>' +
                        '<td>' + '<input type="text" name="pph23' + (i + 1) + '" id="pph23' + (i + 1) + '" class="form-control form-control-sm text-right  border-secondary pph23"  onkeyup="hitungTotalBayar()" style="height: 28px;">' + '</td>' +
                        '<td>' + '<input type="text" name="pph4' + (i + 1) + '" id="pph4' + (i + 1) + '" class="form-control form-control-sm text-right  border-secondary pph4"  onkeyup="hitungTotalBayar()" style="height: 28px;">' + '</td>' +
                        '<td>' + '<input type="text" name="jumlah_bayar' + (i + 1) + '" id="jumlah_bayar' + (i + 1) + '" class="form-control form-control-sm  border-secondary jumlah_bayar text-right " onkeyup="hitungTotalByr()" style="height: 28px;">' + '</td>' +
                        '<input type="hidden" name="owing' + (i + 1) + '" id="owing' + (i + 1) + '" value = ' + $owing + '>' +
                        '<input type="hidden" id="ctr' + (i + 1) + '" value = ' + (i + 1) + '>' +
                        '<input type="hidden" name="no_invoice' + (i + 1) + '" value = ' + data[i].no_invoice + '>' + '</td>' +
                        '</tr>';
                }

                $('#totalitem').val(i);
                $('#show_receipt').html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    });


    $(document).ready(function() {
        $('#tgl_receipt').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#kode_account').focus();
            }
        });
        $('#kode_account').keydown(function(e) {
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
    });
    
    $(document).on('click', '.centangpay', function(e) {
        let ctr = $(this).data('ctr');
        let jumlah_bayar = $('#owing' + ctr).val();
        if ($(this).prop("checked") == true) {
            $('#jumlah_bayar' + ctr).val(number_format(jumlah_bayar, 0));
            $('#potongan' + ctr).val(0);
            $('#admin' + ctr).val(0);
            $('#pph23' + ctr).val(0);
            $('#pph4' + ctr).val(0);
            hitungTotalByr();
        } else {
            $('#jumlah_bayar' + ctr).val(0);
            $('#potongan' + ctr).val(0);
            $('#admin' + ctr).val(0);
            $('#pph23' + ctr).val(0);
            $('#pph4' + ctr).val(0);
            hitungTotalByr();
        }
    });
    
    function hitungTotalBayar() {
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
            let pph4 = 0;

            if ($('#centang' + j).prop("checked") == true) {
                potongan = $('#potongan' + j).val();
                admin = $('#admin' + j).val();
                pph23 = $('#pph23' + j).val();
                pph4 = $('#pph4' + j).val();
                jumlah_bayar = $('#owing' + j).val() - potongan - admin -pph23 - pph4;
            } else {
                jumlah_bayar = 0;
                potongan = 0;
                admin = 0;
                pph23 = 0;
                pph4 = 0;
            }

            $('#potongan' + j).val(potongan);
            $('#admin' + j).val(admin);
            $('#pph23' + j).val(pph23);
            $('#pph4' + j).val(pph4);
            $('#jumlah_bayar' + j).val(number_format(jumlah_bayar, 0));

            total_potongan = total_potongan + parseFloat(potongan);
            total_admin = total_admin + parseFloat(admin);
            total_pph23 = total_pph23 + parseFloat(pph23);
            total_pph4 = total_pph4 + parseFloat(pph4);
            total_bayar = total_bayar + parseFloat(jumlah_bayar);
        }
        $('#total_bayar').val(number_format(total_bayar, 0));
        $('#total_admin').val(number_format(total_admin, 0));
        $('#total_pph23').val(number_format(total_pph23, 0));
        $('#total_pph4').val(number_format(total_pph4, 0));
        $('#total_potongan').val(number_format(total_potongan, 0));
    }

    
    function hitungTotalByr() {
        var total_bayar = 0;
        let total_potongan = 0;
        let total_admin = 0;
        let total_pph23 = 0;
        let total_pph4 = 0;
        var totitem = $('#totalitem').val();
        for (j = 1; j <= totitem; j++) {
            var jumlah_bayar = 0;
            if ($('#jumlah_bayar' + j).val()) {
                jumlah_bayar = $('#jumlah_bayar' + j).val();
                potongan = $('#potongan' + j).val();
                admin = $('#admin' + j).val();
                pph23 = $('#pph23' + j).val();
                pph4 = $('#pph4' + j).val();

                jmlbyr = parseFloat(jumlah_bayar.replace(/[^0-9.-]+/g, ''))
                pot = parseFloat(potongan.replace(/[^0-9.-]+/g, ''))
                adm = parseFloat(admin.replace(/[^0-9.-]+/g, ''))
                p23 = parseFloat(pph23.replace(/[^0-9.-]+/g, ''))
                p4  = parseFloat(pph4.replace(/[^0-9.-]+/g, ''))

                total_admin = total_admin + parseFloat(adm);
                total_pph23 = total_pph23 + parseFloat(p23);
                total_pph4  = total_pph4 + parseFloat(p4);
                total_bayar = total_bayar + parseFloat(jmlbyr);
                total_potongan = total_potongan + parseFloat(pot);
            }
        }
        $('#total_admin').val(number_format(total_admin, 0));
        $('#total_pph23').val(number_format(total_pph23, 0));
        $('#total_pph4').val(number_format(total_pph4, 0));
        $('#total_bayar').val(number_format(total_bayar, 0));
        $('#total_potongan').val(number_format(total_potongan, 0));
    }

    $('.tombolSimpanReceipt').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpanreceipt')[0];
        let data = new FormData(form);
        $.ajax({
            type: "post",
            url: "<?= base_url('receipt/simpandata') ?>",
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
                $('.tombolSimpanReceipt').html('SIMPAN DATA');
                $('.tombolSimpanReceipt').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;
                    if (dataError.errorCustomer) {
                        $('.errorCustomer').html(dataError.errorCustomer).show();
                    } else {
                        $('.errorCustomer').fadeOut();
                    }
                    if (dataError.errorAccount) {
                        $('.errorAccount').html(dataError.errorAccount).show();
                    } else {
                        $('.errorAccount').fadeOut();
                    }
                } else {

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

    $('#kode_customer').on('mouseenter', function() {
        $('.errorCustomer').fadeOut();
    });
    $('#kode_account').on('change', function() {
        $('.errorAccount').fadeOut();
    });
    

</script>

<?= $this->endSection() ?>