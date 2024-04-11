<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-sm-6">
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
                    <th>NAMA BARANG</th>
                    <th class="text-right">TOTAL QTY</th>
                    <th class="text-right">TOTAL RP</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totqty = 0;
                $totinv = 0;
                $gtotqty = 0;
                $gtotinv = 0;
                $kdsupp = '';
                $sw = 0;
                foreach ($laporan as $lap) : ?>
                    <?php if ($kdsupp != $lap['kode_supplier']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td class="text-bold p-0">SUB TOTAL</td>
                                <td align="right" class="text-bold p-0"><?= number_format($totqty, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                            </tr>
                            <?php
                            $totqty = 0;
                            $totinv = 0;
                            ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="3" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['nama_supplier'] ?></td>
                        </tr>
                        <?php $kdsupp = $lap['kode_supplier'] ?>
                    <?php endif; ?>

                    <tr>
                        <?php
                        $totqty = $totqty + $lap['totqty'];
                        $totinv = $totinv + $lap['totrp'];
                        $gtotqty = $gtotqty + $lap['totqty'];
                        $gtotinv = $gtotinv + $lap['totrp'];
                        $sw = 1;
                        ?>
                        <td align="left" class="p-0"><?= $lap['nama_baku'] ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['totqty'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['totrp'], '0', ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tr>
                <td class="text-bold p-0">SUB TOTAL</td>
                <td align="right" class="text-bold p-0"><?= number_format($totqty, '0', ',', '.') ?></td>
                <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td class="text-bold p-0">TOTAL</td>
                <td align="right" class="text-bold p-0"><?= number_format($gtotqty, '0', ',', '.') ?></td>
                <td align="right" class="text-bold p-0"><?= number_format($gtotinv, '0', ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
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