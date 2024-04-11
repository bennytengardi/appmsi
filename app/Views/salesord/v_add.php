<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title mt-n1">SALES ORDER</h3>
                <a href="<?= base_url('SalesOrd') ?>" type="button" class="btn btn-sm mt-n1 mb-2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>

            <div class="card-body" style="font-size: 12px;">
                <div class="row px-3">
                    <div class="col-sm-7">
                        <div class="row">
                            <div class="col-md-2">CUSTOMER ID</div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm kode_customer " aria-describedby="basic-addon2" name="kode_customer" id="kode_customer" style="font-size: 12px;height:26px;" onkeyup="this.value = this.value.toUpperCase()">
                                    <div class="input-group-append">
                                        <button type="button" class="input-group-text bg-primary tombol-customer" id="basic-addon2" data-toggle="modal" data-target="#modal-customer" style="font-size: 12px;height:26px;"><i class="fas fa-search"></i></button>
                                    </div>
                                    <div class="errorKodeCustomer invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">CUSTOMER NAME</div>
                            <div class="col-md-8">
                                <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm"  style="font-size: 12px;height:26px;" readonly>
                                <input type="hidden" name="status" id="status">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">ADDRESS </div>
                            <div class="col-md-8">
                                <input type="text" name="address1" id="address1" class="form-control form-control-sm" style="font-size: 12px;height:26px;" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2"> </div>
                            <div class="col-md-8">
                                <input type="text" name="address2" id="address2" class="form-control form-control-sm" style="font-size: 12px;height:26px;" readonly>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2 col-form-label">NAMA PEMESAN</div>
                            <div class="col-md-4">
                                <input type="text" name="nama_pemesan" id="nama_pemesan" class="form-control form-control-sm" style="font-size: 12px;height:26px;">
                            </div>
                        </div>
                        <div class="row mt-n2">
                            <div class="col-md-2 col-form-label">NO HP</div>
                            <div class="col-md-4">
                                <input type="text" name="no_handphone" id="no_handphone" class="form-control form-control-sm" style="font-size: 12px;height:26px;">
                            </div>
                        </div>
                        <div class="row mt-n2">
                            <div class="col-md-2 col-form-label">NAMA PROYEK</div>
                            <div class="col-md-8">
                                <input type="text" name="nama_proyek" id="nama_proyek" class="form-control form-control-sm" style="font-size: 12px;height:26px;">
                            </div>
                        </div>
                        <div class="row mt-n2">
                            <div class="col-md-2">DIVISI</div>
                            <div class="col-md-3">
                                <select name="kode_divisi" id="kode_divisi" class="form-control form-control-sm" style="font-size: 12px;height:26px;">
                                    <option value="">Pilih Divisi</option>
                                    <?php foreach ($divisi as $sls) : ?>
                                        <option value="<?= $sls['kode_divisi'] ?>"><?= $sls['kode_divisi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="errorKodeDivisi invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>                           
                    </div>

                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-md-3">NO SALES ORDER</div>
                            <div class="col-md-5">
                                <input type="text" name="no_so" id="no_so" class="form-control form-control-sm text-bold text-danger" style="font-size: 12px;height:26px;">
                                <input type="hidden" name="no_random" id="no_random" value="<?= $no_random ?>">
                                <div class="errorNoSo invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">TGL SALES ORDER</div>
                            <div class="col-md-3">
                                <input type="date" name="tgl_so" id="tgl_so" class="form-control form-control-sm" value="<?= $tgl_so ?>" style="font-size: 12px;height:26px;">
                            </div>
                        </div>                            
                        <div class="row">
                            <div class="col-md-3">NO PO</div>
                            <div class="col-md-5">
                                <input type="text" name="no_po" id="no_po" class="form-control form-control-sm" style="font-size: 12px;height:26px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">PEMBAYARAN</div>
                            <div class="col-md-5">
                                <input type="text" name="pembayaran" id="pembayaran" class="form-control form-control-sm" style="font-size: 12px;height:26px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">TGL KIRIM</div>
                            <div class="col-md-5">
                                <input type="text" name="tgl_kirim" id="tgl_kirim" class="form-control form-control-sm" style="font-size: 12px;height:26px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">LOKASI KIRIM</div>
                            <div class="col-md-9">
                                <input type="text" name="lokasi_kirim" id="lokasi_kirim" class="form-control form-control-sm" style="font-size: 12px;height:26px;">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">CATATAN</div>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="catatan1" id="catatan1" style="font-size: 12px;height:26px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="catatan2" id="catatan2" style="font-size: 12px;height:26px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="catatan3" id="catatan3" style="font-size: 12px;height:26px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="catatan4" id="catatan4" style="font-size: 12px;height:26px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row px-2 mt-4">
                    <div class="col-md-2 ml-2">
                        <div class="text-center bg-primary" style="height: 22px;">ITEM NO</div>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm kode_barang" aria-describedby="basic-addon2" name="kode_barang" id="kode_barang" style="font-size: 12px;height:26px;" onkeyup="this.value = this.value.toUpperCase()">
                            <input type="hidden" name="id_barang" id="id_barang">
                            <div class="input-group-append">
                                <!--<button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon2"><i class="fas fa-search"></i></button>-->
                                <button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon3" data-toggle="modal" data-target="#modal-barang" style="font-size: 12px;height:26px;"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="text-center bg-primary" style="height: 22px;">ITEM NAME</div>
                            <input type="text" class="form-control form-control-sm" name="nama_barang" id="nama_barang" style="font-size: 12px;height:26px;" readonly>
                            <input type="hidden" class="form-control form-control-sm" name="qtystok" id="qtystok">                                
                            <input type="hidden" class="form-control form-control-sm" name="sttstok" id="sttstok">                                
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <div class="text-center bg-primary" style="height: 22px;">QTY</div>
                            <input type="text" class="form-control form-control-sm text-right autonum2" name="qty" id="qty" style="font-size: 12px;height:26px;">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <div class="text-center bg-primary" style="height: 22px;">UNIT</div>
                            <input type="text" class="form-control form-control-sm" name="kode_satuan" id="kode_satuan" style="font-size: 12px;height:26px;" readonly>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form group">
                            <div class="text-center bg-primary" style="height: 22px;">PRICE</div>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm text-right autonum2 harga" aria-describedby="basic-addon2" name="harga" id="harga" style="font-size: 12px;height:26px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <div>&nbsp</div>
                            <button type="button" class="btn btn-success btn-sm d-block tombolTambah" id="btnTambah" style="font-size: 12px;height:26px;"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 dataDetailInv" id="dataDetailInv">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-xs btn-primary tombolSimpanInv ml-3" type="button" id="btnSimpanInv">
                        SAVE DATA
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<!-- MODAL SEARCH -->
<div class="modal fade" id="modal-customer" data-backdrop="static" data-keyboard="false" style="width:100%">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="height: 40px;">
                <h3 class="card-title mt-n1">LIST CUSTOMER</h3>
                <a href="<?= base_url('SalesOrd') ?>" type="button" class="btn btn-sm mb-2 mt-n2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>
            <div class="modal-body" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
                <table class="table table-bordered table-hover table-sm" id="example7" name="tabel1" style="font-size: 12px;">
                    <thead>
                        <tr class="bg-primary text-center">
                            <th width="6%">CUSTOMER ID</th>
                            <th>customer CUSTOMER NAME</th>
                            <th>ADDRESS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php foreach ($customer as $itm) : ?>
                            <tr>
                                <td class="pb-0"><?= $itm['kode_customer'] ?></td>
                                <td class="pb-0"><?= $itm['nama_customer'] ?></td>
                                <td class="pb-0"><?= $itm['address1'] ?></td>
                                <td class="pb-0 text-center">
                                    <button class="btn btn-primary btn-xs" id="select" style="height: 18px;font-size: 10px;" data-kode_customer="<?= $itm['kode_customer'] ?>">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        dataDetailInv();
        hitungTotalBelanja();
        $('#kode_customer').focus();
    });
    
    $(document).on('click', '#select', function(e) {
        e.preventDefault();
        var kode_customer = $(this).data('kode_customer');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Customer/cari_kodecustomer') ?>",
            dataType: "JSON",
            data: {
                kode_customer: kode_customer
            },
            cache: false,
            success: function(data) {
                $.each(data, function(kode_customer, nama_customer, address1, address2, status) {
                    $('[id="kode_customer"]').val(data.kode_customer);
                    $('[id="nama_customer"]').val(data.nama_customer);
                    $('[id="address1"]').val(data.address1);
                    $('[id="address2"]').val(data.address2);
                    $('[id="status"]').val(data.status);
                    $("#nama_pemesan").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        $('#modal-customer').on('hidden.bs.modal', function(event) {
            $('#nama_pemesan').focus();
        })
        $('#modal-customer').modal('hide');

    });


    $(document).on('keydown', '#kode_customer', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var kode_customer = $("#kode_customer").val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Customer/cari_kodecustomer') ?>",
                dataType: "JSON",
                data: {
                    kode_customer: kode_customer
                },
                cache: false,
                success: function(data) {
                    $.each(data, function(kode_customer, nama_customer, address1, address2, status) {
                        $('[id="kode_customer"]').val(data.kode_customer);
                        $('[id="nama_customer"]').val(data.nama_customer);
                        $('[id="address1"]').val(data.address1);
                        $('[id="address2"]').val(data.address2);
                        $('[id="status"]').val(data.status);
                        
                        $("#nama_pemesan").focus();
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('Kode Customer ini tidak ada dalam master customer');
                }
            });
            return false;
        }
    });
    
 
    function dataDetailInv() {
        no_so = $('#no_random').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('SalesOrd/dataDetail') ?>",
            data: {
                no_so: no_so
            },
            dataType: "json",
            beforeSend: function() {
                $('.dataDetailInv').html('<i class="fa-spin fa-spinner"></i>')
            },
            success: function(response) {
                if (response.data) {
                    $('.dataDetailInv').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
    
    

    $(document).ready(function() {
        $('.tombol-customer').click(function(e) {
            e.preventDefault();
            $('#modal-customer').modal('show');
            $('#modal-customer').on('shown.bs.modal', function() {
                $("#modal-customer [type='search']").focus();
            })
        });

        $('.tombol-barang').click(function(e) {
            e.preventDefault();
            cekKode();
        });

        $('#kode_barang').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekKode2();
            }
        });



        $('#nama_pemesan').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#no_handphone').focus();
            }
        });
        $('#no_handphone').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#nama_proyek').focus();
            }
        });
        $('#nama_proyek').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#kode_divisi').focus();
            }
        });
        $('#kode_divisi').change(function(e) {
                e.preventDefault();
                $('#no_so').focus();
        });
        
        
        $('#no_so').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#tgl_so').focus();
            }
        });
        $('#tgl_so').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#no_po').focus();
            }
        });
        
        $('#no_po').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#pembayaran').focus();
            }
        });

        $('#pembayaran').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#tgl_kirim').focus();
            }
        });

        $('#tgl_kirim').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#lokasi_kirim').focus();
            }
        });
        
        $('#lokasi_kirim').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#catatan1').focus();
            }
        });
        
        $('#catatan1').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#catatan2').focus();
            }
        });
        $('#catatan2').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#catatan3').focus();
            }
        });
        $('#catatan3').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#catatan4').focus();
            }
        });

        $('#catatan4').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#kode_barang').focus();
            }
        });
        
        $('#qty').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#harga').focus();
            }
        });

        $('#harga').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#btnTambah').focus();
            }
        });

        $('#btnTambah').click(function(e) {
            e.preventDefault();
            masukCart();
        });
    });

    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };

        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    function cekKode() {
        $.ajax({
            url: "<?= site_url('SalesOrd/viewDataBarang') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewmodal').html(response.viewmodal).show();
                $('#modalbarang').modal('show');
                $('#modalbarang').on('shown.bs.modal', function() {
                    $("#modalbarang [type='search']").focus();
                })
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    }


    function cekKode2() {
        let kode_barang = $('#kode_barang').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('Barang/cari_kodebarang') ?>",
            data: {
                kode_barang: kode_barang,
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $.each(data, function(id_barang,kode_barang, nama_barang, kode_satuan, hargajual, masuk, keluar, returjual, returbeli, adjust, sttstok) {
                    $('[id="id_barang"]').val(data.id_barang);
                    $('[id="kode_barang"]').val(data.kode_barang);
                    $('[id="nama_barang"]').val(data.nama_barang);
                    $('[id="kode_satuan"]').val(data.kode_satuan);
                    $('[id="sttstok"]').val(data.sttstok);
                    $('[id="qtystok"]').val(parseInt(data.masuk) - parseInt(data.keluar) + parseInt(data.returjual) - parseInt(data.returbeli) + parseInt(data.adjust));
                    $("#qty").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    }




    function masukCart() {
        let qty = parseInt($('#qty').val());
        let stok = parseInt($('#qtystok').val());
        let sttstok = $('#sttstok').val();
        if (sttstok === "INV") {
            if (qty > stok) {
                alert('stok tidak cukup');
            } else {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('SalesOrd/simpanTemp') ?>",
                    data: {
                        no_random: $('#no_random').val(),
                        id_barang:   $('#id_barang').val(),
                        kode_barang:   $('#kode_barang').val(),
                        nama_barang: $('#nama_barang').val(),
                        kode_satuan: $('#kode_satuan').val(),
                        qty: $('#qty').val(),
                        harga: $('#harga').val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses == 'berhasil') {
                            dataDetailInv();
                            hitungTotalBelanja();
                            kosong();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        } else {
            $.ajax({
                type: "post",
                url: "<?= site_url('SalesOrd/simpanTemp') ?>",
                data: {
                    no_random: $('#no_random').val(),
                    id_barang:   $('#id_barang').val(),
                    kode_barang:   $('#kode_barang').val(),
                    nama_barang: $('#nama_barang').val(),
                    kode_satuan: $('#kode_satuan').val(),
                    qty: $('#qty').val(),
                    harga: $('#harga').val(),
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses == 'berhasil') {
                        dataDetailInv();
                        hitungTotalBelanja();
                        kosong();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }
    }


    function kosong() {
        $('#kode_barang').val('');
        $('#nama_barang').val('');
        $('#kode_satuan').val('');
        $('#qty').val('');
        $('#harga').val('');
        $('#kode_barang').focus();
    }


    $('.tombolSimpanInv').click(function(e) {
        e.preventDefault();
        let norandom = $('#no_random').val();
        let noso = $('#no_so').val();
        let tglso = $('#tgl_so').val();
        let kodecustomer = $('#kode_customer').val();
        let no_po = $('#no_po').val();
        let nama_pemesan = $('#nama_pemesan').val();
        let no_handphone = $('#no_handphone').val();
        let nama_proyek = $('#nama_proyek').val();
        let kode_divisi = $('#kode_divisi').val();
        let pembayaran = $('#pembayaran').val();
        let tgl_kirim = $('#tgl_kirim').val();
        let lokasi_kirim = $('#lokasi_kirim').val();
        let catatan1 = $('#catatan1').val();
        let catatan2 = $('#catatan2').val();
        let catatan3 = $('#catatan3').val();
        let catatan4 = $('#catatan4').val();
        let totalamount = $('#total_amount').val();
        let totalppn = $('#total_ppn').val();
        let totalso = $('#total_so').val();       

        $.ajax({
            type: "post",
            url: "<?= base_url('SalesOrd/simpandata') ?>",
            data: {
                no_random: norandom,
                no_so: noso,
                tgl_so: tglso,
                kode_customer: kodecustomer,
                no_po: no_po,
                nama_pemesan: nama_pemesan,
                no_handphone: no_handphone,
                nama_proyek: nama_proyek,
                kode_divisi: kode_divisi,
                pembayaran: pembayaran,
                tgl_kirim: tgl_kirim,
                lokasi_kirim: lokasi_kirim,
                catatan1: catatan1,
                catatan2: catatan2,
                catatan3: catatan3,
                catatan4: catatan4,
                total_amount: totalamount,
                total_ppn: totalppn,
                total_so: totalso,
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;
                    if (dataError.errorKodeCustomer) {
                        $('.errorKodeCustomer').html(dataError.errorKodeCustomer).show();
                    } else {
                        $('.errorKodeCustomer').fadeOut();
                    }
                    if (dataError.errorNoSo) {
                        $('.errorNoSo').html(dataError.errorNoSo).show();
                    } else {
                        $('.errorNoSo').fadeOut();
                    }
                    if (dataError.errorKodeDivisi) {
                        $('.errorKodeDivisi').html(dataError.errorKodeDivisi).show();
                    } else {
                        $('.errorKodeDivisi').fadeOut();
                    }
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        html: response.sukses,
                    }).then((result) => {
                        if (result.value) {
                            window.location = "<?= base_url('SalesOrd') ?>";
                        }
                    });
                }
            },

            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $('#kode_customer').on('mouseenter', function() {
        $('.errorKodeCustomer').fadeOut();
    });
    $('#no_so').on('mouseenter', function() {
        $('.errorNoSo').fadeOut();
    });
    $('#kode_divisi').on('change', function() {
        $('.errorKodeDivisi').fadeOut();
    });
    


    function hitungTotalBelanja() {
        $.ajax({
            url: "<?= site_url('SalesOrd/hitungTotalBelanja') ?>",
            dataType: "json",
            data: {
                no_random: $('#no_random').val(),
                status: $('#status').val()
            },
            type: "post",

            success: function(response) {
                if (response.totalamount) {
                    $('#total_amount').val(response.totalamount);
                }
                if (response.totalppn) {
                    $('#total_ppn').val(response.totalppn);
                }
                if (response.totalso) {
                    $('#total_so').val(response.totalso);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }


</script>

<?= $this->endSection() ?>