<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center mt-1">
    <div class="col-md-12">
        <div class="card card-primary" style="background-color: lightskyblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">PURCHASE ORDER</h3>
                <a href="<?= base_url('PurchOrd') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>
            <div class="card-body">
                <div class="card" style="background-color: #d0ecff;">
                    <div class="row p-3">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-2">SUPPLIER ID</div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm  kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" value="<?= $po['kode_supplier'] ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">SUPPLIER NAME</div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm"value="<?= $po['nama_supplier'] ?>" readonly>
                                    <input type="hidden" name="status" id="status" value="<?= $po['status'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">ADDRESS</div>
                                <div class="col-md-8">
                                    <input type="text" name="address1" id="address1" class="form-control form-control-sm"value="<?= $po['address1'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address2" id="address2" class="form-control form-control-sm"value="<?= $po['address2'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address3" id="address3" class="form-control form-control-sm"value="<?= $po['address3'] ?>" readonly>
                                </div>
                            </div>


                        </div>

                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-3">NO. PO</div>
                                <div class="col-md-4">
                                    <input type="text" name="no_po" id="no_po" class="form-control form-control-sm   text-bold text-danger" value="<?= $po['no_po'] ?>" readonly>
                                    <div class="errorNoPo invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">DATE PO</div>
                                <div class="col-md-3">
                                    <input type="date" name="tgl_po" id="tgl_po" class="form-control form-control-sm  " value="<?= $po['tgl_po'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">PAYMENT</div>
                                <div class="col-md-5">
                                    <input type="text" name="termin" id="termin" class="form-control form-control-sm" value="<?= $po['termin'] ?>" readonly>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-3">CURRENCY</div>
                                <div class="col-md-2">
                                    <input type="text" name="currency" id="currency" class="form-control form-control-sm" value="<?= $po['currency'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">DESCRIPTION</div>
                                <div class="col-md-9">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" value="<?= $po['keterangan'] ?>" readonly>
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
                                                <td width="8%">QTY</td>
                                                <td width="6%">UNIT</td>
                                                <td width="12%">PRICE</td>
                                                <td width="12%">AMOUNT</td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $no = 1;
                                            $totaldpp = 0;
                                            foreach ($dpo as $row) :
                                                $totaldpp += $row['subtotal'];
                                            ?>
                                                <tr>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['kode_barang'] ?>" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['nama_barang'] ?>" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= $row['qty'] ?>" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $row['kode_satuan'] ?>" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['harga'], 2) ?>" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['subtotal'], 2) ?>" readonly></td>

                                                </tr>
                                            <?php endforeach; ?>
                                            <?php 
                                                if ($po['status'] == 'PKP') {
                                                    $totalppn = $totaldpp * 0.11;
                                                } else {
                                                    $totalppn = $totaldpp * 0;
                                                }
                                                $totalpo = $totalppn + $totaldpp;
                                            ?>
                                        </tbody>
                                        <tr>
                                            <td colspan="6" class="text-right">TOTAL DPP :</td>
                                            <td class="p-0">
                                                <input type="text" id="total_dpp" name="total_dpp" class="form-control form-control-sm  text-right" value="<?= number_format($totaldpp, 2) ?>" readonly>
                                                <input type="hidden" id="totalitem" name="totalitem">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right">TOTAL PPN :</td>
                                            <td class="p-0">
                                                <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm  text-right total_ppn autonum" value="<?= number_format($totalppn, 2) ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right">TOTAL PO :</td>
                                            <td class="p-0">
                                                <input type="text" id="total_po" name="total_po" class="form-control form-control-sm text-right" value="<?= number_format($totalpo, 2) ?>" readonly>
                                            </td>
                                        </tr>

                                    </table>
                                    <a href="<?= base_url('PurchOrd') ?>" type="button" class="btn btn-success btn-sm ml-2 mt-2"><i class="fas fa-angle-double-left"></i>
                                        BACK</a>
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