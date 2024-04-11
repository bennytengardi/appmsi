<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center mt-1">
    <div class="col-md-12" style="font-size: 13px;">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title">PENERIMAAN KAS/BANK</h3>
                <a href="<?= base_url('OthRcv') ?>" type="button" class="btn btn-sm mb-2 mt-n2 float-right">
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
                            <div class="col-sm-2">NO VOUCHER</div>
                            <div class="col-sm-2">
                                <input type="text" name="no_bukti" id="no_bukti" class="form-control form-control-sm text-bold text-danger" style="font-size: 13px;height: 26px;" value="<?= $mothrcv['no_bukti'] ?>" readonly>
                                <input type="hidden" name="id_bukti" id="id_bukti" value="<?= $mothrcv['id_bukti'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">DATE</div>
                            <div class="col-sm-2">
                                <input type="date" name="tgl_bukti" id="tgl_bukti" class="form-control form-control-sm " style="font-size: 13px;height: 26px;" value="<?= $mothrcv['tgl_bukti'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">NO CHEQUE</div>
                            <div class="col-sm-2">
                                <input type="text" name="no_cheque" id="no_cheque" class="form-control form-control-sm " style="font-size: 13px;height: 26px;"  value="<?= $mothrcv['no_cheque'] ?>" onkeyup="this.value = this.value.toUpperCase()" readonly>
                            </div>
                        </div>                
                        <div class="row">
                            <div class="col-sm-2">DEPOSIT TO</div>
                            <div class="col-sm-4">
                                <input type="text" name="no_cheque" id="no_cheque" class="form-control form-control-sm " style="font-size: 13px;height: 26px;"  value="<?= $mothrcv['nama_account'] ?>" onkeyup="this.value = this.value.toUpperCase()" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <?php if ($mothrcv['currency'] != 'IDR') { ?>
                                <div class="col-sm-2" id="textkurs">KURS</div>
                                <div class="col-sm-1" id="inputkurs">
                                    <input type="text" class="form-control form-control-sm text-right" name="kurs" id="kurs" style="font-size: 13px;height: 26px;" value="<?= $mothrcv['nilai_tukar'] ?>" readonly>
                                </div>
                            <?php } else { ?>
                                <div class="col-sm-2" id="textkurs"></div>
                                <div class="col-sm-1" id="inputkurs">
                                    <input type="hidden" class="form-control form-control-sm text-right" name="kurs" id="kurs"  style="font-size: 13px;height: 26px;" value="<?= $mothrcv['nilai_tukar'] ?>" readonly >
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">DESCRIPTION</div>
                            <div class="col-sm-8">
                                <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" style="font-size: 13px;height: 26px;" value="<?= $mothrcv['keterangan'] ?>" readonly>
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
                                        <td width="4%">NO</td>
                                        <td width="8%">ACCOUNT#</td>
                                        <td>ACCOUNT NAME</td>
                                        <td width="12%">AMOUNT IDR</td>
                                        <td width="35%">DESCRIPTION</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $no = 1;
                                        $total = 0;
                                        foreach ($dothrcv as $row) :
                                            $total += $row['jumlah'];
                                        ?>
                                            <tr>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm text-center" value="<?= $no++ ?>"  style="font-size:13px;height: 26px;background-color: white;" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['kode_account'] ?>"  style="font-size:13px;height: 26px;background-color: white;" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['nama_account'] ?>"  style="font-size:13px;height: 26px;background-color: white;" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['jumlah'], 2) ?>"  style="font-size:13px;height: 26px;background-color: white;" readonly></td>
                                                <td class="p-0"><input type="text" class="form-control form-control-sm" value="<?= $row['keterangan'] ?>"  style="font-size:13px;height: 26px;background-color: white;" readonly></td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    ?>
                                </tbody>

                                <tr>
                                    <td colspan="3" class="text-right text-bold">TOTAL :</td>
                                    <td class="p-0">
                                        <input type="text" id="total" name="total" class="form-control form-control-sm  text-right text-danger text-bold"  style="font-size:13px;height: 26px;background-color: white;" value="<?= number_format($total, 2) ?>" readonly>
                                    </td>
                                </tr>
                            </table>
                            <a href="<?= base_url('OthRcv') ?>" type="button" class="btn btn-success btn-xs ml-2 mt-2"><i class="fas fa-angle-double-left"></i>
                                BACK</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>


