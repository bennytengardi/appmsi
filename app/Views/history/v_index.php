<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
    <div class="card-header" style="height: 40px;">
        <h3 class="card-title mt-n1">ACCOUNT HISTORY</h3>
        <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mt-n1 mb-2 float-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </a>
    </div>

    <div class="card-body">
        <div class="row mt-2 mb-2">
            <div class="col-sm-12">
                <div class="form-inline">
                    <input type="date" name="tglmulai" id="tglmulai" class="form-control form-control-sm date" style="font-size: 12px;height: 26px;" value="<?= session()->get('tglawlhistory') ?>">
                    <input type="date" name="tglakhir" id="tglakhir" class="form-control form-control-sm date ml-3" style="font-size: 12px;height: 26px;" value="<?= session()->get('tglakhhistory') ?>">
                    <select name="kode_account" id="kode_account" class="form-control form-control-sm ml-3" style="font-size: 12px;height: 26px;">
                        <option value="ALL">All Accounts</option>
                        <?php foreach ($account as $acc) : ?>
                            <option value="<?= $acc['kode_account'] ?>"><?= $acc['nama_account'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="source" id="source" class="form-control form-control-sm ml-3" style="font-size: 12px;height: 26px;">
                        <option value="All Source">All Source</option>
                        <option value="Sales Invoice">Sales Invoice</option>
                        <option value="Sales Return">Sales Return</option>
                        <option value="Customer Receipt">Customer Receipt</option>
                        <option value="Purchase Invoice">Purchase Invoice</option>
                        <option value="Purchase Return">Purchase Return</option>
                        <option value="Supplier Payment">Supplier Payment</option>
                        <option value="Other Payment">Other Payment</option>
                        <option value="Other Receipt">Other Receipt</option>
                        <option value="Memorial">Memorial</option>
                    </select>

                    <button type="button" name="filter_reset" id="filter_reset" class="btn btn-xs btn-danger ml-2 tombolReset">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                            <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                        </svg> Reset
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered table-hover" id="DataHistory" width="100%"  style="font-size: 12px;">
                <thead class="bg-primary text-center">
                    <tr>
                        <td width="4%">No</td>
                        <td width="7%">Date</td>
                        <td width="10%">Source</td>
                        <td width="10%">Source No</td>
                        <td width="6%">Acct No</td>
                        <td width="15%">Account Name</td>
                        <td>Description</td>
                        <td width="9%">Debet</td>
                        <td width="9%">Credit</td>
                    </tr>
                </thead>
                <tbody class="bg-white">

                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="<?= base_url('assets') ?>/plugins/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        listDataHistory()
    });

    function listDataHistory() {
        var table = $('#DataHistory').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "pageLength": 20,
            "bDestroy": true,
            'ajax': {
                "url": "<?= base_url('History/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [{
                    "targets": [7,8],
                    "className": 'p-0 text-right'
                },
                {
                    "targets": [0,1],
                    "className": 'p-0 text-center',
                },
                {
                    "targets": [2,3,4,5,6],
                    "className": 'p-0 text-left',
                },
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],
        })
    }

    // $('.tombolFilter').click(function(e) {

    $('#kode_account').on('change', function() {
        let tgl1 = $('#tglmulai').val();
        let tgl2 = $('#tglakhir').val();
        let acct = $('#kode_account').val();
        let srch = $('#source').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('History/setses') ?>",
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                acct: acct,
                srch: srch
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    listDataHistory();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    });

    $('#source').on('change', function() {
        let tgl1 = $('#tglmulai').val();
        let tgl2 = $('#tglakhir').val();
        let acct = $('#kode_account').val();
        let srch = $('#source').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('History/setses') ?>",
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                acct: acct,
                srch: srch
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    listDataHistory();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    });

    $('#tglmulai').on('keyup', function(e) {
        let tgl1 = $('#tglmulai').val();
        let tgl2 = $('#tglakhir').val();
        let acct = $('#kode_account').val();
        let srch = $('#source').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('History/setses') ?>",
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                acct: acct,
                srch: srch
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    listDataHistory();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    });

    $('#tglakhir').on('keyup', function(e) {
        let tgl1 = $('#tglmulai').val();
        let tgl2 = $('#tglakhir').val();
        let acct = $('#kode_account').val();
        let srch = $('#source').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('History/setses') ?>",
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                acct: acct,
                srch: srch
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    listDataHistory();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    });

    $('.tombolReset').click(function(e) {
        window.location = "<?= base_url('History') ?>";

    });

 </script>

<?= $this->endSection() ?>