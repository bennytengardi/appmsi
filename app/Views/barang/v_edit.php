<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title mt-n1">BARANG</h3>
                <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 mt-n1 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>
            <div class="card-body" style="font-size: 12px;">
                <?= form_open_multipart('', ['class' => 'formsimpanbarang']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-9">
                        <div class="form group row">
                            <label for="kode_barang" class="col-sm-2 col-form-label" style="font-weight: normal;">KODE BARANG</label>
                            <div class="col-sm-3">
                                <input type="text" name="kode_barang" id="kode_barang" class="form-control form-control-sm text-md text-bold text-danger"style=" font-size: 12px;height: 28px;" onkeyup="this.value = this.value.toUpperCase()"  value="<?= $barang['kode_barang'] ?>" readonly>
                                <input type="hidden" name="id_barang" id="id_barang" value="<?= $barang['id_barang'] ?>">
                                <div class="errorKodeBarang invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="form group row">
                            <label for="nama_barang" class="col-sm-2 col-form-label" style="font-weight: normal;">NAMA BARANG</label>
                            <div class="col-sm-8">
                                <textarea class="form-control form-control-sm" rows="6" name="nama_barang" id="description" style="font-size: 12px;"><?= $barang['nama_barang'] ?></textarea>
                            </div>
                            <div class="errorNamaBarang invalid-feedback" style="display: none;"></div>
                        </div>

                        
                        <div class="form group row" style="margin-top: 5px;">
                            <label for="kode_kategori" class="col-sm-2 col-form-label" style="font-weight: normal;">NAMA KATEGORI</label>
                            <div class="col-sm-3">
                                <select name="kode_kategori" id="kode_kategori" class="form-control form-control-sm" style="font-size: 12px;height: 28px;">
                                    <?php foreach ($kategori as $kat) : ?>
                                        <?php if ($kat['kode_kategori'] == $barang['kode_kategori']) : ?>
                                            <option value="<?= $kat['kode_kategori'] ?>" selected><?= $kat['nama_kategori'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $kat['kode_kategori'] ?>"><?= $kat['nama_kategori'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorKodeKategori invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="form group row">
                            <label for="kode_merk" class="col-sm-2 col-form-label" style="font-weight: normal;">NAMA MERK</label>
                            <div class="col-sm-3">
                                <select name="kode_merk" id="kode_merk" class="form-control form-control-sm" style="font-size: 12px;height: 28px;">
                                    <?php foreach ($merk as $mrk) : ?>
                                        <?php if ($mrk['kode_merk'] == $barang['kode_merk']) : ?>
                                            <option value="<?= $mrk['kode_merk'] ?>" selected><?= $mrk['nama_merk'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $mrk['kode_merk'] ?>"><?= $mrk['nama_merk'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorKodeMerk invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>


                        <div class="form group row">
                            <label for="kode_satuan" class="col-sm-2 col-form-label" style="font-weight: normal;">KODE SATUAN</label>
                            <div class="col-sm-2">
                                <select name="kode_satuan" id="kode_satuan" class="form-control form-control-sm" style="font-size: 12px;height: 28px;">
                                    <?php foreach ($satuan as $sat) : ?>
                                        <?php if ($sat['kode_satuan'] == $barang['kode_satuan']) : ?>
                                            <option value="<?= $sat['kode_satuan'] ?>" selected><?= $sat['kode_satuan'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $sat['kode_satuan'] ?>"><?= $sat['kode_satuan'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorKodeSatuan invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>


                        <div class="form group row">
                            <label for="hargajual" class="col-sm-2 col-form-label" style="font-weight: normal;">HARGA JUAL</label>
                            <div class="col-sm-2">
                                <input type="text" name="hargajual" id="hargajual" class="form-control form-control-sm text-right autonum" style="font-size: 12px;height: 28px;" value="<?= $barang['hargajual'] ?>">
                            </div>
                            <label class="col-sm-1 col-form-label" style="font-weight: normal;">STATUS </label>
                            <div class="col-sm-2">
                                <select name="sttstok" id="sttstok" class="form-control form-control-sm" style="font-size: 12px;height: 28px;">
                                    <?php if ($barang['sttstok'] == 'INV') : ?>
                                        <option value="INV" selected>INVENTORY</option>
                                        <option value="NON">NON INVENTORY</option>
                                    <?php else : ?>
                                        <option value="NON" selected>NON INVENTORY</option>
                                        <option value="INV">INVENTORY</option>
                                    <?php endif; ?>                                    
                                </select>
                            </div>                            
                        </div>


                        <div class="form group row">
                            <label for="hargabeli" class="col-sm-2 col-form-label" style="font-weight: normal;">HARGA BELI</label>
                            <div class="col-sm-2">
                                <input type="text" name="hargabeli" id="hargabeli" class="form-control form-control-sm text-right autonum2" style="font-size: 12px;height: 28px;" value="<?= $barang['hargabeli'] ?>">
                            </div>
                            <label class="col-sm-1 col-form-label" style="font-weight: normal;">CURENCY</label>
                            <div class="col-sm-2">
                                <select name="currency" id="currency" class="form-control form-control-sm" style="font-size: 12px;height: 28px;">
                                    <?php foreach ($currency as $curr) : ?>
                                        <?php if ($curr['currency'] == $barang['currency']) : ?>
                                            <option value="<?= $curr['currency'] ?>" selected><?= $curr['currency'] ?>
                                            </option>
                                        <?php else : ?>
                                            <option value="<?= $curr['currency'] ?>"><?= $curr['currency'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label for="nilaikurs" class="col-sm-1 col-form-label text-right" style="font-weight: normal;">KURS</label>
                            <div class="col-sm-1">
                                <input type="text" name="nilaikurs" id="nilaikurs" class="form-control form-control-sm text-right autonum" style="font-size: 12px;height: 28px;" value="<?= $barang['nilaikurs'] ?>">
                            </div>
                             
                        </div>

                        <div class="form group row">
                            <label class="col-sm-2 col-form-label" style="font-weight: normal;">KETERANGAN BARANG</label>
                            <div class="col-sm-8">
                                <textarea class="form-control form-control-sm" rows="6" name="description" id="description" style="font-size: 12px;"><?= $barang['description'] ?></textarea>
                            </div>
                        </div>

                        <div class="form group row" style="margin-top: 5px;">
                            <label for="uploadgambar" class="col-sm-2 col-form-label" style="font-weight: normal;">UPLOAD GBR (<i>jika ada</i>)</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="uploadgambar" class="custom-file-input form-control-sm" id="uploadgambar">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                    <div class="invalid-feedback errorUploadGambar" style="display: none;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-xs btn-primary tombolSimpanBarang my-4">SIMPAN DATA</button>
                    </div>
                    <div class="col-sm-3 ml-n5">
                        <label style="font-weight: normal;">GAMBAR PRODUK</label>
                        <img src="<?= base_url('fotoproduk/noimage.jpg') ?>" id="gambar_load" class="img-bordered-sm" width="350px" height="350px">
                        <br>
                    </div>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
    $('#kode_barang').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#nama_barang').focus();
        }
    });

    $('#nama_barang').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#kode_kategori').focus();
        }
    });

    $('#kode_kategori').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#kode_merk').focus();
        }
    });

    $('#kode_merk').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#kode_satuan').focus();
        }
    });

    $('#kode_satuan').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#hargajual').focus();
        }
    });

    $('#hargajual').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#hargabeli').focus();
        }
    });

    $('#hargabeli').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#currency').focus();
        }
    });

    $('#currency').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#description').focus();
        }
    });

    $('#uploadgambar').change(function() {
        bacaGambar(this);
    });

    $('.tombolSimpanBarang').click(function(e) {
        e.preventDefault();
        let form = $('.formsimpanbarang')[0];
        let data = new FormData(form);

        $.ajax({
            type: "post",
            url: "<?= base_url('barang/updatedata') ?>",
            data: data,
            dataType: "json",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanBarang').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanBarang').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanBarang').html('SIMPAN DATA');
                $('.tombolSimpanBarang').prop('disabled', false);
            },

            success: function(response) {
                if (response.error) {
                    let dataError = response.error;

                    if (dataError.errorKodeBarang) {
                        $('.errorKodeBarang').html(dataError.errorKodeBarang).show();
                    } else {
                        $('.errorKodeBarang').fadeOut();
                    }

                    if (dataError.errorNamaBarang) {
                        $('.errorNamaBarang').html(dataError.errorNamaBarang).show();
                    } else {
                        $('.errorNamaBarang').fadeOut();
                    }

                    if (dataError.errorKodeKategori) {
                        $('.errorKodeKategori').html(dataError.errorKodeKategori).show();
                    } else {
                        $('.errorKodeKategori').fadeOut();
                    }

                    if (dataError.errorKodeMerk) {
                        $('.errorKodeMerk').html(dataError.errorKodeMerk).show();
                    } else {
                        $('.errorKodeMerk').fadeOut();
                    }

                    if (dataError.errorKodeSatuan) {
                        $('.errorKodeSatuan').html(dataError.errorKodeSatuan).show();
                    } else {
                        $('.errorKodeSatuan').fadeOut();
                    }

                    if (dataError.errorUploadGambar) {
                        $('.errorUploadGambar').html(dataError.errorUploadGambar).show();
                        $('#uploadgambar').addClass('is-invalid');
                    }
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        html: response.sukses,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.value) {
                            window.location = "<?= base_url('barang') ?>";
                        }
                    });
                }
            },

            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });
    });
</script>

<?= $this->endSection() ?>