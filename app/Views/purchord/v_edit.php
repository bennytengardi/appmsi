<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="row justify-content-center mt-1">
    <div class="col-md-12" style="font-size: 12px;">
        <div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
            <div class="card-header" style="height: 40px;">
                <h3 class="card-title">PURCHASE ORDER</h3>
                <a href="<?= base_url('PurchOrd') ?>" type="button" class="btn btn-sm mb-2 mt-n2 float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-2">SUPPLIER ID</div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm  kode_supplier" aria-describedby="basic-addon2" name="kode_supplier" id="kode_supplier" style="font-size: 12px;height: 26px;" value="<?= $po['kode_supplier'] ?>">
                                        <div class="input-group-append">
                                            <button type="button" class="input-group-text bg-primary tombol-supplier" id="basic-addon2" data-toggle="modal" data-target="#modal-supplier" style="font-size: 12px; height: 26px;"><i class="fas fa-search"></i></button>
                                        </div>
                                        <div class="errorKodeSupplier invalid-feedback" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">SUPPLIER NAME</div>
                                <div class="col-md-9">
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['nama_supplier'] ?>" readonly>
                                    <input type="hidden" name="status" id="status" value="<?= $po['status'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">ALAMAT KIRIM</div>
                                <div class="col-md-9">
                                    <input type="text" name="addkrm1" id="addkrm1" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['addkrm1'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-9">
                                    <input type="text" name="addkrm2" id="addkrm2" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['addkrm2'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-9">
                                    <input type="text" name="addkrm3" id="addkrm3" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['addkrm3'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">U.P</div>
                                <div class="col-md-5">
                                    <input type="text" name="nama_up" id="nama_up" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['nama_up'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">NO. TELEPON</div>
                                <div class="col-md-5">
                                    <input type="text" name="telepon_up" id="telepon_up" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['telepon_up'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-3">NO. PO</div>
                                <div class="col-md-5">
                                    <input type="text" name="no_po" id="no_po" class="form-control form-control-sm text-bold text-danger" style="font-size: 12px;height: 26px;" value="<?= $po['no_po'] ?>">
                                    <input type="hidden" name="id_po" id="id_po" class="form-control form-control-sm text-bold text-danger" style="font-size: 12px;height: 26px;" value="<?= $po['id_po'] ?>" readonly>
                                    <div class="errorNoPo invalid-feedback" style="display: none;"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">DATE PO</div>
                                <div class="col-md-3">
                                    <input type="date" name="tgl_po" id="tgl_po" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['tgl_po'] ?>" autofocus>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">PAYMENT</div>
                                <div class="col-md-5">
                                    <input type="text" name="termin" id="termin" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['termin'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">CURRENCY</div>
                                <div class="col-md-2">
                                    <input type="text" name="currency" id="currency" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['currency'] ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">PEGIRIMAN</div>
                                <div class="col-md-5">
                                    <input type="text" name="tgl_kirim" id="tgl_kirim" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['tgl_kirim']?>">
                                </div>                                
                            </div>                                

                            <div class="row">
                                <div class="col-md-3">UNTUK PROYEK</div>
                                <div class="col-md-9">
                                    <input type="text" name="proyek" id="proyek" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value = "<?= $po['proyek']  ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">DESCRIPTION</div>
                                <div class="col-md-9">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm" style="font-size: 12px;height: 26px;" value="<?= $po['keterangan'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-2">
                            <div class="bg-primary text-center" style="font-size: 12px;height: 20px;">ITEM NO</div>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm  kode_barang" aria-describedby="basic-addon2" name="kode_barang" id="kode_barang" style="font-size: 12px;height: 26px;" onkeyup="this.value = this.value.toUpperCase()">
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-primary tombol-barang" id="basic-addon2" style="font-size: 12px;height: 26px;"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="bg-primary text-center" style="height: 20px;">ITEM NAME</div>
                                <input type="text" class="form-control form-control-sm" name="nama_barang" id="nama_barang" style="font-size: 12px;height: 26px;" readonly>
                                <input type="hidden" class="form-control form-control-sm" name="id_barang" id="id_barang" style="font-size: 12px;height: 26px;" readonly>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="bg-primary text-center" style="height: 20px">QTY</div>
                                <input type="text" class="form-control  form-control-sm   text-right  autonum2" name="qty" id="qty" style="font-size: 12px;height: 26px;">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="bg-primary text-center" style="height: 20px">UNIT</div>
                                <input type="text" class="form-control  form-control-sm  " name="kode_satuan" id="kode_satuan" style="font-size: 12px;height: 26px;" onkeyup="this.value = this.value.toUpperCase()" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="bg-primary text-center" style="height: 20px">PRICE</div>
                                <input type="text" class="form-control  form-control-sm   text-right  autonum2" name="harga" id="harga" style="font-size: 12px;height: 26px;">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <div>&nbsp</div>
                                <button type="button" class="btn btn-success btn-sm  mt-1 tombolTambah" id="btnTambah"  style="font-size: 12px;height: 26px;"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-12 dataDetailPo" id="dataDetailPo">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-xs tombolSimpanInv" type="button" id="btnSimpanInv">
                        SAVE DATA
                    </button>
                </div>
            </div>
        </div>

        <div class="viewmodal" style="display: none;"></div>

        <!-- MODAL SEARCH -->
        <div class="modal fade" id="modal-supplier" data-backdrop="static" data-keyboard="false" style="width:100%">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary" style="height: 40px;">
                        <h3 class="card-title mt-n1">LIST SUPPLIER</h3>
                        <a href="<?= base_url('PurchOrd') ?>" type="button" class="btn btn-sm mb-2 mt-n2 float-right">
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
                                    <th width="6%">SUPPLIER ID</th>
                                    <th>SUPPLIER NAME</th>
                                    <th>ADDRESS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <?php foreach ($supplier as $itm) : ?>
                                    <tr>
                                        <td class="pb-0"><?= $itm['kode_supplier'] ?></td>
                                        <td class="pb-0"><?= $itm['nama_supplier'] ?></td>
                                        <td class="pb-0"><?= $itm['address1'] ?></td>
                                        <td class="pb-0 text-center">
                                            <button class="btn btn-primary btn-xs" id="select" style="height: 18px;font-size: 10px;" data-kode_supplier="<?= $itm['kode_supplier'] ?>">
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
    </div>
</div>


<script>
    $(document).on('click', '#select', function(e) {
        e.preventDefault();
        var kode_supplier = $(this).data('kode_supplier');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('supplier/cari_kodesupplier') ?>",
            dataType: "JSON",
            data: {
                kode_supplier: kode_supplier
            },
            cache: false,
            success: function(data) {
                $.each(data, function(kode_supplier, nama_supplier, address1, address2, address3, status, currency, personal_kontak, no_hp) {
                    $('[id="kode_supplier"]').val(data.kode_supplier);
                    $('[id="nama_supplier"]').val(data.nama_supplier);
                    $('[id="currency"]').val(data.currency);
                    $('[id="status"]').val(data.status);
                    $('[id="nama_up"]').val(data.personal_kontak);
                    $('[id="telepon_up"]').val(data.no_hp);
                    $("#addkrm1").focus();
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        $('#modal-supplier').on('hidden.bs.modal', function(event) {
            $('#addkrm1').focus();
        })
        $('#modal-supplier').modal('hide');
    });

    $('#keterangan').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#kode_barang').focus();
        }
    });

    $(document).on('keydown', '#kode_supplier', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var kode_supplier = $("#kode_supplier").val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('supplier/cari_kodesupplier') ?>",
                dataType: "JSON",
                data: {
                    kode_supplier: kode_supplier
                },
                cache: false,
                success: function(data) {
                    $.each(data, function(kode_supplier, nama_supplier, address1, address2, address3, status, currency, personal_kontak, no_hp) {
                        $('[id="kode_supplier"]').val(data.kode_supplier);
                        $('[id="nama_supplier"]').val(data.nama_supplier);
                        $('[id="currency"]').val(data.currency);
                        $('[id="status"]').val(data.status);
                        $('[id="nama_up"]').val(data.nama_up);
                        $('[id="telepon_up"]').val(data.no_hp);
                        $("#addkrm1").focus();
                    });
                },
                error: function() {
                    alert("Kode Supplier ini tidak ditemukan");
                }
            });
            return false;
        }
    });


    $(document).ready(function() {
        dataDetailPo();
    });

    function dataDetailPo() {
        id_po = $('#id_po').val();
        status = $('#status').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('PurchOrd/dataDetail') ?>",
            data: {
                id_po: id_po,
                status: status
            },
            dataType: "json",
            beforeSend: function() {
                $('.dataDetailPo').html('<i class="fa-spin fa-spinner"></i>')
            },
            success: function(response) {
                if (response.data) {
                    $('.dataDetailPo').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        $('.tombol-supplier').click(function(e) {
            e.preventDefault();
            $('#modal-supplier').modal('show');
            $('#modal-supplier').on('shown.bs.modal', function() {
                $("#modal-supplier [type='search']").focus();
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

        $('#kode_supplier').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#addkrm1').focus();
            }
        });

        $('#addkrm1').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#addkrm2').focus();
            }
        });

        $('#addkrm2').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#addkrm3').focus();
            }
        });
        $('#addkrm3').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#no_po').focus();
            }
        });
        
        $('#no_po').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#tgl_po').focus();
            }
        });

        $('#tgl_po').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#termin').focus();
            }
        });

        $('#termin').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#tgl_kirim').focus();
            }
        });

        $('#tgl_kirim').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#proyek').focus();
            }
        });


        $('#proyek').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('#keterangan').focus();
            }
        });

        $('#keterangan').keydown(function(e) {
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

    function cekKode() {
        $.ajax({
            url: "<?= site_url('PurchOrd/viewDataBarang') ?>",
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
                $.each(data, function(id_barang,kode_barang, nama_barang, kode_satuan, hargabeli) {
                    $('[id="id_barang"]').val(data.id_barang);
                    $('[id="kode_barang"]').val(data.kode_barang);
                    $('[id="nama_barang"]').val(data.nama_barang);
                    $('[id="kode_satuan"]').val(data.kode_satuan);
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
        let id_po = $('#id_po').val();
        let no_po = $('#no_po').val();
        let id_barang = $('#id_barang').val();
        let kode_barang= $('#kode_barang').val();
        let nama_barang= $('#nama_barang').val();
        let kode_satuan= $('#kode_satuan').val();
        let qty=  $('#qty').val();
        let harga=  $('#harga').val();
        // console.log(no_po,id_barang,kode_barang,nama_barang,kode_satuan,qty,harga);
        $.ajax({
            type: "post",
            url: "<?= site_url('PurchOrd/simpanTemp') ?>",
            data: {
                id_po: id_po,
                no_po: no_po,
                id_barang: id_barang,
                kode_barang: kode_barang,
                nama_barang: nama_barang,
                kode_satuan: kode_satuan,
                qty: qty,
                harga: harga,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses == 'berhasil') {
                    dataDetailPo();
                    kosong();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
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
        let kodesupplier = $('#kode_supplier').val();
        let addkrm1  = $('#addkrm1').val();
        let addkrm2  = $('#addkrm2').val();
        let addkrm3  = $('#addkrm3').val();
        let nama_up  = $('#nama_up').val();
        let telepon_up= $('#telepon_up').val();
        let nopo     = $('#no_po').val();
        let idpo     = $('#id_po').val();
        let tglpo    = $('#tgl_po').val();
        let tglkirim = $('#tgl_kirim').val();
        let ket      = $('#keterangan').val();
        let proyek   = $('#proyek').val();
        let termin   = $('#termin').val();
        let totaldpp = $('#total_dpp').val();
        let totalppn = $('#total_ppn').val();
        let totalpph = $('#total_pph').val();
        let totalpo  = $('#total_po').val();

        $.ajax({
            type: "post",
            url: "<?= base_url('PurchOrd/updatedata') ?>",
            data: {
                kode_supplier: kodesupplier,
                id_po: idpo,
                no_po: nopo,
                tgl_po: tglpo,
                addkrm1: addkrm1,
                addkrm2: addkrm2,
                addkrm3: addkrm3,
                nama_up: nama_up,
                telepon_up: telepon_up,
                termin: termin,
                tgl_kirim: tglkirim,
                proyek: proyek,
                keterangan: ket,
                total_dpp: totaldpp,
                total_ppn: totalppn,
                total_pph: totalpph,
                total_po: totalpo,
            },
            dataType: "json",
            beforeSend: function() {
                $('.tombolSimpanInv').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.tombolSimpanInv').prop('disabled', true);
            },
            complete: function() {
                $('.tombolSimpanInv').html('SIMPAN DATA');
                $('.tombolSimpanInv').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let dataError = response.error;
                    console.log(dataError);
                    if (dataError.errorKodeSupplier) {
                        $('.errorKodeSupplier').html(dataError.errorKodeSupplier).show();
                        $('#kode_supplier').addClass('is-invalid');
                    } else {
                        $('.errorKodeSupplier').fadeOut();
                        $('#kode_supplier').removeClass('is-invalid');
                        $('#kode_supplier').addClass('is-valid');
                    }

                    if (dataError.errorNoPo) {
                        $('.errorNoPo').html(dataError.errorNoInvoice).show();
                        $('#no_po').addClass('is-invalid');
                    } else {
                        $('.errorNoPo').fadeOut();
                        $('#no_po').removeClass('is-invalid');
                        $('#no_po').addClass('is-valid');
                    }

                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        html: response.sukses,
                    }).then((result) => {
                        if (result.value) {
                            window.location = "<?= base_url('PurchOrd') ?>";
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
