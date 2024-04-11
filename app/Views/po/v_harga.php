<div class="card" style="background-color: aliceblue;">
    <div class="row p-3">
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

                <tbody>
                    <?php $no = 1;
                    $totaldpp = 0;
                    foreach ($datadetail as $row) :
                        $totaldpp += $row['subtotal'];
                    ?>
                        <tr>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['kode_barang'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['nama_barang'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= $row['qty'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $row['kode_satuan'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['harga'], 2) ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['subtotal'], 2) ?>" readonly></td>
                            <td class="text-center p-0"  style="background-color: #e9ecef;vertical-align: middle">
                                <button class="btn btn-xs btn-danger" onclick="hapusitem('<?= $row['id_purchord'] ?>' , `<?= $row['nama_barang'] ?>`, '<?= $row['no_po'] ?>')">DELETE</button>
                                <button class="btn btn-xs btn-success ml-2" onclick="edititem('<?= $row['id_purchord'] ?>','<?= $row['no_po'] ?>',`<?= $row['kode_barang'] ?>`,`<?= $row['nama_barang'] ?>`,'<?= $row['qty'] ?>','<?= $row['kode_satuan'] ?>','<?= $row['harga'] ?>', '<?= $row['subtotal'] ?>')">EDIT</button>
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
                        <input type="text" id="total_dpp" name="total_dpp" class="form-control form-control-sm  text-right" value="<?= number_format($totaldpp, 2) ?>" readonly>
                        <input type="hidden" id="totalitem" name="totalitem">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right">TOTAL PPN :</td>
                    <td class="p-0">
                        <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm  text-right total_ppn autonum" value="<?= number_format($totalppn, 2) ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right">TOTAL PO :</td>
                    <td class="p-0">
                        <input type="text" id="total_po" name="total_po" class="form-control form-control-sm text-right" value="<?= number_format($totalpo, 2) ?>" readonly>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</div>

<script>

    function edititem(id, nopo, kode, nama, qt, kodesatuan, hrg, subtot) {
        let id_purchord = id;
        let kode_barang = kode;
        let nama_barang = nama;
        let kode_satuan = kodesatuan;
        let no_po = nopo;
        let qty = qt;
        let harga = hrg;
        let subtotal = subtot;

        $.ajax({
            type: "post",
            url: "<?= site_url('PurchOrd/viewEditHarga') ?>",
            data: {
                id_purchord: id_purchord,
                kode_barang: kode_barang,
                nama_barang: nama_barang,
                kode_satuan: kode_satuan,
                no_po: no_po,
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
                        id: id
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