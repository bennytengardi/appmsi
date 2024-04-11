<div class="modal fade" id="modaleditharga" tabindex="-1" aria-labelledby="modaledithargaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modalbarangLabel">EDIT SALES INVOICE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('SalesInv/updateHarga', ['class' => 'formupdateharga']) ?>
            <div class="modal-body" style="background-color: #d7ecff;">
                <div class="form group row mt-1">
                    <label for="kode_barang" class="col-sm-2 col-form-label" style="font-weight: normal;">ITEM NO</label>
                    <div class="col-sm-4">
                        <input type="text" name="kode_barang" id="kode_barang" class="form-control form-control-sm border-secondary" value="<?= $kode_barang ?>" readonly>
                        <input type="hidden" name="id_salesinv" id="id_salesinv" value="<?= $id_salesinv ?>">
                        <input type="hidden" name="no_invoice" id="no_invoice" value="<?= $no_invoice ?>">
                        <input type="hidden" name="id_barang" id="id_barang" value="<?= $id_barang ?>">
                    </div>
                </div>
                <div class="form group row mt-2">
                    <label for="nama_barang" class="col-sm-2 col-form-label" style="font-weight: normal;">ITEM NAME</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control form-control-sm border-secondary" value="<?= $nama_barang ?>" readonly>
                    </div>
                </div>
                <div class="form group row mt-2">
                    <label for="kode_satuan" class="col-sm-2 col-form-label" style="font-weight: normal;">UNIT</label>
                    <div class="col-sm-2">
                        <input type="text" name="kode_satuan" id="kode_satuan" class="form-control form-control-sm border-secondary" value="<?= $kode_satuan ?>" readonly>
                    </div>
                </div>
                <div class="form group row mt-2">
                    <label for="qty" class="col-sm-2 col-form-label" style="font-weight: normal;">QTY</label>
                    <div class="col-sm-2">
                        <input type="text" name="qty" id="qty" class="form-control form-control-sm border-secondary text-right autonum2 qty" value="<?= $qty ?>" autofocus>
                    </div>
                </div>

                <div class="form group row mt-2">
                    <label for="harga" class="col-sm-2 col-form-label" style="font-weight: normal;">PRICE</label>
                    <div class="col-sm-3">
                        <input type="text" name="harga" id="harga" class="form-control form-control-sm border-secondary text-right harga autonum2" value="<?= $harga ?>">
                    </div>
                </div>
                <div class="form group row mt-2">
                    <label for="cogs" class="col-sm-2 col-form-label" style="font-weight: normal;">COGS</label>
                    <div class="col-sm-3">
                        <input type="text" name="cogs" id="cogs" class="form-control form-control-sm border-secondary text-right cogs autonum2" value="<?= $cogs ?>">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm tombolSimpan">UPDATE</button>
                <button type="button" class="btn btn-danger btn-sm closemodal" data-dismiss="modal">CLOSE</button>
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