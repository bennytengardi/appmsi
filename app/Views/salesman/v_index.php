<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="row justify-content-center">
    <div class="col-sm-6">
        <div class="card card-primary" style="background-color: aliceblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">DATA SALESMAN</h3>
                <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm tomboltambahinv mb-2" onclick="window.location='<?= base_url('salesman/add') ?>'">
                    <i class="fa fa-plus-circle"></i> TAMBAH SALESMAN</button>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped" id="DataSls" width="100%">
                        <thead class="bg-primary" align="center">
                            <tr>
                                <td>NO</td>
                                <td>KODE SALESMAN</td>
                                <td>NAMA SALESMAN</tdwidth=>
                                <td>AKSI</td>
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
        listDataSls()
    });

    function listDataSls() {
        var table = $('#DataSls').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            'ajax': {
                "url": "<?= base_url('salesman/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [{
                    "targets": [0, 3],
                    "className": 'text-center',
                },
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],
        })
    }


    function hapusSalesman(kode_salesman, nama_salesman) {
        Swal.fire({
            html: `Yakin mau menghapus data Salesman : <strong> ${kode_salesman}<br>${nama_salesman}</strong>`,
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
                    url: "<?= base_url('salesman/hapus') ?>",
                    data: {
                        kode_salesman: kode_salesman,
                        nama_salesman: nama_salesman
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