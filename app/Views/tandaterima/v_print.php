<?= $this->extend('layout/template2') ?>
<?= $this->section('content') ?>

<div class="container" style="font-size: 16px;">
    <?php $page = 1; ?>
    <div class="detail">
        <div class="row">
            <table class="table table table-borderless" id="data_table" style="font-size: 20px;">
                <thead>
                    <?php $page = 1; ?>
                    <tr class="text-bold">
                        <td colspan="3">
                            <h4><?= session()->get('nama_company') ?></h4>
                        </td>
                        <td colspan="3" class="text-right">
                            <h4>TANDA TERIMA FAKTUR</h4>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="6" class="py-0">
                            <p style="margin-top: -22px;font-size:14px"><?= session()->get('address1') ?></p>
                        </td>
                    </tr>
                   
                    <tr>
                        <td colspan="3" class="py-0 text-bold">
                            <p style="margin-top: -14px;">Supplier,</p>
                        </td>
                        
                        <td colspan="2" class="py-0 text-right">
                            <p style="margin-top: -14px;">No Tnd Terima</p>
                        </td>
                        <td colspan="2" class="text-bold py-0">
                            <p style="margin-top: -14px;">: <?= $tandaterima['no_tandaterima'] ?></p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" class="py-0 text-bold">
                            <p style="margin-top: -18px;"><?= $tandaterima['nama_supplier'] ?></p>
                        </td>
                        <td colspan="2" class="py-0 text-right">
                            <p style="margin-top: -18px;">Tgl Tnd Terima</p>
                        </td>
                        <td colspan="2" class="text-bold py-0">
                            <p style="margin-top: -18px;">: <?= date('d-M-Y', strtotime($tandaterima['tgl_tandaterima'])) ?></p>
                        </td>
                    </tr>

                   
                    <tr>
                        <td colspan="3" class="py-0 text-bold">
                            <p style="margin-top: -18px;"><?= $tandaterima['address1'] ?></p>
                        </td>
                    </tr>

                    <tr class=" text-center text-bold">
                        <th width="3%"  style="border: 1px solid black;" class="py-0">NO</th>
                        <th style="border: 1px solid black;" class="py-0">NO INVOICE</th>
                        <th width="8%"  style="border: 1px solid black;" class="py-0">TGL INVOICE</th>
                        <th width="12%"  style="border: 1px solid black;" class="py-0">SUPP INVOICE</th>
                        <th width="12%" style="border: 1px solid black;" class="py-0">TOTAL INVOICE</th>
                        <th width="12%" style="border: 1px solid black;" class="py-0">POTONGAN</th>
                        <th width="12%" style="border: 1px solid black;" class="py-0">TOTAL TT</th>
                        
                    </tr>
                </thead>
                

                <tbody>
                    <?php
                    $no = 1;
                    $i = 0;
                    $total_potongan = 0;
                    $total_amount = 0;
                    $brs = 0;
                    foreach ($dtandaterima as $dtl) :  ?>
                        <?php $i++;
                        $total_amount = $total_amount + $dtl['jumlah_bayar'];
                        $total_potongan = $total_potongan + $dtl['potongan'];
                        ?>
                        <tr>
                            <td class="p-0 text-center" style="vertical-align: middle;border-left:1px solid black;"> <?= $no++ ?></td>
                            <td class="p-0" style="border-left: 1px solid black;"><?= $dtl['no_invoice'] ?></td>
                            <td class="p-0" style="border-left: 1px solid black;"><?= date('d-M-Y', strtotime($dtl['tgl_invoice'])) ?></td>  
                            <td class="p-0" style="border-left: 1px solid black;"><?= $dtl['invoice_supp']?></td>
                            <td class="text-right p-0" style="border-left: 1px solid black;"><?= number_format($dtl['total_invoice'], 0, '.', ',') ?>&nbsp</td>
                            <td class="text-right p-0" style="border-left: 1px solid black;"><?= number_format($dtl['potongan'], 0, '.', ',') ?>&nbsp</td>
                            <td class="text-right p-0" style="border-left: 1px solid black;border-right: 1px solid black;"><?= number_format($dtl['jumlah_bayar'],0, '.', ',') ?>&nbsp</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                
               
               
                <?php for ($i = $no - 1; $i < 12; $i++) { ?>
                    <tr>
                        <td class="py-0 text-center" style="vertical-align: middle;border-left:1px solid black;"></td>
                        <td class="py-0" style="border-left: 1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black; border-right: 1px solid black;">
                            &nbsp
                        </td>
                    </tr>
                <?php } ?>
                    
                    
               
                <tr>
                    <th colspan="2" style="border-top: 1px solid black;" class="py-0">Tgl Kembali :  </th>
                    <th style="border-top: 1px solid black;margin-left: -30px;" class="py-0">Dibuat Oleh</th>
                    <th style="border-top: 1px solid black;" class="py-0">Penerima</th>
                    <th style="border-top: 1px solid black;" class="py-0 text-right">TOTAL</th>
                    <td class="text-right text-bold py-0" style="border: 1px solid black;"><?= number_format($total_potongan, 0, '.', ',') ?></td>
                    <td class="text-right text-bold py-0" style="border: 1px solid black;"><?= number_format($total_amount, 0, '.', ',') ?></td>
                </tr>
                
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr>
                    <th colspan="2" style="border: 0px solid black;  class="py-0"></th>
                    <th style="border: 0px solid black;" class="py-0">(...........................)</th>
                    <th style="border: 0px solid black;" class="py-0">(...........................)</th>
                </tr>
                
            </table>
        </div>
    </div>

</div>

<script>
    window.print();
</script>
<?= $this->endSection() ?>