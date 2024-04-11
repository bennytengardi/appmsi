<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="card card-primary" style="background-color: aliceblue;">
    <div class="card-header" style="height: 50px;">
        <h3 class="card-title">SUPPLIER PAYMENT</h3>
        <a href="<?= base_url('payment/index') ?>" type="button" class="btn btn-md mb-2 float-right">
            <i class="fa fa-times-circle"></i></button></a>
    </div>

    <div class="card-body">
        <?= form_open('', ['class' => 'formsimpanpayment']) ?>
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-sm-6">
                <!-- <div class="card p-3" style="background-color: #d8f0f0;"> -->
                    <div class="form group row">
                        <div class="col-sm-2">Supplier ID</div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" value="<?= $payment['kode_supplier'] ?>" style="height: 28px;" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Supplier Name</div>
                        <div class="col-sm-9">
                            <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" value="<?= $payment['nama_supplier'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Address</div>
                        <div class="col-sm-9">
                            <input type="text" name="address1" id="address1" class="form-control form-control-sm" value="<?= $payment['address1'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>

                    <div class=" form group row">
                        <div class="col-sm-2"> </div>
                        <div class="col-sm-9">
                            <input type="text" name="address2" id="address2" class="form-control form-control-sm" value="<?= $payment['address2'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class=" form group row">
                        <div class="col-sm-2"> </div>
                        <div class="col-sm-9">
                            <input type="text" name="address3" id="address3" class="form-control form-control-sm" value="<?= $payment['address3'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                <!-- </div> -->
            </div>

            <div class="col-sm-5 offset-1">
                <!-- <div class="card p-3" style="background-color: #d8f0f0;"> -->
                    <div class="form group row">
                        <div class="col-sm-2">Form No</div>
                        <div class="col-sm-3">
                            <input type="text" name="no_payment" id="no_payment" class="form-control form-control-sm text-bold text-danger" value="<?= $payment['no_payment'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Payment Date</div>
                        <div class="col-sm-3">
                            <input type="date" name="tgl_payment" id="tgl_payment" class="form-control form-control-sm" value="<?= $payment['tgl_payment'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>

                    <div class="form group row">
                        <div class="col-sm-2">Cheque No</div>
                        <div class="col-sm-4">
                            <input type="text" name="no_giro" id="no_giro" class="form-control form-control-sm" value="<?= $payment['no_giro'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Cheque Date</div>
                        <div class="col-sm-3">
                            <input type="date" name="tgl_giro" id="tgl_giro" class="form-control form-control-sm" value="<?= $payment['tgl_giro'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class="form group row">
                        <div class="col-sm-2">Paid From</div>
                        <div class="col-sm-6">
                            <input type="text" name="kode_account" id="kode_account" class="form-control form-control-sm" value="<?= $payment['nama_account'] ?>" style="height: 28px;" readonly>
                        </div>
                    </div>
                    <div class="form group row">
                        <?php if ($payment['currency'] != 'IDR') { ?>
                            <div class="col-sm-2" id="textkurs">Exchg Rate</div>
                            <div class="col-sm-2" id="inputkurs">
                                <input type="text" class="form-control form-control-sm text-right autonum" name="kurs" id="kurs" value="<?= $payment['nilai_tukar'] ?>" style="height: 28px;" readonly>
                            </div>
                        <?php } else { ?>
                            <div class="col-sm-2" id="textkurs"></div>
                            <div class="col-sm-2" id="inputkurs">
                                <input type="hidden" class="form-control form-control-sm text-right" name="kurs" id="kurs" value="<?= $payment['nilai_tukar'] ?>" style="height: 28px;" readonly>
                            </div>
                        <?php } ?>
                    </div>

                <!-- </div> -->
            </div>
        </div>


        <div class="row mt-2">
            <div class="col-lg-12 mt-2">
                <table class="table table-sm table-bordered" width="100%">
                    <thead class="bg-primary text-white">
                        <tr align="center">
                        <td width="5%">No</td>
                            <td>Invoice No</td>
                            <td width="10%">Date</td>
                            <td width="10%">Total Invoice</td>
                            <td width="10%">Total Retur</td>
                            <td width="10%">Owing</td>
                            <td width="10%">Discount</td>
                            <td width="10%">PPH Ps23</td>
                            <td width="10%">Ongkir</td>
                            <td width="10%">Total Paid</td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $total_potongan = 0;
                        $total_bayar = 0;
                        $total_pph23 = 0;
                        $total_ongkir = 0;
                        $total_balance = 0;
                        $no = 1;
                        $i = 0;
                        foreach ($dpayment as $dtl) :  ?>
                            <?php $i++;
                            $total_balance  += $dtl['owing'];
                            $total_potongan += $dtl['potongan'];
                            $total_pph23    += $dtl['pph23'];
                            $total_ongkir   += $dtl['ongkir'];
                            $total_bayar    += $dtl['jumlah_bayar'] ?>
                            <tr>
                                <td>
                                    <input type=" text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" style="height: 28px;" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" value="<?= $dtl['no_invoice'] ?>" style="height: 28px;" readonly>
                                </td>
                                <td><input type="text" class="form-control form-control-sm text-center" value="<?= $dtl['tgl_invoice'] ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($dtl['total_invoice'], 2) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($dtl['total_retur'], 2) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($dtl['owing'], 2) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right potongan autonum2" value="<?= number_format($dtl['potongan'], 2) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right pph23 autonum2" value="<?= number_format($dtl['pph23'], 2) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right ongkir autonum2" value="<?= number_format($dtl['ongkir'], 2) ?>" style="height: 28px;" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-right jumlah_bayar autonum2" value="<?= number_format($dtl['jumlah_bayar'], 2) ?>" style="height: 28px;" readonly></td>

                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                    <tr>
                        <th colspan="6" class="text-right">TOTAL</th>
                        <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($total_potongan, 2) ?>" style="height: 28px;" readonly></td>
                        <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($total_pph23,2) ?>" style="height: 28px;" readonly></td>
                        <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($total_ongkir,2) ?>" style="height: 28px;" readonly></td>
                        <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($total_bayar, 2) ?>" style="height: 28px;" readonly></td>
                    </tr>

                </table>
                <a href="<?= base_url('payment') ?>" type="button" class="btn btn-primary btn-sm tombolSimpanPo ml-2 mt-2"><i class="fas fa-angle-double-left"></i>
                    Back </a>
            </div>
        </div>
    </div>
    <?= form_close() ?>

</div>



<?= $this->endSection() ?>