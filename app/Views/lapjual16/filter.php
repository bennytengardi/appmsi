<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 18px;">TANDA TERIMA FAKTUR</p>
                </div>
                <div class="card-body">
                    <?= form_open('LapJual16/preview') ?>
                    <br>
                    <div class="row">
                        <div class="col-md-3">KODE CUSTOMER</div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm text-md kode_customer" aria-describedby="basic-addon2" name="kode_customer" id="kode_customer" onkeyup="this.value = this.value.toUpperCase()" autofocus autocomplete="off">
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-primary tombol-customer" id="basic-addon2" data-toggle="modal" data-target="#modal-customer"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-3">NAMA CUSTOMER</div>
                        <div class="col-md-8">
                            <input type="text" name="nama_customer" id="nama_customer" class="form-control form-control-sm text-md " readonly>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-3">PERIODE</div>
                        <div class="col-md-3">
                            <input type="date" name="dari" id="dari" value="<?= $dari ?>" class="form-control form-control-sm text-md">
                        </div>
                        <div class="col-md-0">
                            <p class="text-center">S/D</p>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="sampai" id="sampai" value="<?= $sampai ?>" class="form-control form-control-sm text-md">
                        </div>

                    </div>

                    <div class="form-group">
                        <button class="btn btn-sm btn-success text-md mt-4 mr-1" name="btnCetak" type="submit"><i class="fa fa-print"></i> PRINT</button>
                        <a href="<?= base_url() ?>/admin" class="btn btn-sm btn-danger text-md mt-4"><i class="fas fa-sign-out-alt"></i> KELUAR</a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
    $('.tombol-customer').click(function(e) {
        e.preventDefault();
        cekKodeCustomer2();
    });

    $('#kode_customer').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            cekKodeCustomer();
        }
    });

    function cekKodeCustomer2() {
        let kode_customer = $('#kode_customer').val();
        $.ajax({
            url: "<?= site_url('LapJual16/viewDataCustomer') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewmodal').html(response.viewmodal).show();
                $('#modalcustomer').modal('show');
                $('#modalcustomer').on('shown.bs.modal', function() {
                    $("#modalcustomer [type='search']").focus();
                })
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function cekKodeCustomer() {
        let kode_customer = $('#kode_customer').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('Customer/cari_kodecustomer') ?>",
            data: {
                kode_customer: kode_customer,
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $.each(data, function(kode_customer, nama_customer, address1, address2) {
                    $('[id="kode_customer"]').val(data.kode_customer);
                    $('[id="nama_customer"]').val(data.nama_customer);
                    $("#dari").focus();
                });
            },
            error: function() {
                alert("Kode Customer ini tidak ditemukan");
            }
        });
        return false;
    }
</script>
<?= $this->endSection() ?>