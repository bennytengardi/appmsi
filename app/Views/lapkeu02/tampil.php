<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-10" style="font-size: 14px">
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
                <tr class="bg-info text-white text-center">
                    <th></th>
                    <th></th>
                    <th colspan="2" class="p-1">Beginning Balance</th>
                    <th colspan="2" class="p-1">Change</th>
                    <th colspan="2" class="p-1">Ending Balance</th>
                </tr>
                <tr class="bg-info text-white text-center">
                    <th class="p-1" width=7%>#Acct</th>
                    <th class="p-1" width=30%>Account Name</th>
                    <th class="p-1">Debit</th>
                    <th class="p-1">Credit</th>
                    <th class="p-1">Debit</th>
                    <th class="p-1">Credit</th>
                    <th class="p-1">Debit</th>
                    <th class="p-1">Credit</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totawldbt = 0;
                $totawlcrd = 0;
                $totdbt = 0;
                $totcrd = 0;
                $totakhdbt = 0;
                $totakhcrd = 0;
                foreach ($laporan as $lap) : ?>
                    <?php if ($lap['awldbt'] + $lap['awlcrd'] + $lap['dbt'] + $lap['crd'] + $lap['saldo_awal'] != 0) { ?>
                        <tr>
                            <?php
                            $totdbt = $totdbt + $lap['dbt'];
                            $totcrd = $totcrd + $lap['crd'];

                            if ($lap['position'] == 'DB') {
                                if ($lap['kode_account'] < '4000-000') {
                                    $totawldbt = $totawldbt + $lap['saldo_awal'] + $lap['awldbt'] - $lap['awlcrd'];
                                }
                                $totakhdbt = $totakhdbt + $lap['saldo_awal'] + $lap['awldbt'] + $lap['dbt'] - $lap['awlcrd'] - $lap['crd'];
                            } else {
                                if ($lap['kode_account'] < '4000-000') {
                                    $totawlcrd = $totawlcrd + $lap['saldo_awal'] + $lap['awlcrd'] - $lap['awldbt'];
                                }
                                $totakhcrd = $totakhcrd + $lap['saldo_awal'] + $lap['awlcrd'] + $lap['crd'] - $lap['awldbt'] - $lap['dbt'];
                            }
                            ?>

                            <td class="p-0"><?= $lap['kode_account'] ?></td>
                            <td class="p-0"><?= $lap['nama_account'] ?></td>
                            <?php if ($lap['position'] == 'DB') { ?>
                                <?php if ($lap['kode_account'] < '4000-000') { ?>
                                    <td class="text-right p-0"><?= number_format($lap['saldo_awal'] + $lap['awldbt'] - $lap['awlcrd'], '2', ',', '.') ?></td>
                                <?php } else { ?>
                                    <td class="text-right p-0">0</td>
                                <?php } ?>
                                <td class="text-right p-0">0</td>
                            <?php } else { ?>
                                <td class="text-right p-0">0</td>
                                <?php if ($lap['kode_account'] < '4000-000') { ?>
                                    <td class="text-right p-0"><?= number_format($lap['saldo_awal'] + $lap['awlcrd'] - $lap['awldbt'], '2', ',', '.') ?></td>
                                <?php } else { ?>
                                    <td class="text-right p-0">0</td>
                                <?php } ?>
                            <?php } ?>

                            <td class="text-right p-0"><?= number_format($lap['dbt'], '2', ',', '.') ?></td>
                            <td class="text-right p-0"><?= number_format($lap['crd'], '2', ',', '.') ?></td>

                            <?php if ($lap['position'] == 'DB') { ?>
                                <td class="text-right p-0"><?= number_format($lap['saldo_awal'] + $lap['awldbt'] + $lap['dbt'] - $lap['awlcrd'] - $lap['crd'], '2', ',', '.') ?></td>
                                <td class="text-right p-0">0</td>
                            <?php } else { ?>
                                <td class="text-right p-0">0</td>
                                <td class="text-right p-0"><?= number_format($lap['saldo_awal'] + $lap['awlcrd'] + $lap['crd'] - $lap['awldbt'] - $lap['dbt'], '2', ',', '.') ?></td>

                            <?php } ?>
                        </tr>
                    <?php } ?>
                <?php endforeach; ?>

            </tbody>
            <td colspan="2" class="text-bold p-0">Total</td>
            <td align="right" class="text-bold p-0"><?= number_format($totawldbt, '2', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totawlcrd, '2', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totdbt, '2', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totcrd, '2', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totakhdbt, '2', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totakhcrd, '2', ',', '.') ?></td>
            <tr>
                <td colspan="8"></td>
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