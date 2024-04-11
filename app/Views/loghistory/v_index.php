<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center">
    <div class="col-sm-10">
        <div class="card card-primary" style="background-color: aliceblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">LOG HISTORY</h3>
                <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-danger btn-sm tomboltambahinv mb-2" onclick="hapusLogHistory()">
                <i class="fa fa-trash"></i> Clear History</button>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped" id="DataLog" width="100%">
                        <thead class="bg-primary" align="center">
                            <tr>
                                <td>NO</td>
                                <td>UserName</td>
                                <td>Tanggal</td>
                                <td>Aktifitas</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        listDataLogHistory()
    });

    function listDataLogHistory() {
        var table = $('#DataLog').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 18,
            "order": [],
            'ajax': {
                "url": "<?= base_url('Loghistory/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [
                {
                    "targets": [0,2],
                    "className": 'text-center py-0',
                },
                {
                    "targets": [1,3],
                    "className": 'text-left py-0',
                },
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],
        })
    }
    
    function hapusLogHistory() {
        Swal.fire({
            html: `Yakin mau menghapus data Log History`,
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
                    url: "<?= base_url('Loghistory/hapusLog') ?>",
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