<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-10" style="font-size: 13px;">
        <table class="table">
            <center style="margin-top: 20px;">
                <h4><?= $title1 ?></h4>
                <h5 style="margin-top: -10px;"><b><?= $title ?></b></h5>
                <p style="margin-top: -8px;"><?= date('d-M-Y', strtotime(set_value('dari'))) ?> To <?= date('d-M-Y', strtotime(set_value('sampai'))) ?>
                </p>
            </center>

            <thead>
                <tr class="bg-info text-white">
                    <th>Date</th>
                    <th>No Reff</th>
                    <th>Customer</th>
                    <th>No Cheque</th>
                    <th>Deposit To</th>
                    <th class="text-right">Discount</th>
                    <th class="text-right">Total Paid</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totpot = 0;
                $totbyr = 0;
                $tgl = '';
                $norcp = '';
                $sw = 0;
                foreach ($laporan as $lap) : ?>
                    <tr>
                        <?php
                        $totpot = $totpot + $lap['total_potongan'];
                        $totbyr = $totbyr + $lap['total_bayar'];
                        $sw = 1;
                        ?>
                        <?php if ($lap['tgl_receipt'] != $tgl) { ?>
                            <td class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_receipt'])) ?></td>
                        <?php } else { ?>
                            <td class="p-0"></td>
                        <?php } ?>
                        <td class="p-0"><?= $lap['no_receipt'] ?></td>
                        <td class="p-0"><?= $lap['nama_customer'] ?></td>
                        <td class="p-0"><?= $lap['no_giro'] ?></td>
                        <td class="p-0"><?= $lap['nama_account'] ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['total_potongan'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['total_bayar'], '0', ',', '.') ?></td>
                    </tr>
                    <?php $tgl = $lap['tgl_receipt'] ?>
                <?php endforeach; ?>
            </tbody>
            <tr>
                <td colspan="5" class="text-bold p-0">TOTAL</td>
                <td align="right" class="text-bold p-0"><?= number_format($totpot, '0', ',', '.') ?></td>
                <td align="right" class="text-bold p-0"><?= number_format($totbyr, '0', ',', '.') ?></td>
            </tr>
        </table>
    </div>
</div>
<script>
    $('.btncetak').click(function() {
        $(this).hide();
        window.print();
        $(this).show();
    });
</script>
<?= $this->endSection() ?>