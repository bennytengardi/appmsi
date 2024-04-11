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
                    <th>No SrtJln</th>
                    <th>Tgl SrtJln</th>
                    <th>No. SO</th>
                    <th>Customer Name</th>
                    <th>Description</th>
                    <th class="text-right">Qty</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                    $sw = 0;
                    $tgl = '';
                    $noinv = '';
                    foreach ($laporan as $lap) : ?>
                    <tr>
                        <?php if ($lap['no_suratjln'] != $noinv) { ?>
                            <?php if ($sw == 1) { ?>
                                <tr>
                                    <td colspan="7"></td>
                                </tr>
                             <?php $totinv = 0; $totamt=0; $totppn=0; ?>
                    <?php } ?>

                <td align="left" class="p-0"><?= $lap['no_suratjln'] ?></td>
                <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_suratjln'])) ?></td>
                <td align="left" class="p-0"><?= $lap['no_so'] ?></td>
                <td align="left" class="p-0"><?= $lap['nama_customer'] ?></td>
            <?php } else { ?>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
            <?php } ?>

            <td align="left" class="p-0"><?= $lap['nama_barang'] ?></td>
            <td align="right" class="p-0"><?= number_format($lap['qty'], '0', ',', '.') ?></td>
            <td align="center" class="p-0"><?= $lap['kode_satuan'] ?></td>

            <?php $noinv = $lap['no_suratjln'];
                    $sw = 1; ?>
            </tr>
        <?php endforeach; ?>

            </tbody>

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