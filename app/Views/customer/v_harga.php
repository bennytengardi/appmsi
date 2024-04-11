<div class="card" style="background-color: #d7ecff;">
    <div class="container p-3">
        <div class="mx-2">
            <table class="table table-bordered table-sm" width="100%">
                <thead class="bg-primary">
                    <tr class="text-center">
                        <td width="4%">NO</td>
                        <td width="12%">NO INVOICE</td>
                        <td width="8%">DATE INVOICE</td>
                        <td width="10%">DIVISI</td>
                        <td width="10%">TOTAL INVOICE</td>
                        <td width="10%>]">ACTION</td>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    $total_saldo = 0;
                    foreach ($datadetail as $row) :
                        $total_saldo += $row['total_invoice'];
                    ?>
                        <tr>
                            <td><input type="text" class="form-control form-control-sm border-secondary text-center" value="<?= $no++ ?>" readonly></td>
                            <td><input type="text" class="form-control form-control-sm border-secondary" value="<?= $row['no_invoice'] ?>" readonly></td>
                            <td><input type="text" class="form-control form-control-sm border-secondary" value="<?= date('d-m-Y', strtotime($row['tgl_invoice'])) ?>" readonly></td>
                            <td><input type="text" class="form-control form-control-sm border-secondary" value="<?= $row['kode_divisi'] ?>" readonly></td>
                            <td><input type="text" class="form-control form-control-sm border-secondary text-right" value="<?= number_format($row['total_invoice'], 0) ?>" readonly></td>
                            <td style="text-align: center;">
                                <button class="btn btn-xs btn-danger" onclick="hapusitem('<?= $row['no_invoice'] ?>')">DELETE</button>
                                <button class="btn btn-xs btn-success ml-2" onclick="edititem('<?= $row['no_invoice'] ?>','<?= $row['tgl_invoice'] ?>','<?= $row['kode_divisi'] ?>','<?= $row['total_invoice'] ?>','<?= $row['total_bayar'] ?>')">EDIT</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tr>
                    <td colspan="3" class="text-right" style="font-size: 14px;">TOTAL :</td>
                    <td>
                        <input type="text" id="total_saldo" name="total_saldo" class="form-control form-control-sm text-right border-secondary" value="<?= number_format($total_saldo, 0) ?>" style="height: 26px" readonly>
                        <input type="hidden" id="totalitem" name="totalitem">
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script>
    function edititem(noinvoice, tginvoice, kddiv, total, totalbyr) {
        let no_invoice = noinvoice
        let tgl_invoice = tginvoice;
        let kode_divisi = kddiv;
        let total_invoice = total;
        let total_bayar = totalbyr;

        console.log(kode_divisi);

        $.ajax({
            type: "post",
            url: "<?= site_url('customer/viewEditHarga') ?>",
            data: {
                no_invoice: no_invoice,
                tgl_invoice: tgl_invoice,
                kode_divisi: kode_divisi,
                total_invoice: total_invoice,
                total_bayar: total_bayar
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

    function hapusitem(noinvoice) {
        let no_invoice = noinvoice;
        Swal.fire({
            title: 'Hapus Item ?',
            html: `Yakin menghapus data barang : <strong>${no_invoice}</strong>`,
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
                    url: "<?= base_url('customer/hapusItem') ?>",
                    data: {
                        no_invoice: no_invoice
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