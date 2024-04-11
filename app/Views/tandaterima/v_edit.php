<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card card-primary" style="background-color: lightskyblue;">

            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">TANDA TERIMA</h3>
                <a href="<?= base_url('TandaTerima/index') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <div class="card" style="background-color: #d7ecff;">
                    <div class="row p-3">
                        <div class="col-sm-6">
                            <div class="form group row">
                                <div class="col-sm-3">KODE SUPPLIER</div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm border-secondary  kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" value="<?= $tandaterima['kode_supplier'] ?>" readonly>
                                        <div class="errorSupplier invalid-feedback" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form group row mt-2">
                                <div class="col-sm-3">NAMA SUPPLIER</div>
                                <div class="col-sm-8">
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm border-secondary" value="<?= $tandaterima['nama_supplier'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                        </div>

                        <div class="col-sm-5">
                            <div class="form group row">
                                <div class="col-sm-2">NO TT</div>
                                <div class="col-sm-4">
                                    <input type="text" name="no_tandaterima" id="no_tandaterima" class="form-control form-control-sm border-secondary text-bold text-danger" value="<?= $tandaterima['no_tandaterima'] ?>" readonly>
                                </div>
                            </div>

                            <div class="form group row mt-2">
                                <div class="col-sm-2">TGL TT</div>
                                <div class="col-sm-4">
                                    <input type="date" name="tgl_tandaterima" id="tgl_tandaterima" class="form-control form-control-sm border-secondary" value="<?= $tandaterima['tgl_tandaterima'] ?>">
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
                                        <td width="12%">POTONGAN</td>
                                        <td width="15%">JUMLAH TT</td>

                                    </tr>
                                </thead>

                                <tbody id="show_tandaterima">
                                    <?php
                                    $total_potongan = 0;
                                    $total_bayar = 0;

                                    $no = 1;
                                    $i = 0;
                                    foreach ($dtandaterima as $dtl) :  ?>
                                        <?php $i++;
                                        $total_potongan += $dtl['potongan'];
                                        $total_bayar   += $dtl['jumlah_bayar'] ?>
                                        <tr>
                                            <td><input type="text" class="form-control form-control-sm text-center border-secondary" value="<?= $no++ ?>" readonly></td>
                                            <td>
                                                <input type="text" name="no_invoice<?= $i ?>" id="no_invoice<?= $i ?>" class="form-control form-control-sm border-secondary" value="<?= $dtl['no_invoice'] ?>" readonly>
                                                <input type="hidden" name="id_tandaterima<?= $i ?>" id="id_tandaterima<?= $i ?>" value="<?= $dtl['id_tandaterima'] ?>">
                                            </td>

                                            <td><input type="text" name="tgl_invoice<?= $i ?>" id="tgl_invoice<?= $i ?>" class="form-control form-control-sm text-center border-secondary" value="<?= $dtl['tgl_invoice'] ?>" readonly></td>
                                            <td><input type="text" name="invoice_supp<?= $i ?>" id="invoice_supp<?= $i ?>" class="form-control form-control-sm text-center border-secondary" value="<?= $dtl['invoice_supp'] ?>" readonly></td>
                                            <td><input type="text" name="total_invoice<?= $i ?>" id="total_invoice<?= $i ?>" class="form-control form-control-sm text-right border-secondary" value="<?= number_format($dtl['total_invoice']) ?>" readonly></td>
                                            <td><input type="text" name="potongan<?= $i ?>" id="potongan<?= $i ?>" class="form-control form-control-sm text-right potongan border-secondary" onkeyup="hitungtotalbayar()" value="<?= number_format($dtl['potongan'], 0) ?>"></td>
                                            <td><input type="text" name="jumlah_bayar<?= $i ?>" id="jumlah_bayar<?= $i ?>" class="form-control form-control-sm text-right jumlah_bayar border-secondary" onkeyup="hitungtotalbyr()" value="<?= number_format($dtl['jumlah_bayar'], 0) ?>"></td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>

                                <tr>
                                    <td colspan="5" class="text-right">TOTAL:</td>
                                    <td>
                                        <input type="text" name="total_potongan" id="total_potongan" class="form-control form-control-sm border-secondary text-right" value="<?= number_format($total_potongan, 0) ?>" readonly>
                                    </td>
                                    <td><input type="text" name="total_bayar" id="total_bayar" class="form-control form-control-sm border-secondary text-right" value="<?= number_format($total_bayar, 0) ?>" readonly>
                                        <input type="hidden" id="totalitem" name="totalitem" value="<?= $i ?>">
                                    </td>
                                </tr>
                            </table>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-sm tombolSimpantandaterima ml-2 mt-1">SAVE DATA</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= form_close() ?>
            <div class="viewmodal" style="display: none;"></div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.centangpay', function(e) {
        var ctr = $(this).data('ctr');
        var jumlah_bayar = $('#owing' + ctr).val();
        console.log(jumlah_bayar);
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
            potongan = $('#potongan' + j).val().replace(/[^0-9.-]/g, '');
            owing = $('#owing' + j).val().replace(/[^0-9.-]/g, '');
            jumlah_bayar = parseFloat(owing) - parseFloat(potongan);

            $('#potongan' + j).val(potongan);
            $('#jumlah_bayar' + j).val(jumlah_bayar);

            total_potongan = total_potongan + parseFloat(potongan);
            total_bayar = total_bayar + parseFloat(jumlah_bayar);
        }

        $('#total_bayar').val(total_bayar);
        $('#total_potongan').val(total_potongan);
    }

    function hitungtotalbyr() {

        var total_bayar = 0;
        var totitem = $('#totalitem').val();
        for (j = 1; j <= totitem; j++) {
            var jumlah_bayar = 0;
            jumlah_bayar = $('#jumlah_bayar' + j).val().replace(/[^0-9.-]/g, '');
            $('#jumlah_bayar' + j).val(number_format(jumlah_bayar, 0));
            total_bayar = total_bayar + parseFloat(jumlah_bayar);
        }
        $('#total_bayar').val(number_format(total_bayar, 0));
    }


    $('.tombolSimpantandaterima').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpantandaterima')[0];
        let data = new FormData(form);
        $.ajax({
            type: "post",
            url: "<?= base_url('TandaTerima/updatedata') ?>",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpantandaterima').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpantandaterima').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpantandaterima').html('SAVE DATA');
                $('.tombolSimpantandaterima').prop('disabled', false);
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