<div class="row mt-3" style="font-size: 12px;">
    <div class="col-md-12">
        <table class="table table-sm table-hover table-bordered" width="100%">
            <thead class="bg-primary">
                <tr class="text-center">
                    <td class="text-center" width="4%">No</td>
                    <td class="text-center" width="8%">Account#</td>
                    <td class="text-center">Account Name</td>
                    <td class="text-right" width="13%">Debet (Rp)</td>
                    <td class="text-right" width="13%">Credit (Rp)</td>
                    <!--<td class="text-right" width="8%">Rate</td>-->
                    <td width="30%">Descriptions</td>
                    <td class="text-center" width="8%">Action</td>
                </tr>
            </thead>

            <tbody class="bg-white">
                <?php $no = 1;
                $totaldebet = 0;
                $totalcredit = 0;
                foreach ($datadetail as $row) :
                    $totaldebet += $row['debet'];
                    $totalcredit += $row['credit'];
                ?>
                    <tr>
                        <td class="pb-0 text-center"><?= $no++ ?></td>
                        <td class="pb-0"><?= $row['kode_account'] ?></td>
                        <td class="pb-0"><?= $row['nama_account'] ?></td>
                        <?php if ($row['debet'] != 0) { ?>
                            <td class="pb-0 text-right"><?= number_format($row['debet'], 2) ?></td>
                        <?php } else { ?> 
                            <td class="pb-0"></td>
                        <?php } ?> 
                        
                        <?php if ($row['credit'] != 0) { ?>
                            <td class="pb-0 text-right"><?= number_format($row['credit'], 2) ?></td>
                        <?php } else { ?> 
                            <td class="pb-0"></td>
                        <?php } ?> 
                        <td class="pb-0"><?= $row['keterangan'] ?></td>
                        <td class="pb-0 text-center">
                            <button class="btn btn-xs btn-success" style="font-size: 10px;height: 18px;"  onclick="edititem('<?= $row['id_jurnal'] ?>','<?= $row['no_voucher'] ?>','<?= $row['kode_account'] ?>','<?= $row['nama_account'] ?>','<?= $row['debet'] ?>','<?= $row['credit'] ?>','<?= $row['rate'] ?>','<?= $row['prime_debet'] ?>','<?= $row['prime_credit'] ?>' ,'<?= $row['keterangan'] ?>')">Edit</button>
                            <button class="btn btn-xs btn-danger ml-2" style="font-size: 10px;height: 18px;" onclick="hapusitem('<?= $row['id_jurnal'] ?>' , '<?= $row['no_voucher'] ?>')">Delete</button>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
            </tbody>

            <tr>
                <td colspan="3" class="text-right">TOTAL :</td>
                <td class="pb-0 text-right"><?= number_format($totaldebet, 2) ?>
                    <input type="hidden" id="totaldebet" name="totaldebet" class="form-control form-control-sm  text-bold text-right text-danger" value="<?= number_format($totaldebet, 2) ?>" style="font-size: 12px;height: 24px;" readonly>
                </td>
                <td class="pb-0 text-right"><?= number_format($totalcredit, 2) ?>
                    <input type="hidden" id="totalcredit" name="totalcredit" class="form-control form-control-sm text-bold text-right text-danger" value="<?= number_format($totalcredit, 2) ?>" style="font-size: 12px; height: 24px;" readonly>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
</div>

<script>
    function edititem(id, novoucher, kode, nama, dbt, crd,rat,prmd,prmc,rmk) {
        let id_jurnal = id;
        let no_voucher = novoucher;
        let kode_account = kode;
        let nama_account = nama;
        let debet = dbt;
        let credit = crd;
        let prime_debet = prmd;
        let prime_credit = prmc;
        let rate = rat;
        let remark = rmk;
        $.ajax({
            type: "post",
            url: "<?= site_url('jurnal/viewEditHarga') ?>",
            data: {
                id_jurnal: id_jurnal,
                no_voucher: no_voucher,
                kode_account: kode_account,
                nama_account: nama_account,
                debet: debet,
                credit: credit,
                prime_debet: prime_debet,
                prime_credit: prime_credit,
                rate: rate,
                remark: remark
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

    function hapusitem(id, novoucher) {
        let no_voucher = novoucher;
        Swal.fire({
            title: 'Hapus Item ?',
            html: `Yakin menghapus data barang : <strong>${no_voucher}</strong>`,
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
                    url: "<?= base_url('jurnal/hapusItem') ?>",
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