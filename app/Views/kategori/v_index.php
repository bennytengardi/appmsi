<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center">
    <div class="col-sm-8">

        <div class="card card-primary" style="background-color: aliceblue">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">TABEL KATEGORI</h3>
                <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>

            <div class="card-body">
                <button type="button" class="btn btn-primary btn-xs tomboltambahbeli mb-2" onclick="window.location='<?= base_url('Kategori/add') ?>'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg> Tambah
                </button>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped" id="DataKategori" width="100%">
                        <thead class="bg-primary" align="center">
                            <tr>
                                <td>NO</td>
                                <td>KODE KATEGORI</td>
                                <td>NAMA KATEGORI</td>
                                <!-- <td>ACCOUNT PENJUALAN</td>
                                <td>ACCOUNT HPP</td> -->
                                <td width="20%">AKSI</td>
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
        listDataKategori()
    });

    function listDataKategori() {
        var table = $('#DataKategori').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            'ajax': {
                "url": "<?= base_url('kategori/listData') ?>",
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


    function hapusKategori(kode_kategori, nama_kategori) {

        Swal.fire({
            html: `Apakah anda yakin mau menghapus Kategori : <strong> ${kode_kategori}<br>${nama_kategori}</strong>`,
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
                    url: "<?= base_url('kategori/hapus') ?>",
                    data: {
                        kode_kategori: kode_kategori
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