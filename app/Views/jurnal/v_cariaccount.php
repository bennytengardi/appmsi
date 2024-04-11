<!-- Modal -->
<div class="modal fade" id="modalaccount" tabindex="-1" aria-labelledby="modalaccountLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="height: 40px">
                <h6 class="modal-title mt-n2" id="modalaccountLabel">LIST ACCOUNT</h6>                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle text-white text-boldt" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </span>
                </button>
            </div>
            <div class="modal-body" style="background-image: linear-gradient(#abc4ff, #f5f7fa);font-size: 13px;">
                <input type="hidden" name="keywordkodeaccount" id="keywordkodeaccount" value="<?= $keyword ?>">
                <div class="table-responsive">
                    <table id="dataaccount" class="table table-sm table-bordered table-striped" width="100%">
                        <thead class="bg-primary">
                            <tr class="text-center">
                                <td width="4%">NO</td>
                                <td width='10%'>ACCOUNT#</td>
                                <td>ACCOUNT NAME</td>
                                <td width=8%>ACTION</td>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-secondary closemodal" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#dataaccount').DataTable({
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "pageLength": 15,
            "order": [],
            "ajax": {
                "async": true,
                "url": "<?php echo site_url('OthRcv/listDataAccount') ?>",
                "type": "POST",
                "data": {
                    keywordkodeaccount: $('#keywordkodeaccount').val(),
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            //optional
            "columnDefs": [
                {
                    "targets": [0, 3],
                    "className": 'text-center pb-0',
                },
                {
                    "targets": [1, 2],
                    "className": 'text-left pb-0',
                },
            ],
        });
    });

    function pilihitem(kode, nama) {
        $('#kode_acct').val(kode);
        $('#nama_acct').val(nama);
        $('#modalaccount').on('hidden.bs.modal', function(event) {
            $('#jumlah').focus();
        })
        $('#modalaccount').modal('hide');
    }
</script>