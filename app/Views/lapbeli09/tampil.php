<?= $this->extend('layout/template2') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-12">

        <table class="table">
            <center style="margin-top: 20px;">
                <h4><?= $title1 ?></h4>
                <h5 style="margin-top: -10px;"><b><?= $title ?></b></h5>
                <p style="margin-top: -8px;">TAHUN : <?= $tahun ?>
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
                <tr class="bg-info text-white" style="font-size: 12px;">
                    <!-- <th>Kode Customer</th> -->
                    <th>Nama Supplier</th>
                    <th class="text-right">Januari</th>
                    <th class="text-right">Februari</th>
                    <th class="text-right">Maret</th>
                    <th class="text-right">April</th>
                    <th class="text-right">Mei</th>
                    <th class="text-right">Juni</th>
                    <th class="text-right">Juli</th>
                    <th class="text-right">Agustus</th>
                    <th class="text-right">September</th>
                    <th class="text-right">Oktober</th>
                    <th class="text-right">Nopember</th>
                    <th class="text-right">Desember</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $tot1 = 0;
                $tot2 = 0;
                $tot3 = 0;
                $tot4 = 0;
                $tot5 = 0;
                $tot6 = 0;
                $tot7 = 0;
                $tot8 = 0;
                $tot9 = 0;
                $tot10 = 0;
                $tot11 = 0;
                $tot12 = 0;
                $gtotal = 0;


                foreach ($laporan as $lap) : ?>
                    <tr style="font-size: 12px;">
                        <?php
                        $total = $lap['beli1'] + $lap['beli2'] + $lap['beli3'] + $lap['beli4'] + $lap['beli5'] + $lap['beli6'] + $lap['beli7'] + $lap['beli8'] + $lap['beli9'] + $lap['beli10'] + $lap['beli11'] + $lap['beli12'];
                        ?>

                        <?php if ($total > 0) : ?>
                            <td class="p-0"><?= $lap['nama_supplier'] ?></td>
                            <td class="text-right p-0"><?= number_format($lap['beli1'], '0', '.', ',') ?></td>
                            <td class="text-right p-0"><?= number_format($lap['beli2'], '0', '.', ',') ?></td>
                            <td class="text-right p-0"><?= number_format($lap['beli3'], '0', '.', ',') ?></td>
                            <td class="text-right p-0"><?= number_format($lap['beli4'], '0', '.', ',') ?></td>
                            <td class="text-right p-0"><?= number_format($lap['beli5'], '0', '.', ',') ?></td>
                            <td class="text-right p-0"><?= number_format($lap['beli6'], '0', '.', ',') ?></td>
                            <td class="text-right p-0"><?= number_format($lap['beli7'], '0', '.', ',') ?></td>
                            <td class="text-right p-0"><?= number_format($lap['beli8'], '0', '.', ',') ?></td>
                            <td class="text-right p-0"><?= number_format($lap['beli9'], '0', '.', ',') ?></td>
                            <td class="text-right p-0"><?= number_format($lap['beli10'], '0', '.', ',') ?></td>
                            <td class="text-right p-0"><?= number_format($lap['beli11'], '0', '.', ',') ?></td>
                            <td class="text-right p-0"><?= number_format($lap['beli12'], '0', '.', ',') ?></td>
                            <td class="text-right p-0"><?= number_format($total, '0', '.', ',') ?></td>
                        <?php endif; ?>
                    </tr>

                    <?php
                    $tot1  = $tot1 + $lap['beli1'];
                    $tot2  = $tot2 + $lap['beli2'];
                    $tot3  = $tot3 + $lap['beli3'];
                    $tot4  = $tot4 + $lap['beli4'];
                    $tot5  = $tot5 + $lap['beli5'];
                    $tot6  = $tot6 + $lap['beli6'];
                    $tot7  = $tot7 + $lap['beli7'];
                    $tot8  = $tot8 + $lap['beli8'];
                    $tot9  = $tot9 + $lap['beli9'];
                    $tot10  = $tot10 + $lap['beli10'];
                    $tot11  = $tot11 + $lap['beli11'];
                    $tot12  = $tot12 + $lap['beli12'];
                    $gtotal = $gtotal + $total
                    ?>

                <?php endforeach; ?>
            </tbody>
            <tr style="font-size: 12px; color: red;">
                <td class="text-bold p-0">TOTAL</td>
                <td class="text-right p-0"><?= number_format($tot1, '0', '.', ',') ?></td>
                <td class="text-right p-0"><?= number_format($tot2, '0', '.', ',') ?></td>
                <td class="text-right p-0"><?= number_format($tot3, '0', '.', ',') ?></td>
                <td class="text-right p-0"><?= number_format($tot4, '0', '.', ',') ?></td>
                <td class="text-right p-0"><?= number_format($tot5, '0', '.', ',') ?></td>
                <td class="text-right p-0"><?= number_format($tot6, '0', '.', ',') ?></td>
                <td class="text-right p-0"><?= number_format($tot7, '0', '.', ',') ?></td>
                <td class="text-right p-0"><?= number_format($tot8, '0', '.', ',') ?></td>
                <td class="text-right p-0"><?= number_format($tot9, '0', '.', ',') ?></td>
                <td class="text-right p-0"><?= number_format($tot10, '0', '.', ',') ?></td>
                <td class="text-right p-0"><?= number_format($tot11, '0', '.', ',') ?></td>
                <td class="text-right p-0"><?= number_format($tot12, '0', '.', ',') ?></td>
                <td class="text-right p-0"><?= number_format($gtotal, '0', '.', ',') ?></td>
            </tr>
            <tr>
                <td colspan="14"></td>
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