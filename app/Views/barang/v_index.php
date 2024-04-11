<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center">
    <div class="col-sm-12">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title mt-n1">BARANG</h3>
                <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 mt-n1 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>

            <div class="card-body">
                <div class="row float-right">
                    <button type="button" class="btn btn-primary btn-xs tomboltambahbeli mb-2" onclick="window.location='<?= base_url('Barang/add') ?>'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                        </svg>&nbsp;&nbsp;Add Item
                    </button>
                </div>
        
                <div class="row mt-2 mb-2">
                    <div class="col-sm-12">
                        <div class="form-inline ml-n2">
                            <select name="kode_kategori" id="kode_kategori" class="form-control form-control-sm" style="font-size: 12px;width: 200px;height: 26px;">
                                <option value="ALL">All Categories</option>
                                <?php foreach ($kategori as $kat) : ?>
                                    <option value="<?= $kat['kode_kategori'] ?>"><?= $kat['nama_kategori'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select name="kode_merk" id="kode_merk" class="form-control form-control-sm ml-2"  style="font-size: 12px;width:200px;height: 26px;">
                                <option value="ALL">All Merk</option>
                                <?php foreach ($merk as $mrk) : ?>
                                    <option value="<?= $mrk['kode_merk'] ?>"><?= $mrk['nama_merk'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" name="filter_reset" id="filter_reset" class="btn btn-xs btn-danger ml-2 tombolReset">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                                </svg>&nbsp;&nbsp;Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover" id="DataBrg" width="100%" style="font-size: 12px;">
                        <thead class="bg-primary" align="center">
                            <tr>
                                <td width="3%">NO</td>
                                <td width="10%">ITEM NO</td>
                                <td>ITEM NAME</td>
                                <td width="10%">CATEGORY</td>
                                <td width="12%">MERK</td>
                                <td width="4%">UNIT</td>
                                <td width="8%">PRICE</td>
                                <td width="8%">COGS</td>
                                <td width="4%">CURR</td>
                                <td width="5%">STOCK</td>
                                <td width="10%">ACTION</td>
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
        listDataBrg()
    });

    function listDataBrg() {
        var table = $('#DataBrg').DataTable({
            "processing": true,
            "serverSide": true,
            "bDestroy": true,
            "pageLength": 15,
            "order": [],
            'ajax': {
                "url": "<?= base_url('barang/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [
                {
                    "targets": [0, 5, 8, 10],
                    "className": 'pb-0 text-center align-middle',
                },
                {
                    "targets": [6, 7, 9],
                    "className": 'pb-0 text-right align-middle',
                },
                {
                    "targets": [1,2,3,4],
                    "className": 'pb-0 text-left align-middle',
                },
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],
        })
    }
    
    $('#kode_merk').on('change', function() {
        let kat = $('#kode_kategori').val();
        let mrk = $('#kode_merk').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('Barang/setses') ?>",
            data: {
                kat: kat,
                mrk: mrk
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    listDataBrg();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $('#kode_kategori').on('change', function() {
       let kat = $('#kode_kategori').val();
       let mrk = $('#kode_merk').val();
       $.ajax({
            type: "post",
            url: "<?= site_url('Barang/setses') ?>",
            data: {
                kat: kat,
                mrk: mrk
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    listDataBrg();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    });

    $('.tombolReset').click(function(e) {
        window.location = "<?= base_url('Barang') ?>";
    });



    function hapusBarang(id_barang, nama_barang) {
        Swal.fire({
            html: `Yakin mau menghapus data Barang : <strong> <br>${nama_barang}</strong>`,
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
                    url: "<?= base_url('barang/hapus') ?>",
                    data: {
                        id_barang: id_barang
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