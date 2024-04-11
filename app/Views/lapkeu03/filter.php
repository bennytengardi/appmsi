<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-4 mt-5">
        <div class="card" style="height: 100%;background-color: #d7ecff;">
            <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                <p style="font-size: 18px;">PROFIT & LOSS</p>
            </div>
            <div class="card-body">
                <?= form_open('LapKeu03/preview') ?>
                <br>
                <div class="row">
                    <div class="form-group col-md-4 offset-2">
                        <label>From Date</label>
                        <input type="date" name="dari" value="<?= $dari ?>" class="form-control form-control-sm border-secondary">
                    </div>

                    <div class=" form-group col-md-4">
                        <label>To Date</label>
                        <input type="date" name="sampai" value="<?= $sampai ?>" class="form-control form-control-sm border-secondary">
                    </div>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-sm btn-success mt-3" name="btnCetak" type="submit"><i class="fa fa-print"></i> Print</button>
                    <button class="btn btn-sm btn-primary mt-3" name="btnExport" type="submit"><i class="fa fa-file-excel"></i> Excel</button>
                    <a href="<?= base_url() ?>/admin" class="btn btn-sm btn-danger mt-3"><i class="fas fa-sign-out-alt"></i> Exit</a>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>