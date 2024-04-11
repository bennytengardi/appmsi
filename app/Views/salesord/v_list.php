<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title mt-n1">SALES ORDER</h3>
                <a href="<?= base_url('SalesOrd') ?>" type="button" class="btn btn-sm mt-n1 mb-2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>

            <div class="card-body" style="font-size: 12px;">
                <div class="row px-3">
                    <div class="col-sm-7">
                        <div class="row">
                            <div class="col-md-2">CUSTOMER ID</div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm kode_customer " aria-describedby="basic-addon2" name="kode_customer" id="kode_customer" style="font-size: 12px;height:26px;" value="<?= $msalesord['kode_customer'] ?>" onkeyup="this.value = this.value.toUpperCase()" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">CUSTOMER NAME</div>
                            <div class="col-md-8">
                                <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm"  style="font-size: 12px;height:26px;" value="<?= $msalesord['nama_customer'] ?>" readonly>
                                <input type="hidden" name="status" id="status" value="<?= $msalesord['status'] ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">ADDRESS </div>
                            <div class="col-md-8">
                                <input type="text" name="address1" id="address1" class="form-control form-control-sm" style="font-size: 12px;height:26px;" value="<?= $msalesord['address1'] ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2"> </div>
                            <div class="col-md-8">
                                <input type="text" name="address2" id="address2" class="form-control form-control-sm" style="font-size: 12px;height:26px;" value="<?= $msalesord['address2'] ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2 col-form-label">NAMA PEMESAN</div>
                            <div class="col-md-4">
                                <input type="text" name="nama_pemesan" id="nama_pemesan" class="form-control form-control-sm" style="font-size: 12px;height:26px;" value="<?= $msalesord['nama_pemesan'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-n2">
                            <div class="col-md-2 col-form-label">NO HP</div>
                            <div class="col-md-4">
                                <input type="text" name="no_handphone" id="no_handphone" class="form-control form-control-sm" style="font-size: 12px;height:26px;" value="<?= $msalesord['no_handphone'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-n2">
                            <div class="col-md-2 col-form-label">NAMA PROYEK</div>
                            <div class="col-md-8">
                                <input type="text" name="nama_proyek" id="nama_proyek" class="form-control form-control-sm" style="font-size: 12px;height:26px;" value="<?= $msalesord['nama_proyek'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-n2">
                            <div class="col-md-2">DIVISI</div>
                            <div class="col-md-3">
                                <input type="text" name="nama_proyek" id="nama_proyek" class="form-control form-control-sm" style="font-size: 12px;height:26px;" value="<?= $msalesord['kode_divisi'] ?>" readonly>
                            </div>
                        </div>                           
                    </div>

                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-md-3">NO SALES ORDER</div>
                            <div class="col-md-5">
                                <input type="text" name="no_so" id="no_so" class="form-control form-control-sm text-bold text-danger" style="font-size: 12px;height:26px;" value="<?= $msalesord['no_so'] ?>" readonly>
                                <input type="hidden" name="id_so" id="id_so" value="<?= $msalesord['id_so'] ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">TGL SALES ORDER</div>
                            <div class="col-md-3">
                                <input type="date" name="tgl_so" id="tgl_so" class="form-control form-control-sm" value="<?= $msalesord['tgl_so'] ?>" style="font-size: 12px;height:26px;" readonly>
                            </div>
                        </div>                            
                        <div class="row">
                            <div class="col-md-3">NO PO</div>
                            <div class="col-md-5">
                                <input type="text" name="no_po" id="no_po" class="form-control form-control-sm" style="font-size: 12px;height:26px;"  value="<?= $msalesord['no_po'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">PEMBAYARAN</div>
                            <div class="col-md-5">
                                <input type="text" name="pembayaran" id="pembayaran" class="form-control form-control-sm" style="font-size: 12px;height:26px;"  value="<?= $msalesord['pembayaran'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">TGL KIRIM</div>
                            <div class="col-md-5">
                                <input type="text" name="tgl_kirim" id="tgl_kirim" class="form-control form-control-sm" style="font-size: 12px;height:26px;" value="<?= $msalesord['tgl_kirim'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">LOKASI KIRIM</div>
                            <div class="col-md-9">
                                <input type="text" name="lokasi_kirim" id="lokasi_kirim" class="form-control form-control-sm" style="font-size: 12px;height:26px;" value="<?= $msalesord['lokasi_kirim'] ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">CATATAN</div>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="catatan1" id="catatan1" style="font-size: 12px;height:26px;" value="<?= $msalesord['catatan1'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="catatan2" id="catatan2" style="font-size: 12px;height:26px;" value="<?= $msalesord['catatan2'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="catatan3" id="catatan3" style="font-size: 12px;height:26px;" value="<?= $msalesord['catatan3'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="catatan4" id="catatan4" style="font-size: 12px;height:26px;" value="<?= $msalesord['catatan4'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        foreach ($dsalesord as $row) :
                                        ?>
                                            <tr class="bg-white">
                                                <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;background-color: white;" value="<?= $no++ ?>" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['kode_barang'] ?>" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['nama_barang'] ?>" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['qty'] ?>" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm text-center" style="font-size:12px;height: 26px;background-color: white;" value="<?= $row['kode_satuan'] ?>" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($row['harga'], 2) ?>" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($row['subtotal'], 2) ?>" readonly></td>
                                            </tr>
                                        <?php endforeach;
                                        ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="text-center bg-primary">TOTAL AMOUNT</div>
                                            <input type=" text" id="total_amount" name="total_amount" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($msalesord['total_amount'],2) ?>" readonly>
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="text-center bg-primary">TOTAL PPN</div>
                                            <input type="text" id="total_ppn" name="total_ppn" class="form-control form-control-sm text-right" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($msalesord['total_ppn'],2) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="text-center bg-primary">TOTAL SO</div>
                                            <input type="text" id="total_invoice" name="total_invoice" class="form-control form-control-sm text-right text-danger text-bold" style="font-size:12px;height: 26px;background-color: white;" value="<?= number_format($msalesord['total_so'],2) ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                 <a href="<?= base_url('SalesOrd') ?>" type="button" class="btn btn-success btn-xs mt-2"><i class="fas fa-angle-double-left"></i>
                                        KEMBALI</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>