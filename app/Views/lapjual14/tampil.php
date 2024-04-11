<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-8">
        <table class="table">
            <center style="margin-top: 20px;">
                <h4><?= $title1 ?></h4>
                <h5 style="margin-top: -10px;"><b><?= $title ?></b></h5>
                <p style="margin-top: -8px;"><?= date('d-M-Y', strtotime($sampai)) ?>
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
                    <th>Invoice No</th>
                    <th>Date</th>
                    <th class="text-center">0-30 Days</th>
                    <th class="text-center">31-60 Days</th>
                    <th class="text-center">61-90 Days</th>
                    <th class="text-center">>90 Days</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>

            <tbody>
                <?php $no = 1;
                $tot30 = 0;
                $tot60 = 0;
                $tot90 = 0;
                $tot120 = 0;
                $gtot30 = 0;
                $gtot60 = 0;
                $gtot90 = 0;
                $gtot120 = 0;
                $tot30 = 0;
                $tot60 = 0;
                $tot90 = 0;
                $tot120 = 0;
                $total = 0;
                $gtotal = 0;

                $sw = 0;
                $kdcust = '';
                foreach ($laporan as $lap) : ?>
                    <?php if ($kdcust != $lap['nama_customer'] . $lap['kode_customer']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td colspan="2" class="p-0">SUB TOTAL</td>
                                <td align="right" class="text-bold p-0"><?= number_format($tot30, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($tot60, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($tot90, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($tot120, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($total, '0', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                            <?php
                            $tot30 = 0;
                            $tot60 = 0;
                            $tot90 = 0;
                            $tot120 = 0;
                            $total = 0;
                            ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="6" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['nama_customer'] ?></td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <?php
                        $tgl2 = strtotime($sampai);
                        $tgl1 = strtotime($lap['tgl_invoice']);
                        $jarak = $tgl2 - $tgl1;
                        $hari = $jarak / 60 / 60 / 24;
                        if ($hari <= 30) {
                            $tot30   = $tot30  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                            $gtot30   = $gtot30  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                        } else {
                            if ($hari <= 60) {
                                $tot60   = $tot60  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                $gtot60   = $gtot60  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                            } else {
                                if ($hari <= 90) {
                                    $tot90   = $tot90  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                    $gtot90   = $gtot90  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                } else {
                                    $tot120  = $tot120 + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                    $gtot120  = $gtot120 + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                }
                            }
                        }

                        $total   = $total  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                        $gtotal   = $gtotal  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);

                        $sw = 1;
                        ?>

                        <td align="left" class="p-0"><?= $lap['no_invoice'] ?></td>
                        <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_invoice'])) ?></td>

                        <?php if ($hari <= 30) { ?>
                            <td align="right" class="p-0">
                                <?= number_format($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur'], '0', ',', '.') ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <?php } else { ?>

                            <?php if ($hari <= 60) { ?>
                                <td></td>
                                <td align="right" class="p-0">
                                    <?= number_format($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur'], '0', ',', '.') ?>
                                </td>
                                <td></td>
                                <td></td>
                            <?php } else { ?>

                                <?php if ($hari <= 90) { ?>
                                    <td></td>
                                    <td></td>
                                    <td align="right" class="p-0">
                                        <?= number_format($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur'], '0', ',', '.') ?>
                                    </td>
                                    <td></td>
                                <?php } else { ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right" class="p-0">
                                        <?= number_format($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur'], '0', ',', '.') ?>
                                    </td>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        <td align="right" class="p-0">
                            <?= number_format($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur'], '0', ',', '.') ?>
                        </td>
                    </tr>
                    <?php $kdcust  = $lap['nama_customer'] . $lap['kode_customer'] ?>

                <?php endforeach; ?>
            </tbody>
            <td colspan="2" class="text-bold p-0">Sub Total</td>
            <td align="right" class="text-bold p-0"><?= number_format($tot30, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($tot60, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($tot90, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($tot120, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($total, '0', ',', '.') ?></td>

            <tr>
                <td colspan="7"></td>
            </tr>

            <td colspan="2" class="text-bold p-0">Grand Total</td>
            <td align="right" class="text-bold p-0"><?= number_format($gtot30, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($gtot60, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($gtot90, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($gtot120, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($gtotal, '0', ',', '.') ?></td>
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