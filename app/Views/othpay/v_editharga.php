<div class="modal fade" id="modaleditharga" tabindex="-1" aria-labelledby="modaledithargaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="height: 40px">
                <h6 class="modal-title mt-n2" id="modalbarangLabel">PENGELUARAN KAS/BANK</h6>                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle text-white text-bold" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </span>
                </button>
            </div>
            <?= form_open('OthPay/updateHarga', ['class' => 'formupdateharga']) ?>
            <div class="modal-body" style="background-image: linear-gradient(#abc4ff, #f5f7fa);font-size: 13px;">
                <div class="form group row mt-2">
                    <div class="col-sm-2">ACCOUNT NO</div>
                    <div class="col-sm-2">
                        <input type="text" name="kode_account" id="kode_account" class="form-control form-control-sm" style="font-size: 13px; height: 26px;"  value="<?= $kode_account ?>" readonly>
                        <input type="hidden" name="row_id" id="row_id" value="<?= $row_id ?>">
                        <input type="hidden" name="no_bukti" id="no_bukti" value="<?= $no_bukti ?>">
                    </div>
                </div>
                <div class="form group row mt-2">
                    <div class="col-sm-2">ACCOUNT NAME</div>
                    <div class="col-sm-8">
                        <input type="text" name="nama_account" id="nama_account" class="form-control form-control-sm" style="font-size: 13px; height: 26px;"  value="<?= $nama_account ?>" readonly>
                    </div>
                </div>

                <div class="form group row mt-2">
                    <div class="col-sm-2">AMOUNT IDR</div>
                    <div class="col-sm-3">
                        <input type="text" name="jumlah" id="jumlah" class="form-control form-control-sm text-right" style="font-size: 13px; height: 26px;"  value="<?= $jumlah ?>" autofocus>
                    </div>
                </div>

                <div class="form group row mt-2">
                    <div class="col-sm-2">DESCRIPTION</div>
                    <div class="col-sm-9">
                        <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" style="font-size: 13px; height: 26px;"  value="<?= $keterangan ?>" onkeyup="this.value = this.value.toUpperCase()">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-xs tombolSimpan">UPDATE</button>
                <button type="button" class="btn btn-secondary btn-xs closemodal" data-dismiss="modal">CLOSE</button>
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
            let no_bukti = $('#no_bukti').val();
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
                    // if (response.sukses == 'berhasil') {
                    $('#modaleditharga').modal('hide');
                    dataDetailInv();
                    // }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>