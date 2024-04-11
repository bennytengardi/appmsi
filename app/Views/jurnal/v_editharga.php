<div class="modal fade" id="modaleditharga" tabindex="-1" aria-labelledby="modaledithargaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modalbarangLabel">JOURNAL MEMORIAL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('jurnal/updateHarga', ['class' => 'formupdateharga']) ?>
            <div class="modal-body" style="background-color: aliceblue;">
                <div class="form group row mt-1">
                    <label for="kode_account" class="col-sm-2" style="font-weight: normal;">Account No</label>
                    <div class="col-sm-2">
                        <input type="text" name="kode_account" id="kode_account" class="form-control form-control-sm border-secondary" value="<?= $kode_account ?>" readonly>
                        <input type="hidden" name="id_jurnal" id="id_jurnal" value="<?= $id_jurnal ?>">
                        <input type="hidden" name="no_voucher" id="no_voucher" value="<?= $no_voucher ?>">
                    </div>
                </div>
                <div class="form group row mt-1">
                    <label for="nama_account" class="col-sm-2" style="font-weight: normal;">Account Name</label>
                    <div class="col-sm-8">
                        <input type="text" name="nama_account" id="nama_account" class="form-control form-control-sm border-secondary" value="<?= $nama_account ?>" readonly>
                    </div>
                </div>

                <div class="form group row mt-1">
                    <label for="debet" class="col-sm-2" style="font-weight: normal;">Debet (Rp)</label>
                    <div class="col-sm-3">
                        <input type="text" name="debet" id="debet" class="form-control form-control-sm border-secondary text-right" value="<?= $debet ?>" autofocus>
                    </div>
                </div>
                <div class="form group row mt-1">
                    <label for="credit" class="col-sm-2" style="font-weight: normal;">Credit (Rp)</label>
                    <div class="col-sm-3">
                        <input type="text" name="credit" id="credit" class="form-control form-control-sm border-secondary text-right" value="<?= $credit ?>">
                    </div>
                </div>
                
                <div class="form group row mt-1">
                    <label for="kurs" class="col-sm-2" style="font-weight: normal;">Exch Rate</label>
                    <div class="col-sm-2">
                        <input type="text" name="rate" id="rate" class="form-control form-control-sm border-secondary text-right" value="<?= $rate ?>">
                    </div>
                </div>
                <div class="form group row mt-1">
                    <label for="debet" class="col-sm-2" style="font-weight: normal;">Prime (Db)</label>
                    <div class="col-sm-3">
                        <input type="text" name="prime_debet" id="prime_debet" class="form-control form-control-sm border-secondary text-right" value="<?= $prime_debet ?>" readonly>
                    </div>
                </div>
                <div class="form group row mt-1">
                    <label for="credit" class="col-sm-2" style="font-weight: normal;">Prime (Cr)</label>
                    <div class="col-sm-3">
                        <input type="text" name="prime_credit" id="prime_credit" class="form-control form-control-sm border-secondary text-right" value="<?= $prime_credit ?>" readonly>
                    </div>
                </div>

                <div class="form group row mt-1">
                    <label for="remark" class="col-sm-2" style="font-weight: normal;">Descriptions</label>
                    <div class="col-sm-9">
                        <input type="text" name="remark" id="remark" class="form-control form-control-sm border-secondary" value="<?= $remark ?>">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-sm tombolSimpan">Update Data</button>
                <button type="button" class="btn btn-secondary btn-sm closemodal" data-dismiss="modal">Cancel</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        function autonum() {
            $('.autonum').autoNumeric('init', {
                aSep: ',',
                aDec: '.',
                mDec: '0'
            });
            $('.autonum2').autoNumeric('init', {
                aSep: ',',
                aDec: '.',
                mDec: '2'
            });
        }
        autonum()
        
    $('#debet').on('keyup', function() {
        hitungPrime();
    });

    $('#credit').on('keyup', function() {
        hitungPrime();
    });
    
    $('#rate').on('keyup', function() {
        hitungPrime();
    });


    function hitungPrime() {
        let debet = ($('#debet').val() == "") ? 0 : $('#debet').val();
        let credit = ($('#credit').val() == "") ? 0 : $('#credit').val();
        let rate  = ($('#rate').val() == "") ? 0 : $('#rate').val();
        let primedb = debet / rate;
        let primecr = credit / rate;        
        $('#prime_debet').val(number_format(primedb,2));
        $('#prime_credit').val(number_format(primecr,2));
    }

        $('.formupdateharga').submit(function(e) {
            e.preventDefault();
            let no_voucher = $('#no_voucher').val();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.tombolSimpan').prop('disabled', true);
                    $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.tombolSimpan').prop('disabled', false);
                    $('.tombolSimpan').html('UPDATE');
                },
                success: function(response) {
                    if (response.sukses == 'berhasil') {
                        $('#modaleditharga').modal('hide');
                        dataDetailInv();
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>