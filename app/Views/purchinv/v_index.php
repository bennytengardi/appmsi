<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
    <div class="card-header" style="height: 40px;">
        <h3 class="card-title mt-n1">PURCHASE INVOICE</h3>
        <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 mt-n1 float-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </a>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-xs tomboltambahjual mb-2" onclick="window.location='<?= base_url('PurchInv/add') ?>'">
            <i class="fa fa-plus-circle"></i> Add Invoice</button>
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover" id="DataPurchInv" width="100%" style="font-size: 12px">
                <thead class="bg-primary text-center">
                    <tr>
                        <td>NO</td>
                        <td>FORM NO</td>
                        <td>DATE INVOICE</td>
                        <td>NO INVOICE</td>
                        <td>SUPPLIER NAME</td>
                        <td>DIVISI</td>
                        <td>CURRENCY</td>
                        <td>NO. PO</td>
                        <td>TOTAL INVOICE</td>
                        <td>TOTAL PAID</td>
                        <td width="17%">ACTION</td>
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
        listDataPurchInv()
    });

    function listDataPurchInv() {
        var table = $('#DataPurchInv').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 15,
            "order": [],
            'ajax': {
                "url": "<?= base_url('PurchInv/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [
                {
                    "targets": [ 8, 9],
                    "className": 'pb-0 text-right'
                },
                {
                    "targets": [0, 2, 6, 10],
                    "className": 'pb-0 text-center',
                },
                {
                    "targets": [1, 3, 4, 5, 7],
                    "className": 'pb-0 text-left',
                },
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],
        })
    }

    function hapusPurchInv(no_invoice, nama_supplier) {

        Swal.fire({
            html: `Are you sure to delete this Invoice : <strong> ${no_invoice}<br>${nama_supplier}</strong>`,
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
                    url: "<?= base_url('PurchInv/hapus') ?>",
                    data: {
                        no_invoice: no_invoice
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