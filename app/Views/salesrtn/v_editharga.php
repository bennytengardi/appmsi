<div class="modal fade" id="modaleditharga" tabindex="-1" aria-labelledby="modaledithargaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modalbarangLabel">DETAIL SALES RETURN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('SalesRtn/updateHarga', ['class' => 'formupdateharga']) ?>
            <div class="modal-body" style="background-color: #d7ecff;">
                <div class="form group row mt-1">
                    <div class="col-md-2">ITEM NO</div>
                    <div class="col-md-3">
                        <input type="text" name="kode_barang" id="kode_barang" class="form-control form-control-sm " value="<?= $kode_barang ?>" readonly>
                        <input type="hidden" name="id_salesrtn" id="id_salesrtn" value="<?= $id_salesrtn ?>">
                        <input type="hidden" name="no_retur" id="no_retur" value="<?= $no_retur ?>">
                    </div>
                </div>
                <div class="form group row mt-2">
                    <div class="col-md-2">ITEM NAME</div>
                    <div class="col-md-9">
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control form-control-sm " value="<?= $nama_barang ?>" readonly>
                    </div>
                </div>
                <div class="form group row mt-2">
                    <div class="col-md-2">UNIT</div>
                    <div class="col-md-2">
                        <input type="text" name="kode_satuan" id="kode_satuan" class="form-control form-control-sm " value="<?= $kode_satuan ?>" readonly>
                    </div>
                </div>
                <div class="form group row mt-2">
                    <div class="col-md-2">QTY</div>
                    <div class="col-md-2">
                        <input type="text" name="qty" id="qty" class="form-control form-control-sm  text-right autonum2" value="<?= $qty ?>" autofocus>
                    </div>
                </div>

                <div class="form group row mt-2">
                    <div class="col-md-2">PRICE</div>
                    <div class="col-md-3">
                        <input type="text" name="harga" id="harga" class="form-control form-control-sm  text-right harga autonum" value="<?= $harga ?>">
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
            let no_retur = $('#no_retur').val();

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