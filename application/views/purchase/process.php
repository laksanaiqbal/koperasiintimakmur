<div class="modal fade bd-example-modal-lg" id="process" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-shopping-bag"> &nbsp</i>
                <h4 style="font-weight: bolder;" class="modal-title" id="myLargeModalLabel"></i></h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="hitung">
                                <form method="POST" id="formprocess" class="theme-form" enctype="multipart/form-data">
                                    <input hidden name="idtemps" id="idtemps">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h3 style="font-weight: bolder;">TOTAL </h3>
                                        </div>
                                        <div class="col-sm-1">
                                            <h3 style="font-weight: bolder;">= </h3>
                                        </div>
                                        <div class="col-sm-7" style="text-align: right;">
                                            <h1><span id="totalan" style="color:white" class="badge bg-warning"></span></h1>
                                        </div>
                                        <hr>
                                        <div class="col-sm-10" hidden>
                                            <input class="form-control" id="total" name="total" type="number" placeholder="Type Jumlah Here" readonly>
                                        </div>
                                    </div>
                                    <div class="row" id="discount">
                                        <label style="font-weight: bolder;" class="col-sm-4 col-form-label" for="Disc">Discount </label>
                                        <div class="col-sm-1">
                                            <h3 style="font-weight: bolder;">= </h3>
                                        </div>
                                        <div class="col-sm-7" style="text-align: right;">
                                            <input style="background-color:bisque; color: black;" value="0" class="form-control" id="Disc" name="Disc" type="number" placeholder="Type Jumlah Here">
                                        </div>
                                    </div>
                                    <div class="row" id="pajak">
                                        <label style="font-weight: bolder;" class="col-sm-4 col-form-label" for="PPN">PPN </label>
                                        <div class="col-sm-1">
                                            <h3 style="font-weight: bolder;">= </h3>
                                        </div>
                                        <div class="col-sm-7" style="text-align: right;">
                                            <input style="background-color:bisque; color: black;" value="0" class="form-control" id="PPN" name="PPN" type="number" placeholder="Type Jumlah Here">
                                        </div>
                                    </div>
                                    <div class="row" hidden>
                                        <label class="col-sm-2 col-form-label" for="tbaru">New Total</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" id="tbaru" name="tbaru" type="number" placeholder="Type Jumlah Here" readonly>
                                        </div>
                                    </div>
                                    <div class="row" hidden>
                                        <label class="col-sm-2 col-form-label" for="kembalian">Change</label>
                                        <div class="col-sm-5">
                                            <input class="form-control" id="kembalian" name="kembalian" type="number" placeholder="Type Jumlah Here" readonly>
                                        </div>
                                    </div>
                                    <div class="row" id="fakturs">
                                        <label style="font-weight: bolder;" class="col-sm-4 col-form-label" for="faktur">Faktur </label>
                                        <div class="col-sm-1">
                                            <h3 style="font-weight: bolder;">= </h3>
                                        </div>
                                        <div class="col-sm-7" style="text-align: right;">
                                            <input style="background-color:bisque; color: black;color: black;" class="form-control" id="faktur" name="faktur" type="text" placeholder="Type Faktur Here">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <hr>
                                        <div class="col-sm-4">
                                            <h3 style="font-weight: bolder;">New TOTAL </h3>
                                        </div>
                                        <div class="col-sm-1">
                                            <h3 style="font-weight: bolder;">= </h3>
                                        </div>
                                        <div class="col-sm-7" style="text-align: right;">
                                            <h1><span id="tbarus" style="color:white" class="badge bg-primary"></span></h1>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row" style="font-size: x-large;">
                                        <label style="font-weight: bolder;" class="col-sm-4 col-form-label" for="bayar">Rp </label>
                                        <div class="col-sm-1">
                                            <h3 style="font-weight: bolder;">= </h3>
                                        </div>
                                        <div class="col-sm-7">
                                            <input style="font-size:xx-large; text-align: right;background-color:bisque; color: black;" class="form-control" id="bayar" name="bayar" type="number" placeholder="Type Nominal Here">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <hr>
                                        <div class="col-sm-4">
                                            <h3 style="font-weight: bolder;">Change </h3>
                                        </div>
                                        <div class="col-sm-1">
                                            <h3 style="font-weight: bolder;">= </h3>
                                        </div>
                                        <div class="col-sm-4">
                                            <h1><span id="kembalians" style="color:white" class="badge bg-success"></span></h1>
                                        </div>
                                        <div class="col-sm-3" style="text-align: right; margin-top: auto; margin-bottom: auto; ">
                                            <button type="submit" id="btnProcess" class="btn btn-pill btn-outline-primary-2x btn-air-primary">
                                                <i style="font-weight: bolder;" class="fa fa-send-o"> Pay!</i>
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
    </div>
</div>

<script type="text/javascript">
    $(".hitung").keyup(function() {
        var total = parseInt($("#total").val())
        var bayar = parseInt($("#bayar").val())
        var PPN = parseInt($("#PPN").val())
        var disc = parseInt($("#Disc").val())

        var hdisc = total + (-(disc));
        var hppn = hdisc + PPN;
        hppn = isNaN(hppn) ? total : hppn
        $("#tbaru").attr("value", hppn)
        var kembalian = bayar - hppn;
        kembalian = isNaN(kembalian) ? 0 : kembalian

        $("#kembalian").attr("value", kembalian)
        document.getElementById("tbarus").innerHTML = "Rp. " + hppn;
        document.getElementById("kembalians").innerHTML = "Rp. " + kembalian;

    });

    function process(nobeli) {
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        // alert(kodebrg);
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_pembelian/ajax_process') ?>/" + nobeli,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="idtemps"]').val(data.nobeli);
                $('[name="total"]').val(data.tbrutto);
                document.getElementById("totalan").innerHTML = "Rp. " + data.tbrutto;
                $('[name="disc"]').val(data.nilaidisc1);
                $('[name="ppn"]').val(data.nilaippn);

                var discount = document.getElementById("discount");
                if (data.disc1 == 0) {
                    discount.style.visibility = "hidden"
                } else {
                    discount.style.visibility = "visible"
                }

                var pajak = document.getElementById("pajak");
                if (data.ppn == 0) {
                    pajak.style.visibility = "hidden"
                } else {
                    pajak.style.visibility = "visible"
                }

                var faktur = document.getElementById("fakturs");
                if (data.faktur == 0) {
                    faktur.style.visibility = "hidden"
                } else {
                    faktur.style.visibility = "visible"
                }

                $('#process').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text(data.kodebeli); // Set Title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    $('#formprocess').submit(function(e) {
        urls = "<?php echo site_url('C_pembelian/process') ?>";
        // var data = $(this).serialize();
        var data = new FormData($('#formprocess')[0]);
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
                    table_pembelian.ajax.reload();
                    document.getElementById("formprocess").reset();
                    $('#process').modal('hide');
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