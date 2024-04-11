<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-primary" style="background-color: lightskyblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">DELIVERY ORDER</h3>
                <a href="<?= base_url('SuratJln') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                <div class="card" style="background-color: #d0ecff;">
                    <div class="row p-3">
                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-md-3">CUSTOMER ID</div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm kode_customer " aria-describedby="basic-addon2" name="kode_customer" id="kode_customer" value="<?= $msuratjln['kode_customer'] ?>" onkeyup="this.value = this.value.toUpperCase()" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">CUSTOMER NAME</div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm" value="<?= $msuratjln['nama_customer'] ?>" readonly>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-3">ADDRESS </div>
                                <div class="col-md-8">
                                    <input type="text" name="address1" id="address1" class="form-control form-control-sm" value="<?= $msuratjln['address1'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-8">
                                    <input type="text" name="address2" id="address2" class="form-control form-control-sm" value="<?= $msuratjln['address2'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-8">
                                    <input type="text" name="address3" id="address3" class="form-control form-control-sm" value="<?= $msuratjln['address3'] ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-md-3">No. DO</div>
                                <div class="col-md-5">
                                    <input type="text" name="no_suratjln" id="no_suratjln" class="form-control form-control-sm text-bold text-danger text-md" value="<?= $msuratjln['no_suratjln'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">DATE DO</div>
                                <div class="col-md-3">
                                    <input type="date" name="tgl_suratjln" id="tgl_suratjln" class="form-control form-control-sm" value="<?= $msuratjln['tgl_suratjln'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">NO. SO</div>
                                <div class="col-md-5">
                                    <input type="text" name="no_so" id="no_so" class="form-control form-control-sm" value="<?= $msuratjln['no_so'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">NO. PO</div>
                                <div class="col-md-6">
                                    <input type="text" name="no_po" id="no_po" class="form-control form-control-sm" value="<?= $msuratjln['no_po'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form group row">
                                <div class="col-md-3">MARKETING</div>
                                <div class="col-sm-8">
                                    <input type="text" name="project" id="project" class="form-control form-control-sm" value="<?= $msuratjln['project'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form group row">
                                <div class="col-md-3">DESCRIPTION</div>
                                <div class="col-sm-8">
                                    <input type="text" name="remark" id="remark" class="form-control form-control-sm" value="<?= $msuratjln['remark'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 dataDetailInv" id="dataDetailInv">
                        <div class="card" style="background-color: #d0ecff">
                            <div class="row p-3">
                                <div class="col-md-12">
                                    <div class="mx-2">
                                        <table class="table table-bordered table-sm" width="100%">
                                            <thead class="bg-primary">
                                                <tr class="text-center">
                                                    <td width="4%">NO</td>
                                                    <td width="10%">ITEM NO</td>
                                                    <td>ITEM NAME</td>
                                                    <td width="8%">QTY</td>
                                                    <td width="6%">UNIT</td>
                                                    <td width="30%">NOTE</td>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $no = 1;
                                                foreach ($dsuratjln as $row) :
                                                ?>
                                                    <tr>
                                                        <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" readonly></td>
                                                        <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['kode_barang'] ?>" readonly></td>
                                                        <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['nama_barang'] ?>" readonly></td>
                                                        <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['qty'], 2) ?>" readonly></td>
                                                        <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $row['kode_satuan'] ?>" readonly></td>
                                                        <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['catatan'] ?>" readonly></td>
                                                    </tr>
                                                <?php
                                                endforeach;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>