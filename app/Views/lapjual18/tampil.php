<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-8">

        <table class="table">
            <center style="margin-top: 20px;">
                <h4><?= $title1 ?></h4>
                <h5 style="margin-top: -10px;"><b><?= $title ?></b></h5>
                <p style="margin-top: -8px;"><?= date('d-M-Y', strtotime(set_value('dari'))) ?> To <?= date('d-M-Y', strtotime(set_value('sampai'))) ?>
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
                    <th>Date</th>
                    <th>Invoice No</th>
                    <th>Customer Name</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totqty = 0;
                $totinv = 0;
                $gtotqty = 0;
                $gtotinv = 0;
                $tgl = '';
                $noinv = '';
                $sw = 0;
                $kdbrg = '';
                foreach ($laporan as $lap) : ?>
                    <?php if ($kdbrg != $lap['kode_barang']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td colspan="3" class="text-bold p-0">Sub Total</td>
                                <td align="right" class="text-bold p-0"><?= number_format($totqty, '0', ',', '.') ?></td>
                                <td></td>
                                <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                            </tr>
                            <?php
                            $totinv = 0;
                            $totqty = 0;
                            ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="6" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['nama_barang'] ?></td>
                        </tr>
                        <?php $kdbrg = $lap['kode_barang'] ?>
                    <?php endif; ?>
                    <tr>
                        <?php
                        $totqty  = $totqty + $lap['qty'];
                        $gtotqty = $gtotqty + $lap['qty'];
                        $totinv  = $totinv + $lap['subtotal'];
                        $gtotinv = $gtotinv + $lap['subtotal'];

                        $sw = 1;
                        ?>

                        <?php if ($lap['tgl_invoice'] != $tgl) { ?>
                            <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_invoice'])) ?></td>
                            <?php $tgl = $lap['tgl_invoice']; ?>
                        <?php } else { ?>
                            <td align="left" class="p-0"></td>
                        <?php } ?>

                        <?php if ($lap['no_invoice'] != $noinv) { ?>
                            <td align="left" class="p-0"><?= $lap['no_invoice'] ?></td>
                            <?php $noinv = $lap['no_invoice']; ?>
                        <?php } else { ?>
                            <td align="left" class="p-0"></td>
                        <?php } ?>

                        <td align="left" class="p-0"><?= $lap['nama_customer'] ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['qty'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['harga'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['subtotal'], '0', ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <td colspan="3" class="text-bold p-0">Sub Total</td>
            <td align="right" class="text-bold p-0"><?= number_format($totqty, '0', ',', '.') ?></td>
            <td></td>
            <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="3" class="text-bold p-0">Grand Total</td>
                <td align="right" class="text-bold p-0"><?= number_format($gtotqty, '0', ',', '.') ?></td>
                <td></td>
                <td align="right" class="text-bold p-0"><?= number_format($gtotinv, '0', ',', '.') ?></td>
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