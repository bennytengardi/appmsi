<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 16px;">BACKUP DATA</p>
                </div>
                <div class="card-body">
                    <?= form_open('backup/doBackup') ?>
                    <br>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <?= session()->getFlashdata('pesan'); ?>
                            <button class="btn btn-sm btn-success mt-4" type="submit">PROSES</button>
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