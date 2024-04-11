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
                    <th>KODE BARANG</th>
                    <th>NAMA BARANG</th>
                    <th class="text-right">TOTAL QTY</th>
                    <th class="text-right">TOTAL RP</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totqty = 0;
                $totinv = 0;
                $kdcust = '';
                $sw = 0;
                foreach ($laporan as $lap) : ?>
                    <?php if ($kdcust != $lap['kode_salesman']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td colspan="2" class="text-bold p-0">SUB TOTAL</td>
                                <td align="right" class="text-bold p-0"><?= number_format($totqty, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <?php
                            $totqty = 0;
                            $totinv = 0;
                            ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="4" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['nama_salesman'] ?></td>
                        </tr>
                        <?php $kdcust = $lap['kode_salesman'] ?>
                    <?php endif; ?>

                    <tr>
                        <?php
                        $totqty = $totqty + $lap['totqty'];
                        $totinv = $totinv + $lap['totrp'];
                        $sw = 1;
                        ?>
                        <td align="left" class="p-0"><?= $lap['kode_barang'] ?></td>
                        <td align="left" class="p-0"><?= $lap['nama_barang'] ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['totqty'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['totrp'], '0', ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <td colspan="2" class="text-bold p-0">SUB TOTAL</td>
            <td align="right" class="text-bold p-0"><?= number_format($totqty, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
            <tr>
                <td colspan="4"></td>
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