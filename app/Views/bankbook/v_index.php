<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
    <div class="card-header" style="height: 40px;">
        <h3 class="card-title mt-n1">BANK BOOK</h3>
        <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 mt-n1 float-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </a>
    </div>

    <div class="card-body">
        <div class="row mt-2 mb-2">
            <div class="col-sm-12" style="font-size: 12px;">
                <div class="form-inline">
                    <div>Bank :</div>
                    <select name="kode_account" id="kode_account" class="form-control form-control-sm ml-3" style="font-size: 12px;height: 26px;">
                        <!-- <option value="">Pilih Account</option> -->
                        <?php foreach ($account as $acc) : ?>
                            <option value="<?= $acc['kode_account'] ?>"><?= $acc['nama_account'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-inline mt-n2">
                    <div>Period :</div>
                    <input type="date" name="tglmulai" id="tglmulai" class="form-control form-control-sm date ml-2" value="<?= $dari ?>" style="font-size: 12px;height: 26px;">
                    <input type="date" name="tglakhir" id="tglakhir" class="form-control form-control-sm date ml-3" value="<?= $sampai ?>" style="font-size: 12px;height: 26px;">
                    <button type="button" name="filter_reset" id="filter_reset" class="btn btn-xs btn-danger ml-2 tombolReset">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                            <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                        </svg> Reset
                    </button>
                    
                    <div class="btn-group" style="margin-left: 700px;margin-top: 10px;">
                        <a class="btn btn-primary btn-xs mb-3 mr-2" style="font-size: 12px;" target="_blank"
                            href="<?= base_url() . '/BankBook/print_laporan/?dari=' . $dari . '&sampai=' . $sampai ?>"><i
                                class="fa fa-print"></i> Print</a>
                        <a class="btn btn-success btn-xs mb-3" style="font-size: 12px;"
                            href="<?= base_url() . '/BankBook/excel/?dari=' . $dari . '&sampai=' . $sampai ?>"
                            style="margin-bottom: 20px; margin-left: 5px;"><i class="fas fa-file-excel"></i> Export Excel</a>
                    </div>
                </div>

                
            </div>
        </div>

         <div class="table-responsive">
            <table class="table table-sm table-striped table-hover mt-2" id="preq" width="100%"  style="font-size: 12px;">
                <thead class="bg-primary text-center" style="position: sticky; top: 0px; padding: 20px;">
                    <tr>
                        <td width="7%">Date</td>
                        <td width="12%">Source No</td>
                        <td>Description</td>
                        <td width="12%">Deposit (Db)</td>
                        <td width="12%">Widthdrawal (Cr)</td>
                        <td width="12%">Balance</td>
                    </tr>
                </thead>
                <tbody id="ShowBb" class="bg-white">
                </tbody>
           </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        listBankBook()
    });

    function listBankBook() {
        let tgl1 = $('#tglmulai').val();
        let tgl2 = $('#tglakhir').val();
        let acct = $('#kode_account').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('BankBook/proses') ?>",
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                acct: acct
            },
            dataType: "json",
            success: function(data) {
                let html = '';
                let i = 0;
                let totdebet = 0;
                let totcredit = 0;
                let saldo = parseFloat(data[i].saldo);     

                for (i = 0; i < data.length; i++) {
                    totdebet  += data[i].debet;
                    totcredit += data[i].credit;
                    saldo   = saldo + parseFloat(data[i].debet) - parseFloat(data[i].credit);
                    tanggal = data[i].tgl_bukti;
                    html += '<tr>' +
                        '<td class="py-0">' + tanggal + '</td>' +
                        '<td class="py-0">' + data[i].no_bukti + '</td>' +
                        '<td class="py-0">' + data[i].keterangan.toUpperCase() + '</td>' +
                        '<td class="text-right py-0">' + number_format(data[i].debet, 2, '.', ',') + '</td>' +
                        '<td class="text-right py-0">' + number_format(data[i].credit, 2, '.', ',') + '</td>' +
                        '<td class="text-right py-0">' + number_format(saldo,2) + '</td>' +
                         '</tr>';
                }
                $('#totalitem').val(i);
                $('#ShowBb').html(html);
            },            
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        
    }

    $('#kode_account').on('change', function() {
        listBankBook();
    });

    $('#tglmulai').on('keyup', function() {
        listBankBook();
    });

    $('.tombolReset').click(function(e) {
        window.location = "<?= base_url('BankBook') ?>";
    });


</script>



<?= $this->endSection() ?>