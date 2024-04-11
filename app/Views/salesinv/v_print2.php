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
        <div class="col-3">
            <h4>INVOICE</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="row">
                <div class="col-3">
                    <p>No Invoice</p>
                </div>
                <div class="col-8">
                    <p><strong>:&nbsp&nbsp <?= $minvoice['no_invoice'] ?></strong></p>
                </div>
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-3">
                    <p>Tanggal </p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp<?= date('d-M-Y', strtotime($minvoice['tgl_invoice'])) ?></p>
                </div>
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-3">
                    <p>No. DO </p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp <?= $minvoice['no_suratjln'] ?></p>
                </div>
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-3">
                    <p>No. PO </p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp <?= $minvoice['no_po'] ?></p>
                </div>
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-3">
                    <p>Pembayaran</p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp <?= $minvoice['pembayaran'] ?></p>
                </div>
            </div>   
            <div class="row" style="margin-top: -15px;">
                <div class="col-3">
                    <p>Keterangan </p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp<?= $minvoice['keterangan'] ?></p>
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
                    <p><strong><?= $minvoice['nama_customer'] ?></strong></p>
                </div>                
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-12">
                    <p><?= $minvoice['address1'] ?></p>
                </div>                
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-12">
                    <p><?= $minvoice['address2'] ?></p>
                </div>                
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-12">
                    <p><?= $minvoice['address3'] ?></p>
                </div>                
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-12">
                    <p>Tlp. <?= $minvoice['telephone'] ?></p>
                </div>                
            </div>
        </div>       
    </div>

    <div class="row">
        <table class="table table table-borderless" id="data_table">
            <thead class="text-center text-bold">
                <tr>
                    <th width="3%" style="border: 1px solid black;" class="py-0">NO</th>
                    <th width="14%" style="border: 1px solid black;" class="py-0">KODE BRG</th>
                    <th style="border: 1px solid black;" class="py-0">NAMA BARANG</th>
                    <th width="10%" style="border: 1px solid black;" class="py-0">QTY</th>
                    <th width="11%" style="border: 1px solid black;" class="py-0">HARGA</th>
                    <th width="14%" style="border: 1px solid black;" class="py-0">JUMLAH</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;
                $i = 0;
                foreach ($dinvoice as $dtl) : 
                     $i++;
                ?>
                    <tr>
                        <td class="py-0 text-center" style="vertical-align: middle;border-left:1px solid black;"> <?= $no++ ?></td>
                        <td class="py-0" style="border-left: 1px solid black;"><?= $dtl['kode_barang'] ?></td>
                        <td class="py-0" style="border-left: 1px solid black;"><?= $dtl['nama_barang'] ?></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"><?= number_format($dtl['qty'], 0, '.', ',') ?> &nbsp <?= $dtl['kode_satuan']?>&nbsp&nbsp&nbsp</td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"><?= number_format($dtl['harga'], 0, '.', ',') ?></td>
                        <td class="text-right py-0" style="border-left: 1px solid black; border-right: 1px solid black;">
                            <?= number_format($dtl['qty'] * $dtl['harga'], 0, '.', ',') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <?php if ($no < 10) { ?>
                <?php for ($x = $no; $x < 10; $x++) { ?>
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
                <?php for ($x = $no; $x < 40; $x++) { ?>
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
                <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($minvoice['total_amount'], 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="text-right py-0" style="border-left: black;">DISCOUNT</td>
                <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($minvoice['total_discount'], 0, ',', '.') ?></td>
            </tr>
            <?php if ($minvoice['total_dp'] > 0) { ?>
                <tr>
                    <td colspan="3"></td>
                    <td colspan="2" class="text-right py-0" style="border-left: black;">TOTAL DP</td>
                    <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($minvoice['total_dp'], 0, ',', '.') ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="text-right py-0" style="border-left: black;">NET SALES</td>
                <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($minvoice['total_dpp'], 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="text-right py-0" style="border-left: black;">PPN</td>
                <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($minvoice['total_ppn'], 0, ',', '.') ?></td>
            </tr>
            <?php if ($minvoice['ongkir'] > 0) { ?>            
                <tr>
                    <td colspan="3"></td>
                    <td colspan="2" class="text-right py-0" style="border-left: black;">ONGKOS KIRIM</td>
                    <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($minvoice['ongkir'], 0, ',', '.') ?></td>
                </tr>
            <?php } ?>

            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="text-right text-bold py-0" style="border-left: black;">TOTAL</td>
                <td class="text-right text-md text-bold py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($minvoice['total_invoice'], 0, ',', '.') ?></td>
            </tr>

        </table>
    </div>

    <div class="row" style="margin-top: -130px;">
        <div class="col-6">
            <p><i><b>Term Conditions:</b></i> </p>
        </div>
        <div class="col-2 text-center">
            <p><i><b>Hormat Kami,</b></i> </p>
        </div>

    </div>
    <div class="row" style="margin-top: -18px;">
        <div class="col-6">
            <p>1. Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
        </div>
    </div>
    <div class="row" style="margin-top: -18px;">
        <div class="col-6">
            <p>2. Apabila ada pembatalan, pembayaran uang muka yang sudah</p>
        </div>
        <div class="col-3">
        </div>
    </div>
    <div class="row" style="margin-top: -18px;">
        <div class="col-6">
            <p>&nbsp&nbsp&nbsp&nbspmasuk tidak dapat dikembalikan</p>
        </div>
        <div class="col-3">
        </div>
    </div>
    <div class="row" style="margin-top: -18px;">
        <div class="col-6">
            <p>3. Pembayaran via transfer harus sesuai dengan jumlah yang tertera</p>
        </div>
        <div class="col-3">
        </div>
    </div>
    <div class="row" style="margin-top: -18px;">
        <div class="col-6">
            <p>&nbsp&nbsp&nbsp&nbspdi faktur, dan kami tidak menanggung biaya transfer.</p>
        </div>
    </div>
    <div class="row" style="margin-top: 0px;">
        <div class="col-6">
            <p>&nbsp&nbsp&nbsp&nbspPembayaran dapat di transfer melalui :</p>
        </div>
        <div class="col-3">
        </div>
    </div>
    <div class="row" style="margin-top: -18px;">
        <div class="col-6">
            <p>&nbsp&nbsp&nbsp&nbspBank Panin Cab.KCP Niaga Mediterania</p>
        </div>
        <div class="col-2 text-center">
            <p><b><u>( Kamdani )</u></b></p>
        </div>
    </div>
    <div class="row" style="margin-top: -18px;">
        <div class="col-6">
            <p>&nbsp&nbsp&nbsp&nbspNo.Rekening : 018 580 0005</p>
        </div>
        <div class="col-2 text-center">
            <p><b>Direktur</b></p>
        </div>
    </div>
    <div class="row" style="margin-top: -18px;">
        <div class="col-6">
            <p>&nbsp&nbsp&nbsp&nbspAtas Nama: PT. Multi Screen Indonesia</p>
        </div>
        <div class="col-3">
        </div>
    </div>

    <!--<?php for ($x = 12; $x < 50; $x++) { ?>-->
    <!--    <div class="row">-->
    <!--        <p></p>-->
    <!--    </div>-->
    <!--<?php } ?>-->
    <div class="row">
        <div class="col-12 text-right">
            <p>PREPARED BY ACCOUNTING APPS</p>
        </div>
    </div>
 
</div>

<script>
    window.print();
</script>
<?= $this->endSection() ?>