<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>


<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-primary" style="background-color: lightskyblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">SALES RETURN</h3>
                <a href="<?= base_url('SalesRtn') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <div class="card p-3" style="background-color: #d0ecff;">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-3">CUSTOMER ID</div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm  kode_customer" aria-describedby="basic-addon2" name="kode_customer" id="kode_customer" value="<?= $sr['kode_customer'] ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">CUSTOMER NAME</div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm " value="<?= $sr['nama_customer'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">ADDRESS</div>
                                <div class="col-md-8">
                                    <input type="text" name="address1" id="address1" class="form-control form-control-sm " value="<?= $sr['address1'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address2" id="address2" class="form-control form-control-sm " value="<?= $sr['address2'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address3" id="address3" class="form-control form-control-sm " value="<?= $sr['address3'] ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-3">NO RETURN</div>
                                <div class="col-md-3">
                                    <input type="text" name="no_retur" id="no_retur" class="form-control form-control-sm  font-weight-bold" value="<?= $sr['no_retur'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">DATE RETURN</div>
                                <div class="col-md-3">
                                    <input type="date" name="tgl_retur" id="tgl_retur" class="form-control form-control-sm " value="<?= $sr['tgl_retur'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">NO INVOICE</div>
                                <div class="col-md-5">
                                    <input type="text" name="no_invoice" id="no_invoice" class="form-control form-control-sm " value="<?= $sr['no_invoice'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">BALANCE</div>
                                <div class="col-md-4">
                                    <input type="text" name="total_invoice" id="total_invoice" class="form-control form-control-sm  text-right autonum" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">DESCRIPTION</div>
                                <div class="col-md-9">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm " value="<?= $sr['keterangan'] ?>" onkeyup="this.value = this.value.toUpperCase()" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 dataDetailInv" id="dataDetailInv">
                        <div class="card" style="background-color: #d0ecff;">
                            <div class="row p-3">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-sm" width="100%">
                                        <thead class="bg-primary">
                                            <tr class="text-center">
                                                <td width="4%">NO</td>
                                                <td width="10%">ITEM NO</td>
                                                <td>ITEM NAME</td>
                                                <td width="12%">QTY</td>
                                                <td width="6%">UNIT</td>
                                                <td width="12%">PRICE</td>
                                                <td width="12%">AMOUNT</td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $no = 1;
                                            $totaldpp = 0;
                                            foreach ($dsr as $row) :
                                                $totaldpp += $row['subtotal'];
                                            ?>
                                                <tr>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm  text-center" value="<?= $no++ ?>" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm " value="<?= $row['kode_barang'] ?>" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm " value="<?= $row['nama_barang'] ?>" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm  text-right" value="<?= $row['qty'] ?>" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm  text-center" value="<?= $row['kode_satuan'] ?>" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm  text-right" value="<?= number_format($row['harga'], 0) ?>" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm  text-right" value="<?= number_format($row['subtotal'], 0) ?>" readonly></td>
                                                </tr>
                                            <?php endforeach; ?>

                                        </tbody>

                                        <tr>
                                            <td colspan="6" class="text-right">SUB TOTAL :</td>
                                            <td class="p-0">
                                                <input type="text" id="total_dpp" name="total_dpp" class="form-control form-control-sm text-right" value="<?= number_format($totaldpp, 0) ?>" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right">TOTAL PPN :</td>
                                            <td class="p-0">
                                                <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm text-right" value="<?= number_format($totaldpp * 0.11, 0) ?>" readonly>
                                            </td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td colspan="6" class="text-right">TOTAL RETURN :</td>
                                            <td class="p-0">
                                                <input type="text" id="total_retur" name="total_retur" class="form-control form-control-sm text-right text-bold" value="<?= number_format($totaldpp * 1.11, 0) ?>" readonly>
                                            </td>

                                        </tr>

                                    </table>
                                    <a href="<?= base_url('SalesRtn') ?>" type="button" class="btn btn-primary btn-sm ml-2 mt-2"><i class="fas fa-angle-double-left"></i>
                                        BACK</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="viewmodal" style="display: none;"></div>

    </div>
</div>


<?= $this->endSection() ?>