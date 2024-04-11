<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center mt-1">
    <div class="col-md-12" style="font-size: 12px;">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title">PURCHASE ORDER</h3>
                <a href="<?= base_url('PurchOrd') ?>" type="button" class="btn btn-sm mb-2 mt-n2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-2">SUPPLIER ID</div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm  kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" style="font-size: 12px; height: 26px;" value="<?= $po['kode_supplier'] ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">SUPPLIER NAME</div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm"  style="font-size: 12px; height: 26px;" value="<?= $po['nama_supplier'] ?>" readonly>
                                    <input type="hidden" name="status" id="status" value="<?= $po['status'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">ADDRESS</div>
                                <div class="col-md-8">
                                    <input type="text" name="address1" id="address1" class="form-control form-control-sm" style="font-size: 12px; height: 26px;" value="<?= $po['address1'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address2" id="address2" class="form-control form-control-sm" style="font-size: 12px; height: 26px;" value="<?= $po['address2'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <input type="text" name="address3" id="address3" class="form-control form-control-sm" style="font-size: 12px; height: 26px;" value="<?= $po['address3'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">U.P</div>
                                <div class="col-md-5">
                                    <input type="text" name="nama_up" id="nama_up" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['nama_up'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">NO. TELEPON</div>
                                <div class="col-md-5">
                                    <input type="text" name="telepon_up" id="telepon_up" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['telepon_up'] ?>" readonly>
                                </div>
                            </div>


                        </div>

                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-3">NO. PO</div>
                                <div class="col-md-4">
                                    <input type="text" name="no_po" id="no_po" class="form-control form-control-sm text-bold text-danger" style="font-size: 12px; height: 26px;" value="<?= $po['no_po'] ?>" readonly>
                                    <div class="errorNoPo invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">DATE PO</div>
                                <div class="col-md-3">
                                    <input type="date" name="tgl_po" id="tgl_po" class="form-control form-control-sm" style="font-size: 12px; height: 26px;" value="<?= $po['tgl_po'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">PAYMENT</div>
                                <div class="col-md-5">
                                    <input type="text" name="termin" id="termin" class="form-control form-control-sm" style="font-size: 12px; height: 26px;" value="<?= $po['termin'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">PEGIRIMAN</div>
                                <div class="col-md-5">
                                    <input type="text" name="tgl_kirim" id="tgl_kirim" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['tgl_kirim']?>" readonly>
                                </div>                                
                            </div>                                
                            <div class="row">
                                <div class="col-md-3">CURRENCY</div>
                                <div class="col-md-2">
                                    <input type="text" name="currency" id="currency" class="form-control form-control-sm" style="font-size: 12px; height: 26px;" value="<?= $po['currency'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">UNTUK PROYEK</div>
                                <div class="col-md-9">
                                    <input type="text" name="proyek" id="proyek" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value = "<?= $po['proyek']  ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">DESCRIPTION</div>
                                <div class="col-md-9">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm"  style="font-size: 12px; height: 26px;"  value="<?= $po['keterangan'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 dataDetailInv" id="dataDetailInv">
                            <div class="row">
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
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $no++ ?>"  style="font-size: 12px; height: 26px;" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['kode_barang'] ?>"  style="font-size: 12px; height: 26px;" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['nama_barang'] ?>"  style="font-size: 12px; height: 26px;" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= $row['qty'] ?>"  style="font-size: 12px; height: 26px;" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $row['kode_satuan'] ?>"  style="font-size: 12px; height: 26px;" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['harga'], 2) ?>" style="font-size: 12px; height: 26px;" readonly></td>
                                                    <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['subtotal'], 2) ?>" style="font-size: 12px; height: 26px;" readonly></td>

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
                                                <input type="text" id="total_dpp" name="total_dpp" class="form-control form-control-sm  text-right" style="font-size: 12px; height: 26px;" value="<?= number_format($totaldpp, 2) ?>" readonly>
                                                <input type="hidden" id="totalitem" name="totalitem">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right">TOTAL PPN :</td>
                                            <td class="p-0">
                                                <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm  text-right total_ppn autonum" style="font-size: 12px; height: 26px;" value="<?= number_format($totalppn, 2) ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right">TOTAL PO :</td>
                                            <td class="p-0">
                                                <input type="text" id="total_po" name="total_po" class="form-control form-control-sm text-right" style="font-size: 12px; height: 26px;" value="<?= number_format($totalpo, 2) ?>" readonly>
                                            </td>
                                        </tr>

                                    </table>
                                    <a href="<?= base_url('PurchOrd') ?>" type="button" class="btn btn-success btn-xs ml-2 mt-2"><i class="fas fa-angle-double-left"></i>
                                        BACK</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>