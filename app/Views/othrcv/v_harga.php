    <div class="mx-0">
        <table class="table table-bordered table-sm" width="100%">
            <thead class="bg-primary">
                <tr class="text-center">
                    <td width="4%">NO</td>
                    <td width="8%">ACCOUNT#</td>
                    <td>ACCOUNT NAME</td>
                    <td width="12%">AMOUNT IDR</td>
                    <td width="35%">DESCRIPTION</td>
                    <td width="12%">ACTION</td>
                </tr>
            </thead>

            <tbody>
                <?php $no = 1;
                $total = 0;
                foreach ($datadetail as $row) :
                    $total += $row['jumlah'];
                ?>
                    <tr>
                        <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $no++ ?>"  style="font-size:13px;height: 26px;background-color: white;" readonly></td>
                        <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['kode_account'] ?>"  style="font-size:13px;height: 26px;background-color: white;" readonly></td>
                        <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['nama_account'] ?>"  style="font-size:13px;height: 26px;background-color: white;" readonly></td>
                        <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['jumlah'], 2) ?>"  style="font-size:13px;height: 26px;background-color: white;" readonly></td>
                        <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['keterangan'] ?>"  style="font-size:13px;height: 26px;background-color: white;" readonly></td>
                        <td  class="p-0" style="text-align: center;">
                            <button class="btn btn-xs btn-success" style="font-size:10px;height:20px;margin-top:2px;" onclick="edititem('<?= $row['row_id'] ?>','<?= $row['no_bukti'] ?>','<?= $row['kode_account'] ?>','<?= $row['nama_account'] ?>','<?= $row['jumlah'] ?>','<?= $row['keterangan'] ?>')"><i class="fa fa-edit"></i> Edit</button>
                            <button class="btn btn-xs btn-danger ml-2" style="font-size:10px;height:20px;margin-top:2px;" onclick="hapusitem('<?= $row['row_id'] ?>' , '<?= $row['nama_account'] ?>', '<?= $row['no_bukti'] ?>')"><i class="fa fa-trash-alt"></i> Delete</button>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
            </tbody>

            <tr>
                <td colspan="3" class="text-right text-bold">TOTAL :</td>
                <td class="p-0">
                    <input type="text" id="total" name="total" class="form-control form-control-sm text-right text-danger text-bold" style="font-size: 13px;height: 26px;" value="<?= number_format($total, 2) ?>" readonly>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
<script>
    function edititem(id, nobukti, kode, nama, jml, rmk) {
        let row_id = id;
        let kode_account = kode;
        let nama_account = nama;
        let remark = rmk;
        let no_bukti = nobukti;
        let jumlah = jml;

        $.ajax({
            type: "post",
            url: "<?= site_url('OthRcv/viewEditHarga') ?>",
            data: {
                row_id: row_id,
                kode_account: kode_account,
                nama_account: nama_account,
                jumlah: jumlah,
                no_bukti: no_bukti,
                keterangan: remark
            },
            dataType: "json",
            success: function(response) {
                $('.viewmodal').html(response.viewmodal).show();
                $('#modaleditharga').modal('show');
                $('#modaleditharga').on('shown.bs.modal', function(e) {
                    // $('#qty').focus();
                })
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function hapusitem(id, nama, noinvoice) {
        let no_bukti = noinvoice;
        Swal.fire({
            title: 'Delete ?',
            html: `Are you sure to delete : <strong> ${nama}</strong>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'No',
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
                    url: "<?= base_url('OthRcv/hapusItem') ?>",
                    data: {
                        row_id: id
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