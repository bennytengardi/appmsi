<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-12">
        <table class="table table-bordered">
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
                    <th width=10%>Cust#</th>
                    <th>Customer Name</th>
                    <th width=12% class="text-right">Opening Balance</th>
                    <th width=12% class="text-right">Sales Invoice</th>
                    <th width=12% class="text-right">Sales Receipt</th>
                    <th width=12% class="text-right">Ending Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totawl = 0;
                $totdbt = 0;
                $totcrd = 0;
                $totakh = 0;
                $gtotawl = 0;
                $gtotdbt = 0;
                $gtotcrd = 0;
                $gtotakh = 0;
                $kdsales = '';
                $sw = 0;
                foreach ($laporan as $lap) : ?>

                    <?php if ($lap['awal'] + $lap['awldbt'] + $lap['awlcrd'] + $lap['dbt'] + $lap['crd'] != 0) { ?>
                        <tr>
                            <?php
                            $sw = 1;
                            $totawl = $totawl + $lap['awal'] + $lap['awldbt'] - $lap['awlcrd'];
                            $totdbt = $totdbt + $lap['dbt'];
                            $totcrd = $totcrd + $lap['crd'];
                            $totakh = $totakh + $lap['awal'] + $lap['awldbt'] - $lap['awlcrd'] + $lap['dbt'] - $lap['crd'];
                            $gtotawl = $gtotawl + $lap['awal'] + $lap['awldbt'] - $lap['awlcrd'];
                            $gtotdbt = $gtotdbt + $lap['dbt'];
                            $gtotcrd = $gtotcrd + $lap['crd'];
                            $gtotakh = $gtotakh + $lap['awal'] + $lap['awldbt'] - $lap['awlcrd'] + $lap['dbt'] - $lap['crd'];
                            ?>
                            <td class="p-0"><?= $lap['kode_customer'] ?></td>
                            <td class="p-0"><?= $lap['nama_customer'] ?></td>
                            <td align="right" class="p-0"><?= number_format($lap['awal'] + $lap['awldbt'] - $lap['awlcrd'], '0', ',', '.') ?></td>
                            <td align="right" class="p-0"><?= number_format($lap['dbt'], '0', ',', '.') ?></td>
                            <td align="right" class="p-0"><?= number_format($lap['crd'], '0', ',', '.') ?></td>
                            <td align="right" class="p-0"><?= number_format($lap['awal'] + $lap['awldbt'] - $lap['awlcrd'] + $lap['dbt'] - $lap['crd'], '0', ',', '.') ?></td>
                        </tr>
                    <?php } ?>
                <?php endforeach; ?>
            </tbody>
            <td colspan="2" class="text-bold p-0">Total</td>
            <td align="right" class="text-bold p-0"><?= number_format($totawl, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totdbt, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totcrd, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totakh, '0', ',', '.') ?></td>
            <?php
            $totawl = 0;
            $totdbt = 0;
            $totcrd = 0;
            $totakh = 0;
            ?>
            <tr>
                <td colspan="7"></td>
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