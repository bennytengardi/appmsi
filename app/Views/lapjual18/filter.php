<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-5">
            <div class="card" style="height: 100%;background-color: lightblue;">
                <div class="card-header bg-primary text-white text-center" style="height: 50px;">
                    <p style="font-size: 20px;">Sales By Items Detail</p>
                </div>
                <div class="card-body">
                    <?= form_open('LapJual18/preview') ?>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Item Description</label>
                            <select name="kode_barang" id="kode_barang" class="form-control form-control-sm">
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>From</label>
                            <input type="date" name="dari" value="<?= $dari ?>" class="form-control form-control-sm">
                        </div>

                        <div class="form-group col-md-4">
                            <label>To.</label>
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
   function dataBarang() {
        $('#kode_barang').select2({
            minimumInputLength: 3,
            allowClear: false,
            placeholder: '',
            ajax: {
                dataType: "json",
                type: "post",
                url: "<?= base_url('barang/ambilDataBarang') ?>",
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

    function tampilBarang() {
        $.ajax({
            url: "<?= site_url('barang/ambilDataBarang') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#kode_barang').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
    
    $(document).ready(function() {
        dataBarang();
        // tampilGroup();
    });

</script>

<?= $this->endSection() ?>