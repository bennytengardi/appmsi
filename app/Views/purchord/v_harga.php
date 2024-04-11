    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-sm" width="100%">
                <thead class="bg-primary">
                    <tr class="text-center">
                        <td width="4%">NO</td>
                        <td width="10%">ITEM NO</td>
                        <td>ITEM NAME</td>
                        <td width="8%">QTY</td>
                        <td width="6%">UNIT</td>
                        <td width="12%">PRICE</td>
                        <td width="12%">AMOUNT</td>
                        <td width="12%">ACTION</td>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    <?php $no = 1;
                    $totaldpp = 0;
                    foreach ($datadetail as $row) :
                        $totaldpp += $row['subtotal'];
                    ?>
                        <tr>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;" value="<?= $no++ ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;" value="<?= $row['kode_barang'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;" value="<?= $row['nama_barang'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;" value="<?= $row['qty'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;" value="<?= $row['kode_satuan'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;" value="<?= number_format($row['harga'], 2) ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;" value="<?= number_format($row['subtotal'], 2) ?>" readonly></td>
                            <td class="text-center p-0"  style="background-color: #e9ecef;vertical-align: middle">
                                <button class="btn btn-xs btn-danger" style="font-size: 10px;height: 18px;" onclick="hapusitem('<?= $row['row_id'] ?>' , `<?= $row['nama_barang'] ?>`, '<?= $row['no_po'] ?>')">DELETE</button>
                                <button class="btn btn-xs btn-success ml-2" style="font-size: 10px;height: 18px;" onclick="edititem('<?= $row['row_id'] ?>','<?= $row['id_po'] ?>','<?= $row['no_po'] ?>',`<?= $row['id_barang'] ?>`,`<?= $row['kode_barang'] ?>`,`<?= $row['nama_barang'] ?>`,'<?= $row['qty'] ?>','<?= $row['kode_satuan'] ?>','<?= $row['harga'] ?>', '<?= $row['subtotal'] ?>')">EDIT</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    
                    <?php 
                        if ($status == 'PKP') {
                           $totalppn = $totaldpp * 0.11;
                        } else {
                          $totalppn = $totaldpp * 0;
                        }
                        $totalpo = $totalppn + $totaldpp;
                    ?>

    

                </tbody>
                <tr>
                    <td colspan="6" class="text-right">TOTAL DPP :</td>
                    <td class="p-0">
                        <input type="text" id="total_dpp" name="total_dpp" class="form-control form-control-sm  text-right" style="font-size: 12px;height: 26px;" value="<?= number_format($totaldpp, 2) ?>" readonly>
                        <input type="hidden" id="totalitem" name="totalitem">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right">TOTAL PPN :</td>
                    <td class="p-0">
                        <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm  text-right total_ppn autonum" style="font-size: 12px;height: 26px;" value="<?= number_format($totalppn, 2) ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right">TOTAL PO :</td>
                    <td class="p-0">
                        <input type="text" id="total_po" name="total_po" class="form-control form-control-sm text-right" style="font-size: 12px;height: 26px;" value="<?= number_format($totalpo, 2) ?>" readonly>
                    </td>
                </tr>
            </table>
        </div>
    </div>

<script>

    function edititem(id, idpo, nopo, idbrg, kode, nama, qt, kodesatuan, hrg, subtot) {
        let row_id = id;
        let id_po = idpo;
        let no_po = nopo;
        let id_barang = idbrg;
        let kode_barang = kode;
        let nama_barang = nama;
        let kode_satuan = kodesatuan;
        let qty = qt;
        let harga = hrg;
        let subtotal = subtot;

        $.ajax({
            type: "post",
            url: "<?= site_url('PurchOrd/viewEditHarga') ?>",
            data: {
                row_id: row_id,
                id_po: id_po,
                no_po: no_po,
                id_barang: id_barang,
                kode_barang: kode_barang,
                nama_barang: nama_barang,
                kode_satuan: kode_satuan,
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

    function hapusitem(id, nama, nopo) {
        let no_po = nopo;
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
                    url: "<?= base_url('PurchOrd/hapusItem') ?>",
                    data: {
                        row_id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses == 'berhasil') {
                            dataDetailPo();
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