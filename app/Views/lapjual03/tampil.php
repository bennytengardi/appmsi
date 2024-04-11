<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-8">

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
                    <th>Item Code</th>
                    <th>Descriptions</th>
                    <th class="text-right">Total Qty</th>
                    <th>Unit</th>
                    <th class="text-right">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totqty = 0;
                $totinv = 0;
                foreach ($laporan as $lap) : ?>
                    <tr>
                        <?php
                        $totqty = $totqty + $lap['totqty'];
                        $totinv = $totinv + $lap['totrp'];
                        ?>
                        <td class="p-0"><?= $lap['kode_barang'] ?></td>
                        <td class="p-0"><?= $lap['nama_barang'] ?></td>
                        <td class="p-0 text-right"><?= number_format($lap['totqty'], '0', ',', '.') ?></td>
                        <td class="p-0 text-center"><?= $lap['kode_satuan'] ?></td>
                        <td class="p-0 text-right"><?= number_format($lap['totrp'], '0', ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <td class="text-bold p-0">Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-bold text-right p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
            <tr>
                <td colspan="5"></td>
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