<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 16px;">LAPORAN PENJUALAN PER SALESMAN</p>
                </div>
                <div class="card-body">
                    <?= form_open('LapJual09/preview') ?>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>TYPE LAPORAN</label>
                            <select name="typelap" class="form-control form-control-sm">
                                <option value="REKAP">REKAP</option>
                                <option value="DETAIL">DETAIL</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>SALESMAN</label>
                            <select name="kode_salesman" class="form-control form-control-sm">
                                <option value="ALL">All Salesman</option>
                                <?php foreach ($salesman as $sales) : ?>
                                    <option value="<?= $sales['kode_salesman'] ?>"><?= $sales['nama_salesman'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>DIVISI</label>
                            <select name="kode_divisi" id="kode_divisi" class="form-control form-control-sm">
                                <option value="">All Divisi</option>
                                <?php foreach ($divisi as $sls) : ?>
                                    <option value="<?= $sls['kode_divisi'] ?>"><?= $sls['kode_divisi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>DARI TANGGAL</label>
                            <input type="date" name="dari" value="<?= $dari ?>" class="form-control form-control-sm">
                        </div>

                        <div class=" form-group col-md-6">
                            <label>S/D TANGGAL</label>
                            <input type="date" name="sampai" value="<?= $sampai ?>" class="form-control form-control-sm">
                        </div>

                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-success mt-3" name="btnCetak" type="submit"><i class="fa fa-print"></i> TAMPILKAN</button>
                        <button class="btn btn-sm btn-primary mt-3" name="btnExport" type="submit"><i class="fa fa-file-excel"></i> EXCEL</button>
                        <a href="<?= base_url() ?>/admin" class="btn btn-sm btn-danger mt-3"><i class="fa fa-exit"></i> KELUAR</a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>