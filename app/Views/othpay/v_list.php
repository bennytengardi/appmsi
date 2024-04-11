<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
    <div class="card-header" style="height: 40px;">
        <h3 class="card-title mt-n1">PENGELUARAN KAS/BANK</h3>
        <a href="<?= base_url('OthPay') ?>" type="button" class="btn btn-sm mb-2 mt-n1 float-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </a>
    </div>
    <div class="card-body" style="font-size: 13px;">
        <div class="row">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-3">NO VOUCHER</div>
                    <div class="col-sm-6">
                        <input type="text" name="no_bukti" id="no_bukti" class="form-control form-control-sm  text-bold text-danger" style="font-size: 13px;height: 26px;" value="<?= $mothpay['no_bukti'] ?>" readonly>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-sm-3">DATE</div>
                    <div class="col-sm-4">
                        <input type="date" name="tgl_bukti" id="tgl_bukti" class="form-control form-control-sm " style="font-size: 13px;height: 26px;" value="<?= $mothpay['tgl_bukti'] ?>" readonly>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-sm-3">PAID FROM</div>
                    <div class="col-sm-8">
                        <input type="text" name="kode_account" id="kode_account" class="form-control form-control-sm " style="font-size: 13px;height: 26px;" value="<?= $mothpay['nama_account'] ?>"  readonly>
                    </div>
                </div>

                <div class="row ">
                    <?php if ($mothpay['currency'] != 'IDR') { ?>
                        <div class="col-sm-3" id="textkurs">KURS</div>
                        <div class="col-sm-3" id="inputkurs">
                            <input type="text" class="form-control form-control-sm text-right" name="kurs" id="kurs" style="font-size: 13px;height: 26px;" value="<?= $mothpay['nilai_tukar'] ?>" readonly>
                        </div>
                    <?php } else { ?>
                        <div class="col-sm-3" id="textkurs"></div>
                        <div class="col-sm-3" id="inputkurs">
                            <input type="hidden" class="form-control form-control-sm text-right" name="kurs" id="kurs" value="<?= $mothpay['nilai_tukar'] ?>" >
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-6 offset-1">
                <div class="row">
                    <div class="col-sm-2">NO CHEQUE</div>
                    <div class="col-sm-2">
                        <input type="text" name="no_cheque" id="no_cheque" class="form-control form-control-sm" style="font-size: 13px;height: 26px;" value="<?= $mothpay['no_cheque'] ?>" readonly>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-md-2">DIVISI</div>
                    <div class="col-md-3">
                        <input type="text" name="kode_divisi" id="kode_divisi" class="form-control form-control-sm " style="font-size: 13px;height: 26px;" value="<?= $mothpay['kode_divisi'] ?>" readonly>
                    </div>
                </div>                    
            
                <div class="row ">
                    <div class="col-sm-2">PAYEE</div>
                    <div class="col-sm-6">
                        <input type="text" name="kepada" id="kepada" class="form-control form-control-sm " style="font-size: 13px;height: 26px;" value="<?= $mothpay['kepada'] ?>"  readonly>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-sm-2">DESCRIPTION</div>
                    <div class="col-sm-9">
                        <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" style="font-size: 13px;height: 26px;" value="<?= $mothpay['keterangan'] ?>"  readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-0 mt-3">
            <table class="table table-bordered table-sm" width="100%">
                <thead class="bg-primary">
                    <tr class="text-center">
                        <td width="4%">NO</td>
                        <td width="8%">ACCOUNT#</td>
                        <td>ACCOUNT NAME</td>
                        <td width="12%">ACCOUNT IDR</td>
                        <td width="35%">DESCRIPTION</td>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    $total = 0;
                    foreach ($dothpay as $row) :
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
                        <input type="text" id="total" name="total" class="form-control form-control-sm  text-right text-danger text-bold" style="font-size: 13px;height: 26px;"" value="<?= number_format($total, 2) ?>" readonly>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
        <a href="<?= base_url('OthPay') ?>" type="button" class="btn btn-primary btn-xs tombolSimpanPo ml-2 mt-2"><i class="fas fa-angle-double-left"></i>
            BACK</a>
    </div>
</div>

<?= $this->endSection() ?>