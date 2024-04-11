<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="card card-primary" style="background-color: aliceblue;">
    <div class="card-header" style="height: 50px;">
        <h3 class="card-title">CUSTOMER RECEIPT</h3>
        <a href="<?= base_url('receipt/index') ?>" type="button" class="btn btn-md mb-2 float-right">
            <i class="fa fa-times-circle"></i></button></a>
    </div>

    <div class="card-body">
        <?= form_open('', ['class' => 'formsimpanreceipt']) ?>
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-sm-6">
                <!-- <div class="card p-3" style="background-color: #d8f0f0;"> -->
                    <div class="form group row">
                        <div class="col-sm-2">Customer ID</div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm kode_customer" aria-describedby="basic-addon2" name="kode_customer" id="kode_customer" value="<?= $receipt['kode_customer'] ?>" style="height: 28px;" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Customer Name</div>
                        <div class="col-sm-9">
                            <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm" value="<?= $receipt['nama_customer'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Address</div>
                        <div class="col-sm-9">
                            <input type="text" name="address1" id="address1" class="form-control form-control-sm" value="<?= $receipt['address1'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>

                    <div class=" form group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-9">
                            <input type="text" name="address2" id="address2" class="form-control form-control-sm" value="<?= $receipt['address2'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class=" form group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-9">
                            <input type="text" name="address3" id="address3" class="form-control form-control-sm" value="<?= $receipt['address3'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                <!-- </div> -->
            </div>

            <div class="col-sm-5 offset-1">
                <!-- <div class="card p-3" style="background-color: #d8f0f0;"> -->
                    <div class="form group row">
                        <div class="col-sm-2">Form No</div>
                        <div class="col-sm-3">
                            <input type="text" name="no_receipt" id="no_receipt" class="form-control form-control-sm text-md text-bold text-danger" value="<?= $receipt['no_receipt'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Payment Date</div>
                        <div class="col-sm-3">
                            <input type="date" name="tgl_receipt" id="tgl_receipt" class="form-control form-control-sm" value="<?= $receipt['tgl_receipt'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>

                    <div class="form group row">
                        <div class="col-sm-2">Deposit To</div>
                        <div class="col-sm-6">
                            <input type="text" name="kode_account" id="kode_account" class="form-control form-control-sm" value="<?= $receipt['nama_account'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Cheque No</div>
                        <div class="col-sm-4">
                            <input type="text" name="no_giro" id="no_giro" class="form-control form-control-sm" value="<?= $receipt['no_giro'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Cheque Date</div>
                        <div class="col-sm-3">
                            <input type="date" name="tgl_giro" id="tgl_giro" class="form-control form-control-sm" value="<?= $receipt['tgl_giro'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
        </div>


        <div class="row mt-2">
            <div class="col-lg-12 mt-2">
                <table class="table table-sm table-bordered" width="100%">
                    <thead class="bg-primary text-white">
                        <tr align="center">
                            <td width="3%">No</td>
                            <td>Invoice No</td>
                            <td width="8%">Date</td>
                            <td width="9%">Total Invoice</td>
                            <td width="9%">Total Retur</td>
                            <td width="9%">Owing</td>
                            <td width="9%">Discount</td>
                            <td width="9%">Admin</td>
                            <td width="9%">Pph-Ps23</td>
                            <td width="9%">Pph-Ps4</td>
                            <td width="9%">Payment Amount</td>
                         </tr>
                    </thead>

                    <tbody>
                        <?php
                        $total_potongan = 0;
                        $total_bayar = 0;
                        $total_admin = 0;
                        $total_pph23 = 0;
                        $total_pph4 = 0;
                        $total_balance = 0;
                        $no = 1;
                        $i = 0;
                        foreach ($dreceipt as $dtl) :  ?>
                            <?php $i++;
                            $total_balance  += $dtl['owing'];
                            $total_potongan += $dtl['potongan'];
                            $total_admin    += $dtl['admin'];
                            $total_pph23    += $dtl['pph23'];
                            $total_pph4     += $dtl['pph4'];
                            $total_bayar    += $dtl['jumlah_bayar'] ?>
                            <tr>
                                <td>
                                    <input type="text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" style="height: 28px;" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" value="<?= $dtl['no_invoice'] ?>" style="height: 28px;" readonly>
                                </td>
                                <td><input type="text" class="form-control form-control-sm text-center" value="<?= $dtl['tgl_invoice'] ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($dtl['total_invoice'], 0) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($dtl['total_retur'], 0) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($dtl['owing'], 0) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right potongan" value="<?= number_format($dtl['potongan'], 0) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right potongan" value="<?= number_format($dtl['admin'], 0) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right potongan" value="<?= number_format($dtl['pph23'], 0) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right potongan" value="<?= number_format($dtl['pph4'], 0) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right jumlah_bayar" value="<?= number_format($dtl['jumlah_bayar'], 0) ?>" style="height: 28px;" readonly></td>

                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                    <tr>
                        <th colspan="6">TOTAL</th>
                        <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($total_potongan, 0) ?>" style="height: 28px;" readonly></td>
                        <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($total_admin, 0) ?>" style="height: 28px;" readonly></td>
                        <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($total_pph23, 0) ?>" style="height: 28px;" readonly></td>
                        <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($total_pph4, 0) ?>" style="height: 28px;" readonly></td>
                        <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($total_bayar, 0) ?>" style="height: 28px;" readonly></td>
                    </tr>

                </table>
                <a href="<?= base_url('receipt') ?>" type="button" class="btn btn-primary btn-sm tombolSimpanPo ml-2 mt-2"><i class="fas fa-angle-double-left"></i>
                    BACK</a>
            </div>
        </div>
    </div>
    <?= form_close() ?>

</div>



<?= $this->endSection() ?>