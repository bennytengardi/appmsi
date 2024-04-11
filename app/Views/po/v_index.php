<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="card card-primary" style="background-color: #D7ECFF;">
    <div class="card-header" style="height: 50px;">
        <h3 class="card-title">PURCHASE ORDER</h3>
        <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 float-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </a>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-sm tomboltambahjual mb-2" onclick="window.location='<?= base_url('PurchOrd/add') ?>'">
            <i class="fa fa-plus-circle"></i> Add PO</button>
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped" id="DataPurchOrd" width="100%"  style="font-size: 13px">
                <thead class="bg-primary text-center">
                    <tr>
                        <td width=3%>NO</td>
                        <td width=12%>NO.PO</td>
                        <td width=10%>DATE PO</td>
                        <td>SUPPLIER NAME</td>
                        <td width=6%>CURRENCY</td>
                        <td width=10%>TOTAL PO</td>
                        <td width=20%>ACTION</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- <script src="<?= base_url('assets') ?>/plugins/jquery/jquery.min.js"></script> -->

<script>
    $(document).ready(function() {
        listDataPurchOrd()
    });

    function listDataPurchOrd() {
        var table = $('#DataPurchOrd').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            'ajax': {
                "url": "<?= base_url('PurchOrd/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [{
                    "targets": [5],
                    "className": 'text-right'
                },
                {
                    "targets": [0, 2, 4, 6],
                    "className": 'text-center',
                },
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],
        })
    }

    function hapusPurchOrd(no_po, nama_supplier) {
        Swal.fire({
            html: `Are you sure to delete this PO : <strong> ${no_po}<br>${nama_supplier}</strong>`,
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
                    url: "<?= base_url('PurchOrd/hapus') ?>",
                    data: {
                        no_po: no_po
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