<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="card card-primary" style="background-color: #D7ECFF;">
    <div class="card-header" style="height: 50px;">
        <h3 class="card-title">STOCK ADJUSTMENT</h3>
        <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 float-right">
            <i class="fa fa-times-circle"></i></button></a>
    </div>

    <div class="card-body">
        <button type="button" class="btn btn-primary btn-xs tomboltambahinv mb-2" onclick="window.location='<?= base_url('Adjustment/add') ?>'">
            <i class="fa fa-plus-circle"></i> ADD</button>
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped" id="DataAdjust" width="100%">
                <thead class="bg-primary" align="center">
                    <tr>
                        <td width="4%">NO</td>
                        <td width="10%">ADJUSTMENT#</td>
                        <td width="8%">DATE</td>
                        <td width="14%">ITEM NO</td>
                        <td>ITEM NAME</td>
                        <td width="8%">QTY</td>
                        <td>DESCRIPTIONS</td>
                        <td width="10%">ACTION</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        listDataAdjust()
    });

    function listDataAdjust() {
        var table = $('#DataAdjust').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "order": [],
            'ajax': {
                "url": "<?= base_url('Adjustment/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [{
                    "targets": [0, 2, 5, 7],
                    "className": 'text-center',
                },
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],
        })
    }


    function hapusAdjustment(no_adjustment) {
        Swal.fire({
            html: `Yakin mau menghapus data Adjustment : <strong> ${no_adjustment}</strong>`,
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
                    url: "<?= base_url('Adjustment/hapus') ?>",
                    data: {
                        no_adjustment: no_adjustment
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