<div class="row px-3 mt-n3">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-sm" width="100%">
                <thead class="bg-primary">
                    <tr class="text-center">
                        <td width="3%">NO</td>
                        <td width="12%">ITEM NO</td>
                        <td>ITEM NAME</td>
                        <td width="8%">QTY</td>
                        <td width="5%">UNIT</td>
                        <td width="12%">PRICE</td>
                        <td width="12%">AMOUNT</td>
                        <td width="12%">ACTION</td>
                    </tr>
                </thead>

                <tbody>

                    <?php $no = 1;
                    $totalamt = 0;
                    foreach ($datadetail as $row) :
                        $totalamt += $row['subtotal'];
                    ?>
                        <tr>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;background-color: white;" value="<?= $no++ ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['kode_barang'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['nama_barang'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['qty'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['kode_satuan'] ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($row['harga'], 2) ?>" readonly></td>
                            <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($row['subtotal'], 2) ?>" readonly></td>
                            <td class="text-center p-0"  style="background-color: #e9ecef;vertical-align: middle">
                                <button class="btn btn-xs btn-danger" style="font-size:10px;height: 18px;" onclick="hapusitem('<?= $row['id_purchinv'] ?>' , `<?= $row['nama_barang'] ?>`, '<?= $row['no_invoice'] ?>')">DELETE</button>
                                <button class="btn btn-xs btn-success ml-2" style="font-size:10px;height: 18px;" onclick="edititem('<?= $row['id_purchinv'] ?>','<?= $row['no_invoice'] ?>',`<?= $row['kode_barang'] ?>`,`<?= $row['nama_barang'] ?>`,'<?= $row['qty'] ?>','<?= $row['kode_satuan'] ?>','<?= $row['harga'] ?>', '<?= $row['subtotal'] ?>')">EDIT</button>
                            </td>

                        </tr>
                    <?php endforeach;
                        $totalinv = $totalamt;
                    ?>
                </tbody>
                <tr>
                    <td colspan="6" class="text-right">TOTAL AMOUNT :</td>
                    <td class="p-0">
                        <input type="text" id="total_amount" name="total_amount" class="form-control form-control-sm  text-right" style="font-size: 12px;height: 26px;" value="0" readonly>
                        <input type="hidden" id="totalitem" name="totalitem">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right">TOTAL DISCOUNT :</td>
                    <td class="p-0">
                        <input type="text" id="total_discount" name="total_discount" class="form-control form-control-sm autonum2 total_discount text-right" style="font-size: 12px;height: 26px;" value="<?= session()->get('disc') ?>">
                    </td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="6" class="text-right">TOTAL DPP :</td>
                    <td class="p-0">
                        <input type="text" id="total_dpp" name="total_dpp" class="form-control form-control-sm  text-right" style="font-size: 12px;height: 26px;" value="0" readonly>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right">PPN (%) :</td>
                    <td class="p-0">
                        <input type="text" id="vat" name="vat" class="form-control form-control-sm text-right vat" style="font-size: 12px;height: 26px;"  value="<?= session()->get('vat') ?>">
                    </td>
                    <td class="p-0">
                        <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm  text-right total_ppn" style="font-size: 12px;height: 26px;" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right">TOTAL INVOICE :</td>
                    <td class="p-0">
                        <input type="text" id="total_invoice" name="total_invoice" class="form-control form-control-sm text-right" style="font-size: 12px;height: 26px;" value="0" readonly>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        autonum();
        hitungTotalBelanja();
    });
    
    $(document).on('keyup','.total_discount', function(){
        hitungTotalBelanja();
    });

    $(document).on('keyup','.vat', function(){
        hitungTotalBelanja();
    });
    
    function edititem(id, noinvoice, kode, nama, qt, satuan, hrg, subtot) {
        let id_purchinv = id;
        let kode_barang = kode;
        let nama_barang = nama;
        let kode_satuan = satuan;
        let no_invoice = noinvoice;
        let qty = qt;
        let harga = hrg;
        let subtotal = subtot;

        $.ajax({
            type: "post",
            url: "<?= site_url('PurchInv/viewEditHarga') ?>",
            data: {
                id_purchinv: id_purchinv,
                kode_barang: kode_barang,
                nama_barang: nama_barang,
                kode_satuan: kode_satuan,
                no_invoice: no_invoice,
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

    function hapusitem(id, nama, noinvoice) {
        let no_invoice = noinvoice;
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
                    url: "<?= base_url('PurchInv/hapusItem') ?>",
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