<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center mt-1">
    <div class="col-md-12" style="font-size: 12px;">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title">PURCHASE INVOICE</h3>
                <a href="<?= base_url('PurchInv') ?>" type="button" class="btn btn-sm mb-2 mt-n2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>
            <div class="card-body">
                <div class="row px-3">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-2">KODE SUPPLIER</div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" style="font-size: 12px;height: 28px;" value="<?= $pi['kode_supplier'] ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">NAMA SUPPLIER</div>
                            <div class="col-md-8">
                                <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" style="font-size: 12px;height: 28px;"  value="<?= $pi['nama_supplier'] ?>" readonly>
                                <input type="hidden" name="status" id="status"  value="<?= $pi['status'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">ALAMAT</div>
                            <div class="col-md-8">
                                <input type="text" name="address1" id="address1" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $pi['address1'] ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input type="text" name="address2" id="address2" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $pi['address2'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">DIVISI</div>
                            <div class="col-md-3">
                                <input type="text" name="kode_divisi" id="kode_divisi" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $pi['kode_divisi'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">KETERANGAN</div>
                            <div class="col-md-10">
                                <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $pi['keterangan'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">FORM NO</div>
                            <div class="col-md-4">
                                <input type="text" name="no_invoice" id="no_invoice" class="form-control form-control-sm text-bold text-danger" style="font-size: 12px;height: 28px;" value="<?= $pi['no_invoice'] ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">TGL INVOICE</div>
                            <div class="col-md-4">
                                <input type="date" name="tgl_invoice" id="tgl_invoice" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $pi['tgl_invoice'] ?>" readonly>
                                <input type="hidden" name="kode_accinv" id="kode_accinv" value="<?= $pi['kode_accinv'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">NO INVOICE</div>
                            <div class="col-md-8">
                                <input type="text" name="invoice_supp" id="invoice_supp" class="form-control form-control-sm" style="font-size: 12px;height: 28px;" value="<?= $pi['invoice_supp'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">CURRENCY</div>
                            <div class="col-md-2">
                                <input type="text" name="currency" id="currency" class="form-control form-control-sm" style="font-size: 12px;height: 28px;"  value="<?= $pi['currency'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <?php if ($pi['currency'] != 'IDR') { ?>
                                <div class="col-sm-4" id="textkurs">EXCHANGE RATE</div>
                                <div class="col-sm-2" id="inputkurs">
                                    <input type="text" class="form-control form-control-sm text-right" name="kurs" id="kurs" style="font-size: 12px;height: 28px;" value="<?= $pi['kursbeli'] ?>" readonly>
                                </div>
                            <?php } else { ?>
                                <div class="col-sm-4" id="textkurs"></div>
                                <div class="col-sm-2" id="inputkurs">
                                    <input type="hidden" class="form-control form-control-sm text-right" name="kurs" id="kurs" style="font-size: 12px;height: 28px;" value="<?= $pi['kursbeli'] ?>" readonly>
                                </div>
                            <?php } ?>
                        </div>                        
                            
                        <div class="row">
                            <div class="col-md-4">NO PO</div>
                            <div class="col-md-6">
                                <input type="text" name="no_po" id="no_po" class="form-control form-control-sm" style="font-size: 12px;height: 28px;"  value="<?= $pi['no_po'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">ACCOUNT</div>
                            <div class="col-md-8">
                                <input type="text" name="kode_account" id="kode_account" class="form-control form-control-sm" style="font-size: 12px;height: 28px;"  value="<?= $pi2['nama_account'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row px-3 mt-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" width="100%">
                                <thead class="bg-primary">
                                    <tr class="text-center">
                                        <td width="3%">NO</td>
                                        <td width="12%">ITEM NO</td>
                                        <td>ITEM NAME</td>
                                        <td width="8%">QTY</td>
                                        <td width="5%">UNIT</td>
                                        <td width="12%">PRICE</td>
                                        <td width="12%">AMOUNT</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $no = 1;
                                    $totaldpp = 0;
                                    foreach ($dpi as $row) :
                                        
                                    ?>
                                    <tr>
                                        <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;background-color: white;" value="<?= $no++ ?>" readonly></td>
                                        <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['kode_barang'] ?>" readonly></td>
                                        <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['nama_barang'] ?>" readonly></td>
                                        <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['qty'] ?>" readonly></td>
                                        <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['kode_satuan'] ?>" readonly></td>
                                        <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($row['harga'], 2) ?>" readonly></td>
                                        <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($row['subtotal'], 2) ?>" readonly></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>

                                <tr>
                                    <td colspan="6" class="text-right">TOTAL AMOUNT :</td>
                                    <td class="p-0">
                                        <input type="text" id="total_amount" name="total_amount" class="form-control form-control-sm  text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($pi['total_amount'], 2) ?>"  readonly>
                                        <input type="hidden" id="totalitem" name="totalitem">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right">TOTAL DISCOUNT :</td>
                                    <td class="p-0">
                                        <input type="text" id="total_discount" name="total_discount" class="form-control form-control-sm autonum2 total_discount text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($pi['total_discount'], 2) ?>" readonly>
                                    </td>
                                    <td></td>
                                </tr>
                                
                                <tr>
                                    <td colspan="6" class="text-right">TOTAL DPP :</td>
                                    <td class="p-0">
                                        <input type="text" id="total_dpp" name="total_dpp" class="form-control form-control-sm  text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($pi['total_dpp'], 2) ?>" readonly>
                                        <input type="hidden" id="totalitem" name="totalitem">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">PPN (%) :</td>
                                    <td class="p-0">
                                        <input type="text" id="vat" name="vat" class="form-control form-control-sm text-right vat" style="font-size:12px;height: 26px;background-color: white;"  value="<?= $pi['vat'] ?>" readonly>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm  text-right total_ppn" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($pi['total_ppn'], 2) ?>" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right">TOTAL INVOICE :</td>
                                    <td class="p-0">
                                        <input type="text" id="total_invoice" name="total_invoice" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($pi['total_invoice'], 2) ?>" readonly>
                                    </td>
                                </tr>
                            </table>
                            <a href="<?= base_url('PurchInv') ?>" type="button" class="btn btn-success btn-xs ml-2 mt-2"><i class="fas fa-angle-double-left"></i>
                                BACK</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>