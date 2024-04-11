<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 18px;">Sales Ord yg Belum ada Invoice</p>
                </div>
                <div class="card-body">
                    <?= form_open('LapJual24/preview') ?>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Division</label>
                            <select name="kode_divisi" id="kode_divisi" class="form-control form-control-sm">
                                <option value="">Pilih Divisi</option>
                                <?php foreach ($divisi as $sls) : ?>
                                    <option value="<?= $sls['kode_divisi'] ?>"><?= $sls['kode_divisi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" form-group col-md-6">
                            <label>Per Tgl</label>
                            <input type="date" name="sampai" value="<?= $sampai ?>" class="form-control form-control-sm">
                        </div>

                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-success mt-3" name="btnCetak" type="submit"><i class="fa fa-print"></i> Preview</button>
                        <button class="btn btn-sm btn-primary mt-3" name="btnExport" type="submit"><i class="fa fa-file-excel"></i> Export to Excel</button>
                        <a href="<?= base_url() ?>/admin" class="btn btn-sm btn-danger mt-3"><i class="fas fa-sign-out-alt"></i> Exit</a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   function dataCustomer() {
        $('#kode_customer').select2({
            minimumInputLength: 3,
            allowClear: false,
            placeholder: '',
            ajax: {
                dataType: "json",
                type: "post",
                url: "<?= base_url('customer/ambilDataCustomer') ?>",
                delay: 200,
                data: function(params, page) {
                    return {
                        search: params.term
                    }
                },
                processResults: function(data) {
                    return {
                        results: data
                    }
                },
                cache: true
            }
        });
    }

    function tampilCustomer() {
        $.ajax({
            url: "<?= site_url('customer/ambilDataCustomer') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#kode_customer').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        dataCustomer();
        // tampilGroup();
    });

</script>

<?= $this->endSection() ?>