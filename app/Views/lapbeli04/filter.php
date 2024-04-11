<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 16px;">LAPORAN PEMBELIAN PER SUPPLIER</p>
                </div>
                <div class="card-body">
                    <?= form_open('LapBeli04/preview') ?>
                    <br>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>SUPPLIER</label>
                            <select name="kode_supplier" class="form-control form-control-sm">
                                <option value="ALL">All Supplier</option>
                                <?php foreach ($supplier as $supp) : ?>
                                    <option value="<?= $supp['kode_supplier'] ?>"><?= $supp['nama_supplier'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>DARI TANGGAL</label>
                            <input type="date" name="dari" value="<?= $dari ?>" class="form-control form-control-sm">
                        </div>

                        <div class=" form-group col-md-4">
                            <label>S/D TANGGAL</label>
                            <input type="date" name="sampai" value="<?= $sampai ?>" class="form-control form-control-sm">
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