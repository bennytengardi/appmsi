<div class="row px-3">
    <div class="col-md-12">
        <div class="mx-0">
            <table class="table table-bordered table-sm" width=100%>
                <thead class="bg-primary">
                    <tr class="text-center">
                        <td width="3%">NO</td>
                        <td width="10%">ITEM NO</td>
                        <td>ITEM NAME</td>
                        <td width="6%">QTY</td>
                        <td width="6%">UNIT</td>
                        <td width="10%">PRICE</td>
                        <td width="12%">AMOUNT</td>
                        <td width="12%">ACTION</td>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    <?php $no = 1;
                    $totalamt = 0;
                    foreach ($datadetail as $row) :
                        $totalamt += $row['subtotal'];
                    ?>
                        <tr class="bg-white">
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;background-color: white;"  value="<?= $no++ ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;background-color: white;"  value="<?= $row['kode_barang'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;background-color: white;"  value="<?= $row['nama_barang'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;"  value="<?= $row['qty'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;background-color: white;"  value="<?= $row['kode_satuan'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;"  value="<?= number_format($row['harga'], 2) ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;"  value="<?= number_format($row['subtotal'], 2) ?>" readonly></td>
                            <td class="text-center p-0"  style="vertical-align: middle;background-color: white;">
                                <button class="btn btn-xs btn-success"  style="font-size: 10px;height: 18px;"  onclick="edititem('<?= $row['id_salesord'] ?>','<?= $row['no_so'] ?>','<?= $row['id_barang'] ?>',`<?= $row['kode_barang'] ?>`,`<?= $row['nama_barang'] ?>`,'<?= $row['qty'] ?>','<?= $row['kode_satuan'] ?>','<?= $row['harga'] ?>','<?= $row['subtotal'] ?>' )">EDIT</button>
                                <button class="btn btn-xs btn-danger ml-2"  style="font-size: 10px;height: 18px;" onclick="hapusitem('<?= $row['id_salesord'] ?>' , `<?= $row['nama_barang'] ?>`, '<?= $row['no_so'] ?>')">DELETE</button>
                            </td>
                        </tr>
                    <?php endforeach;
                    ?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="text-center bg-primary">TOTAL AMOUNT</div>
                        <input type=" text" id="total_amount" name="total_amount" class="form-control form-control-sm text-right total_amount" style="font-size: 12px;height:26px;"  value="0" readonly>
                        <input type="hidden" id="totalitem" name="totalitem">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="text-center bg-primary">TOTAL PPN</div>
                        <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm text-right" value="0" style="font-size: 12px;height:26px;" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="text-center bg-primary">TOTAL SO</div>
                        <input type="text" id="total_so" name="total_so" class="form-control form-control-sm text-right text-danger text-bold" style="font-size: 12px;height:26px;" value="0" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        autonum();
        hitungTotalBelanja();
    });


    function edititem(id, noso, idbrg,kode, nama, qt, satuan, hrg, subtot) {
        let id_salesord = id;
        let id_barang = idbrg;
        let kode_barang = kode;
        let nama_barang = nama;
        let kode_satuan = satuan;
        let no_so = noso;
        let qty = qt;
        let harga = hrg;
        let subtotal = subtot;

        $.ajax({
            type: "post",
            url: "<?= site_url('SalesOrd/viewEditHarga') ?>",
            data: {
                id_salesord: id_salesord,
                id_barang: id_barang,
                kode_barang: kode_barang,
                nama_barang: nama_barang,
                kode_satuan: kode_satuan,
                no_so: no_so,
                qty: qty,
                harga: harga,
                subtotal: subtotal,
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

    function hapusitem(id, nama, noso) {
        let id_invoice = id;
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
                    url: "<?= base_url('SalesOrd/hapusItem') ?>",
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