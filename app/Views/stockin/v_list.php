
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center mt-1">
    <div class="col-md-12" style="font-size: 12px;">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title">ITEM RECEIVED</h3>
                <a href="<?= base_url('StockIn') ?>" type="button" class="btn btn-sm mb-2 mt-n2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>
            <div class="card-body">
                <div class="row p-3">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-2">SUPPLIER ID</div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" style="font-size: 12px;height: 26px;" value="<?= $stkin['kode_supplier'] ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">SUPPLIER NAME</div>
                            <div class="col-md-8">
                                <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $stkin['nama_supplier'] ?>" readonly>
                                <input type="hidden" name="status" id="status">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">ADDRESS</div>
                            <div class="col-md-8">
                                <input type="text" name="address1" id="address1" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $stkin['address1'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input type="text" name="address2" id="address2" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $stkin['address2'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">RECEIPT NO</div>
                            <div class="col-md-4">
                                <input type="text" name="no_bukti" id="no_bukti" class="form-control form-control-sm text-bold text-danger" style="font-size: 12px;height: 26px;" value="<?= $stkin['no_bukti'] ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">RECEIVE DATE</div>
                            <div class="col-md-4">
                                <input type="date" name="tgl_bukti" id="tgl_bukti" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $stkin['tgl_bukti'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">NO PO</div>
                            <div class="col-md-6">
                                <input type="text" name="no_po" id="no_po" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $stkin['no_po'] ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">DESCRIPTION</div>
                            <div class="col-md-8">
                                <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $stkin['keterangan'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row px-3">
                    <div class="col-md-11">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" width="100%">
                                <thead class="bg-primary">
                                    <tr class="text-center">
                                        <td width="3%">NO</td>
                                        <td width="15%">ITEM NO</td>
                                        <td>ITEM NAME</td>
                                        <td width="12%">QTY</td>
                                        <td width="8%">UNIT</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $no = 1;
                                    $totaldpp = 0;
                                    foreach ($dstkin as $row) :
                                    ?>
                                    <tr>
                                        <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;background-color: white;" value="<?= $no++ ?>" readonly></td>
                                        <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['kode_barang'] ?>" readonly></td>
                                        <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['nama_barang'] ?>" readonly></td>
                                        <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['qty'] ?>" readonly></td>
                                        <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['kode_satuan'] ?>" readonly></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                </table>
                                <a href="<?= base_url('StockIn') ?>" type="button" class="btn btn-success btn-xs ml-2 mt-2"><i class="fas fa-angle-double-left"></i>
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