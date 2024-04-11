<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="row">
    <br>
    <div class="col-md-6 offset-3">
        <div class="card card-info mt-4" style="background-color: lightblue;">
            <div class="card-header">
                <h3 class="card-title">CHANGE PASSWORD</h3>
            </div>

            <?= form_open('user/update_password/' . $user['username']) ?>
            <div class="card-body">
                <?php if (session()->getFlashdata('pesan')) {
                    echo '<div class="alert alert-success" role="alert">';
                    echo session()->getFlashdata('pesan');
                    echo '</div>';
                } ?>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label style="font-weight: normal;">FULL NAME</label>
                        <input type="text" name="fullname" class="form-control" value="<?= $user['fullname'] ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 form-group ">
                        <label style="font-weight: normal;">CURRENT PASSWORD</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" autofocus>

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 form-group ">
                        <label style="font-weight: normal;">NEW PASSWORD</label>
                        <input type="password" name="new_password1" id="new_password1" class="form-control <?= ($validation->hasError('new_password1')) ? 'is-invalid' : ''; ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('new_password1'); ?>
                        </div>
                    </div>




                </div>

                <div class="row">
                    <div class="col-sm-12 form-group ">
                        <label style="font-weight: normal;">CONFIRMATION</label>
                        <input type="password" name="new_password2" id="new_password2" class="form-control">
                    </div>
                </div>


                <div class="mt-2">
                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Update</button>
                    <a href="<?= base_url('admin') ?>" class="btn btn-danger btn-sm" name="reset">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>