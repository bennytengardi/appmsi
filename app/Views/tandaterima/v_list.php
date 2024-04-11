<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-primary" style="background-color: lightblue;">

            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">DETAIL TANDA TERIMA</h3>
                <a href="<?= base_url('TandaTerima/index') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <div class="card" style="background-color: aliceblue;">
                    <div class="container p-3">
                        <?= form_open('', ['class' => 'formsimpantandaterima']) ?>
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form group row">
                                    <div class="col-sm-4">KODE SUPPLIER</div>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" value="<?= $tandaterima['kode_supplier'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form group row mt-2">
                                    <div class="col-sm-4">NAMA SUPPLIER</div>
                                    <div class="col-sm-8">
                                        <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" value="<?= $tandaterima['nama_supplier'] ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1">
                            </div>
                            <div class="col-sm-5">
                                <div class="form group row">
                                    <div class="col-sm-4">NO BUKTI</div>
                                    <div class="col-sm-4">
                                        <input type="text" name="no_tandaterima" id="no_tandaterima" class="form-control form-control-sm" value="<?= $tandaterima['no_tandaterima'] ?>" readonly>

                                    </div>
                                </div>

                                <div class="form group row mt-2">
                                    <div class="col-sm-4">TGL BAYAR</div>
                                    <div class="col-sm-4">
                                        <input type="date" name="tgl_tandaterima" id="tgl_tandaterima" class="form-control form-control-sm" value="<?= $tandaterima['tgl_tandaterima'] ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="background-color: aliceblue;">
                    <div class="row p-3" style="font-size: 14px;">
                        <div class="col-lg-12 mt-2">
                            <!-- <div class="container p-2"> -->
                            <div class="mx-2">

                                <table class="table table-sm table-bordered">
                                    <thead class="bg-primary text-white">
                                        <tr align="center">
                                            <td width="3%">NO</td>
                                            <td width="12%">NO INVOICE</td>
                                            <td width="8%">TGL INVOICE</td>
                                            <td width="12%">INVOICE SUPP</td>
                                            <td width="10%">TOTAL</td>
                                            <td width="12%">POTONGAN</td>
                                            <td width="15%">JUMLAH TT</td>
                                        </tr>
                                    </thead>

                                    <tbody id="show_receipt">
                                        <?php
                                        $total_potongan = 0;
                                        $total_bayar = 0;
                                        $total_balance = 0;
                                        $no = 1;
                                        $i = 0;
                                        foreach ($dtandaterima as $dtl) :  ?>
                                            <?php $i++;
                                            $total_potongan += $dtl['potongan'];
                                            $total_bayar    += $dtl['jumlah_bayar'] ?>
                                            <tr>
                                                <td class="text-center" style="vertical-align: middle; height:24px;"><?= $no++ ?></td>
                                                <td><?= $dtl['no_invoice'] ?></td>
                                                <td class="text-center"><?= $dtl['tgl_invoice'] ?></td>
                                                <td class="text-center"><?= $dtl['invoice_supp'] ?></td>
                                                <td class="text-right"><?= number_format($dtl['total_invoice'], 0) ?></td>
                                                <td class="text-right"><?= number_format($dtl['potongan'], 0) ?></td>
                                                <td class="text-right"><?= number_format($dtl['jumlah_bayar'], 0) ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>

                                    <tr>
                                        <td colspan="5" style="font-size: 16px;">TOTAL:</td>
                                        <td class="text-right"><?= number_format($total_potongan, 0) ?></td>
                                        <td class="text-right"><?= number_format($total_bayar, 0) ?></td>
                                    </tr>

                                </table>
                                <a href="<?= base_url('TandaTerima') ?>" type="button" class="btn btn-success btn-sm ml-2 mt-2"><i class="fas fa-angle-double-left"></i>
                                    KEMBALI</a>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>
            <?= form_close() ?>
               </div>
    </div>
</div>

<?= $this->endSection() ?>