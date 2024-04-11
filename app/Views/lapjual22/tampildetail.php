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
                    <th>No SO</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right" width=10%>Price</th>
                    <th class="text-right" width=10%>Amount</th>
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
                        <?php if ($lap['no_so'] != $noinv) { ?>
                            <?php if ($sw == 1) { ?>
                                <tr>
                                    <td colspan="6" class="p-0 text-right">Sub Total</td>
                                    <td align="right" class="p-0"><?= number_format($totamt, '0', ',', '.') ?></td>
                                </tr>
                                <?php if ($totppn > 0) { ?>
                                    <tr>
                                        <td colspan="6" class="p-0 text-right">Total PPN</td>
                                        <td align="right" class="p-0"><?= number_format($totppn, '0', ',', '.') ?></td>
                                    </tr>
                                <?php } ?>  
                                <?php if ($totnet > 0) { ?>
                                    <tr>
                                        <td colspan="6" class="p-0 text-right">Total SO</td>
                                        <td align="right" class="p-0"><?= number_format($totnet, '0', ',', '.') ?></td>
                                    </tr>
                                <?php } ?>
                                <?php $gtotinv = $gtotinv + $totnet; ?>


                                <tr>
                                    <td colspan="7"></td>
                                </tr>
                             <?php $totinv = 0; $totamt=0; $totppn=0; ?>
                    <?php } ?>

                <td align="left" class="p-0"><?= $lap['no_so'] ?></td>
                <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_so'])) ?></td>
                <td align="left" class="p-0"><?= $lap['nama_customer'] ?></td>

            <?php } else { ?>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
                <td align="left" class="p-0"></td>
            <?php } ?>
            <?php
                $totamt = $totamt + $lap['subtotal'];
                $gtotamt = $gtotamt + $lap['subtotal'];
                
                $totdpp = $lap['total_amount'];
                $totppn = $lap['total_ppn'];
                $totnet = $lap['total_so'];
            ?>

            <td align="left" class="p-0"><?= $lap['nama_barang'] ?></td>
            <td align="right" class="p-0"><?= number_format($lap['qty'], '0', ',', '.') ?></td>
            <td align="right" class="p-0"><?= number_format($lap['harga'], '0', ',', '.') ?></td>
            <td align="right" class="p-0"><?= number_format($lap['subtotal'], '0', ',', '.') ?></td>
 
            <?php $noinv = $lap['no_so'];
                    $sw = 1; ?>
            </tr>
        <?php endforeach; ?>

            </tbody>
            <?php $gtotinv = $gtotinv + $totnet; ?>

            <tr>
                <td colspan="6" class="text-right p-0">Sub Total</td>
                <td align="right" class="p-0"><?= number_format($totamt, '0', ',', '.') ?></td>
            </tr>
            <?php if ($totppn > 0) { ?>
                <tr>
                    <td colspan="6" class="p-0 text-right">Total PPN</td>
                    <td align="right" class="p-0"><?= number_format($totppn, '0', ',', '.') ?></td>
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
                <td colspan="5" class="text-bold text-right p-0"></td>
                <td class="text-bold p-0">Grand Total</td>
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