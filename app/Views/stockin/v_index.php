<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
    <div class="card-header" style="height: 40px;">
        <h3 class="card-title mt-n1">RECEIVE ITEM</h3>
        <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 mt-n1 float-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </a>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-xs tomboltambahjual mb-2" onclick="window.location='<?= base_url('StockIn/add') ?>'">
            <i class="fa fa-plus-circle"></i> Add Receipt</button>
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover" id="DataStockIn"  style="font-size: 12px" width="100%">
                <thead class="bg-primary text-center">
                    <tr>
                        <td width=5%>NO</td>
                        <td width=8%>RECEIPT NO</td>
                        <td width=8%>RECEIVE DATE</td>
                        <td width=25%>SUPPLIER NAME</td>
                        <td>NO PO</td>
                        <td>DESCRIPTION</td>
                        <td width="12%">ACTION</td>
                    </tr>
                </thead>
                <tbody class="bg-white">
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- <script src="<?= base_url('assets') ?>/plugins/jquery/jquery.min.js"></script> -->

<script>
    $(document).ready(function() {
        listDataStockIn()
    });

    function listDataStockIn() {
        var table = $('#DataStockIn').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 15,
            "order": [],
            'ajax': {
                "url": "<?= base_url('StockIn/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [
                {
                    "targets": [0, 2, 6],
                    "className": 'text-center pb-0',
                },
                {
                    "targets": [1, 3, 4, 5],
                    "className": 'text-left pb-0',
                },
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],
        })
    }

    function hapusStockIn(no_bukti, nama_supplier) {

        Swal.fire({
            html: `Are you sure to delete this Invoice : <strong> ${no_bukti}<br>${nama_supplier}</strong>`,
            text: "Data ini mau dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00a65a',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel!',
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
                    url: "<?= base_url('StockIn/hapus') ?>",
                    data: {
                        no_bukti: no_bukti
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
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