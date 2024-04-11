<div class="card p-3" style="background-color: #d0ecff;">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-sm" width="100%">
                <thead class="bg-primary">
                    <tr class="text-center">
                        <td width="4%">NO</td>
                        <td width="14%">ITEM NO</td>
                        <td>ITEM NAME</td>
                        <td width="8%">QTY</td>
                        <td width="6%">UNIT</td>
                        <td width="12%">PRICE</td>
                        <td width="12%">AMOUNT</td>
                        <td width="10%">ACTION</td>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    $totaldpp = 0;
                    $totalppn = 0;
                    $totalrtr = 0;
                    foreach ($datadetail as $row) :
                        $totaldpp += $row['subtotal'];
                    ?>
                        <tr  class="bg-white">
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['kode_barang'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['nama_barang'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= $row['qty'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $row['kode_satuan'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['harga'], 0) ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['subtotal'], 0) ?>" readonly></td>
                            <td class="p-0 text-center" style="background-color: #e9ecef;vertical-align: middle">
                                <button class="btn btn-xs btn-danger" onclick="hapusitem('<?= $row['id_salesrtn'] ?>' , `<?= $row['nama_barang'] ?>`, '<?= $row['no_retur'] ?>')">DELETE</button>
                                <button class="btn btn-xs btn-success ml-2" onclick="edititem('<?= $row['id_salesrtn'] ?>','<?= $row['no_retur'] ?>',`<?= $row['kode_barang'] ?>`,`<?= $row['nama_barang'] ?>`,'<?= $row['qty'] ?>','<?= $row['kode_satuan'] ?>','<?= $row['harga'] ?>', '<?= $row['subtotal'] ?>')">EDIT</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>

                <tr>
                    <td colspan="6" class="text-right">SUB TOTAL :</td>
                    <td class="p-0">
                        <input type="text" id="total_dpp" name="total_dpp" class="form-control form-control-sm text-right" value="<?= number_format($totaldpp, 0) ?>" readonly>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right">TOTAL PPN :</td>
                    <td class="p-0">
                        <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm text-right" value="<?= number_format($totaldpp * 0.11, 0) ?>" readonly>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right">TOTAL RETURN :</td>
                    <td class="p-0">
                        <input type="text" id="total_retur" name="total_retur" class="form-control form-control-sm text-right text-bold text-danger" value="<?= number_format($totaldpp * 1.11, 0) ?>" readonly>
                    </td>
                    <td></td>
                </tr>

            </table>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var ppn = $('#ppn').val();
    });

    function edititem(id, noretur, kode, nama, qt, satuan, hrg, subtot) {

        let id_salesrtn = id;
        let kode_barang = kode;
        let nama_barang = nama;
        let kode_satuan = satuan;
        let no_retur = noretur;
        let qty = qt;
        let harga = hrg;
        let subtotal = subtot;
        console.log(no_retur);
        $.ajax({
            type: "post",
            url: "<?= site_url('SalesRtn/viewEditHarga') ?>",
            data: {
                id_salesrtn: id_salesrtn,
                kode_barang: kode_barang,
                nama_barang: nama_barang,
                kode_satuan: kode_satuan,
                no_retur: no_retur,
                qty: qty,
                harga: harga,
                subtotal: subtotal
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

    function hapusitem(id, nama, noretur) {
        let no_retur = noretur;
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
                    url: "<?= base_url('SalesRtn/hapusItem') ?>",
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