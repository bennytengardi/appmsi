<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 60px;">
                    <p style="font-size: 18px;">PROSES POSTING STOCK</p>
                </div>
                <div class="card-body">
                    <?= form_open('Posting/proses') ?>
                    <br>
                    <div class="form-group text-center">
                        <button class="btn btn-success mt-3" type="submit">PROSES</button>
                        <a href="<?= base_url() ?>/admin" class="btn btn-danger mt-3">CANCEL</a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>