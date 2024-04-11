<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card card-primary" style="background-color: lightskyblue;">

            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">TAMBAH TANDA TERIMA</h3>
                <a href="<?= base_url('TandaTerima/index') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <?= form_open('', ['class' => 'formsimpantandaterima']) ?>
                <?= csrf_field() ?>
                <div class="card" style="background-color: #d7ecff;">
                    <div class="row p-3">
                        <div class="col-sm-6">
                            <div class="form group row">
                                <div class="col-sm-3">KODE SUPPLIER</div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm border-secondary  kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier">
                                        <div class="input-group-append">
                                            <button type="button" class="input-group-text bg-primary tombol-supplier" id="basic-addon2" data-toggle="modal" data-target="#modal-supplier"><i class="fas fa-search"></i></button>
                                        </div>
                                        <div class="errorSupplier invalid-feedback" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form group row mt-2">
                                <div class="col-sm-3">NAMA SUPPLIER</div>
                                <div class="col-sm-8">
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm border-secondary" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                        </div>

                        <div class="col-sm-5">
                            <div class="form group row">
                                <div class="col-sm-2">NO TT</div>
                                <div class="col-sm-4">
                                    <input type="text" name="no_tandaterima" id="no_tandaterima" class="form-control form-control-sm border-secondary text-bold text-danger" value="<?= $no_tandaterima ?>" readonly>
                                </div>
                            </div>

                            <div class="form group row mt-2">
                                <div class="col-sm-2">TGL TT</div>
                                <div class="col-sm-4">
                                    <input type="date" name="tgl_tandaterima" id="tgl_tandaterima" class="form-control form-control-sm border-secondary" value="<?= $tgl_tandaterima ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card" style="background-color: #d7ecff">
                    <div class="row p-2">
                        <div class="col-sm-12">
                            <table class="table table-sm table-bordered">
                                <thead class="bg-primary text-white">
                                    <tr align="center">
                                        <td width="3%">NO</td>
                                        <td width="12%">NO INVOICE</td>
                                        <td width="8%">TGL INVOICE</td>
                                        <td width="12%">INVOICE SUPP</td>
                                        <td width="10%">TOTAL</td>
                                        <td width="5%">TT</td>
                                        <td width="12%">POTONGAN</td>
                                        <td width="15%">JUMLAH TT</td>

                                    </tr>
                                </thead>

                                <?php $total_po = 0;
                                $i = 0; ?>
                                <tbody id="show_tandaterima">
                                </tbody>

                                <tr>
                                    <td colspan="6">TOTAL:</td>
                                    <td>
                                        <input type="text" name="total_potongan" id="total_potongan" class="form-control form-control-sm border-secondary text-right" readonly>
                                    </td>
                                    <td><input type="text" name="total_bayar" id="total_bayar" class="form-control form-control-sm border-secondary text-right" readonly>
                                        <input type="hidden" id="totalitem" name="totalitem">
                                    </td>
                                </tr>

                            </table>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-sm tombolSimpanTandaTerima ml-2 mt-1">SAVE DATA</button>
                            </div>

                        </div>
                    </div>
                </div>
                <?= form_close() ?>
                <div class="viewmodal" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL SEARCH -->
<div class="modal fade" id="modal-supplier" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="height: 50px; font-size: 18px">
                <p class="modal-title text-white text-bold" id="exampleModalLabel">DATA SUPPLIER</p>
                <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body" style="background-color: aliceblue;">
                <table class="table table-bordered table-hover table-sm" id="example3" name="tabel1" style="font-size: 14px;">
                    <thead>
                        <tr class="bg-primary text-center">
                            <th>KODE SUPPLIER</th>
                            <th>NAMA SUPPLIER</th>
                            <th>ALAMAT</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($supplier as $itm) : ?>
                            <tr>
                                <td><?= $itm['kode_supplier'] ?></td>
                                <td><?= $itm['nama_supplier'] ?></td>
                                <td><?= $itm['address1'] ?></td>
                                <td align="center">
                                    <button class="btn btn-primary btn-xs" id="select" data-kode_supplier="<?= $itm['kode_supplier'] ?>" data-nama_supplier="<?= $itm['nama_supplier'] ?>" data-address1="<?= $itm['address1'] ?>" data-address2="<?= $itm['address2'] ?>" data-address3="<?= $itm['address3'] ?>" data-status="<?= $itm['status'] ?>">
                                        <i class="fa fa-check"></i> Pilih
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
    $(document).ready(function() {

    });

    $(document).on('click', '#select', function(e) {
        e.preventDefault();
        var kode_supplier = $(this).data('kode_supplier');
        var nama_supplier = $(this).data('nama_supplier');
        $('[id="kode_supplier"]').val(kode_supplier);
        $('[id="nama_supplier"]').val(nama_supplier);
        $('#modal-supplier').on('hidden.bs.modal', function(event) {
            $('#tgl_tandaterima').focus();
        })
        $('#modal-supplier').modal('hide');

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url('TandaTerima/get_data_tt') ?>",
            data: {
                kode_supplier: kode_supplier
            },
            success: function(data) {
                var html = '';
                var i = 0;
                var no = 1;
                for (i = 0; i < data.length; i++) {
                    $owing = parseFloat(data[i].total_invoice) - (parseFloat(data[i].total_tt));
                    html += '<tr>' +
                        '<td align="center">' + no++ +
                        '</td>' + '<td class="">' + data[i].no_invoice + '</td>' +
                        '<td class="text-center  ">' + data[i].tgl_invoice +
                        '</td>' +
                        '<td class="text-center  ">' + data[i].invoice_supp +
                        '</td>' +
                        '<td class="text-right ">' + number_format(data[i].total_invoice, 0, '.', ',') +
                        '</td>' +
                        '<td align="center">' +
                        '<input type="checkbox" class="centangpay" id="centang' + (i + 1) +
                        '" name="centangpay' + (i + 1) + '" data-ctr = ' + (i + 1) + '>' + '</td>' +
                        '</td>' +
                        '</td>' +
                        '<td>' + '<input type="text" name="potongan' + (i + 1) + '" id="potongan' + (i +
                            1) +
                        '" class="form-control form-control-sm text-right border-secondary" onkeyup="hitungtotalbayar()">' +
                        '</td>' +
                        '<td>' + '<input type="text" name="jumlah_bayar' + (i + 1) +
                        '" id="jumlah_bayar' + (i + 1) +
                        '" class="form-control form-control-sm text-right border-secondary  autonum"  onkeyup="hitungtotalbyr()">' +
                        '</td>' +
                        '<input type="hidden" id="owing' + (i + 1) + '" value = ' + $owing +
                        '>' +
                        '<input type="hidden" id="ctr' + (i + 1) + '" value = ' + (i + 1) + '>' +
                        '<input type="hidden" name="no_invoice' + (i + 1) + '" value = ' + data[i]
                        .no_invoice + '>' +
                        '</td>' +
                        '</tr>';
                }
                $('#totalitem').val(i);
                $('#show_tandaterima').html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;

    });

    $(document).on('keydown', '#kode_supplier', function(e) {
        if (e.keyCode == 13) {
            var kode_supplier = $("#kode_supplier").val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Supplier/cari_kodesupplier') ?>",
                dataType: "JSON",
                data: {
                    kode_supplier: kode_supplier
                },
                cache: false,
                success: function(data) {
                    $.each(data, function(kode_supplier, nama_supplier) {
                        $('[id="kode_supplier"]').val(data.kode_supplier);
                        $('[id="nama_supplier"]').val(data.nama_supplier);
                        $("#tgl_tandaterima").focus();
                    });
                },
                error: function() {
                    alert("Kode Supplier ini tidak ditemukan");
                }

            });
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "<?= base_url('TandaTerima/get_data_tt') ?>",
                data: {
                    kode_supplier: kode_supplier
                },
                success: function(data) {
                    var html = '';
                    var i = 0;
                    var no = 1;
                    for (i = 0; i < data.length; i++) {
                        $owing = parseFloat(data[i].total_invoice) - (parseFloat(data[i].total_tt));
                        html += '<tr>' +
                            '<td class="text-center ">' + no++ +
                            '</td>' + '<td class="">' + data[i].no_invoice + '</td>' +
                            '<td class="text-center ">' + data[i].tgl_invoice +
                            '</td>' +
                            '<td class="">' + data[i].invoice_supp +
                            '</td>' +
                            '<td class="text-right " >' + number_format(data[i].total_invoice, 0, '.', ',') +
                            '</td>' +
                            '<td class="text-center ">' +
                            '<input type="checkbox" class="centangpay" id="centang' + (i + 1) +
                            '" name="centangpay' + (i + 1) + '" data-ctr = ' + (i + 1) + '>' + '</td>' +
                            '</td>' +
                            '</td>' +
                            '<td>' + '<input type="text" name="potongan' + (i + 1) + '" id="potongan' + (i +
                                1) +
                            '" class="form-control form-control-sm text-right " onkeyup="hitungtotalbayar()">' +
                            '</td>' +
                            '<td>' + '<input type="text" name="jumlah_bayar' + (i + 1) +
                            '" id="jumlah_bayar' + (i + 1) +
                            '" class="form-control form-control-sm text-right  autonum"  onkeyup="hitungtotalbyr()">' +
                            '</td>' +
                            '<input type="hidden" id="owing' + (i + 1) + '" value = ' + $owing +
                            '>' +
                            '<input type="hidden" id="ctr' + (i + 1) + '" value = ' + (i + 1) + '>' +
                            '<input type="hidden" name="no_invoice' + (i + 1) + '" value = ' + data[i]
                            .no_invoice + '>' +
                            '</td>' +
                            '</tr>';
                    }
                    $('#totalitem').val(i);
                    $('#show_tandaterima').html(html);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        }
    });

    $(document).on('click', '.centangpay', function(e) {
        var ctr = $(this).data('ctr');
        var jumlah_bayar = $('#owing' + ctr).val();
        if ($(this).prop("checked") == true) {
            $('#jumlah_bayar' + ctr).val(jumlah_bayar);
            $('#potongan' + ctr).val(0);
            hitungtotalbayar();
        } else {
            $('#jumlah_bayar' + ctr).val(0);
            $('#potongan' + ctr).val(0);
            hitungtotalbayar();
        }
    });


    function hitungtotalbayar() {
        var total_bayar = 0;
        var total_potongan = 0;
        var totitem = $('#totalitem').val();
        for (j = 1; j <= totitem; j++) {
            var jumlah_bayar = 0;
            var potongan = 0;

            if ($('#centang' + j).prop("checked") == true) {
                potongan = $('#potongan' + j).val().replace(/[^0-9.-]/g, '');
                jumlah_bayar = $('#owing' + j).val() - parseFloat(potongan);
            } else {
                jumlah_bayar = 0;
                potongan = 0;
            }
            $('#potongan' + j).val(number_format(potongan, 0));
            $('#jumlah_bayar' + j).val(number_format(jumlah_bayar, 0));

            total_potongan = total_potongan + parseFloat(potongan);
            total_bayar = total_bayar + parseFloat(jumlah_bayar);
        }
        $('#total_bayar').val(number_format(total_bayar, 0));
        $('#total_potongan').val(number_format(total_potongan, 0));
    }



    function hitungtotalbyr() {

        var total_bayar = 0;
        var totitem = $('#totalitem').val();
        for (j = 1; j <= totitem; j++) {
            var jumlah_bayar = 0;
            jumlah_bayar = $('#jumlah_bayar' + j).val().replace(/[^0-9.-]/g, '');
            $('#jumlah_bayar' + j).val(number_format(jumlah_bayar, 0));
            $('#potongan' + j).val(number_format(potongan, 0));
            total_bayar = total_bayar + parseFloat(jumlah_bayar);
        }
        $('#total_bayar').val(number_format(total_bayar, 0));
    }


    $('.tombolSimpanTandaTerima').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpantandaterima')[0];
        let data = new FormData(form);
        $.ajax({
            type: "post",
            url: "<?= base_url('TandaTerima/simpandata') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanTandaTerima').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanTandaTerima').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanTandaTerima').html('SAVE DATA');
                $('.tombolSimpanTandaTerima').prop('disabled', false);
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
                            window.location = "<?= base_url('TandaTerima') ?>";
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