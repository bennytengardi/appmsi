<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-sm-10">
        <table class="table">
            <center style="margin-top: 20px;">
                <h4><?= $title1 ?></h4>
                <h5 style="margin-top: -10px;"><b><?= $title ?></b></h5>
                <p style="margin-top: -8px;"><?= date('d-M-Y', strtotime(set_value('dari'))) ?> S/D <?= date('d-M-Y', strtotime(set_value('sampai'))) ?>
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
                    <th>No Invoice</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">SubTotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $totinv  = 0;
                $gtotinv = 0;
                $ftotinv = 0;
                $tgl = '';
                $noinv = '';
                $sw = 0;
                $sw2 = 0;
                $kdsupp = '';

                foreach ($laporan as $lap) : ?>
                    <?php if ($noinv != $lap['no_invoice']) : ?>
                        <?php if ($sw2 == 1) : ?>
                            <tr>
                                <td colspan="5" class="text-bold p-0">TOTAL INVOICE</td>
                                <td align="right" class="text-bold p-0"><?= number_format($ftotinv, '0', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                            </tr>
                            <?php
                            $ftotinv = 0;
                            ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($kdsupp != $lap['kode_supplier']) : ?>
                        <?php if ($sw == 1) : ?>
                            <tr>
                                <td colspan="5" class="text-bold text-primary p-0">TOTAL SUPPLIER</td>
                                <td align="right" class="text-bold text-primary p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                            </tr>
                            <?php
                            $totinv = 0;
                            ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="6" class="text-bold text-danger p-0" style="font-size: 16px;" align="left"><?= $lap['nama_supplier'] ?> </td>
                        </tr>
                    <?php endif; ?>





                    <tr>
                        <?php
                        $totalinv = $lap['qty'] * $lap['harga'];
                        $totinv  = $totinv + $totalinv;
                        $gtotinv = $gtotinv + $totalinv;
                        $ftotinv = $ftotinv + $totalinv;
                        $sw = 1;
                        $sw2 = 1;
                        ?>

                        <?php if ($lap['no_invoice'] != $noinv) { ?>
                            <td align="left" class="p-0"><?= $lap['no_invoice'] ?></td>
                            <td align="left" class="p-0"><?= date('d-M-Y', strtotime($lap['tgl_invoice'])) ?></td>
                        <?php } else { ?>
                            <td align="left" class="p-0"></td>
                            <td align="left" class="p-0"></td>
                        <?php } ?>

                        <td align="left" class="p-0"><?= $lap['nama_barang'] ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['qty'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($lap['harga'], '0', ',', '.') ?></td>
                        <td align="right" class="p-0"><?= number_format($totalinv, '0', ',', '.') ?></td>
                        <?php $kdsupp = $lap['kode_supplier'] ?>
                        <?php $noinv = $lap['no_invoice']; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <tr>
                <td colspan="5" class="text-bold p-0">TOTAL INVOICE</td>
                <td align="right" class="text-bold p-0"><?= number_format($ftotinv, '0', ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="5" class="text-bold text-primary p-0">TOTAL SUPPLIER</td>
                <td align="right" class="text-bold text-primary p-0"><?= number_format($totinv, '0', ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>


            <tr>
                <td colspan="5" class="text-bold p-0">GRAND TOTAL</td>
                <td align="right" class="text-bold text-lg p-0"><?= number_format($gtotinv, '0', ',', '.') ?></td>
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