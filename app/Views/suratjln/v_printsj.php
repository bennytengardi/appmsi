<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container bg-white">
    <div class="row">
        <div class="col-3">
            <img src="<?= base_url() ?>/assets/img/logo msi.png" alt=""  style="width: 250px; height: 140px" >
        </div>
        <div class="col-6">
            <p style="margin-left: 25px; font-size:20px;">PT. MULTI SCREEN INDONESIA</h4>
            <p style="margin-top: -22px; margin-left: 25px;">PIK Avenue Mall Level 6</p>
            <p style="margin-top: -22px; margin-left: 25px;">Jl Pantai Indah Barat No 1 RT 001/RW 006</p>
            <p style="margin-top: -22px; margin-left: 25px;">Keluarahan Kamal Muara Kecamatan Penjaringan</p>
            <p style="margin-top: -22px; margin-left: 25px;">Kota Administrasi Jakarta Utara</p>
            <p style="margin-top: -22px; margin-left: 25px;">Tlp : +6221 2267 4247 / Fax: +6221 2267 4247</p>
            <p style="margin-top: -22px; margin-left: 25px;">Email: support@multiscreenindonesia.com</p>
            <p style="margin-top: -22px; margin-left: 25px;">Website: www.multiscreenindonesia.com</p>
        </div>
        <div class="col-3">
            <h4>DELIVERY ORDER</h4>
        </div>
    </div>
    
    <div class="row">
        <div class="col-6">
            <div class="row">
                <div class="col-2">
                    <p>No DO</p>
                </div>
                <div class="col-8">
                    <p><strong>:&nbsp&nbsp <?= $msuratjln['no_suratjln'] ?></strong></p>
                </div>
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-2">
                    <p>Tanggal </p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp<?= date('d-M-Y', strtotime($msuratjln['tgl_suratjln'])) ?></p>
                </div>
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-2">
                    <p>No. PO </p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp <?= $msuratjln['no_po'] ?></p>
                </div>
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-2">
                    <p>Marketing </p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp<?= $msuratjln['project'] ?></p>
                </div>
            </div>   
            <div class="row" style="margin-top: -15px;">
                <div class="col-2">
                    <p>Keterangan </p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp<?= $msuratjln['remark'] ?></p>
                </div>
            </div>
        </div>       
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <p><strong>Kepada Yth,</strong></p>
                </div>                
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-12">
                    <p><strong><?= $msuratjln['nama_customer'] ?></strong></p>
                </div>                
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-12">
                    <p><?= $msuratjln['address1'] ?></p>
                </div>                
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-12">
                    <p><?= $msuratjln['address2'] ?></p>
                </div>                
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-12">
                    <p>Ph. <?= $msuratjln['telephone'] ?></p>
                </div>                
            </div>
        </div>       
    </div>

    <div class="row">
        <table class="table table table-borderless" id="data_table">
            <thead class="text-center text-bold">
                <tr>
                    <th width="12%" style="border: 1px solid black;" class="py-0">QTY</th>
                    <th width="18%" style="border: 1px solid black;" class="py-0">ITEM NO</th>
                    <th style="border: 1px solid black;" class="py-0">ITEM NAME</th>
                    <!--<th width="25%" style="border: 1px solid black;" class="py-0">REMARK</th>-->
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;
                $i = 0;
                foreach ($dsuratjln as $dtl) :  ?>
                    <tr>
                        <td class="text-right py-0" style="border-left: 1px solid black;"><?= number_format($dtl['qty'], 0, '.', ',') ?> &nbsp <?= $dtl['kode_satuan']?>&nbsp&nbsp&nbsp</td>
                        <td class="py-0" style="border-left: 1px solid black;"><?= $dtl['kode_barang'] ?></td>
                        <td class="py-0" style="border-left: 1px solid black; border-right: 1px solid black;"><?= $dtl['nama_barang'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <?php if ($no < 9) { ?>
                <?php for ($x = $no; $x < 9; $x++) { ?>
                    <tr>
                        <td class="py-0 text-center" style="vertical-align: middle;border-left:1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
                        <!--<td class="text-right py-0" style="border-left: 1px solid black;"></td>-->
                        <td class="text-right py-0" style="border-left: 1px solid black; border-right: 1px solid black;">
                            &nbsp
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <?php for ($x = $no; $x < 45; $x++) { ?>
                    <tr>
                        <td class="py-0 text-center" style="vertical-align: middle;border-left:1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
                        <!--<td class="text-right py-0" style="border-left: 1px solid black;"></td>-->
                        <td class="text-right py-0" style="border-left: 1px solid black; border-right: 1px solid black;">
                            &nbsp
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <th colspan="3" style="border-top: 1px solid black;" class="py-0"></th>
            </tr>
        </table>
    </div>


    <?php if ($msuratjln['catatan1']) { ?>
        <div class="row">
            <div class="col-12">
                <p>Catatan :</p>            
            </div>
        </div>
        <div class="row">
            <div class="col-12" style="margin-top: -18px;">
                <p><?= $msuratjln['catatan1'] ?></p>            
            </div>
        </div>
    <?php } ?>
    
    <?php if ($msuratjln['catatan2']) { ?>
        <div class="row">
            <div class="col-12" style="margin-top: -18px;">
                <p><?= $msuratjln['catatan2'] ?></p>            
            </div>
        </div>
    <?php }  ?>

    <?php if ($msuratjln['catatan3']) { ?>
        <div class="row">
            <div class="col-12" style="margin-top: -18px;">
                <p><?= $msuratjln['catatan3'] ?></p>            
            </div>
        </div>
    <?php }  ?>
    <?php if ($msuratjln['catatan4']) { ?>
        <div class="row">
            <div class="col-12" style="margin-top: -18px;">
                <p><?= $msuratjln['catatan4'] ?></p>            
            </div>
        </div>
    <?php }  ?>

    <div class="row">
        <div class="col-4 text-center">
            <p>Diterima Oleh</p>
        </div>
        <div class="col-4 text-center">
            <p>Dikirim Oleh</p>
        </div>
        <div class="col-4 text-center">
            <p>Mengetahui</p>
        </div>
    </div>
    <br>
    <div class="row mt-5">
        <div class="col-4 text-center">
            <p>(________________)</p>
        </div>
        <div class="col-4 text-center">
            <p>(________________)</p>
        </div>
        <div class="col-4 text-center">
            <p>(________________)</p>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 text-right">
            <p>PREPARED BY ACCOUNTING APPS</p>
        </div>
    </div>
 
</div>

<script>
    window.print();
</script>
<?= $this->endSection() ?>