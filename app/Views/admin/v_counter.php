<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<br>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary" style="background-color: lightblue;">
            <div class="card-header" style="height: 50px;">
                <p class="card-title" style="font-size: 16px;">SET COUNTER</p>
                <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>
            <?= form_open('counter/edit') ?>

            <div class="card-body mt-2">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form group row">
                            <label class="col-sm-6 col-form-label">CUSTOMER</label>
                            <div class="col-sm-5">
                                <input type=" text" name="customer" class="form-control text-right" value="<?= $counter['customer'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-6 col-form-label">SUPPLIER</label>
                            <div class="col-sm-5">
                                <input type="text" name="supplier" class="form-control text-right" value="<?= $counter['supplier'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-6 col-form-label">SALESMAN</label>
                            <div class="col-sm-5">
                                <input type="text" name="salesman" class="form-control text-right" value="<?= $counter['salesman'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-6 col-form-label">BARANG</label>
                            <div class="col-sm-5">
                                <input type="text" name="barang" class="form-control text-right" value="<?= $counter['barang'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-6 col-form-label">INVOICE NON</label>
                            <div class="col-sm-5">
                                <input type="text" name="non" class="form-control text-right" value="<?= $counter['non'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-6 col-form-label">INVOICE PPN</label>
                            <div class="col-sm-5">
                                <input type="text" name="inv" class="form-control text-right" value="<?= $counter['inv'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-6 col-form-label">RETUR PENJUALAN</label>
                            <div class="col-sm-5">
                                <input type="text" name="sr" class="form-control text-right" value="<?= $counter['sr'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-6 col-form-label">PELUNASAN PIUTANG</label>
                            <div class="col-sm-5">
                                <input type="text" name="cr" class="form-control text-right" value="<?= $counter['cr'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-6 col-form-label">TANDA TERIMA FAKTUR</label>
                            <div class="col-sm-5">
                                <input type="text" name="tt" class="form-control text-right" value="<?= $counter['tt'] ?>">
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="form group row">
                            <label class="col-sm-7 col-form-label">PURHASE ORDER</label>
                            <div class="col-sm-5">
                                <input type="text" name="po" class="form-control text-right" value="<?= $counter['po'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-7 col-form-label">FAKTUR PEMBELIAN</label>
                            <div class="col-sm-5">
                                <input type="text" name="pi" class="form-control text-right" value="<?= $counter['pi'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-7 col-form-label">RETUR PEMBELIAN</label>
                            <div class="col-sm-5">
                                <input type="text" name="sr" class="form-control text-right" value="<?= $counter['pr'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-7 col-form-label">PEMBAYARAN HUTANG</label>
                            <div class="col-sm-5">
                                <input type="text" name="vp" class="form-control text-right" value="<?= $counter['vp'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-7 col-form-label">BUKTI KAS/BANK MASUK</label>
                            <div class="col-sm-5">
                                <input type="text" name="othrcv" class="form-control text-right" value="<?= $counter['othrcv'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-7 col-form-label">BUKTI KAS/BANK KELUAR</label>
                            <div class="col-sm-5">
                                <input type="text" name="othpay" class="form-control text-right" value="<?= $counter['othpay'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-7 col-form-label">JURNAL MEMORIAL</label>
                            <div class="col-sm-5">
                                <input type="text" name="sr" class="form-control text-right" value="<?= $counter['pr'] ?>">
                            </div>
                        </div>
                        <div class="form group row">
                            <label class="col-sm-7 col-form-label">ADJUSTMENT STOCK</label>
                            <div class="col-sm-5">
                                <input type="text" name="adjustment" class="form-control text-right" value="<?= $counter['adjustment'] ?>">
                            </div>
                        </div>

                    </div>

                </div>

                <div>
                    <button type="submit" class="btn btn-sm btn-success mt-4"><i class="fa fa-edit"></i> UPDATE</button>
                    <a href="<?= base_url('admin') ?>" class="btn btn-sm btn-danger mt-4" name="reset">
                        <i class="fa fa-times"></i> CANCEL
                    </a>
                </div>


            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>



<?= $this->endSection() ?>