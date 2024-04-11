<div class="modal fade" id="modaleditharga" tabindex="-1" aria-labelledby="modaledithargaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modalbarangLabel">EDIT BALANCE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('supplier/updateHarga', ['class' => 'formupdateharga']) ?>
            <div class="modal-body" style="background-color: #d7ecff">
                <div class="form group row mt-1">
                    <label for="no_invoice" class="col-sm-4 col-form-label" style="font-weight: normal;">NO INVOICE</label>
                    <div class="col-sm-5">
                        <input type="text" name="no_invoice" id="no_invoice" class="form-control form-control-sm border-secondary" value="<?= $no_invoice ?>" readonly>
                    </div>
                </div>
                <div class="form group row mt-2">
                    <label for="tgl_invoice" class="col-sm-4 col-form-label" style="font-weight: normal;">DATE INVOICE</label>
                    <div class="col-sm-5">
                        <input type="date" name="tgl_invoice" id="tgl_invoice" class="form-control form-control-sm border-secondary" value="<?= $tgl_invoice ?>" readonly>
                    </div>
                </div>

                <div class="form group row mt-2">
                    <label for="total_invoice" class="col-sm-4 col-form-label" style="font-weight: normal;">TOTAL INVOICE</label>
                    <div class="col-sm-5">
                        <input type="text" name="total_invoice" id="total_invoice" class="form-control form-control-sm border-secondary text-right total_invoice autonum" value="<?= $total_invoice ?>">
                        <input type="hidden" name="total_bayar" id="total_bayar" value="<?= $total_bayar ?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-sm tombolSimpan">UPDATE</button>
                <button type="button" class="btn btn-secondary btn-sm closemodal" data-dismiss="modal">CLOSE</button>
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

        $('.formupdateharga').submit(function(e) {
            e.preventDefault();
            let no_invoice = $('#no_invoice').val();

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