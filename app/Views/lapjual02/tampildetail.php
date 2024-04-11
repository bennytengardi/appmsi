<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-12">

        <table class="table" style="font-size: 12px;">
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
                <tr class="bg-info text-white" style="position: sticky; top: 0px; padding: 20px;">
                    <th>Date</th>
                    <th>Invoice#</th>
                    <th>Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-center">Unit</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Amount</th>
                    <th class="text-right">Vat</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totinv = 0;
                $gtotinv = 0;
                $totdpp = 0;
                $gtotdpp = 0;
                $totppn = 0;
                $gtotppn = 0;
                $tgl = '';
                $noinv = '';
                $sw = 0;
                $kdcust = '';
                foreach ($laporan as $lap) : ?>
                    <?php if ($kdcust != $lap['kode_customer']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td colspan="6" class="text-bold p-0">Sub Total</td>
                                <td align="right" class="text-bold p-0"><?= number_format($totdpp, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($totppn, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="9"></td>
                            </tr>
                            <?php
                            $totinv = 0;
                            ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="9" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['nama_customer'] ?></td>
                        </tr>
                        <?php $kdcust = $lap['kode_customer'] ?>
                    <?php endif; ?>
                    <tr>
                        <?php
                        $totdpp = $totdpp + $lap['subtotal'];
                        $gtotdpp = $gtotdpp + $lap['subtotal'];
                        $totppn = $totppn + $lap['subtotal'] * 0.11;
                        $gtotppn = $gtotppn + $lap['subtotal'] * 0.11;
                        $totinv = $totinv + $lap['subtotal'] * 1.11;
                        $gtotinv = $gtotinv + $lap['subtotal'] * 1.11;
                        $sw = 1;
                        ?>

                        <?php if ($lap['tgl_invoice'] != $tgl) { ?>
                            <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_invoice'])) ?></td>
                            <?php $tgl = $lap['tgl_invoice']; ?>
                        <?php } else { ?>
                            <td align="left" class="p-0"></td>
                        <?php } ?>

                        <?php if ($lap['no_invoice'] != $noinv) { ?>
                            <td align="left" class="p-0 mt-2"><?= $lap['no_invoice'] ?></td>
                            <?php $noinv = $lap['no_invoice']; ?>
                        <?php } else { ?>
                            <td align="left" class="p-0"></td>
                        <?php } ?>

                        <td align="left" class="p-0"><?= $lap['nama_barang'] ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['qty'], '0', ',', '.') ?></td>
                        <td align="center" class="p-0"><?= $lap['kode_satuan'] ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['harga'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['subtotal'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['subtotal']*0.11, '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['subtotal']*1.11, '0', ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <td colspan="6" class="text-bold p-0">Sub Total</td>
            <td align="right" class="text-bold p-0"><?= number_format($totdpp, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totppn, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
            <tr>
                <td colspan="9"></td>
            </tr>
            <td colspan="6" class="text-bold p-0">Total</td>
            <td align="right" class="text-bold p-0"><?= number_format($gtotdpp, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($gtotppn, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($gtotinv, '0', ',', '.') ?></td>
            <tr>
                <td colspan="9"></td>
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