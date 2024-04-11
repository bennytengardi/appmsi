<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-12">

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
                    <th>NO INVOICE</th>
                    <th>INVOICE SUPPL</th>
                    <th>TANGGAL</th>
                    <th>NAMA SUPPLIER</th>
                    <th>CURRENCY</th>
                    <th>KURS</th>
                    <th>NAMA BARANG</th>
                    <th class="text-right">QTY</th>
                    <th class="text-right">HARGA</th>
                    <th class="text-right">TOTAL CURRENCY</th>
                    <th class="text-right">TOTAL IDR</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totinv = 0;
                $gtotinv = 0;
                $sw = 0;
                $tgl = '';
                $noinv = '';
                foreach ($laporan as $lap) : ?>
                    <tr>

                        <?php if ($lap['no_invoice'] != $noinv) { ?>
                            <?php if ($sw == 1) { ?>
                    <tr>
                        <!--<td colspan="4" class="text-bold p-0"></td>-->
                        <td colspan="10" class="text-bold p-0">SUB TOTAL</td>
                        <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td colspan="8"></td>
                    </tr>
                    <?php $totinv = 0 ?>
                <?php } ?>

                <td align="left" class="p-0"><?= $lap['no_invoice'] ?></td>
                <td align="left" class="p-0"><?= $lap['invoice_supp'] ?></td>
                <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_invoice'])) ?></td>
                <td align="left" class="p-0"><?= $lap['nama_supplier'] ?></td>
                <td align="left" class="p-0"><?= $lap['currency'] ?></td>
                <td align="center" class="p-0"><?= number_format($lap['kursbeli'], '0', ',', '.') ?></td>

            <?php } else { ?>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
            <?php } ?>
            <?php
                    $totinv = $totinv + $lap['subtotal'] * $lap['kursbeli'];
                    $gtotinv = $gtotinv + $lap['subtotal'] * $lap['kursbeli'];
            ?>

            <td align="left" class="p-0"><?= $lap['nama_barang'] ?></td>
            <td align="right" class="p-0"><?= number_format($lap['qty'], '0', ',', '.') ?></td>
            <td align="right" class="p-0"><?= number_format($lap['harga'], '0', ',', '.') ?></td>
            <td align="right" class="p-0"><?= number_format($lap['subtotal'], '0', ',', '.') ?></td>
            <td align="right" class="p-0"><?= number_format($lap['subtotal'] * $lap['kursbeli'], '0', ',', '.') ?></td>

            <?php $noinv = $lap['no_invoice'];
                    $sw = 1; ?>
            </tr>
        <?php endforeach; ?>
            </tbody>

            <tr>
                <!--<td colspan="6" class="text-bold p-0"></td>-->
                <td colspan="10" class="text-bold p-0">SUB TOTAL</td>
                <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
            </tr>

            <tr>
                <td colspan="11"></td>
            </tr>
            <tr>
                <td colspan="6" class="text-bold p-0"></td>
                <td colspan="4" class="text-bold p-0">GRAND TOTAL</td>
                <td align="right" class="text-bold p-0"><?= number_format($gtotinv, '0', ',', '.') ?></td>
            </tr>

            <tr>
                <td colspan="11"></td>
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