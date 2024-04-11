<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<br>
<div class="card card-primary" style="background-image: linear-gradient(#abc4ff, #f5f7fa);">
    <div class="card-header" style="height: 40px;">
        <h3 class="card-title mt-n1">CUSTOMER</h3>
        <a href="<?= base_url('admin') ?>" type="button" class="btn btn-sm mb-2 mt-n1 float-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </a>
    </div>

    <div class="card-body">
        <button type="button" class="btn btn-primary btn-xs tomboltambahbeli mb-2" onclick="window.location='<?= base_url('Customer/add') ?>'">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg>&nbsp;&nbsp;Add Customer
        </button>
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover" id="DataCust" width="100%" style="font-size: 12px;">
                <thead class="bg-primary text-center" align="center">
                    <tr>
                        <td width=3%>NO</td>
                        <td width=6%>CUST ID</td>
                        <td width=25%>CUSTOMER NAME</td>
                        <td>ADDRESS</td>
                        <td width=14%>TELEPHONE#</td>
                        <td width=8%>BALANCE</td>
                        <td width=15%>ACTION</td>
                    </tr>
                </thead>
                <tbody class="bg-white">

                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        listDataCust()
    });

    function listDataCust() {
        var table = $('#DataCust').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 15,
            "order": [],
            'ajax': {
                "url": "<?= base_url('customer/listData') ?>",
                "type": "post",
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            },
            "columnDefs": [{
                    "targets": [0, 6],
                    "className": 'pb-0 text-center',
                },
                {
                    "targets": [5],
                    "className": 'pb-0 text-right',
                },
                {
                    "targets": [1,2,3,4],
                    "className": 'pb-0 text-left',
                },
                {
                    "targets": [0,5,6],
                    "orderable": false,
                },
            ],
        })
    }


    function hapusCustomer(kode_customer, nama_customer) {
        Swal.fire({
            html: `Are you sure to delete this customer : <strong> ${kode_customer}<br>${nama_customer}</strong>`,
            text: "Do you want to delete !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00a65a',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel',
            showClass: {
                popup: 'animate__animated animate__fadeIn'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('customer/hapus') ?>",
                    data: {
                        kode_customer: kode_customer,
                        nama_customer: nama_customer
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.sukses,
                                confirmButtonColor: '#00a65a',
                                showClass: {
                                    popup: 'animate__animated animate__fadeIn'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                }
                            }).then((result) => {
                                if (result.value) {
                                    window.location.reload();
                                }
                            })
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        })
    }
</script>


<?= $this->endSection() ?>