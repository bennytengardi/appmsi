<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-6">
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
            </thead>
            <tbody>
                <?php
                $total = 0;
                $totalrl = 0;
                $sw = 0;
                $kdgrup = '';
                foreach ($laporan as $lap) : ?>
                    <?php if ($kdgrup != $lap['kode_group']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td class="text-bold p-0">TOTAL <?= $nmgrup ?></td>
                                <td class="text-bold text-right p-0"><?= number_format($total, '2', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>


                            <?php
                            $total = 0;
                            ?>
                        <?php endif; ?>

                        <?php if ($lap['kode_group'] == '710') { ?>
                            <tr>
                                <td class="text-bold p-0">LABA/RUGI KOTOR</td>
                                <td class="text-bold text-right p-0"><?= number_format($totalrl, '2', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td colspan="2" class="text-bold text-danger p-0" style="font-size: 16px;"><?= $lap['nama_group'] ?></td>
                        </tr>
                        <?php $kdgrup = $lap['kode_group'];
                        $total = 0;
                        ?>
                    <?php endif; ?>

                    <tr>
                        <?php
                        if ($lap['position'] == 'DB') {
                            $saldo  = $lap['dbt'] - $lap['crd'];
                        } else {
                            $saldo =  $lap['crd'] - $lap['dbt'];
                        }
                        $total  = $total + $saldo;
                        $totalrl = $totalrl + $lap['crd'] - $lap['dbt'];
                        $nmgrup = $lap['nama_group'];
                        $sw = 1;
                        ?>
                        <?php if ($saldo != 0) { ?>
                            <td class="p-0"><?= $lap['nama_account'] ?></tdn=>
                            <td class="text-right p-0"><?= number_format($saldo, '2', ',', '.') ?></td>
                        <?php } ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <td class="text-bold p-0">TOTAL <?= $nmgrup ?></td>
            <td class="text-right text-bold p-0"><?= number_format($total, '2', ',', '.') ?></td>
            <tr>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td class="text-bold p-0">TOTAL RUGI/LABA</td>
                <td class="text-right text-bold p-0"><?= number_format($totalrl, '2', ',', '.') ?></td>
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