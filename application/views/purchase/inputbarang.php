<div class="modal fade bd-example-modal-lg" id="inputbarang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-bullhorn">
                    &nbsp<h4 class="modal-title-product" id="myLargeModalLabel">
                </i></h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="card-body">
                        <form method="POST" id="inputFormBaru" class="theme-form" enctype="multipart/form-data">
                            <div class="mb row" hidden>
                                <div class="col-sm-9">
                                    <input class="form-control" id="nobeli" name="nobeli" type="number" placeholder="Type nobeli Here">
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <button id="btn_show" type="button" class="btn btn-primary col-md-2 "><i class="fa fa-search"> Product</i></button>
                                <div class="col-md-4">
                                    <input class="form-control" id="namabrg" name="namabrg" type="text" placeholder="Type Nama Here" readonly>
                                </div>
                                <label class="col-md-2 col-form-label" for="hbeli">Purchase Price</label>
                                <div class="col-md-4">
                                    <input class="form-control" id="hbeli" name="hbeli" type="text" placeholder="Type Jumlah Here">
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label class="col-md-2 col-form-label" for="Barcode">Barcode</label>
                                <div class="col-md-4">
                                    <input readonly class="form-control" id="barcode" name="barcode" type="text" placeholder="Type kode Here" readonly>
                                </div>
                                <div class="col-md-4" hidden>
                                    <input readonly class="form-control" id="kodebrg" name="kodebrg" type="text" placeholder="Type kode Here">
                                </div>
                                <label class="col-md-2 col-form-label" for="hjual">Selling Price</label>
                                <div class="col-md-4">
                                    <input class="form-control" id="hjual" name="hjual" type="text" placeholder="Type Jumlah Here">
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label class="col-md-2 col-form-label" for="qty">QTY</label>
                                <div class="col-md-2">
                                    <input class="form-control" id="qty" name="qty" type="number" placeholder="Type Jumlah Here" required>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" id="sat" name="sat" type="text" placeholder="Type Unit Here" readonly>
                                </div>
                                <label class="col-md-2 col-form-label" for="note"><i>Note</i></label>
                                <div class="col-md-4">
                                    <input class="form-control" id="note" name="note" type="text" placeholder="Type note Here" required>
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <div class="col-md-6" style="text-align: right;">
                                    <button style="width: 150px;" type="submit" id="btnSave" class="btn btn-pill btn-outline-primary-2x btn-air-primary">
                                        <i class="fa fa-send-o"> Post!</i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#btninput').click(function() { //button filter event click
        document.getElementById("inputFormBaru").reset();
        var nobeli = parseInt($("#PO").val())
        $("#nobeli").attr("value", nobeli)
        $('#inputbarang').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title-product').text('  Input Product'); // Set Title to Bootstrap modal title
    });

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
                "url": "<?php echo site_url('C_pembelian/ajax_list_detail') ?>",
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
    $('#inputFormBaru').submit(function(e) {
        urls = "<?php echo site_url('C_pembelian/input_baru') ?>";
        var data = new FormData($('#inputFormBaru')[0]);
        $.ajax({
            url: urls,
            type: 'POST',
            data: data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                var out = jQuery.parseJSON(data);
                if (out.is_error == true) {
                    swal({
                        title: 'Error Bro',
                        text: out['error_message'],
                        showConfirmButton: false,
                        html: true,
                        timer: 1000,
                        type: "error"
                    });
                } else {
                    swal({
                        title: 'Hore',
                        text: out['succes_message'],
                        showConfirmButton: false,
                        timer: 1000,
                        type: "success"
                    });
                    // location.reload()
                    table_pembelian.ajax.reload();
                    // table_edit.ajax.reload();
                    table_baru.ajax.reload();
                    $('#inputbarang').modal('hide');
                    document.getElementById("inputFormBaru").reset();
                    var print = document.getElementById("print");
                    if (print.style.display === "none") {
                        print.style.display = "block";
                    } else {
                        print.style.display = "none";
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal({
                    title: 'Crash Bro',
                    showConfirmButton: false,
                    timer: 1000,
                    type: "error"
                });
            }
        });
        e.preventDefault();
    });
</script>