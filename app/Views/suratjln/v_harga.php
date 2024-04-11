<div class="card" style="background-color: #d0ecff">
    <div class="row p-3">
        <div class="col-md-12">
            <div class="mx-2">
                <table class="table table-bordered table-sm" width="100%">
                    <thead class="bg-primary">
                        <tr class="text-center">
                            <td width="4%">NO</td>
                            <td width="10%">ITEM NO</td>
                            <td>ITEM NAME</td>
                            <td width="8%">QTY</td>
                            <td width="6%">UNIT</td>
                            <td width="30%">NOTE</td>
                            <td width="12%">ACTION</td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1;
                        foreach ($datadetail as $row) :
                        ?>
                            <tr>
                                <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" readonly></td>
                                <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['kode_barang'] ?>" readonly></td>
                                <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['nama_barang'] ?>" readonly></td>
                                <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= $row['qty'] ?>" readonly></td>
                                <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $row['kode_satuan'] ?>" readonly></td>
                                <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $row['catatan'] ?>" readonly></td>
                                <td class="p-0 text-center" style="background-color: #e9ecef; vertical-align: middle;">
                                    <button class="btn btn-xs btn-success" onclick="edititem('<?= $row['id_suratjln'] ?>','<?= $row['no_suratjln'] ?>','<?= $row['id_barang'] ?>',`<?= $row['kode_barang'] ?>`,`<?= $row['nama_barang'] ?>`,'<?= $row['qty'] ?>','<?= $row['kode_satuan'] ?>','<?= $row['catatan'] ?>')">EDIT</button>
                                    <button class="btn btn-xs btn-danger ml-2" onclick="hapusitem('<?= $row['id_suratjln'] ?>' , `<?= $row['nama_barang'] ?>`, '<?= $row['no_suratjln'] ?>')">DELETE</button>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                        ?>

                    </tbody>
                    <input type="hidden" id="totalitem" name="totalitem">
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function edititem(id, nosuratjln, idbrg, kode, nama, qt, satuan, cat) {
        let id_suratjln = id;
        let no_suratjln = nosuratjln;
        let id_barang = idbrg;
        let kode_barang = kode;
        let nama_barang = nama;
        let qty = qt;
        let kode_satuan = satuan;
        let catatan = cat;
        console.log(id_suratjln, no_suratjln, id_barang, kode_barang, nama_barang, qty, kode_satuan, catatan);
        $.ajax({
            type: "post",
            url: "<?= site_url('SuratJln/viewEditHarga') ?>",
            data: {
                id_suratjln: id_suratjln,
                kode_barang: kode_barang,
                id_barang: id_barang,
                nama_barang: nama_barang,
                kode_satuan: kode_satuan,
                no_suratjln: no_suratjln,
                qty: qty,
                catatan: catatan,
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

    function hapusitem(id, nama, nosuratjln) {
        let no_suratjln = nosuratjln;
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
                    url: "<?= base_url('SuratJln/hapusItem') ?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses == 'berhasil') {
                            dataDetailSj();
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