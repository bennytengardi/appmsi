<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
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
                <!-- <div class="card p-4" style="background-color: #d8f0f0;"> -->
                    <div class="form group row">
                        <div class="col-sm-2">Supplier ID</div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" autofocus>
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-primary tombol-supplier" id="basic-addon2" data-toggle="modal" data-target="#modal-supplier"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="errorSupplier invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2">Supplier Name</div>
                        <div class="col-sm-9">
                            <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2">Address</div>
                        <div class="col-sm-9">
                            <input type="text" name="address1" id="address1" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-9">
                            <input type="text" name="address2" id="address2" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-9">
                            <input type="text" name="address3" id="address3" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
            <div class="col-sm-5 offset-1">
                <!-- <div class="card p-4" style="background-color: #d8f0f0;"> -->
                    <div class="form group row">
                        <div class="col-sm-2">Form No</div>
                        <div class="col-sm-4">
                            <input type="text" name="no_payment" id="no_payment" class="form-control form-control-sm text-md text-bold text-danger" value="<?= $no_payment ?>" readonly>
                            <input type="hidden" name="counter" id="counter">
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2">Payment Date</div>
                        <div class="col-sm-3">
                            <input type="date" name="tgl_payment" id="tgl_payment" class="form-control form-control-sm" value="<?= $tgl_payment ?>">
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2">Paid From</div>
                        <div class="col-sm-6">
                            <select name="kode_account" id="kode_account" class="form-control form-control-sm">
                                <option value=""></option>
                                <?php foreach ($account as $acct) : ?>
                                    <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="kode_voucher" id="kode_voucher">
                            <input type="hidden" name="matauang" id="matauang">
                            <div class="errorAccount invalid-feedback" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="form group row mt-1">
                        <div class="col-sm-2" id="textkurs"></div>
                        <div class="col-sm-3" id="inputkurs"></div>
                    </div>

                    <div class="form group row mt-1">
                        <div class="col-sm-2">Cheque No</div>
                        <div class="col-sm-3">
                            <input type="text" name="no_giro" id="no_giro" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form group row mt-1">
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
                <table class="table table-sm table-bordered" style="background: aliceblue;">
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

                    <?php $total_po = 0;
                    $i = 0; ?>
                    <tbody id="show_payment">
                    </tbody>

                    <tr>
                        <td colspan="7" class="text-right">TOTAL :</td>
                        <td>
                            <input type="text" name="total_potongan" id="total_potongan" class="form-control form-control-sm text-right" value="0" readonly>
                        </td>
                        <td>
                            <input type="text" name="total_pph23" id="total_pph23" class="form-control form-control-sm text-right" value="0" readonly>
                        </td>
                        <td>
                            <input type="text" name="total_ongkir" id="total_ongkir" class="form-control form-control-sm text-right" value="0" readonly>
                        </td>
                        
                        <td><input type="text" name="total_bayar" id="total_bayar" class="form-control form-control-sm text-right" value="0" readonly>
                            <input type="hidden" id="totalitem" name="totalitem">
                        </td>
                    </tr>

                </table>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm  tombolSimpanPayment ml-2"><i class="fa fa-save"></i> Save Data</button>
                </div>

            </div>
        </div>
    </div>
    <?= form_close() ?>
    <div class="viewmodal" style="display: none;"></div>
    <div class="viewmodalpembayaran" style="display: none;"></div>
</div>

<!-- MODAL SEARCH -->
<div class="modal fade" id="modal-supplier" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="height: 50px">
                <p class="modal-title text-md text-white text-bold" id="exampleModaldiv">SUPPLIER</p>
                <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body" style="background-color: aliceblue;">
                <table class="table table-bordered table-hover table-sm" id="example3" name="tabel1">
                    <thead>
                        <tr class="bg-primary text-center">
                            <th>Supplier ID</th>
                            <th>Supplier Name</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($supplier as $itm) : ?>
                            <tr>
                                <td><?= $itm['kode_supplier'] ?></td>
                                <td><?= $itm['nama_supplier'] ?></td>
                                <td><?= $itm['address1'] ?></td>
                                <td align="center">
                                    <button class="btn btn-primary btn-xs" id="select" data-kode_supplier="<?= $itm['kode_supplier'] ?>" data-nama_supplier="<?= $itm['nama_supplier'] ?>" data-address1="<?= $itm['address1'] ?>" data-address2="<?= $itm['address2'] ?>" data-currency="<?= $itm['currency'] ?>">
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
        $('#tgl_payment').focus();
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
                       html = '<input type="text" class="form-control form-control-sm text-right" name="kurs" id="kurs">';
                       document.getElementById("textkurs").innerHTML = "Exchg Rate";
                       $('#inputkurs').html(html);
                       $('#kurs').val(nilaitukar);
                       $('#matauang').val(matauang);
                    $('#no_bukti').focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    });


    $('.tombol-supplier').click(function(e) {
        e.preventDefault();
        $('#modal-supplier').modal('show');
        $('#modal-supplier').on('shown.bs.modal', function() {
            $("#modal-supplier [type='search']").focus();
        })
    });

    $(document).on('click', '#select', function(e) {
        e.preventDefault();
        var kode_supplier = $(this).data('kode_supplier');
        var nama_supplier = $(this).data('nama_supplier');
        var address1 = $(this).data('address1');
        var address2 = $(this).data('address2');
        var address3 = $(this).data('address3');

        $('[id="kode_supplier"]').val(kode_supplier);
        $('[id="nama_supplier"]').val(nama_supplier);
        $('[id="address1"]').val(address1);
        $('[id="address2"]').val(address2);
        $('[id="address3"]').val(address3);
        $('#modal-supplier').on('hidden.bs.modal', function(event) {
            $('#kode_account').focus();
        })
        $('#modal-supplier').modal('hide');

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('Payment/get_data_pi') ?>",
            data: {
                kode_supplier: kode_supplier
            },
            success: function(data) {
                var html = '';
                var i = 0;
                var no = 1;
                for (i = 0; i < data.length; i++) {
                    $owing = data[i].total_invoice  - data[i].total_retur - data[i].total_potongan - data[i].total_bayar;
                    $totalinvoice = data[i].total_invoice;
                    $totalretur = data[i].total_retur;
                    html += '<tr>' +
                        '<td align="center"  vertical-align: center;">' + no++ +
                        '</td>' + '<td style="vertical-align: center;">' + data[i].no_invoice + '</td>' +
                        '<td class="text-center" style="vertical-align: center;">' + data[i].tgl_invoice + '</td>' +
                        '<td class="text-right" style="vertical-align: center;">' + number_format($totalinvoice, 2, '.', ',') + '</td>' +
                        '<td class="text-right" style="vertical-align: center;">' + number_format($totalretur, 2, '.', ',') + '</td>' +
                        '<td class="text-right" style="vertical-align: center;">' + number_format($owing, 2, '.', ',') + '</td>' +
                        '<td align="center">' +
                        '<input type="checkbox" class="centangpay form-control form-control-xs" style="height: 26px;" id="centang' + (i + 1) +
                        '" name="centangpay' + (i + 1) + '" data-ctr = ' + (i + 1) + '>' + '</td>' +
                        '<td>' + '<input type="text" name="potongan' + (i + 1) + '" id="potongan' + (i +
                            1) +
                        '" class="form-control form-control-sm text-right autonum2"  style="height: 26px;"  onkeyup="hitungTotalBayar()">' +
                        '</td>' +
                        '<td>' + '<input type="text" name="pph23' + (i + 1) + '" id="pph23' + (i +
                            1) +
                        '" class="form-control form-control-sm text-right autonum2"  style="height: 26px;"  onkeyup="hitungTotalBayar()">' +
                        '</td>' +
                        '<td>' + '<input type="text" name="ongkir' + (i + 1) + '" id="ongkir' + (i +
                            1) +
                        '" class="form-control form-control-sm text-right autonum2"  style="height: 26px;"  onkeyup="hitungTotalBayar()">' +
                        '</td>' +
                        '<td>' + '<input type="text" name="jumlah_bayar' + (i + 1) +
                        '" id="jumlah_bayar' + (i + 1) +
                        '" class="form-control form-control-sm text-right autonum2" style="height: 26px;" onkeyup="hitungTotalByr()">' +
                        '</td>' +
                        '<input type="hidden" name="owing' + (i + 1) + '" id="owing' + (i + 1) + '" value = ' + $owing +
                        '>' +
                        '<input type="hidden" id="ctr' + (i + 1) + '" value = ' + (i + 1) + '>' +
                        '<input type="hidden" name="no_invoice' + (i + 1) + '" value = ' + data[i]
                        .no_invoice + '>' +
                        '</td>' +
                        '</tr>';
                }
                $('#totalitem').val(i);
                $('#show_payment').html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    });

    $(document).on('blur', '.kode_supplier', function() {
        var kode_supplier = $("#kode_supplier").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('supplier/cari_supplier') ?>",
            dataType: "JSON",
            data: {
                kode_supplier: kode_supplier
            },
            cache: false,
            success: function(data) {
                $.each(data, function(kode_supplier, nama_supplier, address1, address2, currency) {
                    $('[id="kode_supplier"]').val(data.kode_supplier);
                    $('[id="nama_supplier"]').val(data.nama_supplier);
                    $('[id="address1"]').val(data.address1);
                    $('[id="address2"]').val(data.address2);
                    $('[id="currency"]').val(data.currency);
                    $("#kode_account").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('payment/get_data_pi') ?>",
            data: {
                kode_supplier: kode_supplier
            },
            success: function(data) {
                var html = '';
                var i = 0;
                var no = 1;
                for (i = 0; i < data.length; i++) {
                    $owing = data[i].total_invoice  - data[i].total_retur - data[i].total_potongan - data[i].total_bayar;
                    $totalinvoice = data[i].total_invoice;
                    $totalretur = data[i].total_retur;
                    html += '<tr>' +
                        '<td align="center"  vertical-align: center;">' + no++ +
                        '</td>' + '<td style="vertical-align: center;">' + data[i].no_invoice + '</td>' +
                        '<td class="text-center" style="vertical-align: center;">' + data[i].tgl_invoice + '</td>' +
                        '<td class="text-center" style="vertical-align: center;">' + data[i].no_po + '</td>' +
                        '<td class="text-right" style="vertical-align: center;">' + number_format($totalinvoice, 2, '.', ',') + '</td>' +
                        '<td class="text-right" style="vertical-align: center;">' + number_format($totalretur, 2, '.', ',') + '</td>' +
                        '<td class="text-right" style="vertical-align: center;">' + number_format($owing, 2, '.', ',') + '</td>' +
                        '<td align="center">' +
                        '<input type="checkbox" class="centangpay form-control form-control-xs" style="height: 26px;" id="centang' + (i + 1) +
                        '" name="centangpay' + (i + 1) + '" data-ctr = ' + (i + 1) + '>' + '</td>' +
                        '<td>' + '<input type="text" name="potongan' + (i + 1) + '" id="potongan' + (i +
                            1) +
                        '" class="form-control form-control-sm text-right autonum2 border-secondary" onkeyup="hitungtotalbayar()">' +
                        '</td>' +
                        '<td>' + '<input type="text" name="pph23' + (i + 1) + '" id="pph23' + (i +
                            1) +
                        '" class="form-control form-control-sm text-right autonum2"  onkeyup="hitungTotalBayar()">' +
                        '</td>' +
                        '<td>' + '<input type="text" name="ongkir' + (i + 1) + '" id="ongkir' + (i +
                            1) +
                        '" class="form-control form-control-sm text-right autonum2"  onkeyup="hitungTotalBayar()">' +
                        '</td>' +
                        '<td>' + '<input type="text" name="jumlah_bayar' + (i + 1) +
                        '" id="jumlah_bayar' + (i + 1) +
                        '" class="form-control form-control-sm text-right autonum2" onkeyup="hitungtotalbyr()">' +
                        '</td>' +
                        '<input type="hidden" name="owing' + (i + 1) + '" id="owing' + (i + 1) + '" value = ' + $owing +
                        '>' +
                        '<input type="hidden" id="ctr' + (i + 1) + '" value = ' + (i + 1) + '>' +
                        '<input type="hidden" name="no_invoice' + (i + 1) + '" value = ' + data[i]
                        .no_invoice + '>' +
                        '</td>' +
                        '</tr>';
                }
                $('#totalitem').val(i);
                $('#show_payment').html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;

    });

    $(document).ready(function() {
        $('#tgl_payment').keydown(function(e) {
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
            $('#jumlah_bayar' + ctr).val(number_format(jumlah_bayar, 2));
            $('#potongan' + ctr).val(0);
            $('#pph23' + ctr).val(0);
            $('#ongkir' + ctr).val(0);
            hitungTotalByr();
        } else {
            $('#jumlah_bayar' + ctr).val(0);
            $('#potongan' + ctr).val(0);
            $('#pph23' + ctr).val(0);
            $('#ongkir' + ctr).val(0);
            hitungTotalByr();
        }
    });

    function hitungTotalBayar() {
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

            if ($('#centang' + j).prop("checked") == true) {
                potongan = $('#potongan' + j).val();
                pph23 = $('#pph23' + j).val();
                ongkir = $('#ongkir' + j).val();
                jumlah_bayar = $('#owing' + j).val() - parseFloat(potongan.replace(/[^0-9.]/g, '')) - parseFloat(pph23.replace(/[^0-9.]/g, '')) + parseFloat(ongkir.replace(/[^0-9.]/g, ''));
            } else {
                jumlah_bayar = 0;
                pph23 = 0;
                potongan = 0;
                ongkir = 0;
            }

            $('#potongan' + j).val(potongan);
            $('#pph23' + j).val(pph23);
            $('#ongkir' + j).val(ongkir);
            $('#jumlah_bayar' + j).val(number_format(jumlah_bayar, 2));

            total_potongan = total_potongan + parseFloat(potongan);
            total_pph23 = total_pph23 + parseFloat(pph23);
            total_ongkir= total_ongkir + parseFloat(ongkir);
            total_bayar = total_bayar + parseFloat(jumlah_bayar);
        }
        $('#total_bayar').val(number_format(total_bayar, 2));
        $('#total_pph23').val(number_format(total_pph23, 2));
        $('#total_ongkir').val(number_format(total_ongkir, 2));
        $('#total_potongan').val(number_format(total_potongan, 2));
    }

    function hitungTotalByr() {
        var total_bayar = 0;
        let total_potongan = 0;
        let total_pph23 =0
        let total_ongkir =0
        var totitem = $('#totalitem').val();
        for (j = 1; j <= totitem; j++) {
            var jumlah_bayar = 0;
            if ($('#jumlah_bayar' + j).val()) {
                jumlah_bayar = $('#jumlah_bayar' + j).val();
                potongan = $('#potongan' + j).val();
                pph23 = $('#pph23' + j).val();
                ongkir = $('#ongkir' + j).val();

                jmlbyr = parseFloat(jumlah_bayar.replace(/[^0-9.]/g, ''))
                pot = parseFloat(potongan.replace(/[^0-9.]/g, ''))
                p23 = parseFloat(pph23.replace(/[^0-9.]/g, ''))
                okr = parseFloat(ongkir.replace(/[^0-9.]/g, ''))

                total_bayar = total_bayar + parseFloat(jmlbyr);
                total_potongan = total_potongan + parseFloat(pot);
                total_pph23 = total_pph23 + parseFloat(p23);
                total_ongkir= total_ongkir + parseFloat(okr);
            }
        }
        $('#total_bayar').val(number_format(total_bayar, 2));
        $('#total_pph23').val(number_format(total_pph23, 2));
        $('#total_ongkir').val(number_format(total_ongkir, 2));
        $('#total_potongan').val(number_format(total_potongan, 2));
    }


    $('.tombolSimpanPayment').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpanpayment')[0];
        let data = new FormData(form);
        $.ajax({
            type: "post",
            url: "<?= base_url('payment/simpandata') ?>",
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
                $('.tombolSimpanPayment').html('SIMPAN DATA');
                $('.tombolSimpanPayment').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;
                    if (dataError.errorSupplier) {
                        $('.errorSupplier').html(dataError.errorSupplier).show();
                    } else {
                        $('.errorSupplier').fadeOut();
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

    $('#kode_supplier').on('mouseenter', function() {
        $('.errorSupplier').fadeOut();
    });
    $('#kode_account').on('change', function() {
        $('.errorAccount').fadeOut();
    });

</script>

<?= $this->endSection() ?>