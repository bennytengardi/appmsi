<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="card card-primary" style="background-color: #d7ecff;">
    <div class="card-header" style="height: 50px;">
        <h3 class="card-title">SALES RETURN</h3>
        <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 float-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </a>
    </div>

    <div class="card-body">
        <button type="button" class="btn btn-primary btn-sm tomboltambahbeli mb-2" onclick="window.location='<?= base_url('SalesRtn/add') ?>'">
            <i class="fa fa-plus-circle"></i> Add Sls Rtn</button>
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped" id="DataSalesRtn" width="100%" style="font-size: 13px">
                <thead class="bg-primary text-center">
                    <tr>
                        <td width="4%">NO</td>
                        <td width="10%">RETURN#</td>
                        <td width="10%">DATE</td>
                        <td>CUSTOMER</td>
                        <td width="13%">NO INVOICE</td>
                        <td width="18%">DESCRIPTION</td>
                        <td width="12%">TOTAL RETURN</td>
                        <td width="15%">ACTION</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="<?= base_url('assets') ?>/plugins/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        listDataSalesRtn()
    });

    function listDataSalesRtn() {
        var table = $('#DataSalesRtn').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            'ajax': {
                "url": "<?= base_url('SalesRtn/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [{
                    "targets": [6],
                    "className": 'text-right'
                },
                {
                    "targets": [0, 2, 7],
                    "className": 'text-center',
                },
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],
        })
    }

    function hapusSr(no_retur, nama_customer) {

        Swal.fire({
            html: `Yakin mau menghapus data No Retur : <strong> ${no_retur}<br>${nama_customer}</strong>`,
            text: "this data will be deleted !",
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
                    url: "<?= base_url('SalesRtn/hapus') ?>",
                    data: {
                        no_retur: no_retur
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
                                // tampildatasttb();
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