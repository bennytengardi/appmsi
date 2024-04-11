<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-10">

        <table class="table">
            <center style="margin-top: 20px;">
                <h4><?= $title1 ?></h4>
                <h5 style="margin-top: -10px;"><b><?= $title ?></b></h5>
                <p style="margin-top: -8px;"><?= date('d-M-Y', strtotime(set_value('dari'))) ?> S/D <?= date('d-M-Y', strtotime(set_value('sampai'))) ?>
                </p>
            </center>
            <div class="row">
                <div class="col-sm-12">
                    <div class="btn-group float-right">
                        <button class="btn btn-primary btn-sm mb-3 mr-2 btncetak" style="margin-bottom: 20px;"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
            </div>

            <thead>
                <tr class="bg-info text-white">
                    <th>TANGGAL</th>
                    <th>NO BUKTI</th>
                    <th>NO INVOICE</th>
                    <th>TGL INVOICE</th>
                    <th class="text-right">TOTAL INVOICE</th>
                    <th class="text-right">POTONGAN</th>
                    <th class="text-right">JUMLAH BAYAR</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totpot = 0;
                $totbyr = 0;
                $totinv = 0;
                $gtotbyr = 0;
                $gtotpot = 0;
                $gtotinv = 0;
                $tgl = '';
                $norcp = '';
                $sw = 0;
                $kdsupp = '';
                foreach ($laporan as $lap) : ?>
                    <?php if ($kdsupp != $lap['kode_supplier']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td colspan="5" class="text-bold p-0">SUB TOTAL</td>
                                <td align="right" class="text-bold p-0"><?= number_format($totpot, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($totbyr, '0', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                            <?php
                            $totbyr = 0;
                            $totpot = 0;
                            $totinv = 0;

                            ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="7" class="text-bold text-danger p-0" style="font-size: 16px;"><?= $lap['nama_supplier'] ?> &nbsp&nbsp [<?= $lap['address1'] ?>] </td>
                        </tr>
                        <?php $kdsupp = $lap['kode_supplier'] ?>
                    <?php endif; ?>
                    <tr>
                        <?php
                        $totpot = $totpot + $lap['potongan'];
                        $totbyr = $totbyr + $lap['jumlah_bayar'];
                        $totinv = $totinv + $lap['total_invoice'];
                        $gtotpot = $gtotpot + $lap['potongan'];
                        $gtotbyr = $gtotbyr + $lap['jumlah_bayar'];
                        $gtotinv = $gtotinv + $lap['total_invoice'];
                        $sw = 1;
                        ?>

                        <?php if ($lap['tgl_payment'] != $tgl) { ?>
                            <td class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_payment'])) ?></td>
                            <?php $tgl = $lap['tgl_payment']; ?>
                        <?php } else { ?>
                            <td class="p-0"></td>
                        <?php } ?>

                        <?php if ($lap['no_payment'] != $norcp) { ?>
                            <td class="p-0"><?= $lap['no_payment'] ?></td>
                            <?php $norcp = $lap['no_payment']; ?>
                        <?php } else { ?>
                            <td colspan="1" class="p-0"></td>
                        <?php } ?>

                        <td class="p-0"><?= $lap['no_invoice'] ?></td>
                        <td class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_invoice'])) ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['total_invoice'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['potongan'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['jumlah_bayar'], '0', ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <td colspan="5" class="text-bold p-0">SUB TOTAL</td>
            <td align="right" class="text-bold p-0"><?= number_format($totpot, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totbyr, '0', ',', '.') ?></td>
            <tr>
                <td colspan="7"></td>
            </tr>

            <?php if ($kd == 'ALL') { ?>
                <td colspan="5" class="text-bold p-0">GRAND TOTAL</td>
                <td align="right" class="text-bold p-0"><?= number_format($gtotpot, '0', ',', '.') ?></td>
                <td align="right" class="text-bold p-0"><?= number_format($gtotbyr, '0', ',', '.') ?></td>
            <?php } ?>

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