<?= $this->extend('layout/template2') ?>
<?= $this->section('content') ?>
<?php

function terbilang($x)
{
    $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

    if ($x < 12)
        return " " . $angka[$x];
    elseif ($x < 20)
        return terbilang($x - 10) . " belas";
    elseif ($x < 100)
        return terbilang($x / 10) . " puluh" . terbilang($x % 10);
    elseif ($x < 200)
        return "seratus" . terbilang($x - 100);
    elseif ($x < 1000)
        return terbilang($x / 100) . " ratus" . terbilang($x % 100);
    elseif ($x < 2000)
        return "seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
        return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
    elseif ($x < 1000000000)
        return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
}
?>

<div class="container" style="font-size: 16px;">
    <div class="row mt-2">
        <div class="col-2">
            <!--<img src="<?= base_url() ?>/gambar/Logo.jpg" alt=""  style="width: 140px; height: 80px" >-->
             <h5><?= session()->get('nama_company') ?></h5> 
        </div>
        <div class="col-10">
            <div class="row" style="margin-left: -60px">
                <div class="col-6">
                    <h6 class="text-bold text-danger"><?= session()->get('nama_company') ?></h6>
                </div>
                <div class="col-6 text-right">
                    <h4 class="text-bold">RETUR PENJUALAN</h4>
                </div>
            </div>
            <div class="row" style="margin-top: -12px;margin-left: -60px;">
                <div class="col-6">
                    <p class="text-bold">JAKARTA</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="font-size: 16px;">
        <div class="col-5">
            <p><strong>KEPADA YTH,</strong></p>
        </div>
        <div class="col-2 offset-3">
            <p>NO RETUR</p>
        </div>
        <div class="col-2">
            <p><strong>: &nbsp;&nbsp;<?= $mretur['no_retur'] ?></strong></p>
        </div>

    </div>

    <div class="row" style="margin-top: -20px;font-size: 16px;">
        <div class="col-5">
            <p class="text-bold"><?= $mretur['nama_customer'] ?></p>
        </div>
        <div class="col-2 offset-3">
            <p>TGL RETUR </p>
        </div>
        <div class="col-2">
            <p>: &nbsp;&nbsp; <?= date('d-M-Y', strtotime($mretur['tgl_retur'])) ?></p>
        </div>
    </div>

    <div class="row" style="margin-top: -20px;font-size: 16px;">
        <div class="col-5">
            <p><?= $mretur['address1'] ?></p>
        </div>
        <div class="col-2 offset-3">
            <p>NO INVOICE </p>
        </div>
        <div class="col-2">
            <p>: &nbsp;&nbsp; <?= $mretur['no_invoice'] ?></p>
        </div>
    </div>

    <div class="row" style="margin-top: -20px;font-size: 16px;">
        <div class="col-5">
            <p><?= $mretur['address2'] ?></p>
        </div>
        <div class="col-2 offset-3">
            <p>TGL INVOICE </p>
        </div>
        <div class="col-2">
            <p>: &nbsp;&nbsp; <?= date('d-M-Y', strtotime($mretur['tgl_invoice'])) ?></p>
        </div>
    </div>


    <div class="row">
        <table class="table table table-borderless" id="data_table" style="font-size: 16px;">
            <thead>
                <tr class=" text-center">
                    <th width=4% style="border: 1px solid black;" class="py-0">NO</th>
                    <th width=15% style="border: 1px solid black;" class="py-0">KODE BARANG</th>
                    <th style="border: 1px solid black;" class="py-0">NAMA BARANG</th>
                    <th width=8% style="border: 1px solid black;" class="py-0">QTY</th>
                    <th width=6% style="border: 1px solid black;" class="py-0">SATUAN</th>
                    <th width=12% style="border: 1px solid black;" class="py-0">HARGA</th>
                    <th width=12% style="border: 1px solid black;" class="py-0">SUB TOTAL</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;
                $i = 0;
                $total_amount = 0;
                $brs = 0;
                foreach ($dretur as $dtl) :  ?>
                    <?php $i++;
                    $total_amount = $total_amount + $dtl['subtotal'];
                    ?>
                    <tr>
                        <td class="py-0 text-center" style="vertical-align: middle;border-left:1px solid black;"> <?= $no++ ?></td>
                        <td class="py-0" style="border-left: 1px solid black;"><?= $dtl['kode_barang'] ?></td>
                        <td class="py-0" style="border-left: 1px solid black;"><?= $dtl['nama_barang'] ?></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"><?= number_format($dtl['qty'], 0, '.', ',') ?>&nbsp&nbsp&nbsp</td>
                        <td class="text-center py-0" style="border-left: 1px solid black;"><?= $dtl['kode_satuan'] ?></td>
                        <td class="text-right py-0" style="border-left: 1px solid black;"><?= number_format($dtl['harga'], 0, '.', ',') ?></td>
                        <td class="text-right py-0" style="border-left: 1px solid black; border-right: 1px solid black;">
                            <?= number_format($dtl['subtotal'], 0, '.', ',') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <?php if ($no < 12) { ?>
                <?php for ($x = $no; $x < 12; $x++) { ?>
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
            <?php } else { ?>
                <?php for ($x = $no; $x < 35; $x++) { ?>
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
            <?php } ?>

            <tr>
                <td class="py-0 text-center" style="vertical-align: middle;border-top:1px solid black;"></td>
                <td class="py-0" style="border-top: 1px solid black;"></td>
                <td class="text-right py-0" style="border-top: 1px solid black;"></td>
                <td class="text-right py-0" style="border-top: 1px solid black;"></td>
                <td class="text-right py-0" style="border-top: 1px solid black;"></td>
                <td class="text-right py-0" style="border-top: 1px solid black;"></td>
                <td class="text-right py-0" style="border-top: 1px solid black;"></td>
            </tr>

            <tr>
                <td colspan="4" style="font-size: 16px" class="py-0">#<?= ucwords(terbilang($total_amount)) ?> Rupiah #</td>
                <td colspan="2" class="py-0 text-right" style="border-left: black;">TOTAL RETUR</td>
                <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black; border-bottom: 1px solid black"><?= number_format($total_amount, 0, '.', ',') ?></td>
            </tr>
        </table>
    </div>
    <div class="row" style="font-size: 16px;">
        <div class="col-3 text-center">
            <p>Dibuat Oleh</p>
        </div>
        <div class="col-3 text-center">
            <p>Disetujui oleh</p>
        </div>
    </div>
    <br>
    <div class="row mt-5">
        <div class="col-3 text-center" style="margin-top: -25px">
            <p>____________________</p>
        </div>
        <div class="col-3 text-center" style="margin-top: -25px">
            <p>____________________</p>
        </div>
    </div>




</div>

<script>
    window.print();
</script>
<?= $this->endSection() ?>