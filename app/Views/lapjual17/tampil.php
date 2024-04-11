<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<style>
    @media print {
        @page {
            size: landscape;
        }
    }
</style>
<div class="row justify-content-center">
    <div class="col-sm-12">

        <table class="table" style="font-size: 12px;">
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

            <thead >
                <tr>
                    <th class="text-lg"><?= $divisi ?></th>
                </tr>
                
                <tr class="bg-info text-white text-center" style="position: sticky; top: 0px; padding: 20px;">
                    <th>Date</th>
                    <th width="12%">Invoice#</th>
                    <th width="20%">Customer Name</th>
                    <th class="text-right" width="10%">Total Amount</th>
                    <th class="text-right" width="8%">Total Disc</th>
                    <th class="text-right" width="8%">Total DP</th>
                    <th class="text-right" width="10%">Total DPP</th>
                    <th class="text-right" width="8%">Total VAT</th>
                    <th class="text-right" width="8%">Expedition</th>
                    <th class="text-right" width="10%">Total Invoice</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totdpp = 0;
                $totdp  = 0;
                $totppn = 0;
                $totinv = 0;
                $totamt = 0;
                $totokr = 0;
                $totdis = 0;
                foreach ($laporan as $lap) : ?>
                    <tr>
                        <?php
                        $totamt = $totamt + $lap['total_amount'];
                        $totdis = $totdis + $lap['total_discount'];
                        $totdp  = $totdp  + $lap['total_dp'];
                        $totdpp = $totdpp + $lap['total_dpp'];
                        $totppn = $totppn + $lap['total_ppn'];
                        $totokr = $totokr + $lap['ongkir'];
                        $totinv = $totinv + $lap['total_invoice'];
                        ?>

                        <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_invoice']))?></td>
                        <td align="left" class="p-0"><?= $lap['no_invoice'] ?></td>
                        <!--<td align="left" class="p-0"><?= $lap['no_suratjln'] ?></td>-->
                        <td align="left" class="p-0"><?= $lap['nama_customer'] ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['total_amount'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['total_discount'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['total_dp'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['total_dpp'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['total_ppn'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['ongkir'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['total_invoice'], '0', ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <td colspan="3" class="text-bold p-0">Total</td>
            <td align="right" class="text-bold p-0"><?= number_format($totamt, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totdis, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totdp, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totdpp, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totppn, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totokr, '0', ',', '.') ?></td>
            <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
            <tr>
                <td colspan="10"></td>
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