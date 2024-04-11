<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-6">

        <table class="table" style="font-size: 13px;">
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
                    <th>Kode Account</th>
                    <th>Nama Account</th>
                    <th class="text-right">Total Biaya</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totalbiaya = 0;
                foreach ($laporan as $lap) : ?>
                    <tr>
                        <?php
                        $totalbiaya = $totalbiaya + $lap['totbiaya'];
                        ?>

                        <td align="left" class="p-0"><?= $lap['kode_account'] ?></td>
                        <td align="left" class="p-0"><?= $lap['nama_account'] ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['totbiaya'], '0', ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <td colspan="2" class="text-bold p-0">Total</td>
            <td align="right" class="text-bold p-0"><?= number_format($totalbiaya, '0', ',', '.') ?></td>
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