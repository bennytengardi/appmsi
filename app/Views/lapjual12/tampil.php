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
                    <th>CUSTOMER</th>
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
                $totpot2 = 0;
                $totbyr2 = 0;
                $totinv2 = 0;
                $gtotpot = 0;
                $gtotbyr = 0;
                $gtotinv = 0;
                $tgl = '';
                $norcp = '';
                $sw = 0;
                $sw2 = 0;
                $kdsales = '';
                $kdcust = '';
                foreach ($laporan as $lap) : ?>

                    <?php if ($kdcust != $lap['kode_customer']) : ?>
                        <?php if ($sw2 == 1) : ?>
                            <tr>
                                <td colspan="5" class="text-bold p-0"></td>
                                <td class="text-bold text-right p-0">SUB TOTAL</td>
                                <td align="right" class="text-bold p-0"><?= number_format($totpot, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($totbyr, '0', ',', '.') ?></td>
                            </tr>

                            <tr>
                                <td colspan="8"></td>
                            </tr>
                            <?php $totinv = 0;
                            $totbyr = 0; ?>

                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($kdsales != $lap['kode_salesman']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td colspan="6" class="text-bold text-danger p-0">TOTAL SALESMAN</td>
                                <td align="right" class="text-bold p-0"><?= number_format($totpot2, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($totbyr2, '0', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="8"></td>
                            </tr>
                            <?php $totpot2 = 0;
                            $totbyr2 = 0; ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="8" class="text-bold text-primary p-0" style="font-size: 20px;" align="left"><?= $lap['nama_salesman'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <?php
                        $totpot = $totpot + $lap['potongan'];
                        $totbyr = $totbyr + $lap['jumlah_bayar'];
                        $totpot2 = $totpot2 + $lap['potongan'];
                        $totbyr2 = $totbyr2 + $lap['jumlah_bayar'];
                        $gtotpot = $gtotpot + $lap['potongan'];
                        $gtotbyr = $gtotbyr + $lap['jumlah_bayar'];
                        $sw = 1;
                        $sw2 = 1;
                        ?>
                        <?php if ($lap['kode_customer'] != $kdcust) { ?>
                            <td align="left" class="p-0 text-bold"><?= $lap['nama_customer'] ?></td>
                        <?php } else { ?>
                            <td align="left" class="p-0"></td>
                        <?php } ?>
                        <td class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_receipt'])) ?></td>
                        <td class="p-0"><?= $lap['no_receipt'] ?></td>
                        <td class="p-0"><?= $lap['no_invoice'] ?></td>
                        <td class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_invoice'])) ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['total_invoice'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['potongan'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['jumlah_bayar'], '0', ',', '.') ?></td>
                        <?php $kdsales = $lap['kode_salesman'] ?>
                        <?php $kdcust  = $lap['kode_customer']; ?>

                    </tr>
                <?php endforeach; ?>
            </tbody>

            <td colspan="5" class="text-bold p-0"></td>
            <td class="text-bold text-right p-0">SUB TOTAL</td>
            <td align="right" class="text-bold p-0"><?= number_format($totpot, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totbyr, '0', ',', '.') ?></td>
            <tr>
                <td colspan="8"></td>
            </tr>

            <td colspan="6" class="text-bold p-0">TOTAL SALESMAN</td>
            <td align="right" class="text-bold p-0"><?= number_format($totpot2, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totbyr2, '0', ',', '.') ?></td>
            <tr>
                <td colspan="8"></td>
            </tr>

            <tr>
                <td colspan="6" class="text-bold p-0">TOTAL SELURUH SALESMAN</td>
                <td align="right" class="text-bold p-0"><?= number_format($gtotpot, '0', ',', '.') ?></td>
                <td align="right" class="text-bold p-0"><?= number_format($gtotbyr, '0', ',', '.') ?></td>
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