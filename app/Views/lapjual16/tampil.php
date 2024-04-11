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
        <div class="col-8">
            <div class="row">
                <div class="col-6">
                    <h4 class="text-bold text-danger"><?= session()->get('nama_company') ?></h4>
                </div>
                <div class="col-6 text-right">
                    <h4 class="text-bold">TANDA TERIMA</h4>
                </div>
            </div>
            <div class="row" style="margin-top: -12px">
                <div class="col-6">
                    <p class="text-bold">JAKARTA</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2" style="font-size: 16px;">
        <div class="col-5">
        </div>
        <div class="col-5">
            <p><strong>KEPADA YTH,</strong></p>
        </div>
    </div>

    <div class="row" style="margin-top: -20px;font-size: 16px;">
        <div class="col-5">
        </div>
        <div class="col-5">
            <p class="text-bold"><?= $customer['nama_customer'] ?></p>
        </div>
    </div>

    <div class="row" style="margin-top: -20px;font-size: 16px;">
        <div class="col-5">
        </div>
        <div class="col-5">
            <p><?= $customer['address1'] ?></p>
        </div>
    </div>

    <div class="row" style="margin-top: -20px;font-size: 16px;">
        <div class="col-5">
            <p>Sudah Terima dari : <b>PT Berkat Arta Prima</b></p>
        </div>
        <div class="col-5">
            <p><?= $customer['address2'] ?></p>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-10">
            <table class="table table table-borderless" id="data_table" style="font-size: 16px;">
                <thead>
                    <tr class=" text-center">
                        <th style="border: 1px solid black;" class="py-0">NO</th>
                        <th style="border: 1px solid black;" class="py-0">NO INVOICE</th>
                        <th style="border: 1px solid black;" class="py-0">TANGGAL</th>
                        <th style="border: 1px solid black;" class="py-0">JUMLAH</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;
                    $i = 0;
                    $total = 0;
                    $brs = 0;
                    foreach ($laporan as $dtl) :  ?>
                        <?php $i++;
                        $sisa = ($dtl['total_invoice'] - $dtl['total_retur'] - $dtl['total_bayar']);
                        $total = $total + $sisa;
                        ?>
                        
                        <?php if ($sisa > 0) { ?>                        
                            <tr>
                                <td class="py-0 text-center" style="vertical-align: middle;border-left:1px solid black;"> <?= $no++ ?></td>
                                <td class="py-0 text-center" style="border-left: 1px solid black;"><?= $dtl['no_invoice'] ?></td>
                                <td class="py-0 text-center" style="border-left: 1px solid black;"><?= date('d-M-Y', strtotime($dtl['tgl_invoice'])) ?></td>
                                <td class="text-right py-0" style="border-left: 1px solid black; border-right: 1px solid black;">
                                    <?= number_format($sisa, 0, '.', ',') ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php endforeach; ?>
                </tbody>

                <?php if ($no < 12) { ?>
                    <?php for ($x = $no; $x < 12; $x++) { ?>
                        <tr>
                            <td class="py-0 text-center" style="vertical-align: middle;border-left:1px solid black;"></td>
                            <td class="py-0" style="border-left: 1px solid black;"></td>
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
                            <td class="text-right py-0" style="border-left: 1px solid black; border-right: 1px solid black;">
                                &nbsp
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>

                <tr>
                    <td class="py-0 text-center" style="vertical-align: middle;border-top:1px solid black;"></td>
                    <td class="py-0 text-center" style="border-top: 1px solid black;"></td>
                    <td class="text-right py-0" style="border-top: 1px solid black;"></td>
                    <td class="text-right py-0" style="border-top: 1px solid black;"></td>
                </tr>
                <tr>
                    <td class="py-0 text-center" style="vertical-align: middle;border-left:1px solid black;">TOTAL</td>
                    <td class="py-0"></td>
                    <td class="py-0 text-right" style="border-left: black;"></td>
                    <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black"><?= number_format($total, 0, '.', ',') ?></td>
                </tr>
                <tr>
                    <td class="py-0 text-center" style="vertical-align: middle;border-top:1px solid black;"></td>
                    <td class="py-0 text-center" style="border-top: 1px solid black;"></td>
                    <td class="text-right py-0" style="border-top: 1px solid black;"></td>
                    <td class="text-right py-0" style="border-top: 1px solid black;"></td>
                </tr>

                <tr>
                    <td colspan="6" style="font-size: 16px" class="py-0">#<?= ucwords(terbilang($total)) ?> Rupiah #</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row" style="font-size: 16px;">
        <div class="col-5">
            <p>Catatan:</p>
        </div>
        <div class="col-2 text-center offset-2">
            <p>Diterima Oleh</p>
        </div>
    </div>

    <div class="row" style="font-size: 16px;margin-top: -15px">
                <div class="col-5">
            <p>Pembayaran harap ditujukan : </p>
            <p style="margin-top: -18px;font-weight:bold">BNI NO.AC: 2299-2298-86</p>
            <p style="margin-top: -18px;font-weight:bold">A/N : TEDY LIM</p>
        </div>
    </div>
    <div class="row" style="font-size: 16px; margin-top : -20px">
        <div class="col-5">
        </div>
        <div class="col-2 text-center offset-2">
            <p>______________</p>
        </div>
    </div>




</div>

<script>
    window.print();
</script>
<?= $this->endSection() ?>