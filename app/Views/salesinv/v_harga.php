<div class="card" style="background-color: #d0ecff">
    <div class="row p-3">
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

                    <tbody>
                        <?php $no = 1;
                        $totalamt = 0;
                        $totalhpp = 0;
                        foreach ($datadetail as $row) :
                            $totalamt += $row['subtotal'];
                            $totalhpp += $row['qty'] * $row['cogs'];
                        ?>
                            <tr class="bg-white">
                                <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" readonly></td>
                                <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['kode_barang'] ?>" readonly></td>
                                <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['nama_barang'] ?>" readonly></td>
                                <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= $row['qty'] ?>" readonly></td>
                                <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $row['kode_satuan'] ?>" readonly></td>
                                <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['harga'], 2) ?>" readonly></td>
                                <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['subtotal'], 0) ?>" readonly></td>
                                <td class="text-center p-0"  style="background-color: #e9ecef;vertical-align: middle">
                                    <button class="btn btn-xs btn-success" onclick="edititem('<?= $row['id_salesinv'] ?>','<?= $row['no_invoice'] ?>','<?= $row['id_barang'] ?>',`<?= $row['kode_barang'] ?>`,`<?= $row['nama_barang'] ?>`,'<?= $row['qty'] ?>','<?= $row['kode_satuan'] ?>','<?= $row['harga'] ?>','<?= $row['cogs'] ?>','<?= $row['subtotal'] ?>' )">EDIT</button>
                                    <button class="btn btn-xs btn-danger ml-2" onclick="hapusitem('<?= $row['id_salesinv'] ?>' , `<?= $row['nama_barang'] ?>`, '<?= $row['no_invoice'] ?>')">DELETE</button>
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
                            <input type=" text" id="total_amount" name="total_amount" class="form-control form-control-sm text-right total_amount" value="0" readonly>
                            <input type="hidden" id="totalitem" name="totalitem">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <div class="text-center bg-primary">DISCOUNT</div>
                            <input type="text" id="total_discount" name="total_discount" class="form-control form-control-sm text-right total_discount autonum" value="<?= session()->get('disc') ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="text-center bg-primary">DOWN PAYMENT</div>
                            <input type="text" id="total_dp" name="total_dp" class="form-control form-control-sm text-right total_dp autonum" value="<?= session()->get('dp') ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="text-center bg-primary">TOTAL DPP</div>
                            <input type="text" id="total_dpp" name="total_dpp" class="form-control form-control-sm text-right" value="0" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="text-center bg-primary">TOTAL PPN</div>
                            <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm text-right" value="0" readonly>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <div class="text-center bg-primary">ONGKIR</div>
                            <input type="text" id="ongkir" name="ongkir" class="form-control form-control-sm text-right ongkir autonum" value="<?= session()->get('ongkir') ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="text-center bg-primary">TOTAL INVOICE</div>
                            <input type="text" id="total_invoice" name="total_invoice" class="form-control form-control-sm text-right text-danger text-bold" value="0" readonly>
                            <input type="hidden" id="total_hpp" name="total_hpp" value="<?= number_format($totalhpp, 0, '.', ',') ?>">
                        </div>
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

    $(document).on('keyup', '.total_discount', function() {
        hitungTotalBelanja();
    });
    $(document).on('keyup', '.total_dp', function() {
        hitungTotalBelanja();
    });

    $(document).on('keyup', '.ongkir', function() {
        hitungTotalBelanja();
    });

    function edititem(id, noinvoice, idbrg,kode, nama, qt, satuan, hrg,cog, subtot) {
        let id_salesinv = id;
        let id_barang = idbrg;
        let kode_barang = kode;
        let nama_barang = nama;
        let kode_satuan = satuan;
        let no_invoice = noinvoice;
        let qty = qt;
        let harga = hrg;
        let cogs = cog;
        let subtotal = subtot;

        $.ajax({
            type: "post",
            url: "<?= site_url('SalesInv/viewEditHarga') ?>",
            data: {
                id_salesinv: id_salesinv,
                id_barang: id_barang,
                kode_barang: kode_barang,
                nama_barang: nama_barang,
                kode_satuan: kode_satuan,
                no_invoice: no_invoice,
                qty: qty,
                harga: harga,
                cogs: cogs,
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

    function hapusitem(id, nama, noinvoice) {
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
                    url: "<?= base_url('SalesInv/hapusItem') ?>",
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