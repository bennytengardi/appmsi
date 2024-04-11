<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-6">
        <table class="table">
            <center style="margin-top: 20px;">
                <h4><?= $title1 ?></h4>
                <h5 style="margin-top: -10px;"><b><?= $title ?></b></h5>
                <p style="margin-top: -8px;">As Of : <?= date('d-M-Y', strtotime(set_value('sampai'))) ?>
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
                    <td colspan="2" class="text-bold p-0 text-md">AKTIVA</td>
                </tr>
                <tr>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $taktiva = 0;
                $tpassiva = 0;
                $sw = 0;
                $kdgrup = '';
                $nmgrup = '';
                $rec = '';

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
                            <?php if ($kdgrup == "12") { ?>
                                <tr>
                                    <td class="text-bold p-0">TOTAL AKTIVA</td>
                                    <td class="text-bold text-right p-0"><?= number_format($taktiva, '2', ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan='2' class="text-bold p-0 text-md">PASSIVA</td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>

                            <?php } ?>
                            <?php
                            $total = 0;
                            ?>
                        <?php endif; ?>


                        <tr>
                            <td colspan="2" class="text-bold text-danger p-0 mt-2" style="font-size: 16px;"><?= $lap['nama_group'] ?></td>
                        </tr>
                        <?php $kdgrup = $lap['kode_group'];
                        $total = 0;
                        ?>
                    <?php endif; ?>

                    <tr>
                        <?php
                        if ($lap['position'] == 'DB') {
                            $saldo  = $lap['saldoawal'] + $lap['trxdebet'] - $lap['trxcredit'];
                        } else {
                            $saldo =  $lap['saldoawal'] + $lap['trxcredit'] - $lap['trxdebet'];
                        }

                        if ($lap['rectype'] == '1') {
                            $taktiva  = $taktiva + $saldo;
                        } else {
                            $tpassiva = $tpassiva + $saldo;
                        }
                        $nmgrup = $lap['nama_group'];
                        $sw = 1;
                        ?>
                        <?php if ($saldo != 0) { ?>
                            <td class="p-0"><?= $lap['nama_account'] ?></tdn=>
                            <td class="text-right p-0"><?= number_format($saldo, '2', ',', '.') ?></td>
                            <?php $total = $total + $saldo; ?>
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
                <td class="text-bold p-0">TOTAL PASSIVA</td>
                <td class="text-right text-bold p-0"><?= number_format($tpassiva, '2', ',', '.') ?></td>
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