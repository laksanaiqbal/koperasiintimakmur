<div class="modal fade bd-example-modal-lg" tabindex="-1" id="frmEdit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-group">
                    &nbsp<h4 class="modal-title-edit" id="myLargeModalLabel">
                </i></h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="card-body">
                        <form method="POST" id="frm_Edit" class="theme-form">
                            <div class="mb row" hidden>
                                <label class="col-sm-2 col-form-label" for="id_detail">Purchase Code</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="id_detail" name="id_detail" type="number" placeholder="Type Nama Here" readonly>
                                </div>
                            </div>
                            <div class="mb row">
                                <label class="col-sm-2 col-form-label" for="namabrg">Product</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="namabrg" name="namabrg" type="text" placeholder="Type Nama Here" readonly>
                                </div>
                            </div>
                            <div class="mb row">
                                <label class="col-sm-2 col-form-label" for="hargabeli">Purchase Price</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="hargabeli" name="hargabeli" type="text" placeholder="Type Jumlah Here">
                                </div>
                            </div>
                            <div class="mb row">
                                <label class="col-sm-2 col-form-label" for="hargajual">Selling Price</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="hargajual" name="hargajual" type="text" placeholder="Type Jumlah Here">
                                </div>
                            </div>
                            <div class="mb row">
                                <label class="col-sm-2 col-form-label" for="jumlah">QTY</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="jumlah" name="jumlah" type="number" placeholder="Type Jumlah Here">
                                </div>
                            </div>
                            <div class="mb row">
                                <label class="col-sm-2 col-form-label" for="catatan">Note</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="catatan" name="catatan" type="text" placeholder="Type Note Here">
                                </div>
                            </div>
                            <div id="hidden" hidden>
                                <div class="mb row">
                                    <label class="col-sm-2 col-form-label" for="brutto">Brutto</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" id="brutto" name="brutto" type="number" placeholder="Type brutto Here">
                                    </div>
                                </div>
                                <div class="mb row">
                                    <label class="col-sm-2 col-form-label" for="bruttobaru">bruttobaru</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" id="bruttobaru" name="bruttobaru" type="number" placeholder="Type bruttobaru Here">
                                    </div>
                                </div>
                                <div class="mb row">
                                    <label class="col-sm-2 col-form-label" for="kodebrg">kodebrg</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" id="kodebrg" name="kodebrg" type="number" placeholder="Type bruttobaru Here">
                                    </div>
                                </div>
                                <div class="mb row">
                                    <label class="col-sm-2 col-form-label" for="nobeli">nobeli</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" id="nobeli" name="nobeli" type="number" placeholder="Type nobeli Here">
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="iddbeli">iddbeli</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" id="iddbeli" name="iddbeli" type="number" placeholder="Type iddbeli Here">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" id="btnEdit" class="btn btn-pill btn-outline-primary-2x btn-air-primary"><i class="fa fa-send-o">
                                        Save</i></button>
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
    $("#frm_Edit").keyup(function() {
        var brutto = parseInt($("#brutto").val())
        var jumlah = parseInt($("#jumlah").val())
        var hargabeli = parseInt($("#hargabeli").val())
        var hargajual = parseInt($("#hargajual").val())

        hjual = hargajual * 0;

        bruttobaru = (jumlah * hargabeli) + hjual;
        $("#bruttobaru").attr("value", bruttobaru)


    });
    $('#frm_Edit').submit(function(e) {
        urls = "<?php echo site_url('C_pembelian/update_dbeli') ?>";
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
                    table_edit.ajax.reload();
                    table_pembelian.ajax.reload();
                    table_proses.ajax.reload();
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

    function edit_detail_beli(id) {
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $.ajax({
            url: "<?php echo site_url('C_pembelian/edit_detail_beli') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="namabrg"]').val(data.namabrg);
                $('[name="kodebrg"]').val(data.kodebrg);
                $('[name="hargabeli"]').val(data.hpp);
                $('[name="hargajual"]').val(data.hjual1);
                $('[name="jumlah"]').val(data.qtybeli);
                $('[name="iddbeli"]').val(data.iddbeli);
                $('[name="brutto"]').val(data.brutto);
                $('[name="nobeli"]').val(data.nobeli);
                $('[name="catatan"]').val(data.note);

                $('#frmEdit').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title-edit').text('Product Entering Edit'); // Set Title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>