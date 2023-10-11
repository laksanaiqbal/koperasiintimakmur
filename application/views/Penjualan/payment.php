<div class="modal fade bd-example-modal-lg" id="show_pay" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-image">
                    &nbsp<h4 class="modal-title" id="myLargeModalLabel">
                </i></h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="openimage">
                <div class="col-sm-12">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-10" style="margin-left: auto; margin-right:auto;">
                                <div class="hitung">
                                    <form method="POST" id="simpanjual" class="theme-form" enctype="multipart/form-data">
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="total">Total</label>
                                            <div class="col-sm-9">
                                                <input value="<?php echo $sum; ?>" class="form-control" id="total" name="total" type="number" placeholder="Type Jumlah Here" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="diskon">Diskon (%)</label>
                                            <div class="col-sm-3">
                                                <input value="0" class="form-control" id="diskon" name="diskon" type="number" placeholder="Type Jumlah Here">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="metode">Payment</label>
                                            <div class="col-sm-9">
                                                <div class="checkbox">
                                                    <input type="radio" name="metode" id="layanan" value="0" checked> Cash
                                                    <input type="radio" name="metode" id="layanan" value="1"> Hutang
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="bayar">Bayar</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="bayar" name="bayar" type="number" placeholder="Type Jumlah Here">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="kembalian">Kembalian</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="kembalian" name="kembalian" type="number" placeholder="Type Jumlah Here" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-2 row" hidden>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="cabangs" name="cabangs" type="number" placeholder="Type Jumlah Here" readonly>
                                                <input class="form-control" id="payments" name="payments" type="number" placeholder="Type Jumlah Here" readonly>
                                                <input class="form-control" id="namacust" name="namacust" type="number" placeholder="Type Jumlah Here" readonly>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="btnSave" class="btn btn-pill btn-outline-primary-2x btn-air-primary">
                                                <i class="fa fa-send-o"> Pay!</i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".hitung").keyup(function() {
        var bil1 = parseInt($("#total").val())
        var bil2 = parseInt($("#bayar").val())
        var diskon = parseInt($("#diskon").val())

        var hdiskon = bil1 * (diskon / 100);
        var hbaru = bil1 - hdiskon;
        var kembalian = bil2 - hbaru;
        $("#kembalian").attr("value", kembalian)
    });
    $(".cust").keyup(function() {
        var cus1 = parseInt($("#namacus").val())
        $("#cust").attr("value", cus1)
    })


    $('#simpanjual').submit(function(e) {
        urls = "<?php echo site_url('C_penjualan/simpan_penjualan') ?>";
        var data = new FormData($('#simpanjual')[0]);
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
                    table_penjualan.ajax.reload(null, false);
                    table_input.ajax.reload(null, false);
                    document.getElementById("simpanjual").reset();
                    $('#show_pay').modal('hide');
                    $('#forminput').modal('hide');
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