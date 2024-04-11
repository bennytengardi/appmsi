<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>

<div class="row justify-content-center">
    <div class="col-md-12">

        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 50px;">
                <h3 class="card-title">JOURNAL MEMORIAL</h3>
                <a href="<?= base_url('jurnal') ?>" type="button" class="btn btn-sm mb-2 float-right">
                    <i class="fa fa-times-circle"></i></button></a>
            </div>

            <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4 col-form-label">NO VOUCHER</div>
                                <div class="col-sm-5">
                                    <input type="text" name="no_voucher" id="no_voucher" class="form-control form-control-sm text-md text-bold text-danger" value="<?= $mjurnal['no_voucher'] ?>" readonly>
                                    <input type="hidden" name="counter" id="counter">
                                    <div class="errorNoVoucher invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4 col-form-label">DATE VOUCHER</div>
                                <div class="col-sm-4">
                                    <input type="date" name="tgl_voucher" id="tgl_voucher" class="form-control form-control-sm " value="<?= $mjurnal['tgl_voucher'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-sm" width="100%">
                                <thead class="bg-primary">
                                    <tr class="text-center">
                                        <td width="3%">NO</td>
                                        <td width="8%">ACCOUNT#</td>
                                        <td>ACCOUNT NAME</td>
                                        <td width="12%">DEBET</td>
                                        <td width="12%">CREDIT</td>
                                        <td width="35%">DESCRIPTIONS</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $no = 1;
                                    $totaldebet = 0;
                                    $totalcredit = 0;
                                    foreach ($djurnal as $row) :
                                        $totaldebet += $row['debet'];
                                        $totalcredit += $row['credit'];
                                    ?>
                                        <tr>
                                            <td><input type="text" class="form-control form-control-sm text-center" value="<?= $no++ ?>" style="height: 26px;" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm" value="<?= $row['kode_account'] ?>" style="height: 26px;" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm" value="<?= $row['nama_account'] ?>" style="height: 26px;" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['debet'], 2) ?>" style="height: 26px;" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm text-right" value="<?= number_format($row['credit'], 2) ?>" style="height: 26px;" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm" value="<?= $row['keterangan'] ?>" style="height: 26px;" readonly></td>
                                        </tr>
                                    <?php
                                    endforeach;
                                    ?>

                                </tbody>

                                <tr>
                                    <td colspan="3" class="text-right">TOTAL :</td>
                                    <td>
                                        <input type="text" id="totaldebet" name="totaldebet" class="form-control form-control-sm text-bold text-right text-danger" value="<?= number_format($totaldebet, 2) ?>" readonly>
                                    </td>
                                    <td>
                                        <input type="text" id="totalcredit" name="totalcredit" class="form-control form-control-sm text-bold text-right text-danger" value="<?= number_format($totalcredit, 2) ?>" readonly>
                                    </td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                </div>
                <a href="<?= base_url('Jurnal') ?>" type="button" class="btn btn-primary btn-sm tombolSimpanPo ml-2 mt-2"><i class="fas fa-angle-double-left"></i>
                    BACK</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>