<div class="modal fade bd-example-modal-lg" tabindex="-1" id="show_detail" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-bullhorn">
                    &nbsp<h4 class="modal-title" id="myLargeModalLabel">
                </i></h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="card-body">
                        <form method="POST" id="frm_logger" class="theme-form">
                            <input hidden name="idtemp" id="idtemp">
                            <div class="mb-12 row">
                                <label class="col-sm-2 col-form-label" for="id_jual">ID</label>
                                <div class="col-sm-2">
                                    <input class="form-control" id="id_jual" name="id_jual" type="text" Readonly>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="dt-ext table-responsive">
                            <!-- <table class="display" id="export-button"> -->
                            <table class="display" id="datatable_detail">
                                <div id="buttondetail"></div>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Jual</th>
                                        <th>Nama Produk</th>
                                        <th>Harga Jual</th>
                                        <th>qty</th>
                                        <th>SubTotal</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var table_detail;
    $(document).ready(function(e) {
        table_detail = $('#datatable_detail').DataTable({
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('black');
            },
            "paging": true,
            "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],
            // "lengthChange": false,
            "oLanguage": {
                "sProcessing": '<center><img alt src="<?php echo base_url('assets/mt/assets/images/loading/loading-4.gif'); ?>" style="opacity: 1.0;filter: alpha(opacity=100);"></center>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "searching": false,
            "autoWidth": false,
            "scrollY": true,
            "scrollX": true,
            "order": [], //Initial no order.
            "ajax": {
                "url": "<?php echo site_url('C_penjualan/ajax_list_detail') ?>",
                "type": "POST",
                "data": function(data) {
                    $('#loader').hide();
                    data.txt_transID = $('#idtemp').val();
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [-1], //last column
                    "orderable": true, //set not orderable
                },
                {
                    "targets": [-2], //2 last column (photo)
                    "orderable": true, //set not orderable
                },
            ],

        });
        var buttons = new $.fn.dataTable.Buttons(table_detail, {}).container().appendTo($('#buttondetail'));
    })
</script>