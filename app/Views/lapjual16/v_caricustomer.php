<!-- Modal -->
<div class="modal fade" id="modalcustomer" tabindex="-1" aria-labelledby="modalcustomerLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modalcustomerLabel">DATA CUSTOMER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-size: 15px;">
                <input type="hidden" name="keyw15pxordkodecustomer" id="keywordkodecustomer" value="<?= $keyword ?>">
                <div class="table-responsive">
                    <table id="datacustomer" class="table table-sm table-bordered table-striped" width="100%">
                        <thead class="bg-primary">
                            <tr class="text-center">
                                <td width="5%">NO</td>
                                <td width='15%'>KODE CUSTOMER</td>
                                <td>NAMA CUSTOMER</td>
                                <td>ALAMAT</td>
                                <td>AKSI</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm closemodal" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#datacustomer').DataTable({
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "async": true,
                "url": "<?php echo site_url('SalesInv/listDataCustomer') ?>",
                "type": "POST",
                "data": {
                    keywordkodecustomer: $('#keywordkodecustomer').val(),
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            //optional
            "columnDefs": [{
                "targets": [0, 4],
                "className": 'text-center',
            }, ],
        });
    });

    function pilihitem(kode, nama, add1, add2, add3) {
        $('#kode_customer').val(kode);
        $('#nama_customer').val(nama);
        $('#modalcustomer').on('hidden.bs.modal', function(event) {
            $('#dari').focus();
        })
        $('#modalcustomer').modal('hide');
    }
</script>