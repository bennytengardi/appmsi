<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-10">
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
                    <th>NAMA CUSTOMER</th>
                    <th>NO INVOICE</th>
                    <th>TGL INVOICE</th>
                    <th class="text-center">0-30 HARI</th>
                    <th class="text-center">31-60 HARI</th>
                    <th class="text-center">61-90 HARI</th>
                    <th class="text-center">>90 HARI</th>
                    <th class="text-center">TOTAL</th>
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
                $stot30 = 0;
                $stot60 = 0;
                $stot90 = 0;
                $stot120 = 0;
                $total = 0;
                $stotal = 0;
                $gtotal = 0;

                $sw = 0;
                $sw2 = 0;
                $kdcust = '';
                $kdsales = '';

                foreach ($laporan as $lap) : ?>
                    <?php if ($kdcust != $lap['nama_customer'] . $lap['kode_customer']) : ?>
                        <?php if ($sw2 == 1) : ?>
                            <tr>
                                <td colspan="3" class="p-0 text-bold">TOTAL CUSTOMER</td>
                                <td align="right" class="text-bold p-0"><?= number_format($tot30, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($tot60, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($tot90, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($tot120, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($total, '0', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="8"></td>
                            </tr>
                            <?php
                            $tot30 = 0;
                            $tot60 = 0;
                            $tot90 = 0;
                            $tot120 = 0;
                            $total = 0;
                            ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($kdsales != $lap['kode_salesman']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td colspan="3" class="text-bold text-danger p-0">TOTAL SALESMAN</td>
                                <td align="right" class="text-bold text-danger p-0"><?= number_format($stot30, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold text-danger p-0"><?= number_format($stot60, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold text-danger p-0"><?= number_format($stot90, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold text-danger p-0"><?= number_format($stot120, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold text-danger p-0"><?= number_format($stotal, '0', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="8"></td>
                            </tr>
                            <?php
                            $stot30 = 0;
                            $stot60 = 0;
                            $stot90 = 0;
                            $stot120 = 0;
                            $stotal = 0;
                            ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="8" class="text-bold text-primary p-0" style="font-size: 20px;" align="left"><?= $lap['nama_salesman'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="8" class="p-0"></td>
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
                            $stot30   = $stot30  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                            $gtot30   = $gtot30  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                        } else {
                            if ($hari <= 60) {
                                $tot60   = $tot60  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                $stot60   = $stot60  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                $gtot60   = $gtot60  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                            } else {
                                if ($hari <= 90) {
                                    $tot90   = $tot90  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                    $stot90   = $stot90  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                    $gtot90   = $gtot90  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                } else {
                                    $tot120  = $tot120 + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                    $stot120  = $stot120 + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                    $gtot120  = $gtot120 + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                                }
                            }
                        }

                        $total   = $total  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                        $stotal   = $stotal  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                        $gtotal   = $gtotal  + ($lap['total_invoice'] - $lap['total_bayar'] - $lap['total_retur']);
                        $sw2 = 1;
                        $sw = 1;
                        ?>

                        <?php if ($kdcust != $lap['nama_customer'] . $lap['kode_customer']) { ?>
                            <td class="p-0 text-bold"><?= $lap['nama_customer'] ?></td>
                        <?php } else { ?>
                            <td class="p-0"></td>
                        <?php } ?>
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
                    <?php $kdsales = $lap['kode_salesman']; ?>
                <?php endforeach; ?>
            </tbody>

            <td colspan="3" class="text-bold p-0">TOTAL CUSTOMER</td>
            <td align="right" class="text-bold p-0"><?= number_format($tot30, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($tot60, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($tot90, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($tot120, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($total, '0', ',', '.') ?></td>
            <tr>
                <td colspan="8"></td>
            </tr>

            <td colspan="3" class="text-bold text-danger p-0">TOTAL SALESMAN</td>
            <td align="right" class="text-bold text-danger p-0"><?= number_format($stot30, '0', ',', '.') ?></td>
            <td align="right" class="text-bold text-danger p-0"><?= number_format($stot60, '0', ',', '.') ?></td>
            <td align="right" class="text-bold text-danger p-0"><?= number_format($stot90, '0', ',', '.') ?></td>
            <td align="right" class="text-bold text-danger p-0"><?= number_format($stot120, '0', ',', '.') ?></td>
            <td align="right" class="text-bold text-danger p-0"><?= number_format($stotal, '0', ',', '.') ?></td>
            <tr>
                <td colspan="8"></td>
            </tr>

            <td colspan="3" class="text-bold text-success p-0">GRAND TOTAL</td>
            <td align="right" class="text-bold text-success p-0"><?= number_format($gtot30, '0', ',', '.') ?></td>
            <td align="right" class="text-bold text-success p-0"><?= number_format($gtot60, '0', ',', '.') ?></td>
            <td align="right" class="text-bold text-success p-0"><?= number_format($gtot90, '0', ',', '.') ?></td>
            <td align="right" class="text-bold text-success p-0"><?= number_format($gtot120, '0', ',', '.') ?></td>
            <td align="right" class="text-bold text-success p-0"><?= number_format($gtotal, '0', ',', '.') ?></td>
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