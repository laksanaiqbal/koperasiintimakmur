<div class="modal fade bd-example-modal-xl" tabindex="-1" id="frmEditHeader" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-shopping-bag"> &nbsp <u>
                        <h4 class="modal-title" id="myLargeModalLabel">
                </i></h4></u>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="card" style="margin-bottom: 0px;">
                        <div class="mb-2 row">
                            <h6><i class="fa fa-circle"></i> <u>Purchase Order Edit</u></h6>
                        </div>
                        <div class="card-body" style="padding-top: 0px;padding-bottom: 0px;">
                            <form method="POST" id="frm_Edit_Pembelian" class="theme-form">
                                <input hidden name="idtemp2" id="idtemp2">
                                <input hidden name="codebeli" id="codebeli">
                                <div class="mb-12 row" hidden>
                                    <label class="col-sm-2 col-form-label" for="id_pembelian">ID</label>
                                    <div class="col-sm-2">
                                        <input class="form-control" id="id_pembelian" name="id_pembelian" type="text" Readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="cabangs">Branch</label>
                                            <div class="col-sm-8">
                                                <select name="cabangs" id="cabangs" class="form-control">
                                                    <?php foreach ($datacabang as $data) : ?>
                                                        <option value="<?php echo $data->idcabang ?>"><?php echo $data->namacabang ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="payments">Payment</label>
                                            <div class="col-sm-8">
                                                <select name="payments" id="payments">
                                                    <option value="0">Cash</option>
                                                    <option value="1">Debt</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="kodesups">Suplier</label>
                                            <input hidden name="namasups" id="namasups">
                                            <div class="col-sm-8">
                                                <select name="kodesups" id="kodesups" class="form-control select2" data dropdown-parent="#frmEditHeader" disabled>
                                                    <?php foreach ($datasup as $data) : ?>
                                                        <option value="<?php echo $data->kodesup ?>"><?php echo $data->namasup ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="fakturss">Invoice</label>
                                            <div class="col-sm-8">
                                                <select name="fakturss" id="fakturss" class="form-control select2" data dropdown-parent="#frmEditHeader">
                                                    <option value="0">NO</option>
                                                    <option value="1">YES</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="tanggalreqs">Request Date</label>
                                            <div class="col-sm-8">
                                                <input style="height: 40px;" class="form-control" id="tanggalreqs" name="tanggalreqs" type="date" placeholder="Type Jumlah Here">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="tanggaldels">Deliver Date</label>
                                            <div class="col-sm-8">
                                                <input style="height: 40px;" class="form-control" id="tanggaldels" name="tanggaldels" type="date" placeholder="Type Jumlah Here">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="ppns">Tax</label>
                                            <div class="col-sm-8">
                                                <select name="ppns" id="ppns" class="form-control select2" data dropdown-parent="#frmEditHeader">
                                                    <option value="0">NO</option>
                                                    <option value="1">YES</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="diskons">Discount</label>
                                            <div class="col-sm-8">
                                                <select name="diskons" id="diskons" class="form-control select2" data dropdown-parent="#frmEditHeader">
                                                    <option value="0">NO</option>
                                                    <option value="1">YES</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end" style="padding-bottom: 0px;">
                                        <button type="submit" id="btnEdit" class="btn btn-pill btn-outline-primary-2x btn-air-primary"><i class="fa fa-send-o">
                                                Save</i></button>
                                        <button class="btn btn-pill btn-outline-info-2x btn-air-info" data-bs-dismiss="modal"><i class="fa fa-xing"></i> Cancel</i> </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="card">
                        <div class="mb-2 row">
                            <h6><i class="fa fa-circle"></i> <u>Input Product</u></h6>
                        </div>
                        <div class="card-body" style="padding-top: 0px;padding-bottom: 0px;">
                            <form method="POST" id="inputFormBarang" class="theme-form" enctype="multipart/form-data">
                                <div class="mb-2 row" hidden>
                                    <label class="col-md-2 col-form-label" for="nobelis">nobeli</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="nobelis" name="nobelis" type="number" placeholder="Type Jumlah Here">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <button id="btn_barang" type="button" class="btn btn-primary col-md-2" data-bs-target="#staticBackdrop"><i class="fa fa-search"> Product</i></button>
                                    <div class="col-md-4">
                                        <input class="form-control" id="namabrg" name="namabrg" type="text" placeholder="Type Nama Here" readonly required>
                                    </div>
                                    <label class="col-md-2 col-form-label" for="hbeli">Purchase Price</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="hbeli" name="hbeli" type="text" placeholder="Type Jumlah Here" required>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-1 col-form-label" for="Barcode">Barcode</label>
                                    <div class="col-md-5">
                                        <input readonly class="form-control" id="barcode" name="barcode" type="text" placeholder="Type kode Here" readonly required>
                                    </div>
                                    <div class="col-md-4" hidden>
                                        <input readonly class="form-control" id="kodebrg" name="kodebrg" type="text" placeholder="Type kode Here" required>
                                    </div>
                                    <label class="col-md-2 col-form-label" for="hjual">Selling Price</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="hjual" name="hjual" type="text" placeholder="Type Jumlah Here" required>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-1 col-form-label" for="qty">QTY</label>
                                    <div class="col-md-3">
                                        <input class="form-control" id="qty" name="qty" type="number" placeholder="Type Jumlah Here" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" id="sat" name="sat" type="text" placeholder="Type Unit Here" readonly required>
                                    </div>
                                    <label class="col-md-2 col-form-label" for="note"><i>Note</i></label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="note" name="note" type="text" placeholder="Type note Here" required>
                                    </div>
                                </div>
                                <div class="card-footer text-end" style="padding-bottom: 0px;">
                                    <button style="width: 150px;" type="submit" id="btnSave" class="btn btn-pill btn-outline-primary-2x btn-air-primary">
                                        <i class="fa fa-send-o"> Post!</i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="card">
                        <div class="mb-2 row">
                            <h6><i class="fa fa-circle"></i> <u>Product Entered</u></h6>
                        </div>
                        <div class="card-body" style="padding-top: 0px;">
                            <button onclick="Print('div')" class="btn btn-danger mb-2 row" type="button" title="Print"><i class="fa fa-print">&nbsp Print Preview!</i></button>
                            <div id="div">
                                <div class="table-responsive">
                                    <table class="display" style="text-align: center;" id="datatable_edit">
                                        <thead>
                                            <tr>
                                                <th style="width: 90px;">No</th>
                                                <th style="width: 150px;">Product Name</th>
                                                <th style="width: 90px;">QTY</th>
                                                <th style="width: 90px;">Unit</th>
                                                <th style="width: 90px;">Total</th>
                                                <th style="width: 90px;">Note</th>
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
    </div>
</div>

<script type="text/javascript">
    function Print(div) {
        var codebelis = $("#codebeli").val();
        var tglreqs = $("#tanggalreqs").val();
        var tgldels = $("#tanggaldels").val();
        var sups = $("#namasups").val();
        var disp_setting = "toolbar=yes,location=no,";
        disp_setting += "directories=yes,menubar=yes,";
        // disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
        var content_vlues = document.getElementById(div).innerHTML;
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
        docprint.document.write(codebelis);
        docprint.document.write('</h6></center>');
        docprint.document.write('<h5 style="margin-bottom: 0px;">Req Date : ')
        docprint.document.write(tglreqs);
        docprint.document.write('</h5>');
        docprint.document.write('<h5 style="margin-top: 0px;margin-bottom: 0px;">Del Date &nbsp;: ')
        docprint.document.write(tgldels);
        docprint.document.write('</h5>');
        docprint.document.write('<h5 style="margin-top: 0px;">Suplier &nbsp;&nbsp;&nbsp;&nbsp;: ')
        docprint.document.write(sups);
        docprint.document.write('</h5><center><hr>');
        docprint.document.write(content_vlues);
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

    $(document).ready(function(e) {
        $("#payments").select2({
            dropdownParent: $("#frmEditHeader")
        });
        $("#cabangs").select2({
            dropdownParent: $("#frmEditHeader")
        });
        $("#fakturss").select2({
            dropdownParent: $("#frmEditHeader")
        });
        $("#ppns").select2({
            dropdownParent: $("#frmEditHeader")
        });
        $("#diskons").select2({
            dropdownParent: $("#frmEditHeader")
        });
        $("#satuan").select2({
            dropdownParent: $("#frmEditHeader")
        });
    })

    var table_edit;
    $(document).ready(function(e) {
        table_edit = $('#datatable_edit').DataTable({
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
            "ajax": {
                "url": "<?php echo site_url('C_pembelian/ajax_list_detail') ?>",
                "type": "POST",
                "data": function(data) {
                    $('#loader').hide();
                    data.dbeli = $('#idtemp2').val();
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
    $('#frm_Edit_Pembelian').submit(function(e) {
        urls = "<?php echo site_url('C_pembelian/edit_header') ?>";
        // var data = $(this).serialize();
        var data = new FormData($('#frm_Edit_Pembelian')[0]);
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
                    document.getElementById("frm_Edit_Pembelian").reset();
                    $('#frmEditHeader').modal('hide');
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

    $('#inputFormBarang').submit(function(e) {
        urls = "<?php echo site_url('C_pembelian/input_proses') ?>";
        var data = new FormData($('#inputFormBarang')[0]);
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
                    table_edit.ajax.reload(null);
                    table_pembelian.ajax.reload(null);
                    table_show.ajax.reload(null);
                    document.getElementById("inputFormBarang").reset();
                    // $('#frmEditHeader').modal('hide');
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

    function edit_data_pembelian(id) {
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        // alert(kodebrg);
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_pembelian/ajax_edit_pembelian') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#cabangs').val(data.idcabang).trigger('change');
                $('#payments').val(data.hutang).trigger('change');
                $('[name="kodesups"]').val(data.kodesup);
                $('[name="namasups"]').val(data.namasup);
                $('[name="tanggalreqs"]').val(data.tanggalreq);
                $('[name="tanggaldels"]').val(data.tanggaldel);
                $('#ppns').val(data.ppn).trigger('change');
                $('#fakturss').val(data.faktur).trigger('change');
                $('#diskons').val(data.disc1).trigger('change');
                $('[name="nobelis"]').val(data.nobeli);
                $('[name="idtemp2"]').val(data.nobeli);
                $('[name="id_pembelian"]').val(data.nobeli);
                $('[name="codebeli"]').val(data.kodebeli);

                document.getElementById("inputFormBarang").reset();
                $('#frmEditHeader').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text(data.kodebeli); // Set Title to Bootstrap modal title
                $('.modal-subtitle').text('Input Product'); // Set Title to Bootstrap modal title
                table_edit.ajax.reload(null);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    $('#btn_barang').click(function() { //button filter event click
        var nobelis = parseInt($("#id_pembelian").val())
        $("#nobelis").attr("value", nobelis)
        $('#showbarang').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title-product').text('Choose Product'); // Set Title to Bootstrap modal title
    });
</script>