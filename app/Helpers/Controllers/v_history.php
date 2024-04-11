<!-- Modal -->
<div class="modal fade" id="modalharga" tabindex="-1" aria-labelledby="modalhargaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modalhargaLabel">HISTORY HARGA JUAL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px;">
                <input type="hidden" name="kodecustomer" id="kodecustomer" value="<?= $kodecustomer ?>">
                <input type="hidden" name="kodebarang" id="kodebarang" value="<?= $kodebarang ?>">
                <div class="table-responsive">
                    <table id="dataharga" class="table table-sm table-bordered table-striped" width="100%">
                        <thead class="bg-primary">
                            <tr class="text-center">
                                <td>NO</td>
                                <td>NO INVOICE</td>
                                <td>TGL INVOICE</td>
                                <td>JUMLAH</td>
                                <td>HARGA</td>
                            </tr>
                        </thead>
                        <tbody>
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
        var table = $('#dataharga').DataTable({
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "async": true,
                "url": "<?php echo base_url('SalesNon/listDataHistory') ?>",
                "type": "POST",
                "data": {
                    kodebarang: $('#kodebarang').val(),
                    kodecustomer: $('#kodecustomer').val()
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [{
                    "targets": [0, 2, 3],
                    "className": 'text-center',
                },
                {
                    "targets": [4],
                    "className": 'text-right',
                },
            ],
        });
    });
</script>