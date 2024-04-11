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

            <thead style="position: sticky; top: 0; padding: 0px;">
                <tr class="bg-info text-white">
                    <th>Invoice No</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                    $totinv = 0;
                    $gtotinv = 0;
                    $totamt = 0;
                    $gtotamt = 0;
                    $totppn = 0;
                    $gtotppn = 0;

                    $sw = 0;
                    $tgl = '';
                    $noinv = '';
                    foreach ($laporan as $lap) : ?>
                    <tr>
                        <?php if ($lap['no_invoice'] != $noinv) { ?>
                            <?php if ($sw == 1) { ?>
                                <tr>
                                    <td colspan="6" class="p-0 text-right">Sub Total</td>
                                    <td align="right" class="p-0"><?= number_format($totamt, '0', ',', '.') ?></td>
                                </tr>
                                <?php if ($totdisc > 0) { ?>
                                    <tr>
                                        <td colspan="6" class="p-0 text-right">Total Disc</td>
                                        <td align="right" class="p-0"><?= number_format($totdisc, '0', ',', '.') ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if ($totdp > 0) { ?>
                                    <tr>
                                        <td colspan="6" class="p-0 text-right">Total DP</td>
                                        <td align="right" class="p-0"><?= number_format($totdp, '0', ',', '.') ?></td>
                                    </tr>
                                <?php } ?>    
                                <?php if ($totdpp > 0) { ?>
                                    <tr>
                                        <td colspan="6" class="p-0 text-right">Total DPP</td>
                                        <td align="right" class="p-0"><?= number_format($totdpp, '0', ',', '.') ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if ($totppn > 0) { ?>
                                    <tr>
                                        <td colspan="6" class="p-0 text-right">Total PPN</td>
                                        <td align="right" class="p-0"><?= number_format($totppn, '0', ',', '.') ?></td>
                                    </tr>
                                <?php } ?>  
                                <?php if ($ongkir > 0) { ?>
                                    <tr>
                                        <td colspan="6" class="p-0 text-right">Ongkos Kirim</td>
                                        <td align="right" class="p-0"><?= number_format($ongkir, '0', ',', '.') ?></td>
                                    </tr>
                                <?php } ?>  

                                <?php if ($totnet > 0) { ?>
                                    <tr>
                                        <td colspan="6" class="p-0 text-right">Total Invoice</td>
                                        <td align="right" class="p-0"><?= number_format($totnet, '0', ',', '.') ?></td>
                                    </tr>
                                <?php } ?>
                                <?php $gtotinv = $gtotinv + $totnet; ?>


                                <tr>
                                    <td colspan="7"></td>
                                </tr>
                             <?php $totinv = 0; $totamt=0; $totppn=0; ?>
                    <?php } ?>

                <td align="left" class="p-0"><?= $lap['no_invoice'] ?></td>
                <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_invoice'])) ?></td>
                <td align="left" class="p-0"><?= $lap['nama_customer'] ?></td>

            <?php } else { ?>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
            <?php } ?>
            <?php
                $totamt = $totamt + $lap['subtotal'];
                $gtotamt = $gtotamt + $lap['subtotal'];
                // $totppn = $totppn + $lap['subtotal'] * 0.11;
                // $gtotppn = $gtotppn + $lap['subtotal'] * 0.11;
                // $totinv = $totinv + $lap['subtotal'] * 1.11;
                // $gtotinv = $gtotinv + $lap['subtotal'] * 1.11;
                
                $totdp = $lap['total_dp'];
                $totdpp = $lap['total_dpp'];
                $totdisc = $lap['total_discount'];
                $totppn = $lap['total_ppn'];
                $totnet = $lap['total_invoice'];
                $ongkir = $lap['ongkir'];

            ?>

            <td align="left" class="p-0"><?= $lap['nama_barang'] ?></td>
            <td align="right" class="p-0"><?= number_format($lap['qty'], '0', ',', '.') ?></td>
            <td align="right" class="p-0"><?= number_format($lap['harga'], '0', ',', '.') ?></td>
            <td align="right" class="p-0"><?= number_format($lap['subtotal'], '0', ',', '.') ?></td>
 
            <?php $noinv = $lap['no_invoice'];
                    $sw = 1; ?>
            </tr>
        <?php endforeach; ?>

            </tbody>
            <?php $gtotinv = $gtotinv + $totnet; ?>

            <tr>
                <td colspan="6" class="text-right p-0">Sub Total</td>
                <td align="right" class="p-0"><?= number_format($totamt, '0', ',', '.') ?></td>
            </tr>
            <?php if ($totdisc > 0) { ?>
                <tr>
                    <td colspan="6" class="p-0 text-right">Total Disc</td>
                    <td align="right" class="p-0"><?= number_format($totdisc, '0', ',', '.') ?></td>
                </tr>
            <?php } ?>
            <?php if ($totdp > 0) { ?>
                <tr>
                    <td colspan="6" class="p-0 text-right">Total DP</td>
                    <td align="right" class="p-0"><?= number_format($totdp, '0', ',', '.') ?></td>
                </tr>
            <?php } ?>    
            <?php if ($totdpp > 0) { ?>
                <tr>
                    <td colspan="6" class="p-0 text-right">Total DPP</td>
                    <td align="right" class="p-0"><?= number_format($totdpp, '0', ',', '.') ?></td>
                </tr>
            <?php } ?>
            <?php if ($totppn > 0) { ?>
                <tr>
                    <td colspan="6" class="p-0 text-right">Total PPN</td>
                    <td align="right" class="p-0"><?= number_format($totppn, '0', ',', '.') ?></td>
                </tr>
            <?php } ?>    
            <?php if ($ongkir > 0) { ?>
                <tr>
                    <td colspan="6" class="p-0 text-right">Ongkos Kirim</td>
                    <td align="right" class="p-0"><?= number_format($ongkir, '0', ',', '.') ?></td>
                </tr>
            <?php } ?>  

            <?php if ($totnet > 0) { ?>
                <tr>
                    <td colspan="6" class="p-0 text-right">Total Invoice</td>
                    <td align="right" class="p-0"><?= number_format($totnet, '0', ',', '.') ?></td>
                </tr>
            <?php } ?>

            <tr>
                <td colspan="7"></td>
            </tr>

            <tr>
                <td colspan="6" class="text-bold text-left p-0">Grand Total</td>
                <td align="right" class="p-0"><?= number_format($gtotinv, '0', ',', '.') ?></td>
            </tr>

            <tr>
                <td colspan="9"></td>
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