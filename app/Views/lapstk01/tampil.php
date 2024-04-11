<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-10">
        <table class="table">
            <center style="margin-top: 20px;">
                <h4><?= $title1 ?></h4>
                <h5 style="margin-top: -10px;"><b><?= $title ?></b></h5>
                <p style="margin-top: -8px;"> S/D <?= date('d-M-Y', strtotime(set_value('sampai'))) ?>
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
                    <th class="text-right">SLD AWAL</th>
                    <th class="text-right">MASUK</th>
                    <th class="text-right">ADJUST(+)</th>
                    <th class="text-right">KELUAR</th>
                    <th class="text-right">ADJUST(-)</th>
                    <th class="text-right">SLD AKHIR</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totawl = 0;
                $totdbt = 0;
                $totcrd = 0;
                $totakh = 0;
                $kdmerk = '';
                foreach ($laporan as $lap) : ?>

                    <?php
                    $totawl = $lap['awal'] + $lap['awldbt'] + $lap['awldbt2'] + $lap['awldbt3'] - $lap['awlcrd'] - $lap['awlcrd2'];
                    $totdbt = $lap['dbt'] + $lap['dbt2'] + $lap['dbt3'];
                    $totcrd = $lap['crd'] + $lap['crd2'];
                    $totakh = $totawl + $totdbt - $totcrd;
                    ?>


                    <?php if ($totawl + $totdbt + $totcrd + $totakh != 0) { ?>
                        <?php if ($kdmerk != $lap['kode_merk']) : ?>
                            <tr>
                                <td colspan="9"></td>
                            </tr>
                            <tr>
                                <td colspan="9" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['nama_merk'] ?></td>
                            </tr>
                            <?php $kdmerk = $lap['kode_merk'] ?>
                        <?php endif; ?>

                        <tr>
                            <td align="left" class="p-0"><?= $lap['kode_barang'] ?></td>
                            <td align="left" class="p-0"><?= $lap['nama_barang'] ?></td>
                            <td align="right" class="p-0"><?= number_format($totawl, '0', ',', '.') ?></td>
                            <td align="right" class="p-0"><?= number_format($lap['dbt'], '0', ',', '.') ?></td>
                            <td align="right" class="p-0"><?= number_format($lap['dbt3'], '0', ',', '.') ?></td>
                            <td align="right" class="p-0"><?= number_format($lap['crd'], '0', ',', '.') ?></td>
                            <td align="right" class="p-0"><?= number_format($lap['crd2'], '0', ',', '.') ?></td>
                            <td align="right" class="p-0"><?= number_format($totakh, '0', ',', '.') ?></td>
                        </tr>
                    <?php } ?>
                <?php endforeach; ?>
            </tbody>
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