<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-10" style="font-size: 14px">
        <table class="table">
            <center style="margin-top: 20px;">
                <h4><?= $title1 ?></h4>
                <h5 style="margin-top: -10px;"><b><?= $title ?></b></h5>
                <p style="margin-top: -8px;"><?= date('d-M-Y', strtotime($dari)) ?> S/D <?= date('d-M-Y', strtotime($sampai)) ?>
                </p>
            </center>
           
            <thead>
                <tr class="bg-info text-white">
                    <th width=8%>TANGGAL</th>
                    <th width=12%>NO VOUCHER</th>
                    <th>KETERANGAN</th>
                    <th class="text-right" width=12%>DEBET</th>
                    <th class="text-right" width=12%>CREDIT</th>
                    <th class="text-right" width=12%>SALDO</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totdbt = 0;
                $totcrd = 0;
                $sw = 0;
                $kdacct = '';
                foreach ($laporan as $lap) : ?>
                    <?php if ($kdacct != $lap['kode_account']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td colspan="3" class="text-bold p-0">SUB TOTAL</td>
                                <td align="right" class="text-bold p-0"><?= number_format($totdbt, '2', ',', '.') ?></td>
                                <td align="right" class="text-bold p-0"><?= number_format($totcrd, '2', ',', '.') ?></td>
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
                            <td colspan="6" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['kode_account'] ?> - <?= $lap['nama_account'] ?></td>
                        </tr>
                        <?php $kdacct = $lap['kode_account'];
                        $saldo = $lap['saldo']; ?>
                    <?php endif; ?>

                    <tr>
                        <?php
                        $totdbt = $totdbt + $lap['debet'];
                        $totcrd = $totcrd + $lap['credit'];
                        if ($lap['position'] == 'DB') {
                            $saldo  = $saldo + $lap['debet'] - $lap['credit'];
                        } else {
                            $saldo = $saldo + $lap['credit'] - $lap['debet'];
                        }
                        $sw = 1;
                        ?>

                        <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_bukti'])) ?></td>
                        <td align="left" class="p-0"><?= $lap['no_bukti'] ?></td>
                        <td align="left" class="p-0"><?= $lap['keterangan'] ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['debet'], '2', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['credit'], '2', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($saldo, '2', ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <td colspan="3" class="text-bold p-0">TOTAL</td>
            <td align="right" class="text-bold p-0"><?= number_format($totdbt, '2', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totcrd, '2', ',', '.') ?></td>
            <td></td>
            <tr>
                <td colspan="6"></td>
            </tr>
        </table>
    </div>
</div>
<script>
    window.print();
</script>
<?= $this->endSection() ?>