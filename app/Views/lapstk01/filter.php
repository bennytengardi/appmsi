<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 16px;">LAPORAN STOK BARANG JADI</p>
                </div>
                <div class="card-body">
                    <?= form_open('LapStk01/preview') ?>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label">NAMA MERK</label>
                            <select name="kode_merk" id="kode_merk" class="form-control form-control-sm">
                                <option value="">--- Select Merk --- </option>
                                <?php foreach ($merk as $sls) : ?>
                                    <option value="<?= $sls['kode_merk'] ?>"><?= $sls['nama_merk'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <!--<div class="form-group col-md-6">-->
                        <!--    <label>DARI TANGGAL</label>-->
                        <!--</div>-->

                        <div class=" form-group col-md-6">
                            <label>S/D TANGGAL</label>
                            <input type="hidden" name="dari" value="<?= $dari ?>" class="form-control form-control-sm">
                            <input type="date" name="sampai" value="<?= $sampai ?>" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-success mt-3" name="btnCetak" type="submit"><i class="fa fa-print"></i> TAMPILKAN</button>
                        <button class="btn btn-sm btn-primary mt-3" name="btnExport" type="submit"><i class="fa fa-file-excel"></i> EXCEL</button>
                        <a href="<?= base_url() ?>/admin" class="btn btn-sm btn-danger mt-3">KELUAR</a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>