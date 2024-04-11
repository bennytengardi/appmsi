<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 20px;">Invoice Paid By Customer</p>
                </div>
                <div class="card-body">
                    <?= form_open('LapJual05/preview') ?>
                    <br>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Customer Name</label>
                            <select name="kode_customer" class="form-control form-control-sm">
                                <option value="ALL">All Customer</option>
                                <?php foreach ($customer as $cust) : ?>
                                    <option value="<?= $cust['kode_customer'] ?>"><?= $cust['nama_customer'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>From</label>
                            <input type="date" name="dari" value="<?= $dari ?>" class="form-control form-control-sm">
                        </div>

                        <div class=" form-group col-md-6">
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