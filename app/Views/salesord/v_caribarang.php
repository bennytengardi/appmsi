<!-- Modal -->
<div class="modal fade" id="modalbarang" tabindex="-1" aria-labelledby="modalbarangLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modalbarangLabel">LIST ITEM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-image: linear-gradient(#abc4ff, #f5f7fa);font-size: 12px;">
                <input type="hidden" name="keywordkodebarang" id="keywordkodebarang" value="<?= $keyword ?>">
                <div class="table-responsive">
                    <table id="databarang" class="table table-sm table-bordered table-striped" width="100%">
                        <thead class="bg-primary">
                            <tr class="text-center">
                                <td width="5%">NO</td>
                                <td width='10%'>ITEM NO</td>
                                <td>ITEM NAME</td>
                                <td>STOCK</td>
                                <td width='10%'>UNIT</td>
                                <td>PRICE</td>
                                <td>ACTION</td>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary closemodal" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#databarang').DataTable({
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "pageLength": 15,
            "order": [],
            "ajax": {
                "async": true,
                "url": "<?php echo site_url('SalesOrd/listDataBarang') ?>",
                "type": "POST",
                "data": {
                    keywordkodebarang: $('#keywordkodebarang').val(),
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            //optional
            "columnDefs": [
                {
                    "targets": [0, 3, 4, 6],
                    "className": 'pb-0 text-center',
                },
                {
                    "targets": [5],
                    "className": 'pb-0 text-right',
                },
                {
                    "targets": [1,2],
                    "className": 'pb-0 text-left',
                },
            ],
        });
    });

    function pilihitem(kode) {
        $.ajax({
            type: "post",
            url: "<?= site_url('Barang/cari_idbarang') ?>",
            data: {
                id_barang: kode,
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
                    $('[id="harga"]').val(number_format(data.hargajual, 0));
                    $('[id="qtystok"]').val(parseInt(data.masuk) - parseInt(data.keluar) + parseInt(data.returjual) - parseInt(data.returbeli) + parseInt(data.adjust));
                    $('#modalbarang').on('hidden.bs.modal', function(event) {
                        $('#qty').focus();
                    })
                    $('#modalbarang').modal('hide');

                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('Kode Barang ini tidak ada dalam master barang!!');
            }
        });
    }
</script>