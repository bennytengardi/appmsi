<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<table class="table" style="font-size: 12px">
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
        <tr class="bg-info text-white" style="position: sticky; top: 0px; padding: 20px;">
            <th>No Invoice</th>
            <th>Tanggal</th>
            <th>Nama Customer</th>
            <th>Nama Barang</th>
            <th class="text-right">Qty</th>
            <th class="text-center">Satuan</th>
            <th class="text-right">Harga</th>
            <th class="text-right" width=8%>SubTotal</th>
            <th class="text-right" width=8%>Down Payment</th>
            <th class="text-right" width=8%>Total DPP</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php $no = 1;
        $totinv = 0;
        $stotinv = 0;
        $stotdp = 0;
        $gtotinv = 0;
        $totdp = 0;
        $tgl = '';
        $noinv = '';
        $sw = 0;
        $kdcust = '';
        
            foreach ($laporan as $lap) : ?>
                <?php if ($kdcust != $lap['kode_salesman']) : ?>
                    <tr>
                        <td colspan="8" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['nama_salesman'] ?></td>
                    </tr>
                    <?php $kdcust = $lap['kode_salesman'] ?>
                <?php endif; ?>
    
                <?php if ($noinv != $lap['no_invoice']) : ?>
                    <?php if ($sw == 1) : ?>
                        <tr>
                            <td colspan="7" class="text-bold p-0">Total Per Invoice</td>
                            <td align="right" class="text-bold p-0"><?= number_format($stotinv, '0', ',', '.') ?></td>
                            <td align="right" class="text-bold p-0"><?= number_format($stotdp, '0', ',', '.') ?></td>
                            <td align="right" class="text-bold p-0"><?= number_format($stotinv - $stotdp, '0', ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="10"></td>
                        </tr>
                        <?php $stotinv = 0; ?>
                    <?php endif; ?>
                    
                    <?php 
                        $no_invoice = $lap['no_invoice']; 
                    ?>
                <?php endif; ?>
                
                <tr>
                    <?php
                    $totinv = $totinv + $lap['subtotal'];
                    $stotinv = $stotinv + $lap['subtotal'];
                    $gtotinv = $gtotinv + $lap['subtotal'];
                    $stotdp = $lap['total_dp']; 
                    $sw = 1;
                    ?>
    
                    <?php if ($lap['no_invoice'] != $noinv) { ?>
                        <td align="left" class="p-0"><?= $lap['no_invoice'] ?></td>
                        <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_invoice'])) ?></td>
                        <td align="left" class="p-0"><?= $lap['nama_customer'] ?></td>
                        <?php $noinv = $lap['no_invoice']; $totdp = $totdp + $stotdp; ?>
                    <?php } else { ?>
                        <td align="left" class="p-0"></td>
                        <td align="left" class="p-0"></td>
                        <td align="left" class="p-0"></td>
                    <?php } ?>
    
                    <td align="left" class="p-0"><?= $lap['nama_barang'] ?></td>
                    <td align="right" class="p-0"><?= number_format($lap['qty'], '0', ',', '.') ?></td>
                    <td align="center" class="p-0"><?= $lap['kode_satuan'] ?></td>
                    <td align="right" class="p-0"><?= number_format($lap['harga'], '0', ',', '.') ?></td>
                    <td align="right" class="p-0"><?= number_format($lap['subtotal'], '0', ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        
    </tbody>
    
    <td colspan="7" class="p-0 text-bold">Total Per Invoice</td>
    <td align="right" class="p-0 text-bold"><?= number_format($stotinv, '0', ',', '.') ?></td>
    <td align="right" class="text-bold p-0"><?= number_format($stotdp, '0', ',', '.') ?></td>
    <td align="right" class="text-bold p-0"><?= number_format($stotinv - $stotdp, '0', ',', '.') ?></td>
    
    <tr>
        <td colspan="10"></td>
    </tr>
    
    <td colspan="7" class="text-bold p-0">Total Per Salesman</td>
    <td align="right" class="text-bold p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
    <td align="right" class="text-bold p-0"><?= number_format($totdp, '0', ',', '.') ?></td>
    <td align="right" class="text-bold p-0"><?= number_format($totinv - $totdp, '0', ',', '.') ?></td>

</table>
<script>
    $('.btncetak').click(function() {
        $(this).hide();
        window.print();
        $(this).show();
    });
</script>
<?= $this->endSection() ?>