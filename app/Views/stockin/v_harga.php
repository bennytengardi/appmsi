<div class="row px-3">
    <div class="col-md-11">
        <div class="table-responsive">
            <table class="table table-bordered table-sm" width="100%">
                <thead class="bg-primary">
                    <tr class="text-center">
                        <td width="3%">NO</td>
                        <td width="15%">ITEM NO</td>
                        <td>ITEM NAME</td>
                        <td width="12%">QTY</td>
                        <td width="8%">UNIT</td>
                        <td width="10%">ACTION</td>
                    </tr>
                </thead>

                <tbody>

                    <?php $no = 1;
                    $totaldpp = 0;
                    foreach ($datadetail as $row) :
                    ?>
                        <tr>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;background-color: white;" value="<?= $no++ ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['kode_barang'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['nama_barang'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['qty'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['kode_satuan'] ?>" readonly></td>
                            <td class="text-center p-0"  style="background-color: #e9ecef;vertical-align: middle">
                                <button class="btn btn-xs btn-danger" style="font-size:10px;height: 18px;" onclick="hapusitem('<?= $row['id_stockin'] ?>' , `<?= $row['nama_barang'] ?>`, '<?= $row['no_bukti'] ?>')">DELETE</button>
                                <button class="btn btn-xs btn-success ml-2" style="font-size:10px;height: 18px;" onclick="edititem('<?= $row['id_stockin'] ?>','<?= $row['no_bukti'] ?>',`<?= $row['kode_barang'] ?>`,`<?= $row['nama_barang'] ?>`,'<?= $row['qty'] ?>','<?= $row['kode_satuan'] ?>')">EDIT</button>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function edititem(id, nobukti, kode, nama, qt, satuan) {
        let id_stockin = id;
        let kode_barang = kode;
        let nama_barang = nama;
        let kode_satuan = satuan;
        let no_bukti = nobukti;
        let qty = qt;

        $.ajax({
            type: "post",
            url: "<?= site_url('StockIn/viewEditHarga') ?>",
            data: {
                id_stockin: id_stockin,
                kode_barang: kode_barang,
                nama_barang: nama_barang,
                kode_satuan: kode_satuan,
                no_bukti: no_bukti,
                qty: qty,
            },
            dataType: "json",
            success: function(response) {
                $('.viewmodal').html(response.viewmodal).show();
                $('#modaleditharga').modal('show');
                $('#modaleditharga').on('shown.bs.modal', function(e) {
                    $('#qty').focus();
                })
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function hapusitem(id, nama, nobukti) {
        let no_bukti = nobukti;
        Swal.fire({
            title: 'Hapus Item ?',
            html: `Yakin menghapus data barang : <strong>${nama}</strong>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak',
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
                    url: "<?= base_url('StockIn/hapusItem') ?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses == 'berhasil') {
                            dataDetailInv();
                            kosong();
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