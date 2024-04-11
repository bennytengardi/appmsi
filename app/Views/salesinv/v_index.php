<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="card card-primary"  style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
    <div class="card-header" style="height: 40px;">
        <h3 class="card-title mt-n1`">SALES INVOICE</h3>
        <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mt-n1 mb-2 float-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </a>
    </div>

    <div class="card-body">
        <button type="button" class="btn btn-primary btn-xs tomboltambahbeli mb-2" onclick="window.location='<?= base_url('SalesInv/add') ?>'">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg> Add Invoice
        </button>

        <div class="row mt-2 mb-2">
            <div class="col-sm-12">
                <div class="form-inline">
                    <input type="date" name="tglmulai" id="tglmulai" class="form-control form-control-sm date" style="font-size: 12px;height: 26px;" value="<?= session()->get('tglawlinv') ?>">
                    <input type="date" name="tglakhir" id="tglakhir" class="form-control form-control-sm date ml-3" style="font-size: 12px;height: 26px;" value="<?= session()->get('tglakhinv') ?>">
                    <select name="kode_customer" id="kode_customer" class="form-control form-control-sm ml-3" style="font-size: 12px;height: 26px;">
                        <option value="ALL">All Customers</option>
                        <?php foreach ($customer as $acc) : ?>
                            <option value="<?= $acc['kode_customer'] ?>"><?= $acc['nama_customer'] ?></option>
                        <?php endforeach; ?>
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
            <table class="table table-sm table-striped table-bordered table-hover" id="DataSalesInv" width="100%" style="font-size: 12px;">
                <thead class="bg-primary text-center">
                    <tr>
                        <td width="3%">NO</td>
                        <td width="9%">NO INVOICE</td>
                        <td width="8%">DATE</td>
                        <td>CUSTOMER NAME</td>
                        <td width="8%">NO DO</td>
                        <td width="8%">DIVISI</td>
                        <td width="11%">TOTAL INVOICE</td>
                        <td width="6%">STATUS</td>
                        <td width="20%">ACTION</td>
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
        listDataSalesInv()
    });

    function listDataSalesInv() {
        var table = $('#DataSalesInv').DataTable({
            "processing": true,
            "serverSide": true,
            "bDestroy": true,
            'pageLength': 15,
            "order": [],
            'ajax': {
                "url": "<?= base_url('SalesInv/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [{
                    "targets": [6],
                    "className": 'pb-0 text-right'
                },
                {
                    "targets": [0, 2, 7, 8],
                    "className": 'pb-0 text-center',
                },
                {
                    "targets": [1, 3, 4, 5],
                    "className": 'pb-0 text-left',
                },
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],
        })
    }

    // $('.tombolFilter').click(function(e) {
    $('#kode_customer').on('change', function() {
        let tgl1 = $('#tglmulai').val();
        let tgl2 = $('#tglakhir').val();
        let cust = $('#kode_customer').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('SalesInv/setses') ?>",
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                cust: cust
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    listDataSalesInv();
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
        let cust = $('#kode_customer').val();
        console.log(cust);
        $.ajax({
            type: "post",
            url: "<?= site_url('SalesInv/setses') ?>",
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                cust: cust
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    listDataSalesInv();
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
        let cust = $('#kode_customer').val();
        console.log(cust);
        $.ajax({
            type: "post",
            url: "<?= site_url('SalesInv/setses') ?>",
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                cust: cust
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    listDataSalesInv();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    });

    $('.tombolReset').click(function(e) {
        window.location = "<?= base_url('SalesInv') ?>";

    });


    function hapusSalesInv(no_invoice, nama_customer) {

        Swal.fire({
            html: `Yakin mau menghapus data No Invoice : <strong> ${no_invoice}<br>${nama_customer}</strong>`,
            text: "Data ini mau dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00a65a',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal!',
            showClass: {
                popup: 'animate__animated animate__fadeIn'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('SalesInv/hapus') ?>",
                    data: {
                        no_invoice: no_invoice,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.sukses,
                                confirmButtonColor: '#00a65a',
                                showClass: {
                                    popup: 'animate__animated animate__fadeIn'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                }
                            }).then((result) => {
                                if (result.value) {
                                    window.location.reload();
                                }
                            })
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        })
    }
</script>

<?= $this->endSection() ?>