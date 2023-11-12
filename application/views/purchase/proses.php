<div class="modal fade bd-example-modal-xl" id="proses" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-shopping-bag"> &nbsp <u>
                        <h4 class="modal-title-proses" id="myLargeModalLabel">
                </i></h4></u>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="card" style="margin-bottom: 0px;">
                        <div class="mb-2 row">
                            <h6><i class="fa fa-circle"></i> <u>Purchase Order</u></h6>
                        </div>
                        <div class="card-body" style="padding-top: 0px;padding-bottom: 0px;">
                            <form method="POST" id="frm_Edit_Pembelian" class="theme-form">
                                <input hidden name="idtemp4" id="idtemp4">
                                <input hidden name="kodebelis" id="kodebelis">
                                <div class="mb-12 row" hidden>
                                    <label class="col-sm-2 col-form-label" for="id_pembelians">ID</label>
                                    <div class="col-sm-2">
                                        <input class="form-control" id="id_pembelians" name="id_pembelians" type="text" Readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="cabangss">Branch</label>
                                            <div class="col-sm-8">
                                                <select name="cabangss" id="cabangss" class="form-control">
                                                    <?php foreach ($datacabang as $data) : ?>
                                                        <option value="<?php echo $data->idcabang ?>"><?php echo $data->namacabang ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="paymentss">Payment</label>
                                            <div class="col-sm-8">
                                                <select name="paymentss" id="paymentss">
                                                    <option value="0">Cash</option>
                                                    <option value="1">Debt</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="kodesupss">Suplier</label>
                                            <input hidden name="namasupss" id="namasupss">
                                            <div class="col-sm-8">
                                                <select name="kodesupss" id="kodesupss" class="form-control select2" data dropdown-parent="#frmEditHeader" disabled>
                                                    <?php foreach ($datasup as $data) : ?>
                                                        <option value="<?php echo $data->kodesup ?>"><?php echo $data->namasup ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="fak">Invoice</label>
                                            <div class="col-sm-8">
                                                <select name="fak" id="fak" class="form-control select2" data dropdown-parent="#frmEditHeader">
                                                    <option value="0">NO</option>
                                                    <option value="1">YES</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="tanggalreqss">Request Date</label>
                                            <div class="col-sm-8">
                                                <input style="height: 40px;" class="form-control" id="tanggalreqss" name="tanggalreqss" type="date" placeholder="Type Jumlah Here">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="tanggaldelss">Deliver Date</label>
                                            <div class="col-sm-8">
                                                <input style="height: 40px;" class="form-control" id="tanggaldelss" name="tanggaldelss" type="date" placeholder="Type Jumlah Here">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="ppnss">Tax</label>
                                            <div class="col-sm-8">
                                                <select name="ppnss" id="ppnss" class="form-control select2" data dropdown-parent="#frmEditHeader">
                                                    <option value="0">NO</option>
                                                    <option value="1">YES</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="diskonss">Discount</label>
                                            <div class="col-sm-8">
                                                <select name="diskonss" id="diskonss" class="form-control select2" data dropdown-parent="#frmEditHeader">
                                                    <option value="0">NO</option>
                                                    <option value="1">YES</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-body" style="padding-top: 0px;">
                                        <button onclick="cetak('disini')" class="btn btn-danger mb-2 row" type="button" title="cetak"><i class="fa fa-print">&nbsp Print Preview!</i></button>
                                        <div id="disini">
                                            <div class="table-responsive">
                                                <table class="display" style="text-align: center;" id="datatable_proses">
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
                                    <div class="card-footer text-end" style="padding-bottom: 0px;">
                                        <button type="submit" id="btnEdit" class="btn btn-pill btn-outline-primary-2x btn-air-primary"><i class="fa fa-send-o">
                                                Save</i></button>
                                        <button class="btn btn-pill btn-outline-info-2x btn-air-info" data-bs-dismiss="modal"><i class="fa fa-xing"></i> Cancel</i> </button>
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

<script type="text/javascript">
    function cetak(disini) {
        var kodebeliss = $("#kodebelis").val();
        var tglreqss = $("#tanggalreqss").val();
        var tgldelss = $("#tanggaldelss").val();
        var supss = $("#namasupss").val();
        var disp_setting = "toolbar=yes,location=no,";
        disp_setting += "directories=yes,menubar=yes,";
        // disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
        var content_vluess = document.getElementById(disini).innerHTML;
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

    $(document).ready(function(e) {
        $("#paymentss").select2({
            dropdownParent: $("#proses")
        });
        $("#cabangss").select2({
            dropdownParent: $("#proses")
        });
        $("#fak").select2({
            dropdownParent: $("#proses")
        });
        $("#ppnss").select2({
            dropdownParent: $("#proses")
        });
        $("#diskonss").select2({
            dropdownParent: $("#proses")
        });
    })

    var table_proses;
    $(document).ready(function(e) {
        table_proses = $('#datatable_proses').DataTable({
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
                    data.dbeli = $('#idtemp4').val();
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
        var buttons = new $.fn.dataTable.Buttons(table_proses, {}).container().appendTo($('#buttonedit'));
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


    function proses(id) {
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        // alert(kodebrg);
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_pembelian/ajax_proses') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#cabangss').val(data.idcabang).trigger('change');
                $('#paymentss').val(data.hutang).trigger('change');
                $('[name="kodesupss"]').val(data.kodesup);
                $('[name="namasupss"]').val(data.namasup);
                $('[name="tanggalreqss"]').val(data.tanggalreq);
                $('[name="tanggaldelss"]').val(data.tanggaldel);
                $('#ppnss').val(data.ppn).trigger('change');
                $('#fak').val(data.faktur).trigger('change');
                $('#diskonss').val(data.disc1).trigger('change');
                $('[name="nobelis"]').val(data.nobeli);
                $('[name="idtemp4"]').val(data.nobeli);
                $('[name="id_pembelians"]').val(data.nobeli);
                $('[name="kodebelis"]').val(data.kodebeli);

                document.getElementById("inputFormBarang").reset();
                $('#proses').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title-proses').text('Process ' + data.kodebeli); // Set Title to Bootstrap modal title
                $('.modal-subtitle').text('Input Product'); // Set Title to Bootstrap modal title
                table_proses.ajax.reload(null);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>