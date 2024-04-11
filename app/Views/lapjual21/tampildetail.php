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
                <tr>
                    <th class="text-lg"><?= $divisi ?></th>
                </tr>

                 <tr class="bg-info text-white">
                    <th>No Invoice</th>
                    <th>Tanggal</th>
                    <th>Nama Customer</th>
                    <th>Nama Barang</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-right">Harga Jual</th>
                    <th class="text-right">Harga Beli</th>
                    <th class="text-right">Total Jual</th>
                    <th class="text-right">Total Beli</th>
                    <th class="text-right">Profit</th>

                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                    $totjual = 0;
                    $totbeli = 0;
                    $totprofit = 0;

                    foreach ($laporan as $lap) : ?>
                    <tr>
                        <td align="left" class="p-0"><?= $lap['no_invoice'] ?></td>
                        <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_invoice'])) ?></td>
                        <td align="left" class="p-0"><?= $lap['nama_customer'] ?></td>
                        <td align="left" class="p-0"><?= $lap['nama_barang'] ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['qty'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['harga'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['cogs'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['subtotal'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['qty']*$lap['cogs'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['subtotal'] - ($lap['qty']*$lap['cogs']) , '0', ',', '.') ?></td>

                        <?php
                            $totjual = $totjual + $lap['subtotal'];
                            $totbeli = $totbeli + ($lap['qty']*$lap['cogs']);
                        ?>
                    </tr>
                <?php endforeach; ?>

            </tbody>

            <tr>
                <td colspan="7" class="text-right p-0">Total</td>
                <td align="right" class="p-0"><?= number_format($totjual, '0', ',', '.') ?></td>
                <td align="right" class="p-0"><?= number_format($totbeli, '0', ',', '.') ?></td>
                <td align="right" class="p-0"><?= number_format($totjual-$totbeli, '0', ',', '.') ?></td>
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