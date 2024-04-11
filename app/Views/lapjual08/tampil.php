<?= $this->extend('layout/template2') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-12">

        <table class="table">
            <center style="margin-top: 20px;">
                <h4><?= $title1 ?></h4>
                <h5 style="margin-top: -10px;"><b><?= $title ?></b></h5>
                <p style="margin-top: -8px;"><?= date('d-M-Y', strtotime(set_value('sampai'))) ?>
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
                    <th>No Invoice</th>
                    <th>Tgl Invoice</th>
                    <th>Jatuh Tempo</th>
                    <th class="text-right">Total Invoice</th>
                    <th class="text-right">Total Bayar</th>
                    <th class="text-right">Sisa Hutang</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totinv = 0;
                $totbyr = 0;
                $totsisa = 0;
                $gtotinv = 0;
                $gtotbyr = 0;
                $gtotsisa = 0;
                $sw = 0;
                $kdcust = '';
                foreach ($laporan as $lap) : ?>
                    <?php if ($kdcust != $lap['kode_customer']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td colspan="3" class="p-0">SUB TOTAL</td>
                                <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($totbyr, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($totsisa, '0', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                            </tr>
                            <?php
                            $totinv = 0;
                            $totbyr = 0;
                            $totsisa = 0;

                            ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="6" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['nama_customer'] ?></td>
                        </tr>
                        <?php $kdcust = $lap['kode_customer'] ?>
                    <?php endif; ?>

                    <tr>
                        <?php
                        $totinv = $totinv + $lap['total_invoice'];
                        $totbyr = $totbyr + $lap['total_bayar'];
                        $totsisa = $totsisa + ($lap['total_invoice'] - $lap['total_bayar']);
                        $gtotinv = $gtotinv + $lap['total_invoice'];
                        $gtotbyr = $gtotbyr + $lap['total_bayar'];
                        $gtotsisa = $gtotsisa + ($lap['total_invoice'] - $lap['total_bayar']);
                        $sw = 1;
                        ?>

                        <td align="left" class="p-0"><?= $lap['no_invoice'] ?></td>
                        <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_invoice'])) ?></td>
                        <?php if ($lap['due_date'] == null) { ?>
                            <td></td>
                        <?php } else { ?>
                            <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['due_date'])) ?></td>
                        <?php } ?>
                        <td align="right" class="p-0"><?= number_format($lap['total_invoice'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['total_bayar'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['total_invoice'] - $lap['total_bayar'], '0', ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <td colspan="3" class="text-bold p-0">SUB TOTAL</td>
            <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totbyr, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totsisa, '0', ',', '.') ?></td>
            <tr>
                <td colspan="6"></td>
            </tr>
            <?php if ($kd == 'ALL') { ?>
                <td colspan="2" class="text-bold p-0">GRAND TOTAL</td>
                <td align="right" class="text-bold p-0"><?= number_format($gtotinv, '0', ',', '.') ?></td>
                <td align="right" class="text-bold p-0"><?= number_format($gtotbyr, '0', ',', '.') ?></td>
                <td align="right" class="text-bold p-0"><?= number_format($gtotsisa, '0', ',', '.') ?></td>
            <?php } ?>
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