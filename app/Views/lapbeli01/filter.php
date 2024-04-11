<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center text-bold" style="height: 50px;">
                    <p style="font-size: 18px;">LAPORAN PEMBELIAN PER PERIODE</p>
                </div>
                <div class="card-body text-md">
                    <?= form_open('LapBeli01/preview') ?>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-5">
                            <label style="font-weight: normal;">TYPE LAPORAN</label>
                            <select name="typelap" class="form-control form-control-sm text-md">
                                <option value="REKAP">REKAP</option>
                                <option value="DETAIL">DETAIL</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-5">
                            <label style="font-weight: normal;">DARI TANGGAL</label>
                            <input type="date" name="dari" value="<?= $dari ?>" class="form-control form-control-sm text-md">
                        </div>
                        <div class=" form-group col-md-5">
                            <label style="font-weight: normal;">S/D TANGGAL</label>
                            <input type="date" name="sampai" value="<?= $sampai ?>" class="form-control form-control-sm text-md">
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-sm btn-success mt-3" name="btnCetak" type="submit"><i class="fa fa-print"></i> TAMPILKAN</button>
                        <button class="btn btn-sm btn-primary mt-3" name="btnExport" type="submit"><i class="fa fa-file-excel"></i> EXPORT TO EXCEL</button>
                        <a href="<?= base_url() ?>/admin" class="btn btn-sm btn-danger mt-3"><i class="fas fa-sign-out-alt"></i> KELUAR</a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>