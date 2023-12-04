<div class="modal fade bd-example-modal-lg" id="inputbarang2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
                        <form method="POST" id="inputFormBaru2" class="theme-form" enctype="multipart/form-data">
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
                                <div class="col-md-12" style="text-align: center;">
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
    $('#btninput2').click(function() { //button filter event click
        document.getElementById("inputFormBaru2").reset();
        var nobeli = parseInt($("#idtemp2").val())
        $("#inputbarang2 #nobeli").attr("value", nobeli)
        $('#inputbarang2').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title-product').text('  Input Product'); // Set Title to Bootstrap modal title
    });


    $('#inputFormBaru2').submit(function(e) {
        urls = "<?php echo site_url('C_pembelian/input_baru') ?>";
        var data = new FormData($('#inputFormBaru2')[0]);
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
                    table_pembelian.ajax.reload();
                    table_edit.ajax.reload();
                    $('#inputbarang2').modal('hide');
                    // $('#frmEditHeader').modal('hide');

                    document.getElementById("inputFormBaru2").reset();
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