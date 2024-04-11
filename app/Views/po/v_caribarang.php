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
            <div class="modal-body">
                <input type="hidden" name="keywordkodebarang" id="keywordkodebarang" value="<?= $keyword ?>">
                <div class="table-responsive">
                    <table id="databarang" class="table table-sm table-bordered table-striped" width="100%">
                        <thead class="bg-primary">
                            <tr class="text-center">
                                <td width="4%">NO</td>
                                <td width="18%">ITEM NO</td>
                                <td>ITEM NAME</td>
                                <td width="7%">UNIT</td>
                                <td width="10%">COGS</td>
                                <td width="6%">ACTION</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger closemodal" data-dismiss="modal">Close</button>
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
            "order": [],
            "ajax": {
                "async": true,
                "url": "<?php echo site_url('PurchOrd/listDataBarang') ?>",
                "type": "POST",
                "data": {
                    keywordkodebarang: $('#keywordkodebarang').val(),
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            //optional
            "columnDefs": [{
                    "targets": [0,3, 5],
                    "className": 'text-center',
                },
                {
                    "targets": [4],
                    "className": 'text-right',
                },
                {
                    "targets": 0,
                    "orderable": false,
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
                $.each(data, function(id_barang,kode_barang, nama_barang, kode_satuan, hargabeli) {
                    $('[id="id_barang"]').val(data.id_barang);
                    $('[id="kode_barang"]').val(data.kode_barang);
                    $('[id="nama_barang"]').val(data.nama_barang);
                    $('[id="kode_satuan"]').val(data.kode_satuan);
                    // $('[id="harga"]').val(number_format(data.hargabeli, 2));
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