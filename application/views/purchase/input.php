<div class="modal fade bd-example-modal-lg" tabindex="-1" id="forminput" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                            <form method="POST" id="inputbeli" class="theme-form" enctype="multipart/form-data">
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label" for="cabang">Cabang</label>
                                    <div class="col-md-6">
                                        <select name="cabang" id="cabang" class="form-control select2">
                                            <?php foreach ($datacabang as $data) : ?>
                                                <option value="<?php echo $data->idcabang ?>"><?php echo $data->namacabang ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label" for="payment">Payment</label>
                                    <div class="col-md-6">
                                        <select name="payment" id="payment" class="form-control select2">
                                            <option value="0">Cash</option>
                                            <option value="1">Hutang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label" for="kodesup">Suplier</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="kodesup" name="kodesup" type="number" placeholder="Type kodesup Here" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button id="btn_sup" type="button" class="btn btn-primary"><i class="fa fa-search"> Suplier</i></button>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label" for="tanggalreq">TanggalReq</label>
                                    <div class="col-md-3">
                                        <input class="form-control" id="tanggalreq" name="tanggalreq" type="date" placeholder="Type tanggalreq Here">
                                    </div>
                                    <label class="col-md-2 col-form-label" for="tanggaldel">TanggalDel</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="tanggaldel" name="tanggaldel" type="date" placeholder="Type Tanggaldel Here">
                                    </div>

                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label" for="ppn">PPN</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" id="ppn" name="ppn" type="number" placeholder="Type PPN Here">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label" for="faktur">Faktur</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" id="faktur" name="faktur" type="text" placeholder="Type faktur Here">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label" for="faktur">Diskon</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" id="diskon" name="diskon" type="number" placeholder="Type diskon Here">
                                    </div>
                                </div>
                                <div class="row" style="text-align: center;">
                                    <div class="col-md-12">
                                        <button type="submit" id="btnSavePembelian" class="btn btn-pill btn-outline-primary-2x btn-air-primary">
                                            <i class="fa fa-send-o"> </i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>

                            <form method="POST" id="inputFormBaru" class="theme-form" enctype="multipart/form-data">
                                <div class="mb row" hidden>
                                    <div class="col-sm-9">
                                        <input class="form-control" id="nobeli" name="nobeli" type="number" placeholder="Type nobeli Here">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <button id="btn_show" type="button" class="btn btn-primary"><i class="fa fa-search"> Barang</i></button>
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
                            <!-- <div class="table-responsive">
                                <table class="display" id="datatable_baru">
                                    <div id="buttonbaru"></div>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Nama Barang</th>
                                            <th>harga_beli</th>
                                            <th>harga_jual</th>
                                            <th>qty</th>
                                            <th>total</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <br>
                            <div class="mb-2 row" style="text-align: right;">
                                <h2>TOTAL</h2>
                                <hr>
                                <div id="sums">
                                    <h1><?php echo $sum; ?></h1>
                                    <input hidden value="<?php echo $sum; ?>" class="form-control" id="totals" name="totals" type="number" placeholder="Type Jumlah Here">
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <button type="button" id="btn_CO" class="btn btn-primary"><i class="fa fa-paper-plane-o m-right-xs"></i> Simpan</button>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var table_baru;
    $(document).ready(function(e) {
        table_baru = $('#datatable_baru').DataTable({
            // "lengthMenu": [
            //     [10, 25, 50, -1],
            //     [10, 25, 50, "All"]
            // ],
            "lengthMenu": [
                [10, 50, 75, 100, -1],
                [10, 50, 75, 100, "All"]
            ],
            // "pagingType": "full_numbers",
            "oLanguage": {
                "sProcessing": '<center><img alt src="<?php echo base_url('assets/mt/assets/images/loading/loading-4.gif'); ?>" style="opacity: 1.0;filter: alpha(opacity=100);"></center>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "searching": true,
            "autoWidth": false,
            "info": true,
            // "scrollY": 455,
            "scrollX": true,
            "order": [], //Initial no order.
            "ajax": {
                "url": "<?php echo site_url('C_pembelian/ajax_list_Epembelian') ?>",
                "type": "POST",
                "data": function(data) {
                    $('#loader').hide();
                    data.txt_nmkary = $('#txt_nmkary').select2().val();
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
        var buttons = new $.fn.dataTable.Buttons(table_baru, {}).container().appendTo($('#buttonbaru'));

    })
    $('#inputFormBaru').submit(function(e) {
        urls = "<?php echo site_url('C_pembelian/input_baru') ?>";
        var data = new FormData($('#inputFormBaru')[0]);
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
                    // table_pembelian.ajax.reload();
                    table_edit.ajax.reload();
                    document.getElementById("inputFormBaru").reset();
                    $('#frmInput').modal('hide');
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