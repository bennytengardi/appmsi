<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-10">
        <table class="table">
            <center style="margin-top: 20px;">
                <h4><?= $title1 ?></h4>
                <h5 style="margin-top: -10px;"><b><?= $title ?></b></h5>
                <p style="margin-top: -8px;"><?= $tgl ?>
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
                <tr class="bg-info text-white">
                    <th>KODE BARANG</th>
                    <th>NAMA BARANG</th>
                    <th>SATUAN</th>
                    <th class="text-right">STOCK</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $kdmerk = '';
                foreach ($laporan as $lap) : ?>

                    <?php
                    $stock = $lap['awal'] + $lap['masuk'] + $lap['returjual'] - $lap['keluar'] - $lap['returbeli'] + $lap['adjust'];
                    ?>
                        <?php if ($kdmerk != $lap['kode_merk']) : ?>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['kode_merk'] ?></td>
                            </tr>
                            <?php $kdmerk = $lap['kode_merk'] ?>
                        <?php endif; ?>

                        <tr>
                            <td align="left" class="p-0"><?= $lap['kode_barang'] ?></td>
                            <td align="left" class="p-0"><?= $lap['nama_barang'] ?></td>
                            <td align="left" class="p-0"><?= $lap['kode_satuan'] ?></td>
                            <td align="right" class="p-0"><?= number_format($stock, '0', ',', '.') ?></td>
                        </tr>
                <?php endforeach; ?>
            </tbody>
            <tr>
                <td colspan="4"></td>
            </tr>
        </table>
    </div>
</div>
<script>
    $('.btncetak').click(function() {
        $(this).hide();
        window.print();
        $(this).show();
    });
</script>
<?= $this->endSection() ?>