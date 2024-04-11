<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-primary" style="background-color: lightskyblue;">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">SALES INVOICE</h3>
                <a href="<?= base_url('SalesInv') ?>" type="button" class="btn btn-sm mb-2 float-right">
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
                                        <input type="text" class="form-control form-control-sm" id="kode_customer" value="<?= $minvoice['kode_customer'] ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">CUSTOMER NAME</div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm" value="<?= $minvoice['nama_customer'] ?>" readonly>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-3">ADDRESS</div>
                                <div class="col-md-8">
                                    <input type="text" name="address1" id="address1" class="form-control form-control-sm" value="<?= $minvoice['address1'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-8">
                                    <input type="text" name="address2" id="address2" class="form-control form-control-sm" value="<?= $minvoice['address2'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">DIVISI</div>
                                <div class="col-md-3">
                                    <input type="text" name="kode_divisi" id="kode_divisi" class="form-control form-control-sm" value="<?= $minvoice['kode_divisi'] ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-md-3">NO INVOICE</div>
                                <div class="col-md-5">
                                    <input type="text" name="no_invoice" id="no_invoice" class="form-control form-control-sm text-bold text-danger" value="<?= $minvoice['no_invoice'] ?>" readonly>
                                    <input type="hidden" name="id_inv" id="id_inv" value="<?= $minvoice['id_inv'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">DATE INVOICE</div>
                                <div class="col-md-3">
                                    <input type="date" name="tgl_invoice" id="tgl_invoice" class="form-control form-control-sm" value="<?= $minvoice['tgl_invoice'] ?>" readonly>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-3">PEMBAYARAN</div>
                                <div class="col-md-9">
                                    <input type="text" name="pembayaran" id="pembayaran" class="form-control form-control-sm" value="<?= $minvoice['pembayaran'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">NO DO</div>
                                <div class="col-md-5">
                                <input type="text" name="due_date" id="due_date" class="form-control form-control-sm" value="<?= $minvoice['no_suratjln'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">DESCRIPTION</div>
                                <div class="col-md-9">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" value="<?= $minvoice['keterangan'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="background-color: #d0ecff">
                    <div class="row p-3">
                        <div class="col-md-12">
                            <div class="mx-0">
                                <table class="table table-bordered table-sm" width=100%>
                                    <thead class="bg-primary">
                                        <tr class="text-center">
                                            <td width="3%">NO</td>
                                            <td width="10%">ITEM NO</td>
                                            <td>ITEM NAME</td>
                                            <td width="6%">QTY</td>
                                            <td width="6%">UNIT</td>
                                            <td width="10%">PRICE</td>
                                            <td width="12%">AMOUNT</td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $no = 1;
                                        $totalamt = 0;
                                        foreach ($dinvoice as $row) :
                                        ?>
                                            <tr class="bg-white">
                                                <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['kode_barang'] ?>" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['nama_barang'] ?>" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= $row['qty'] ?>" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $row['kode_satuan'] ?>" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['harga'], 2) ?>" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['subtotal'], 0) ?>" readonly></td>
                                            </tr>
                                        <?php endforeach;
                                        ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="text-center bg-primary">TOTAL AMOUNT</div>
                                            <input type=" text" id="total_amount" name="total_amount" class="form-control form-control-sm text-right" value="<?= number_format($minvoice['total_amount'],0) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <div class="text-center bg-primary">DISCOUNT</div>
                                            <input type="text" id="total_discount" name="total_discount" class="form-control form-control-sm text-right" value="<?= number_format($minvoice['total_discount'],0) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="text-center bg-primary">TOTAL DP</div>
                                            <input type="text" id="total_dp" name="total_dp" class="form-control form-control-sm text-right total_dp autonum" value="<?= number_format($minvoice['total_dp'],0) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="text-center bg-primary">TOTAL DPP</div>
                                            <input type="text" id="total_dpp" name="total_dpp" class="form-control form-control-sm text-right" value="<?= number_format($minvoice['total_dpp'],0) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="text-center bg-primary">TOTAL PPN</div>
                                            <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm text-right" value="<?= number_format($minvoice['total_ppn'],0) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <div class="text-center bg-primary">ONGKIR</div>
                                            <input type="text" id="ongkir" name="ongkir" class="form-control form-control-sm text-right" value="<?= number_format($minvoice['ongkir'],0) ?>" readonly> 
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="text-center bg-primary">TOTAL INVOICE</div>
                                            <input type="text" id="total_invoice" name="total_invoice" class="form-control form-control-sm text-right text-danger text-bold" value="<?= number_format($minvoice['total_invoice'],0) ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                 <a href="<?= base_url('SalesInv') ?>" type="button" class="btn btn-success btn-sm ml-2 mt-2"><i class="fas fa-angle-double-left"></i>
                                        KEMBALI</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>