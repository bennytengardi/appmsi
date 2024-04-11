<!-- Modal -->
<div class="modal fade" id="modalbarang" tabindex="-1" aria-labelledby="modalbarangLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="height: 40px">
                <h5 class="modal-title mt-n2" id="modalbarangLabel">LIST ITEM</h5>                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle text-white text-boldt" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </span>
                </button>
            </div>
            <div class="modal-body" style="background-image: linear-gradient(#abc4ff, #f5f7fa);font-size: 12px;">
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
                        <tbody class="bg-white">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-danger closemodal" data-dismiss="modal">Close</button>
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
            "pageLength": 18,
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
            "columnDefs": [
                {
                    "targets": [0, 3, 5],
                    "className": 'pb-0 text-center',
                },
                {
                    "targets": [4],
                    "className": 'pb-0 text-right',
                },
                {
                    "targets": [1, 2],
                    "className": 'pb-0 text-left',
                },
                {
                    "targets": 0,
                    "orderable": false,
                },
            ],

        });
    });

    function pilihitem(kode) {
        let idbrg = kode;
        $.ajax({
            type: "post",
            url: "<?= site_url('Barang/cari_idbarang') ?>",
            data: {
                id_barang: idbrg,
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