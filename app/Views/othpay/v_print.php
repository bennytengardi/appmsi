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


<div class="container">
    <div class="row">
        <div class="col-7">
            <!-- <img src="<?= base_url() ?>" alt=""> -->
            <h4><?= session()->get('nama_company') ?></h4>
        </div>
        <div class="col-5 text-right">
            <?php if (substr($mothpay['kode_account'], 4) == "1101") { ?>
                <h4>BUKTI PENGELUARAN KAS</h4>
            <?php } else { ?>
                <h4>BUKTI PENGELUARAN BANK</h4>
            <?php } ?>
        </div>
    </div>


    <div class="row mt-2">
        <div class="col-2">
            <p>Dibayar Kepada </p>
        </div>
        <div class="col-4">
            <p>: <?= $mothpay['kepada'] ?></p>
        </div>
        <div class="col-2"></div>
        <div class="col-2">
            <p>No Bukti </p>
        </div>
        <div class="col-2">
            <p>: <?= $mothpay['no_bukti'] ?></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p>Dari Perkiraan </p>
        </div>
        <div class="col-4">
            <p>: <?= $mothpay['nama_account'] ?></p>
        </div>
        <div class="col-2"></div>
        <div class="col-2">
            <p>Tgl Bukti </p>
        </div>
        <div class="col-2">
            <p>: <?= date('d-M-Y', strtotime($mothpay['tgl_bukti'])) ?></p>
        </div>
    </div>
    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p>Keterangan</p>
        </div>
        <div class="col-8">
            <p>: <?= $mothpay['keterangan'] ?></p>
        </div>
    </div>

    <div class="row mt-2">
        <table class="table table-bordered table-striped table-sm" id="data_table" style="font-size: 13px;">
            <thead class="text-center">
                <tr class="bg-primary text-white text-center text-sm">
                    <th width="10%">No Perkiraan</th>
                    <th width="25%">Nama Perkiraan</th>
                    <th>Keterangan</th>
                    <th width="15%">Jumlah (Rp)</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;
                $i = 0;
                $total = 0;
                foreach ($dothpay as $dtl) :  ?>
                    <?php $i++;
                    $total = $total + $dtl['jumlah'];
                    ?>
                    <tr>
                        <td><?= $dtl['kode_account'] ?></td>
                        <td><?= $dtl['nama_account'] ?></td>
                        <td><?= $dtl['keterangan'] ?></td>
                        <td class="text-right"><?= number_format($dtl['jumlah'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <tr>
                <th colspan="3" class="text-right">TOTAL :</th>
                <td class="text-right">
                    <strong><?= number_format($total, 0, ',', '.') ?></strong>
                </td>
            </tr>
        </table>
    </div>
    <div class="row mt-2" style="margin-top: -15px;">
        <div class="col-12">
            <p>Terbilang :
                <?= ucwords(terbilang($total)); ?> Rupiah </p>
        </div>
    </div>


    <div class="row mt-2" style="margin-top: -15px;">
        <div class="col-3">
            <p>Disetujuo Oleh, </p>
        </div>
        <div class="col-3">
            <p>Diperiksa Oleh, </p>
        </div>
        <div class="col-3">
            <p>Dibayar Oleh, </p>
        </div>
        <div class="col-3">
            <p>Diterima Oleh,</p>
        </div>
    </div>
</div>






<script>
    window.print();
</script>
<?= $this->endSection() ?>