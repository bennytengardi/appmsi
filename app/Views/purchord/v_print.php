<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container bg-white">
    <div class="row">
        <div class="col-2">
            <img src="<?= base_url() ?>/assets/img/logo msi.png" alt=""  style="width: 200px; height: 140px" >            
        </div>
        <div class="col-7">
            <h4 style="margin-left: 35px;">PT. MULTI SCREEN INDONESIA</h4>
            <p style="margin-top: -12px; margin-left: 35px;">PIK Avenue Mall Level 6</p>
            <p style="margin-top: -22px; margin-left: 35px;">Jl Pantai Indah Barat No 1 RT 001/RW 006</p>
            <p style="margin-top: -22px; margin-left: 35px;">Keluarahan Kamal Muara Kecamatan Penjaringan</p>
            <p style="margin-top: -22px; margin-left: 35px;">Kota Administrasi Jakarta Utara</p>
            <p style="margin-top: -22px; margin-left: 35px;">Tlp : +6221 2267 4247 / Fax: +6221 2267 4247</p>
            <p style="margin-top: -22px; margin-left: 35px;">Email: support@multiscreenindonesia.com</p>
            <p style="margin-top: -22px; margin-left: 35px;">Website: www.multiscreenindonesia.com</p>
        </div>        
        <div class="col-3 text-right text-bold mb-2">
            <h4>PURCHASE ORDER</h4>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-2">
            <p>No PO</p>
        </div>
        <div class="col-5">
            <p><strong>:&nbsp&nbsp <?= $mpo['no_po'] ?></strong></p>
        </div>

        <div class="col-5">
            <p><strong>Order To,</strong></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p>Date PO </p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp <?= date('d-M-Y', strtotime($mpo['tgl_po'])) ?></p>
        </div>
        <div class="col-5">
            <p><strong><?= $mpo['nama_supplier'] ?></strong></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p>Currency </p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp <?= $mpo['currency'] ?></p>
        </div>
        <div class="col-5">
            <p><?= $mpo['address1'] ?></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p>Payment </p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp <?= $mpo['termin'] ?></p>
        </div>
        <div class="col-5">
            <p><?= $mpo['address2'] ?></p>
        </div>
    </div>
    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p>Pengiriman </p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp <?= $mpo['tgl_kirim'] ?></p>
        </div>
        <div class="col-5">
            <p><?= $mpo['address3'] ?></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p>Description </p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp<?= $mpo['keterangan'] ?></p>
        </div>
        <div class="col-5">
            <p>Up. : &nbsp<?= $mpo['nama_up'] ?></p>
        </div>
    </div>
    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p>Delivery Address</p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp <?= $mpo['addkrm1'] ?></p>
        </div>
        <div class="col-5">
            <p>Telp : &nbsp<?= $mpo['telepon_up'] ?></p>
        </div>

    </div>
    
    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p></p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp <?= $mpo['addkrm2'] ?></p>
        </div>
    </div>
    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p></p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp <?= $mpo['addkrm3'] ?></p>
        </div>
    </div>

    <div class="row mt-2">
        <table class="table table table-borderless" id="data_table">
            <thead class="text-center text-bold bg-primary">
                <tr>
                    <th width="3%" style="border: 1px solid black;" class="py-0">NO</th>
                    <th width="14%" style="border: 1px solid black;" class="py-0">ITEM NO</th>
                    <th style="border: 1px solid black;" class="py-0">ITEM NAME</th>
                    <th width="13%" style="border: 1px solid black;" class="py-0">QTY</th>
                    <th width="12%" style="border: 1px solid black;" class="py-0">PRICE</th>
                    <th width="12%" style="border: 1px solid black;" class="py-0">AMOUNT</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;
                $i = 0;
                foreach ($dpo as $dtl) : 
                     $i++;
                ?>
                    <tr>
                        <td class="py-0 text-center" style="border-left:1px solid black;"> <?= $no++ ?></td>
                        <td class="py-0" style="border-left: 1px solid black;"><?= $dtl['kode_barang'] ?></td>
                        <td class="py-0" style="border-left: 1px solid black;"><?= $dtl['nama_barang'] ?></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"><?= number_format($dtl['qty'], 2, '.', ',') ?> &nbsp <?= $dtl['kode_satuan']?>&nbsp&nbsp&nbsp</td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"><?= number_format($dtl['harga'], 2, '.', ',') ?></td>
                        <td class="text-right py-0" style="border-left: 1px solid black; border-right: 1px solid black;">
                            <?= number_format($dtl['qty'] * $dtl['harga'], 2, '.', ',') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <?php if ($no < 12) { ?>
                <?php for ($x = $no; $x < 12; $x++) { ?>
                    <tr>
                        <td class="py-0 text-center" style="vertical-align: middle;border-left:1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
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
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"></td>
                        <td class="text-right py-0" style="border-left: 1px solid black; border-right: 1px solid black;">
                            &nbsp
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <th colspan="6" style="border-top: 1px solid black;" class="py-0"></th>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="text-right py-0" style="border-left: black;">SUB TOTAL</td>
                <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($mpo['total_dpp'], 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="text-right py-0" style="border-left: black;">TAXABLE</td>
                <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($mpo['total_ppn'], 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="text-right text-bold py-0" style="border-left: black;">GRAND TOTAL</td>
                <td class="text-right text-bold py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($mpo['total_po'], 2, ',', '.') ?></td>
            </tr>

        </table>
    </div>

    <div class="row" style="margin-top: -80px;">
        <div class="col-2 text-center">
            <p>Prepared by,</p>
        </div>
        <div class="col-2 text-center">
            <p>Approved by,</p>
        </div>
        <div class="col-4 text-center">
            <p>Acknowledge by, </p>
        </div>
    </div>
    <br><br><br>
    <div class="row">
        <div class="col-2 text-center">
            <p>(......................)</p>
        </div>
        <div class="col-2 text-center">
            <p>(......................)</p>
        </div>
        <div class="col-2 text-center">
            <p>( Kamdani )</p>
        </div>
        <div class="col-2 text-center">
            <p>( Andriansjah )</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
            <p>PREPARED BY ACCOUNTING APPS</p>
        </div>
    </div>
   

    <br>
</div>

<script>
    window.print();
</script>
<?= $this->endSection() ?>