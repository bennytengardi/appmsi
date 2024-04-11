<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-8">
        <table class="table">
            <center style="margin-top: 20px;">
                <h4><?= $title1 ?></h4>
                <h5 style="margin-top: -10px;"><b><?= $title ?></b></h5>
                <p style="margin-top: -8px;"><?= date('d-M-Y', strtotime($sampai)) ?>
                </p>
            </center>
            <div class="row">
                <div class="col-sm-2 text-md text-bold">
                    <?= $kodedivisi ?>
                </div>
                <div class="col-sm-10">
                    <div class="btn-group float-right">
                        <button class="btn btn-primary btn-sm mb-3 mr-2 btncetak" style="margin-bottom: 20px;"><i class="fa fa-print"></i> Print</button>
                    </div>

                </div>

            </div>

            <thead>
                <tr class="bg-info text-center text-white">
                    <th>No. SO</th>
                    <th>Tgl. SO</th>
                    <th class="text-center">Total SO</th>
                    <th class="text-center">Total Invoice</th>
                    <th class="text-center">Belum Invoice</th>
                </tr>
            </thead>

            <tbody>
                <?php $no = 1;

                $sw = 0;
                $kdcust = '';
                foreach ($laporan as $lap) : ?>
                    <?php if ($kdcust != $lap['nama_customer'] . $lap['kode_customer']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td colspan="5" class="p-0"></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="5" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['nama_customer'] ?></td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <?php
                            $sw = 1;
                        ?>
                        <!--<?php if ($lap['total_so'] > $lap['realisasi']) { ?>-->
                            <td align="left" class="p-0"><?= $lap['no_so'] ?></td>
                            <td class="p-0 text-center"><?= date('d-M-Y', strtotime($lap['tgl_so'])) ?></td>
                            <td class="p-0 text-right"><?= number_format($lap['total_so'], '0', ',', '.') ?>
                            <td class="p-0 text-right"><?= number_format($lap['realisasi'], '0', ',', '.') ?>
                            <td class="p-0 text-right"><?= number_format($lap['total_so'] - $lap['realisasi']) ?></td>
                        <!--<?php } ?>-->
                    </tr>
                    <?php $kdcust  = $lap['nama_customer'] . $lap['kode_customer'] ?>
                <?php endforeach; ?>
                
            </tbody>
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