<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container bg-white">
    <div class="row">
        <div class="col-2">
            <img src="<?= base_url() ?>/assets/img/logo msi.png" alt=""  style="width: 180px; height: 140px" >
        </div>
        <div class="col-8 mt-2">
            <div class="row" style="margin-left: 10px">
                <div class="col-8">
                    <h4>PT. MULTI SCREEN INDONESIA</h4>
                </div>
            </div>
            <div class="row" style="margin-top: -12px;margin-left: 10px;">
                <div class="col-8">
                    <p>PIK Avenue Mall Level 6</p>
                </div>
            </div>
            <div class="row" style="margin-top: -22px;margin-left: 10px;">
                <div class="col-8">
                    <p>Jl Pantai Indah Barat No 1 RT 001/RW 006</p>
                </div>
            </div>            
            <div class="row" style="margin-top: -22px;margin-left: 10px">
                <div class="col-8">
                    <p>Keluarahan Kamal Muara Kecamatan Penjaringan</p>
                </div>
            </div>
            <div class="row" style="margin-top: -22px;margin-left: 10px">
                <div class="col-8">
                    <p>Kota Administrasi Jakarta Utara</p>
                </div>
            </div>
            <div class="row" style="margin-top: -22px;margin-left: 10px">
                <div class="col-8">
                    <p>Tlp : +6221 2267 4247 / Fax: +6221 2267 4247</p>
                </div>
            </div>
            <div class="row" style="margin-top: -22px;margin-left: 10px">
                <div class="col-8">
                    <p>Email: support@multiscreenindonesia.com</p>
                </div>
            </div>
            <div class="row" style="margin-top: -22px;margin-left: 10px">
                <div class="col-8">
                    <p>Website: www.multiscreenindonesia.com</p>
                </div>
            </div>
            
        </div>
        <div class="col-12 text-right text-bold" style="margin-top: -150px;">
            <h4>DELIVERY ORDER</h4>
        </div>
    </div>
    

    <div class="row mt-2">
        <div class="col-1">
            <p>No DO</p>
        </div>
        <div class="col-5">
            <p><strong>:&nbsp&nbsp <?= $msuratjln['no_suratjln'] ?></strong></p>
        </div>

        <div class="col-5">
            <p><strong>Kepada Yth,</strong></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-1">
            <p>Tanggal </p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp<?= date('d-M-Y', strtotime($msuratjln['tgl_suratjln'])) ?></p>
        </div>
        <div class="col-5">
            <p><strong><?= $msuratjln['nama_customer'] ?></strong></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-1">
            <p>No. PO </p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp <?= $msuratjln['no_po'] ?></p>
        </div>
        <div class="col-5">
            <p><?= $msuratjln['address1'] ?></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-1">
            <p>Project </p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp<?= $msuratjln['project'] ?></p>
        </div>
        <div class="col-5">
            <p><?= $msuratjln['address2'] ?></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-1">
            <p>Keterangan </p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp<?= $msuratjln['keterangan'] ?></p>
        </div>
        <div class="col-5">
            <p><?= $msuratjln['address3'] ?></p>
        </div>
    </div>

    <div class="row mt-2">
        <table class="table table table-borderless" id="data_table">
            <thead class="text-center text-bold bg-primary">
                <tr>
                    <th width="12%" style="border: 1px solid black;" class="py-0">QTY</th>
                    <th width="18%" style="border: 1px solid black;" class="py-0">ITEM NO</th>
                    <th style="border: 1px solid black;" class="py-0">ITEM NAME</th>
                    <th width="25%" style="border: 1px solid black;" class="py-0">REMARK</th>
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
                        <td class="py-0" style="border-left: 1px solid black;"><?= $dtl['nama_barang'] ?></td>
                        <td class="py-0" style="border-left: 1px solid black; border-right: 1px solid black;">
                            <?= $dtl['catatan'] ?>
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
                        <td class="text-right py-0" style="border-left: 1px solid black; border-right: 1px solid black;">
                            &nbsp
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <th colspan="4" style="border-top: 1px solid black;" class="py-0"></th>

            </tr>
        </table>
    </div>

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
</div>

<script>
    window.print();
</script>
<?= $this->endSection() ?>