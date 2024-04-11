<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-10">

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
                    <th>Kode Account</th>
                    <th>Nama Account</th>
                    <th>Tgl Bukti</th>
                    <th>No Bukti</th>
                    <th>Keterangan</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                    $totamt = 0;
                    $gtotamt = 0;
                    $sw = 0;
                    $tgl = '';
                    $noinv = '';
                    foreach ($laporan as $lap) : ?>
                    <tr>
                        <?php if ($lap['kode_account'] != $noinv) { ?>
                            <?php if ($sw == 1) { ?>
                                <tr>
                                    <td colspan="5" class="p-0 text-right">Sub Total</td>
                                    <td align="right" class="p-0"><?= number_format($totamt, '0', ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                </tr>
                             <?php $totamt=0; ?>
                    <?php } ?>

                <td align="left" class="p-0"><?= $lap['kode_account'] ?></td>
                <td align="left" class="p-0"><?= $lap['nama_account'] ?></td>

            <?php } else { ?>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
            <?php } ?>
            <?php
                $totamt = $totamt + $lap['jumlah'];
                $gtotamt = $gtotamt + $lap['jumlah'];
            ?>

            <td align="left" class="p-0"><?=  date('d-M-Y', strtotime($lap['tgl_bukti']))  ?></td>
            <td align="left" class="p-0"><?= $lap['no_bukti'] ?></td>
            <td align="left" class="p-0"><?= strtolower($lap['keterangan']) ?></td>
            <td align="right" class="p-0"><?= number_format($lap['jumlah'], '0', ',', '.') ?></td>

            <?php $noinv = $lap['kode_account'];
                    $sw = 1; ?>
            </tr>
        <?php endforeach; ?>

            </tbody>

            <tr>
                <td colspan="5" class="text-right p-0">Sub Total</td>
                <td align="right" class="p-0"><?= number_format($totamt, '0', ',', '.') ?></td>
            </tr>
                <tr>
                    <td colspan="5" class="p-0 text-right">Total Biaya</td>
                    <td align="right" class="p-0"><?= number_format($gtotamt, '0', ',', '.') ?></td>
                </tr>
            <tr>
                <td colspan="6"></td>
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