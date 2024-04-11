<div class="modal fade" id="modaleditharga" tabindex="-1" aria-labelledby="modaledithargaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
       <div class="modal-content">
            <div class="modal-header bg-primary" style="height: 40px">
                <h6 class="modal-title mt-n2" id="modalbarangLabel">PURCHASE ORDER</h6>                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle text-white text-bold" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </span>
                </button>
            </div>
            <div class="modal-body" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
                <?= form_open('PurchOrd/updateHarga', ['class' => 'formupdateharga']) ?>
                <div class="form group row mt-3">
                    <div class="col-md-2">ITEM NO</div>
                    <div class="col-md-3">
                        <input type="text" name="kode_barang" id="kode_barang" class="form-control form-control-sm " style="font-size: 12px; height: 26px;"  value="<?= $kode_barang ?>" readonly>
                        <input type="hidden" name="row_id" id="row_id" value="<?= $row_id ?>">
                        <input type="hidden" name="no_po" id="no_po" value="<?= $no_po ?>">
                        <input type="hidden" name="id_po" id="id_po" value="<?= $id_po ?>">
                        <input type="hidden" name="id_barang" id="id_barang" value="<?= $id_barang ?>">
                    </div>
                </div>
                <div class="form group row mt-2">
                    <div class="col-md-2">ITEM NAME</div>
                    <div class="col-md-10">
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control form-control-sm " style="font-size: 12px; height: 26px;" value="<?= $nama_barang ?>" readonly>
                    </div>
                </div>
                <div class="form group row mt-2">
                    <div class="col-md-2">UNIT</div>
                    <div class="col-md-1">
                        <input type="text" name="kode_satuan" id="kode_satuan" class="form-control form-control-sm " style="font-size: 12px; height: 26px;" onkeyup="this.value = this.value.toUpperCase()" value="<?= $kode_satuan ?>" autofocus>
                    </div>
                </div>
                <div class="form group row mt-2">
                    <div class="col-md-2">QTY</div>
                    <div class="col-md-2">
                        <input type="text" name="qty" id="qty" class="form-control form-control-sm  text-right autonum2" style="font-size: 12px; height: 26px;" value="<?= $qty ?>">
                    </div>
                </div>

                <div class="form group row mt-2">
                    <div class="col-md-2">PRICE</div>
                    <div class="col-md-3">
                        <input type="text" name="harga" id="harga" class="form-control form-control-sm  text-right harga autonum2" style="font-size: 12px; height: 26px;" value="<?= $harga ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-xs tombolSimpan">UPDATE</button>
                    <button type="button" class="btn btn-danger btn-xs closemodal" data-dismiss="modal">CLOSE</button>
                </div>
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
            let no_po = $('#no_po').val();
            let id_po = $('#id_po').val();
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
                        dataDetailPo();
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