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
            <h4>SALES ORDER</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="row">
                <div class="col-3">
                    <p>No Sales Ord</p>
                </div>
                <div class="col-8">
                    <p><strong>:&nbsp&nbsp <?= $msalesord['no_so'] ?></strong></p>
                </div>
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-3">
                    <p>Tgl Sales Ord</p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp<?= date('d-M-Y', strtotime($msalesord['tgl_so'])) ?></p>
                </div>
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-3">
                    <p>No. PO </p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp <?= $msalesord['no_po'] ?></p>
                </div>
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-3">
                    <p>Nama Proyek</p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp <?= $msalesord['nama_proyek'] ?></p>
                </div>
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-3">
                    <p>Nama Pemesan</p>
                </div>
                <div class="col-8">
                    <p>:&nbsp&nbsp <?= $msalesord['nama_pemesan'] ?></p>
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
                    <p><strong><?= $msalesord['nama_customer'] ?></strong></p>
                </div>                
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-12">
                    <p><?= $msalesord['address1'] ?></p>
                </div>                
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-12">
                    <p><?= $msalesord['address2'] ?></p>
                </div>                
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-12">
                    <p><?= $msalesord['address3'] ?></p>
                </div>                
            </div>
            <div class="row" style="margin-top: -15px;">
                <div class="col-12">
                    <p>Tlp. <?= $msalesord['no_handphone'] ?></p>
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
                foreach ($dsalesord as $dtl) : 
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
                <?php for ($x = $no; $x < 34; $x++) { ?>
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
                <td colspan="2" class="text-right py-0" style="border-left: black;">TOTAL</td>
                <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black"><?= number_format($msalesord['total_amount'], 0, ',', '.') ?></td>
            </tr>
                <tr>
                    <td colspan="3"></td>
                    <td colspan="2" class="text-right py-0" style="border-left: black;">PPN 11%</td>
                    <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black"><?= number_format($msalesord['total_ppn'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td colspan="2" class="text-right text-bold py-0" style="border-left: black;">GRAND TOTAL</td>
                    <td class="text-right text-md text-bold py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black"><?= number_format($msalesord['total_so'], 0, ',', '.') ?></td>
                </tr>
        </table>
    </div>

    <div class="row" style="margin-top: -80px;">
        <div class="col-4">
            <p><i><b>Catatan:</b></i> </p>
        </div>
        <div class="col-7">
            <p><i><b>Keterangan:</b></i> </p>
        </div>
    </div>
    
    <div class="row" style="margin-top: -18px;">
        <div class="col-2">
            <p>1. Syarat Pembayaran</p>
        </div>
        <div class="col-3">
            <p>: &nbsp&nbsp&nbsp<?= $msalesord['pembayaran']?></p>
        </div>
        <div class="col-5">
            <p><?= $msalesord['catatan1']?></p>
        </div>
    </div>
    <div class="row" style="margin-top: -18px;">
        <div class="col-2">
            <p>2. Tanggal Pengiriman</p>
        </div>
        <div class="col-3">
            <p>: &nbsp&nbsp&nbsp<?= $msalesord['tgl_kirim']?></p>
        </div>
        <div class="col-5">
            <p><?= $msalesord['catatan2']?></p>
        </div>
        
    </div>
    <div class="row" style="margin-top: -18px;">
        <div class="col-2">
            <p>3. Lokasi Pengiriman</p>
        </div>
        <div class="col-3">
            <p>: &nbsp&nbsp&nbsp<?= $msalesord['lokasi_kirim']?></p>
        </div>
        <div class="col-5">
            <p><?= $msalesord['catatan3']?></p>
        </div>
    </div>
    <div class="row" style="margin-top: -18px;">
        <div class="col-2">
            <p></p>
        </div>
        <div class="col-3">
            <p></p>
        </div>
        <div class="col-5">
            <p><?= $msalesord['catatan4']?></p>
        </div>
    </div>

    <div class="row mt-3 text-center">
        <div class="col-3">
            <p>Wiraniaga</p>
        </div>
        <div class="col-3">
            <p>Kepala Divisi</p>
        </div>
        <div class="col-3">
            <p>Menyetujui</p>
        </div>
        <div class="col-3">
            <p>Mengetahui</p>
        </div>
    </div>
    <br><br>
    <div class="row mt-5 text-center">
        <div class="col-3">
            <p>---------------</p>
        </div>
        <div class="col-3">
            <p>( Irawan/Jony )</p>
        </div>
        <div class="col-3">
            <p>( Kamdani )</p>
        </div>
        <div class="col-3">
            <p>( Andriansjah Anwar )</p>
        </div>
    </div>
    <div class="row mt-2">
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