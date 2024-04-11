<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-5">
            <div class="card" style="height: 100%;background-color: #d7ecff;">
                <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 16px;">Balance Sheet (Detail)</p>
                </div>
                <div class="card-body">
                    <?= form_open('LapKeu05/preview') ?>
                    <br>
                    <div class="row justify-content-center">
                        <div class="form-group">
                            <label>PERIODE LAPORAN</label>
                            <input type="date" name="sampai" value="<?= $sampai ?>" class="form-control form-control-sm border-secondary">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group">
                            <button class="btn btn-sm btn-success mt-3" name="btnCetak" type="submit"><i class="fa fa-print"></i> PRINT</button>
                            <button class="btn btn-sm btn-primary mt-3" name="btnExport" type="submit"><i class="fa fa-file-excel"></i> EXCEL</button>
                            <a href="<?= base_url() ?>/admin" class="btn btn-sm btn-danger mt-3"><i class="fas fa-sign-out-alt"></i> KELUAR</a>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>