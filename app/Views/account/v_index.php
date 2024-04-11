<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title mt-n1">ACCOUNT</h3>
                <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 mt-n1 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>
            <div class="card-body" style="font-size: 12px;">
                <button type="button" class="btn btn-primary btn-xs tomboltambahinv mb-2" onclick="window.location='<?= base_url('account/add') ?>'">
                    <i class="fa fa-plus-circle"></i> Add Account</button>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped table-hover" id="DataAcct" width="100%" style="font-size: 12px;">
                        <thead class="bg-primary" align="center">
                            <tr>
                                <td width="5%">No</td>
                                <td width="10%">Account No</td>
                                <td>Account Name</td>
                                <td width="25%">Account group</td>
                                <td width="10%">Type</td>
                                <td width="8%">Currency</td>
                                <td width="15%">Action</td>
                            </tr>
                        </thead>
                        <tbody class="bg-white">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        listDataAcct()
    });

    function listDataAcct() {
        var table = $('#DataAcct').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 15,
            "order": [],
            'ajax': {
                "url": "<?= base_url('account/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [
                {
                    "targets": [0, 4, 5,6],
                    "className": 'pb-0 text-center',
                },
                {
                    "targets": [1,2,3],
                    "className": 'pb-0 text-left',
                },
                {
                    "targets": [0, 5],
                    "orderable": false,
                },
            ],
        })
    }


    function hapusAccount(kode_account, nama_account) {
        Swal.fire({
            html: `Yakin mau menghapus data account : <strong> ${kode_account}<br>${nama_account}</strong>`,
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
                    url: "<?= base_url('account/hapus') ?>",
                    data: {
                        kode_account: kode_account,
                        nama_account: nama_account
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