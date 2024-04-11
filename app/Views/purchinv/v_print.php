<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container bg-white">
    <div class="row">
        <div class="col-4">
            <img src="<?= base_url() ?>/assets/img/logo msi.png" alt=""  style="width: 140px; height: 80px" >
        </div>
        <div class="col-8 text-right text-bold mb-2">
            <h4>PURCHASE INVOICE</h4>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-2">
            <p>No Invoice</p>
        </div>
        <div class="col-5">
            <p><strong>:&nbsp&nbsp <?= $pi['no_invoice'] ?></strong></p>
        </div>

        <div class="col-5">
            <p><strong>Supplier,</strong></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p>Date Inv </p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp <?= date('d-M-Y', strtotime($pi['tgl_invoice'])) ?></p>
        </div>
        <div class="col-5">
            <p><strong><?= $pi['nama_supplier'] ?></strong></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p>Currency </p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp <?= $pi['currency'] ?></p>
        </div>
        <div class="col-5">
            <p><?= $pi['address1'] ?></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p>Invoice Supp</p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp <?= $pi['invoice_supp'] ?></p>
        </div>
        <div class="col-5">
            <p><?= $pi['address2'] ?></p>
        </div>
    </div>

    <div class="row" style="margin-top: -15px;">
        <div class="col-2">
            <p>Description </p>
        </div>
        <div class="col-5">
            <p>:&nbsp&nbsp<?= $pi['keterangan'] ?></p>
        </div>
        <div class="col-5">
            <p><?= $pi['address3'] ?></p>
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
                foreach ($dpi as $dtl) : 
                     $i++;
                ?>
                    <tr>
                        <td class="py-0 text-center" style="vertical-align: middle;border-left:1px solid black;"> <?= $no++ ?></td>
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
                <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($pi['total_dpp'], 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="text-right py-0" style="border-left: black;">TAXABLE</td>
                <td class="text-right py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($pi['total_ppn'], 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" class="text-right text-bold py-0" style="border-left: black;">GRAND TOTAL</td>
                <td class="text-right text-bold py-0" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black""><?= number_format($pi['total_invoice'], 2, ',', '.') ?></td>
            </tr>

        </table>
    </div>

    <div class="row" style="margin-top: -80px;">
        <div class="col-2 text-center">
        </div>
        <div class="col-3 text-center">
        </div>
    </div>
    <br><br><br>
    <div class="row">
        <div class="col-2 text-center">
        </div>
        <div class="col-3 text-center">
        </div>
    </div>
    <div class="row" style="margin-top: -18px;">
        <div class="col-2 text-center">
        </div>
        <div class="col-3 text-center">
            <p><b></b></p>
        </div>
    </div>

    <br>
</div>

<script>
    window.print();
</script>
<?= $this->endSection() ?>