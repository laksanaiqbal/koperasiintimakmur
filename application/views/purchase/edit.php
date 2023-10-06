<div class="modal fade bd-example-modal-lg" tabindex="-1" id="frmEdit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-group">
                    &nbsp<h4 class="modal-title" id="myLargeModalLabel">
                </i></h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <!-- <div class="card"> -->
                    <div class="card-body">
                        <form method="POST" id="frm_Edit" class="theme-form">
                            <div class="mb row" hidden>
                                <label class="col-sm-2 col-form-label" for="id_detail">ID</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="id_detail" name="id_detail" type="number" placeholder="Type Nama Here" readonly>
                                </div>
                            </div>
                            <div class="mb row">
                                <label class="col-sm-2 col-form-label" for="namabarang">Nama</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="namabarang" name="namabarang" type="text" placeholder="Type Nama Here" readonly>
                                </div>
                            </div>
                            <div class="mb row">
                                <label class="col-sm-2 col-form-label" for="hargabeli">H.Beli</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="hargabeli" name="hargabeli" type="text" placeholder="Type Jumlah Here" readonly>
                                </div>
                            </div>
                            <div class="mb row">
                                <label class="col-sm-2 col-form-label" for="hargajual">H.Jual</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="hargajual" name="hargajual" type="text" placeholder="Type Jumlah Here" readonly>
                                </div>
                            </div>
                            <div class="mb row">
                                <label class="col-sm-2 col-form-label" for="jumlah">QTY</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="jumlah" name="jumlah" type="number" placeholder="Type Jumlah Here">
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" id="btnEdit" class="btn btn-pill btn-outline-primary-2x btn-air-primary"><i class="fa fa-send-o">
                                        Submit</i></button>
                                <button class="btn btn-pill btn-outline-info-2x btn-air-info" data-bs-dismiss="modal"><i class="fa fa-xing"></i> Cancel</i> </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(e) {

    });
    $('#frm_Edit').submit(function(e) {
        urls = "<?php echo site_url('C_pembelian/update_proses') ?>";
        // var data = $(this).serialize();
        var data = new FormData($('#frm_Edit')[0]);
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
                        timer: 1999,
                        type: "error"
                    });
                } else {
                    swal({
                        title: 'Hore',
                        text: out['succes_message'],
                        showConfirmButton: false,
                        timer: 1999,
                        type: "success"
                    });
                    table.ajax.reload();
                    document.getElementById("frm_Edit").reset();
                    $('#frmEdit').modal('hide');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal({
                    title: 'Crash Bro',
                    // text: out['error_message'],
                    showConfirmButton: false,
                    timer: 1999,
                    type: "error"
                });
            }
        });
        e.preventDefault();
    });
</script>