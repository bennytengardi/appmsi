<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="row justify-content-center">
    <div class="col-sm-12">
        <div class="card card-primary" style="background-color: aliceblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">TANDA TERIMA</h3>
                <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm tomboltambahbeli mb-2" onclick="window.location='<?= base_url('TandaTerima/add') ?>'">
                    <i class="fa fa-plus-circle"></i> TAMBAH</button>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped" id="DataTandaTerima" width="100%">
                        <thead class="bg-primary text-center">
                            <tr>
                                <td>NO</td>
                                <td>NO TT</td>
                                <td>TGL TT</td>
                                <td>NAMA SUPPLIER</td>
                                <td>TOTAL POTONGAN</td>
                                <td>TOTAL TT</tdwidth=>
                                <td width="25%">AKSI</td>
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



<script src="<?= base_url('assets') ?>/plugins/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        listDataTandaTerima()
    });

    function listDataTandaTerima() {
        var table = $('#DataTandaTerima').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            'ajax': {
                "url": "<?= base_url('TandaTerima/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [{
                    "targets": [4, 5],
                    "className": 'text-right'
                },
                {
                    "targets": [0, 2, 6],
                    "className": 'text-center',
                },
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],
        })
    }

    function hapusTandaTerima(no_tandaterima, nama_supplier) {

        Swal.fire({
            html: `Yakin mau menghapus data No Invoice : <strong> ${no_tandaterima}<br>${nama_supplier}</strong>`,
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
                    url: "<?= base_url('TandaTerima/hapus') ?>",
                    data: {
                        no_tandaterima: no_tandaterima
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