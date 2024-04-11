<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 18px;">LAPORAN PEMBELIAN TAHUNAN</p>
                </div>
                <div class="card-body">
                    <?= form_open('LapBeli09/preview') ?>
                    <br>
                    <div class="form group row mt-2">
                        <div class="col-sm-3"></div>
                        <label>TAHUN </label>
                        <div class="col-sm-3">
                            <input type="text" name="tahun" value="<?= $tahun ?>" class="form-control form-control-sm">
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-sm btn-success mt-4" type="submit">TAMPILKAN</button>
                            <a href="<?= base_url() ?>/admin" class="btn btn-sm btn-danger mt-4">KELUAR</a>

                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>