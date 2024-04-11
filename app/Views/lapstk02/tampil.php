<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-8">
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
                <tr class="bg-info text-white">
                    <td>TANGGAL</td>
                    <td>NO BUKTI</td>
                    <td>KETERANGAN</td>
                    <td class="text-right">MASUK</td>
                    <td class="text-right">KELUAR</td>
                    <td class="text-right">SALDO</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $totdbt = 0;
                $totcrd = 0;
                $sw = 0;
                $kdbarang = '';

                foreach ($laporan as $lap) : ?>
                    <?php if ($kdbarang != $lap['kode_barang']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td colspan="3" class="text-bold p-0">SUB TOTAL</td>
                                <td align="right" class="text-bold p-0"><?= number_format($totdbt, '0', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($totcrd, '0', ',', '.') ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                            </tr>
                            <?php
                            $totdbt = 0;
                            $totcrd = 0;
                            ?>
                        <?php endif; ?>

                        <tr>
                            <td colspan="6" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['nama_barang'] ?></td>
                        </tr>
                        <?php $kdbarang = $lap['kode_barang'];
                        $saldo = $lap['balance']; ?>
                    <?php endif; ?>

                    <tr>
                        <?php
                        $totdbt = $totdbt + $lap['stockin'];
                        $totcrd = $totcrd + $lap['stockout'];
                        $saldo  = $saldo + $lap['stockin'] - $lap['stockout'];
                        $sw = 1;
                        ?>

                        <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_bukti'])) ?></td>
                        <td align="left" class="p-0"><?= $lap['no_bukti'] ?></td>
                        <td align="left" class="p-0"><?= $lap['keterangan'] ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['stockin'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['stockout'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($saldo, '0', ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <td colspan="3" class="text-bold p-0">SUB TOTAL</td>
            <td align="right" class="text-bold p-0"><?= number_format($totdbt, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totcrd, '0', ',', '.') ?></td>
            <td></td>
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