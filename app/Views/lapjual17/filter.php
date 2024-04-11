<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 20px;">Sales By Division</p>
                </div>
                <div class="card-body">
                    <?= form_open('LapJual17/preview') ?>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Type</label>
                            <select name="typelap" class="form-control form-control-sm">
                                <option value="REKAP">Summary</option>
                                <option value="DETAIL">Detail</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Division</label>
                            <select name="kode_divisi" id="kode_divisi" class="form-control form-control-sm">
                                <option value="">Choose Division</option>
                                <?php foreach ($divisi as $sls) : ?>
                                    <option value="<?= $sls['kode_divisi'] ?>"><?= $sls['kode_divisi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>From</label>
                            <input type="date" name="dari" value="<?= $dari ?>" class="form-control form-control-sm">
                        </div>

                        <div class=" form-group col-md-4">
                            <label>To</label>
                            <input type="date" name="sampai" value="<?= $sampai ?>" class="form-control form-control-sm">
                        </div>

                    </div>
                    
                     <div class="form-group">
                        <button class="btn btn-sm btn-success mt-3" name="btnCetak" type="submit"><i class="fa fa-print"></i> Preview</button>
                        <button class="btn btn-sm btn-primary mt-3" name="btnExport" type="submit"><i class="fa fa-file-excel"></i> Export to Excel</button>
                        <a href="<?= base_url() ?>/admin" class="btn btn-sm btn-danger mt-3"><i class="fas fa-sign-out-alt"></i> Exit</a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>