<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-12 justify-content-center">
        <div class="card card-primary mt-4" style="background-color: #d7ecff;">
            <div class="card-header">
                <h2 class="card-title text-bold text-center">COMPANY PROFILE</h2>
            </div>
            <?= form_open('company/edit') ?>
            <div class="card-body mt-2">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form group row">
                            <div class="col-sm-2 col-form-label">NAMA PT</div>
                            <div class="col-sm-8">
                                <input type="text" name="nama_company" id="nama_company" class="form-control form-control-sm border-secondary" value="<?= $company['nama_company'] ?>" style="margin-top: 0px">
                            </div>
                        </div>
                        <div class="form group row">
                            <div class="col-sm-2 col-form-label">ALAMAT</div>
                            <div class="col-sm-8">
                                <input type="text" name="address1" class="form-control form-control-sm border-secondary " value="<?= $company['address1'] ?>" style="margin-top: 3px">
                                <input type="text" name="address2" class="form-control form-control-sm border-secondary mt-1" value="<?= $company['address2'] ?>" style="margin-top: 1px">
                                <input type="text" name="address3" class="form-control form-control-sm border-secondary mt-1" value="<?= $company['address3'] ?>" style="margin-top: 1px">
                            </div>
                        </div>

                        <div class="form group row">
                            <div class="col-sm-2 col-form-label">NO TELEPON</div>
                            <div class="col-sm-8">
                                <input type="text" name="telephone" class="form-control form-control-sm border-secondary" value="<?= $company['telephone'] ?>" style="margin-top: 5px">
                            </div>
                        </div>
                        <div class="form group row">
                            <div class="col-sm-2 col-form-label">NO FASIMILE</div>
                            <div class="col-sm-8">
                                <input type="text" name="facsimile" class="form-control form-control-sm border-secondary" value="<?= $company['facsimile'] ?>" style="margin-top: 5px">
                            </div>
                        </div>

                        <div class="form group row">
                            <div class="col-sm-2 col-form-label">EMAIL</div>
                            <div class="col-sm-8">
                                <input type="text" name="email" class="form-control form-control-sm border-secondary" value="<?= $company['email'] ?>" style="margin-top: 5px">
                            </div>
                        </div>
                        <div class="form group row">
                            <div class="col-sm-2 col-form-label">NPWP</div>
                            <div class="col-sm-8">
                                <input type="text" name="npwp" class="form-control form-control-sm border-secondary" value="<?= $company['npwp'] ?>" style="margin-top: 5px">
                            </div>
                        </div>

                        <div class="form group row">
                            <div class="col-sm-2 col-form-label">TT INVOICE</div>
                            <div class="col-sm-8">
                                <input type="text" name="tanda_tangan" class="form-control form-control-sm border-secondary" value="<?= $company['tanda_tangan'] ?>" style="margin-top: 5px">
                            </div>
                        </div>

                        <div class="form group row mt-2">
                            <div class="col-sm-2 col-form-label"></div>
                            <div class="col-sm-8 col-form-label text-primary"><strong>REKENING UTK PEMBAYARAN INVOICE</strong></div>
                        </div>
                        <div class="form group row">
                            <div class="col-sm-2 col-form-label">NAMA BANK</div>
                            <div class="col-sm-8">
                                <input type="text" name="bank" class="form-control form-control-sm border-secondary" value="<?= $company['bank'] ?>" style="margin-top: 5px">
                            </div>
                        </div>
                        <div class="form group row">
                            <div class="col-sm-2 col-form-label">NO A/C</div>
                            <div class="col-sm-8">
                                <input type="text" name="noac" class="form-control form-control-sm border-secondary" value="<?= $company['noac'] ?>" style="margin-top: 5px">
                            </div>
                        </div>
                        <div class="form group row">
                            <div class="col-sm-2 col-form-label">ATAS NAMA</div>
                            <div class="col-sm-8">
                                <input type="text" name="atasnama" class="form-control form-control-sm border-secondary" value="<?= $company['atasnama'] ?>" style="margin-top: 5px">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form group row">
                            <div class="col-sm-5 col-form-label">ACCOUNT PIUTANG DAGANG</div>
                            <div class="col-sm-6">
                                <select name="acctar" class="form-control form-control-sm border-secondary" style="height:30px;margin-top: 5px">
                                    <?php foreach ($account as $acct) : ?>
                                        <?php if ($acct['kode_account'] == $company['acctar']) : ?>
                                            <option value="<?= $acct['kode_account'] ?>" selected><?= $acct['nama_account'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form group row">
                            <div class="col-sm-5 col-form-label">ACCOUNT HUTANG DAGANG</div>
                            <div class="col-sm-6">
                                <select name="acctap" class="form-control form-control-sm border-secondary" style="height:30px;margin-top: 5px">
                                    <?php foreach ($account as $acct) : ?>
                                        <?php if ($acct['kode_account'] == $company['acctap']) : ?>
                                            <option value="<?= $acct['kode_account'] ?>" selected><?= $acct['nama_account'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form group row">
                            <div class="col-sm-5 col-form-label">ACCOUNT PENJUALAN</div>
                            <div class="col-sm-6">
                                <select name="acctjual" class="form-control form-control-sm border-secondary" style="height:30px;margin-top: 5px">
                                    <?php foreach ($account as $acct) : ?>
                                        <?php if ($acct['kode_account'] == $company['acctjual']) : ?>
                                            <option value="<?= $acct['kode_account'] ?>" selected><?= $acct['nama_account'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form group row">
                            <div class="col-sm-5 col-form-label">ACCOUNT PPN KELUARAN</div>
                            <div class="col-sm-6">
                                <select name="acctppnk" class="form-control form-control-sm border-secondary" style="height:30px;margin-top: 5px">
                                    <?php foreach ($account as $acct) : ?>
                                        <?php if ($acct['kode_account'] == $company['acctppnk']) : ?>
                                            <option value="<?= $acct['kode_account'] ?>" selected><?= $acct['nama_account'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form group row">
                            <div class="col-sm-5 col-form-label">ACCOUNT PPN MASUKKAN</div>
                            <div class="col-sm-6">
                                <select name="acctppnm" class="form-control form-control-sm border-secondary" style="height:30px;margin-top: 5px">
                                    <?php foreach ($account as $acct) : ?>
                                        <?php if ($acct['kode_account'] == $company['acctppnm']) : ?>
                                            <option value="<?= $acct['kode_account'] ?>" selected><?= $acct['nama_account'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form group row">
                            <div class="col-sm-5 col-form-label">ACCOUNT PERSEDIAAN BARANG</div>
                            <div class="col-sm-6">
                                <select name="acctinvt" class="form-control form-control-sm border-secondary" style="height:30px;margin-top: 5px">
                                    <?php foreach ($account as $acct) : ?>
                                        <?php if ($acct['kode_account'] == $company['acctinvt']) : ?>
                                            <option value="<?= $acct['kode_account'] ?>" selected><?= $acct['nama_account'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form group row">
                            <div class="col-sm-5 col-form-label">ACCOUNT HARGA POKOK PENJUALAN</div>
                            <div class="col-sm-6">
                                <select name="accthpp" class="form-control form-control-sm border-secondary" style="height:30px;margin-top: 5px">
                                    <?php foreach ($account as $acct) : ?>
                                        <?php if ($acct['kode_account'] == $company['accthpp']) : ?>
                                            <option value="<?= $acct['kode_account'] ?>" selected><?= $acct['nama_account'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form group row">
                            <div class="col-sm-5 col-form-label">ACCOUNT POTONGAN PENJUALAN</div>
                            <div class="col-sm-6">
                                <select name="acctdisc" class="form-control form-control-sm border-secondary" style="height:30px;margin-top: 5px">
                                    <?php foreach ($account as $acct) : ?>
                                        <?php if ($acct['kode_account'] == $company['acctdisc']) : ?>
                                            <option value="<?= $acct['kode_account'] ?>" selected><?= $acct['nama_account'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form group row">
                            <div class="col-sm-5 col-form-label">ACCOUNT RETUR PENJUALAN</div>
                            <div class="col-sm-6">
                                <select name="acctrtrjl" class="form-control form-control-sm border-secondary" style="height:30px;margin-top: 5px">
                                    <?php foreach ($account as $acct) : ?>
                                        <?php if ($acct['kode_account'] == $company['acctrtrjl']) : ?>
                                            <option value="<?= $acct['kode_account'] ?>" selected><?= $acct['nama_account'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form group row">
                            <div class="col-sm-5 col-form-label">ACCOUNT UANG MUKA PENJUALAN</div>
                            <div class="col-sm-6">
                                <select name="acctumuka" class="form-control form-control-sm border-secondary" style="height:30px;margin-top: 5px">
                                    <?php foreach ($account as $acct) : ?>
                                        <?php if ($acct['kode_account'] == $company['acctumuka']) : ?>
                                            <option value="<?= $acct['kode_account'] ?>" selected><?= $acct['nama_account'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $acct['kode_account'] ?>"><?= $acct['nama_account'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 p-3">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> UPDATE</button>
                        <a href="<?= base_url('admin') ?>" class="btn btn-sm btn-danger ml-2" name="reset">
                            <i class="fa fa-times"></i> CANCEL
                        </a>
                    </div>
                    <br><br>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>



    <?= $this->endSection() ?>