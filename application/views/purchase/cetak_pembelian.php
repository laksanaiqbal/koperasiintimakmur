<div class="modal fade bd-example-modal-lg" tabindex="-1" id="cetakpembelian" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" id="myLargeModalLabel">
                <button onclick="PrintMe('divid')" class="btn btn-pill btn-outline-secondary btn-air-info" type="button" title="Print"><i class="fa fa-print"> Print!</i></button>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="cetak">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body col-12 text-center">
                            <!-- <h3>KOPERASI INTI MAKMUR</h3>
                            <h7>Jl. Akses Pabrik, Mangunreja, Kec. Puloampel, Kabupaten Serang, Banten 42455</h7>
                            <br> -->
                            <center>
                                <h2 style="margin-bottom: 0px;">INVOICE</h2>
                                <h6 style="margin-top: 0px;" id="ID"></h6>
                            </center>
                            <div class="mb row" hidden>
                                <p id="gtotal"></p>
                                <p id="tax"></p>
                                <p id="dis"></p>
                            </div>
                            <div class="mb row" hidden>
                                <div class="col-sm-6">
                                    <h6>Req Date :<p id="tglreq"></p>
                                    </h6>
                                </div>
                                <div class="col-sm-6">
                                    <h6>Req Del :<p id="tgldel"></p>
                                    </h6>
                                </div>
                            </div>
                            <div class="mb row" hidden>
                                <div class="col-sm-6">
                                    <h6>Suplier :<p id="sup"></p>
                                    </h6>
                                </div>
                            </div>
                            <div id="divid">
                                <hr>
                                <h7></h7>
                                <div class="table">
                                    <input hidden name="idtemp1" id="idtemp1">
                                    <div class="mb-12 row" hidden>
                                    </div>
                                    <table class="table table-bordered" style="text-align: center;" id="datatable_print_pembelian">
                                        <thead>
                                            <tr>
                                                <th style="width: 150px;">No </th>
                                                <th style="width: 150px;">Product Name</th>
                                                <th style="width: 150px;">QTY</th>
                                                <th style="width: 150px;">Unit</th>
                                                <th style="width: 150px;">Note</th>
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
<script>
    function PrintMe(divid) {
        var kodebeli = $("#ID").text();
        var tglreq = $("#tglreq").text();
        var gtotal = $("#gtotal").text();
        var tgldel = $("#tgldel").text();
        var tax = $("#tax").text();
        var sup = $("#sup").text();
        var dis = $("#dis").text();
        var disp_setting = "toolbar=yes,location=no,";
        disp_setting += "directories=yes,menubar=yes,";
        // disp_setting += "scrollbars=yes,width=650, height=600, left=100, top=25";
        var content_vlue = document.getElementById(divid).innerHTML;
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
        docprint.document.write(kodebeli);
        docprint.document.write('</h6></center>');
        docprint.document.write('<h5 style="margin-bottom: 0px;">Req Date : ')
        docprint.document.write(tglreq);
        docprint.document.write('</h5>');
        docprint.document.write('<h5 style="margin-top: 0px;margin-bottom: 0px;">Del Date &nbsp;: ')
        docprint.document.write(tgldel);
        docprint.document.write('</h5>');
        docprint.document.write('<h5 style="margin-top: 0px;">Suplier &nbsp;&nbsp;&nbsp;&nbsp;: ')
        docprint.document.write(sup);
        docprint.document.write('</h5><center>');
        docprint.document.write(content_vlue);
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

    $('#btnClose').click(function() { //button filter event click
        $('#cetakpembelian').modal('hide'); // show bootstrap modal when complete loaded
    });

    function print_pembelian(id) {
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        // alert(kodebrg);
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_pembelian/ajax_edit_pembelian') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="nobelis"]').val(data.nobeli);
                $('[name="idtemp1"]').val(data.nobeli);
                document.getElementById("ID").innerHTML = data.kodebeli;
                document.getElementById("tglreq").innerHTML = data.tanggalreq;
                document.getElementById("tgldel").innerHTML = data.tanggaldel;
                document.getElementById("sup").innerHTML = data.namasup;
                document.getElementById("gtotal").innerHTML = data.tbrutto;
                document.getElementById("dis").innerHTML = data.nilaidisc1;
                document.getElementById("tax").innerHTML = data.nilaippn;

                $('#cetakpembelian').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Print Pembelian'); // Set Title to Bootstrap modal title
                table_cetak.ajax.reload(null);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    var table_cetak;
    $(document).ready(function(e) {
        table_cetak = $('#datatable_print_pembelian').DataTable({
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
                "url": "<?php echo site_url('C_pembelian/ajax_list_cetak') ?>",
                "type": "POST",
                "data": function(data) {
                    $('#loader').hide();
                    data.dbeli = $('#idtemp1').val();
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
</script>