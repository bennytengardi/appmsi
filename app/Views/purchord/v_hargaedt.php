<div class="card" style="background-color: aliceblue;">
    <div class="row p-3">
        <div class="col-md-12">
            <table class="table table-bordered table-sm" width="100%">
                <thead class="bg-primary">
                    <tr class="text-center">
                        <td width="4%">NO</td>
                        <td width="10%">KODE BARANG</td>
                        <td>NAMA BARANG</td>
                        <td width="8%">QTY</td>
                        <td width="6%">SATUAN</td>
                        <td width="12%">HARGA</td>
                        <td width="6%">DISC%</td>
                        <td width="12%">SUBTOTAL</td>
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
                            <td><input type="text" class="form-control form-control-sm border-secondary text-center" value="<?= $no++ ?>" readonly></td>
                            <td><input type="text" class="form-control form-control-sm border-secondary" value="<?= $row['kode_baku'] ?>" readonly></td>
                            <td><input type="text" class="form-control form-control-sm border-secondary" value="<?= $row['nama_baku'] ?>" readonly></td>
                            <td><input type="text" class="form-control form-control-sm border-secondary text-right" value="<?= $row['qty'] ?>" readonly></td>
                            <td><input type="text" class="form-control form-control-sm border-secondary text-center" value="<?= $row['kode_satuan'] ?>" readonly></td>
                            <td><input type="text" class="form-control form-control-sm border-secondary text-right" value="<?= number_format($row['harga'], 0) ?>" readonly></td>
                            <td><input type="text" class="form-control form-control-sm border-secondary text-right" value="<?= number_format($row['discpersen'], 2) ?>" readonly></td>
                            <td><input type="text" class="form-control form-control-sm border-secondary text-right" value="<?= number_format($row['subtotal'], 0) ?>" readonly></td>
                            <td style="text-align: center;">
                                <button class="btn btn-xs btn-danger" onclick="hapusitem('<?= $row['id_purchord'] ?>' , '<?= $row['nama_baku'] ?>', '<?= $row['no_po'] ?>')">DELETE</button>
                                <button class="btn btn-xs btn-success ml-2" onclick="edititem('<?= $row['id_purchord'] ?>','<?= $row['no_po'] ?>','<?= $row['kode_baku'] ?>','<?= $row['nama_baku'] ?>','<?= $row['qty'] ?>','<?= $row['satuan'] ?>','<?= $row['harga'] ?>','<?= $row['discpersen'] ?>', '<?= $row['subtotal'] ?>')">EDIT</button>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                    $totalppn =  (session()->get('vat') / 100) * $totaldpp;
                    $totalpph =  session()->get('totalpph');
                    $totalpo = $totaldpp + $totalppn + $totalpph;
                    ?>

                </tbody>
                <tr>
                    <td colspan="7" class="text-right">TOTAL DPP :</td>
                    <td>
                        <input type="text" id="total_dpp" name="total_dpp" class="form-control form-control-sm border-secondary text-right text-bold" value="<?= number_format($totaldpp, 0) ?>" readonly>
                        <input type="hidden" id="totalitem" name="totalitem">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="7" class="text-right">TOTAL PPN :</td>
                    <td>
                        <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm border-secondary text-right total_ppn autonum" value="<?= number_format($totalppn, 0) ?>" readonly>
                        <input type="hidden" id="ppn" name="ppn">
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="text-right">TOTAL PPH :</td>
                    <td>
                        <input type="text" id="total_pph" name="total_pph" class="form-control form-control-sm border-secondary text-right total_pph autonum" value="<?= number_format($totalpph, 0) ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="text-right">TOTAL PO :</td>
                    <td>
                        <input type="text" id="total_po" name="total_po" class="form-control form-control-sm border-secondary  text-right text-bold" value="<?= number_format($totalpo, 0) ?>" readonly>
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

    function hitungtotal() {
        let totaldpp = $("#total_dpp").val().replace(/[^0-9.-]/g, '');
        let totalppn = $("#total_ppn").val().replace(/[^0-9.-]/g, '');
        let totalpph = $("#total_pph").val().replace(/[^0-9.-]/g, '');
        // let totalpph = ($('#total_pph').val() == "") ? 0 : $('#total_pph').val().replace(/[^0-9.-]/g, ''));
        let totalpo = parseInt(totaldpp) + parseInt(totalppn) + parseInt(totalpph);
        if (isNaN(totalpo)) {
            return 0;
        }
        $("#total_po").val(totalpo);
    }

    $('#total_pph').on('keyup', function() {
        hitungtotal();
    });

    function edititem(id, nopo, kode, nama, qt, satuan, hrg, dis1, subtot) {
        let id_purchord = id;
        let kode_baku = kode;
        let nama_baku = nama;
        let kode_satuan = satuan;
        let no_po = nopo;
        let qty = qt;
        let harga = hrg;
        let discpersen = dis1;
        let subtotal = subtot;

        $.ajax({
            type: "post",
            url: "<?= site_url('PurchOrd/viewEditHarga') ?>",
            data: {
                id_purchord: id_purchord,
                kode_baku: kode_baku,
                nama_baku: nama_baku,
                satuan: kode_satuan,
                no_po: no_po,
                qty: qty,
                harga: harga,
                discpersen: discpersen,
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
            html: `Yakin menghapus data baku : <strong>${nama}</strong>`,
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