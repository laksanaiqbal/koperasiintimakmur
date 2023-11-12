<div class="modal fade bd-example-modal-xl" tabindex="-1" id="forminput" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-shopping-bag"></i> &nbsp<h4 class="modal-title" id="myLargeModalLabel">
                    </i></h4>
                <button class="btn-close" id="btn_close" type="button" aria-label="Close" onclick="status()"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body" style="padding-top: 0px;">
                            <form method="POST" id="inputbeli" class="theme-form" enctype="multipart/form-data">
                                <input hidden name="idtemp3" id="idtemp3">
                                <div class="mb-2 row">
                                    <label class="col-md-2 col-form-label" for="PO">Purchase Code</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" id="PO" name="PO" type="number">
                                    </div>
                                    <label class="col-md-2 col-form-label" for="cabang">Branch</label>
                                    <div class="col-md-4">
                                        <select name="cabang" id="cabang" class="form-control select2" data dropdown-parent="#forminput">
                                            <?php foreach ($datacabang as $data) : ?>
                                                <option value="<?php echo $data->idcabang ?>"><?php echo $data->namacabang ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-2 col-form-label" for="payment">Payment</label>
                                    <div class="col-md-4">
                                        <select name="payment" id="payment" class="form-control select2" data dropdown-parent="#forminput">
                                            <option value="0">Cash</option>
                                            <option value="1">Debt</option>
                                        </select>
                                    </div>
                                    <label class="col-md-2 col-form-label" for="kodesups">Suplier</label>
                                    <div class="col-md-3">
                                        <input class="form-control" id="namasuplier" name="namasuplier" type="text" placeholder="Type namasup Here" readonly required>
                                        <input hidden class="form-control" id="kodesups" name="kodesups" type="number" placeholder="Type kodesup Here" readonly required>
                                    </div>
                                    <div class="col-md-1" style="margin-top: auto; margin-bottom: auto;">
                                        <button data-bs-target="#staticBackdrop" style="width:min-content; height:40px" id="btn_sup" type="button" class="btn btn-secondary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-2 col-form-label" for="tanggalreq">Request Date</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="tanggalreq" name="tanggalreq" type="date" placeholder="Type tanggalreq Here" required>
                                    </div>
                                    <label class="col-md-2 col-form-label" for="tanggaldel">Deliver Date</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="tanggaldel" name="tanggaldel" type="date" placeholder="Type Tanggaldel Here" required>
                                    </div>

                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-2 col-form-label" for="ppn"><i>Tax</i></label>
                                    <div class="col-md-4">
                                        <select name="ppn" id="ppn" class="form-control select2" data dropdown-parent="#forminput">
                                            <option value="0">NO</option>
                                            <option value="1">YES</option>
                                        </select>
                                    </div>
                                    <label class="col-md-2 col-form-label" for="faktur"><i>Invoice</i></label>
                                    <div class="col-md-4">
                                        <select name="faktur" id="faktur" class="form-control select2" data dropdown-parent="#forminput">
                                            <option value="0">NO</option>
                                            <option value="1">YES</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-2 col-form-label" for="diskon"><i>Discount</i></label>
                                    <div class="col-md-4">
                                        <select name="diskon" id="diskon" class="form-control select2" data dropdown-parent="#forminput">
                                            <option value="0">NO</option>
                                            <option value="1">YES</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        <button style="width: 150px;" type="submit" id="btnSavePembelian" class="btn btn-pill btn-outline-primary-2x btn-air-primary">
                                            <i class="fa fa-send-o"> POST</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>

                            <br>
                            <div id="input" style="display: none;">
                                <div class="mb-3 row" style="text-align: center;">
                                    <div class="col-sm-12">
                                        <button id="btninput" data-bs-target="#staticBackdrop" class="btn btn-pill btn-outline-secondary btn-air-secondary" type="button" title="btn btn-pill btn-outline-info btn-air-secondary"><i class="fa fa-plus-square">
                                                Input </i></button>
                                    </div>
                                </div>
                            </div>
                            <div id="print" style="display: none;">
                                <button onclick="PrintIT('divIT')" class="btn btn-danger mb-2 row" type="button" title="Print"><i class="fa fa-print">&nbsp Print Preview!</i></button>
                            </div>
                            <div id="divIT">
                                <div class="table-responsive">
                                    <table class="display" id="datatable_baru">
                                        <div id="buttonbaru"></div>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Product Name</th>
                                                <th>QTY</th>
                                                <th>Unit</th>
                                                <th>Total</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function PrintIT(divIT) {
        var kodebeliss = $("#PO").val();
        var tglreqss = $("#tanggalreq").val();
        var tgldelss = $("#tanggaldel").val();
        var supss = $("#namasuplier").val();
        var disp_setting = "toolbar=yes,location=no,";
        disp_setting += "directories=yes,menubar=yes,";
        // disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
        var content_vluess = document.getElementById(divIT).innerHTML;
        var docprint = window.open("", "", disp_setting);
        docprint.document.open();
        docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
        docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
        docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
        docprint.document.write('<head><title>KIM SALIM AGRO</title>');
        docprint.document.write('<style type="text/css">body{ margin:0px;');
        docprint.document.write('font-family:verdana,Arial;color:#000;');
        docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
        docprint.document.write('a{color:#000;text-decoration:none;} </style>');
        docprint.document.write('</head><body onLoad="self.print()">');
        docprint.document.write('<br><br>')
        docprint.document.write('<h3 style="margin-bottom: 0px;"><img class="img-fluid" src="<?php echo base_url(); ?>assets/cuba/assets/images/logo/koperasi.png" width="15" alt=""> KOPERASI INTI MAKMUR</h3>');
        docprint.document.write('<h7>Jl. Akses Pabrik, Mangunreja, Kec. Puloampel, Kabupaten Serang, Banten 42455</h7>');
        docprint.document.write('<center><h2 style="margin-bottom: 0px;">PURCHASE ORDER</h2></center>');
        docprint.document.write('<center><h6 style="margin-top: 0px;">');
        docprint.document.write('PO-');
        docprint.document.write(kodebeliss);
        docprint.document.write('</h6></center>');
        docprint.document.write('<h5 style="margin-bottom: 0px;">Req Date : ')
        docprint.document.write(tglreqss);
        docprint.document.write('</h5>');
        docprint.document.write('<h5 style="margin-top: 0px;margin-bottom: 0px;">Del Date &nbsp;: ')
        docprint.document.write(tgldelss);
        docprint.document.write('</h5>');
        docprint.document.write('<h5 style="margin-top: 0px;">Suplier &nbsp;&nbsp;&nbsp;&nbsp;: ')
        docprint.document.write(supss);
        docprint.document.write('</h5><center><hr>');
        docprint.document.write(content_vluess);
        docprint.document.write('</center><hr><br>');
        // docprint.document.write('<h4 style="margin-bottom: 0px; "> > Grand Total = Rp. ');
        // docprint.document.write(gtotal);
        // docprint.document.write('</h4>');
        // docprint.document.write('<h4 style="margin-top: 0px;margin-bottom: 0px; "> > Discount &nbsp;&nbsp;&nbsp;&nbsp; = Rp. ');
        // docprint.document.write(dis);
        // docprint.document.write('</h4>');
        // docprint.document.write('<h4 style="margin-top: 0px; "> > Tax &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= Rp. ');
        // docprint.document.write(tax);
        // docprint.document.write('</h4>');
        docprint.document.write('</body></html>');
        docprint.document.close();
        docprint.focus();
    }
    $('#btn_input').click(function() { //button filter event click
        var input = document.getElementById("input");
        if (input.style.display === "none") {
            input.style.display = "visible";
        } else {
            input.style.display = "none";
        }
        var print = document.getElementById("print");
        if (print.style.display === "none") {
            print.style.display = "visible";
        } else {
            print.style.display = "none";
        }


        document.getElementById("inputbeli").reset();
        var ts = new Date().getTime();
        var x = Math.round(ts * Math.random());
        document.getElementById("PO").value = x;
        $("#idtemp3").attr("value", x)

        $('#forminput').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('  Purchase Input'); // Set Title to Bootstrap modal title
        table_baru.ajax.reload(null);

    });

    $('.modal').css('overflow-y', 'auto');
    $('#btn_close').click(function() { //button filter event click
        $('#forminput').modal('hide'); // show bootstrap modal when complete loaded
    });



    var table_baru;
    $(document).ready(function(e) {
        table_baru = $('#datatable_baru').DataTable({
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('black');
            },
            "paging": false,
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
            "overflow": false,
            "info": false,
            "order": [], //Initial no order.
            "ajax": {
                "url": "<?php echo site_url('C_pembelian/ajax_list_detail') ?>",
                "type": "POST",
                "data": function(data) {
                    $('#loader').hide();
                    data.dbeli = $('#idtemp3').val();
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
        var buttons = new $.fn.dataTable.Buttons(table_edit, {}).container().appendTo($('#buttonedit'));
    })

    $('#inputbeli').submit(function(e) {
        urls = "<?php echo site_url('C_pembelian/save_header') ?>";
        var data = new FormData($('#inputbeli')[0]);
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
                    // tables.ajax.reload(null, false);
                    table_baru.ajax.reload()
                    table_pembelian.ajax.reload();
                    // document.getElementById("frm_index").reset();
                    var input = document.getElementById("input");
                    if (input.style.display === "none") {
                        input.style.display = "block";
                    } else {
                        input.style.display = "none";
                    }
                    $('#show_co').modal('hide');
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