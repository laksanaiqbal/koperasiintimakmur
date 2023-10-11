<div class="modal fade bd-example-modal-lg" tabindex="-1" id="frmEditHeader" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" id="frm_Edit_Pembelian" class="theme-form">
                                <input hidden name="idtemp" id="idtemp">
                                <div class="mb-12 row" hidden>
                                    <label class="col-sm-2 col-form-label" for="id_pembelian">ID</label>
                                    <div class="col-sm-2">
                                        <input class="form-control" id="id_pembelian" name="id_pembelian" type="text" Readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="mb row" hidden>
                                            <label class="col-sm-2 col-form-label" for="nobelis">ID</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="nobelis" name="nobelis" type="number" placeholder="Type nobeli Here" readonly>
                                            </div>
                                        </div>
                                        <div class="mb row">
                                            <label class="col-sm-4 col-form-label" for="cabangs">Cabang</label>
                                            <div class="col-sm-8">
                                                <select name="cabangs" id="cabangs" class="form-control select2">
                                                    <?php foreach ($datacabang as $data) : ?>
                                                        <option value="<?php echo $data->idcabang ?>"><?php echo $data->namacabang ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb row">
                                            <label class="col-sm-4 col-form-label" for="payments">Payment</label>
                                            <div class="col-sm-8">
                                                <select name="payments" id="payments" class="form-control select2">
                                                    <option value="0">Cash</option>
                                                    <option value="1">Hutang</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb row">
                                            <label class="col-sm-4 col-form-label" for="kodesups">Suplier</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" id="kodesups" name="kodesups" type="text" placeholder="Type Jumlah Here">
                                            </div>
                                        </div>
                                        <div class="mb row">
                                            <label class="col-sm-4 col-form-label" for="fakturs">Faktur</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" id="fakturs" name="fakturs" type="text" placeholder="Type Jumlah Here">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="mb row">
                                            <label class="col-sm-6 col-form-label" for="tanggalreqs">Tanggal Req</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="tanggalreqs" name="tanggalreqs" type="date" placeholder="Type Jumlah Here">
                                            </div>
                                        </div>
                                        <div class="mb row">
                                            <label class="col-sm-6 col-form-label" for="tanggaldels">Tanggal Del</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="tanggaldels" name="tanggaldels" type="date" placeholder="Type Jumlah Here">
                                            </div>
                                        </div>
                                        <div class="mb row">
                                            <label class="col-sm-6 col-form-label" for="ppns">PPN</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="ppns" name="ppns" type="number" placeholder="Type  Here">
                                            </div>
                                        </div>
                                        <div class="mb row">
                                            <label class="col-sm-6 col-form-label" for="diskons">diskon</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="diskons" name="diskons" type="number" placeholder="Type Diskon Here">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" id="btnEdit" class="btn btn-pill btn-outline-primary-2x btn-air-primary"><i class="fa fa-send-o">
                                                Submit</i></button>
                                        <button class="btn btn-pill btn-outline-info-2x btn-air-info" data-bs-dismiss="modal"><i class="fa fa-xing"></i> Cancel</i> </button>
                                    </div>
                                </div>
                            </form>
                            <form method="POST" id="inputFormBarang" class="theme-form" enctype="multipart/form-data">
                                <div class="mb-2 row">
                                    <button id="btn_barang" type="button" class="btn btn-primary"><i class="fa fa-search"> Barang</i></button>
                                </div>
                                <div class="mb-2 row" hidden>
                                    <label class="col-md-2 col-form-label" for="nobeli">nobeli</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="nobeli" name="nobeli" type="number" placeholder="Type Jumlah Here" required>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-2 col-form-label" for="namabrg">Nama</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="namabrg" name="namabrg" type="text" placeholder="Type Nama Here" readonly>
                                    </div>
                                    <label class="col-md-2 col-form-label" for="hbeli">H.Beli</label>
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
                                    <label class="col-md-2 col-form-label" for="hjual">H.Jual</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="hjual" name="hjual" type="text" placeholder="Type Jumlah Here">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-2 col-form-label" for="qty">QTY</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="qty" name="qty" type="number" placeholder="Type Jumlah Here" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row" style="text-align: center;">
                                    <div class="col-md-12">
                                        <button type="submit" id="btnSave" class="btn btn-pill btn-outline-primary-2x btn-air-primary">
                                            <i class="fa fa-send-o">Submit</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <hr>
                            <div class="dt-ext table-responsive">
                                <!-- <table class="display" id="export-button"> -->
                                <table class="display" id="datatable_edit">
                                    <div id="buttonedit"></div>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Barang</th>
                                            <th>qty</th>
                                            <th>Satuan</th>
                                            <th>Total</th>
                                            <th>Status</th>
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
<script type="text/javascript">
    var table_edit;
    $(document).ready(function(e) {
        table_edit = $('#datatable_edit').DataTable({
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
                "url": "<?php echo site_url('C_pembelian/ajax_list_Epembelian') ?>",
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
                    table_pembelian.ajax.reload(null);
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
    // $('#frm_Edit').submit(function(e) {
    //     urls = "<?php echo site_url('C_pembelian/update_proses') ?>";
    //     // var data = $(this).serialize();
    //     var data = new FormData($('#frm_Edit')[0]);
    //     $.ajax({
    //         url: urls,
    //         type: 'POST',
    //         data: data,
    //         async: false,
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         success: function(data) {
    //             var out = jQuery.parseJSON(data);
    //             if (out.is_error == true) {
    //                 swal({
    //                     title: 'Error Bro',
    //                     text: out['error_message'],
    //                     showConfirmButton: false,
    //                     html: true,
    //                     timer: 1999,
    //                     type: "error"
    //                 });
    //             } else {
    //                 swal({
    //                     title: 'Hore',
    //                     text: out['succes_message'],
    //                     showConfirmButton: false,
    //                     timer: 1999,
    //                     type: "success"
    //                 });
    //                 table.ajax.reload();
    //                 document.getElementById("frm_Edit").reset();
    //                 $('#frmEdit').modal('hide');
    //             }
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             swal({
    //                 title: 'Crash Bro',
    //                 // text: out['error_message'],
    //                 showConfirmButton: false,
    //                 timer: 1999,
    //                 type: "error"
    //             });
    //         }
    //     });
    //     e.preventDefault();
    // });
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
                    // location.reload()
                    table_edit.ajax.reload(null);
                    table_pembelian.ajax.reload(null);
                    document.getElementById("inputFormBarang").reset();
                    $('#frmEditHeader').modal('hide');
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

    function edit_data_pembelian(nobeli) {
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        // alert(kodebrg);
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_pembelian/ajax_edit_pembelian') ?>/" + nobeli,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="cabangs"]').val(data.idcabang);
                $('[name="payments"]').val(data.hutang);
                $('[name="kodesups"]').val(data.kodesup);
                $('[name="tanggalreqs"]').val(data.tanggalreq);
                $('[name="tanggaldels"]').val(data.tanggaldel);
                $('[name="ppns"]').val(data.ppn);
                $('[name="fakturs"]').val(data.faktur);
                $('[name="diskons"]').val(data.disc1);
                $('[name="nobeli"]').val(data.nobeli);
                $('[name="nobelis"]').val(data.nobeli);
                $('[name="idtemp"]').val(data.nobeli);

                $('#frmEditHeader').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Data Header Pembelian'); // Set Title to Bootstrap modal title
                table_edit.ajax.reload(null);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    $('#btn_barang').click(function() { //button filter event click
        $('#showbarang').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('PILIH Barang'); // Set Title to Bootstrap modal title
    });
</script>