<div class="page-title">
    <div class="row">
        <div class="col-6">
            <h5><?php echo $title_form; ?></h5>
        </div>
        <div class="col-6">
            <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item"><a href="<?php echo site_url('Welcome'); ?>"><i data-feather="home"></i></a>
                </li> -->
                <li class="breadcrumb-item"><a href="<?php echo site_url('Welcome'); ?>"><i class="fa fa-home">Dashboard</i></a></li>
                <li class="breadcrumb-item active"><?php echo $title_form; ?> </li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="card">
        <div class="card-body">
            <!-- <form class="theme-form" id="formindex">
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="txt_nmkary">Product Name</label>
                    <div class="col-sm-9">
                        <?php
                        $this->db->select("kodebrg,namabrg");
                        $this->db->from('barang b');
                        $this->db->order_by('kodebrg', 'ASC');
                        $barangs = $this->db->get(); ?>
                        <select id="txt_nmkary" name="txt_nmkary">
                            <option value="">Silahkan Pilih</option>
                            <?php
                            foreach ($barangs->result() as $rowbarangs) {
                                echo "<option value='$rowbarangs->kodebrg'>$rowbarangs->namabrg</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-7">
                        </div>
                        <div class="col-sm-5">
                            <button id="btn_reset" class="btn btn-pill btn-outline-info btn-air-info" type="button" title="btn btn-pill btn-outline-info btn-air-info"><i class="fa fa-refresh"> Reload
                                    Record</i></button>
                            <button id="btn_cari" class="btn btn-pill btn-outline-info btn-air-info" type="button" title="btn btn-pill btn-outline-info btn-air-info"><i class="fa fa-send-o"> Find
                                    Record</i></button>
                        </div>
                    </div>
                </div>
            </form> -->
            <div class="mb-3 row">
                <div class="col-sm-5">
                    <button id="btn_input" class="btn btn-pill btn-outline-info btn-air-info" type="button" title="btn btn-pill btn-outline-info btn-air-info" data-bs-target="#staticBackdrop"><i class="fa fa-plus-square">
                            Input Barang </i></button>
                </div>
            </div>
            <div class="dt-ext table-responsive">
                <table class="display" id="datatable_list">
                    <div id="button"></div>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID_Barang</th>
                            <th>Barcode</th>
                            <th>Nama</th>
                            <th>Stok</th>
                            <th>StokMin</th>
                            <th>StokMax</th>
                            <th>HPP</th>
                            <th>Price</th>
                            <th>Profit</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>ID_Barang</th>
                            <th>Barcode</th>
                            <th>Nama</th>
                            <th>Stok</th>
                            <th>StokMin</th>
                            <th>StokMax</th>
                            <th>HPP</th>
                            <th>Price</th>
                            <th>Profit</th>
                            <th>Kategori</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('masterbarang/add') ?>
<?php $this->load->view('masterbarang/edit') ?>
<?php $this->load->view('masterbarang/open_image') ?>
<?php $this->load->view('masterbarang/logger') ?>

<script type="text/javascript">
    var table;
    $(document).ready(function(e) {
        table = $('#datatable_list').DataTable({

            "lengthMenu": [
                [50, 100, 150, -1],
                [50, 100, 150, "All"]
            ],
            // "pagingType": "full_numbers",
            "oLanguage": {
                "sProcessing": '<center><img alt src="<?php echo base_url('assets/mt/assets/images/loading/loading-4.gif'); ?>" style="opacity: 1.0;filter: alpha(opacity=100);"></center>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "searching": true,
            "autoWidth": true,
            "info": true,
            // "scrollY": true,
            "scrollX": false,
            "order": [], //Initial no order.
            "ajax": {
                "url": "<?php echo site_url('C_masterbarang/ajax_list') ?>",
                "type": "POST",
                "data": function(data) {
                    $('#loader').hide();
                    data.kodebrg = $('#txt_nmkary').select2().val();
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
        var buttons = new $.fn.dataTable.Buttons(table, {}).container().appendTo($('#button'));

    })


    function data_logger(kodebrg) {
        // $('#frmModal')[0].reset(); // reset form on modals 
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_masterbarang/ajax_logger_edit') ?>/" + kodebrg,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.TRANS_ID == '') {
                    $('[name="idtemp"]').val(data.NULL);
                    $('[name="txt_transID"]').val(data.NULL);
                    $('[name="txt_transDesc"]').val(data.NULL);
                    $('.modal-title').text('  Master Barang Logger'); // Set Title to Bootstrap modal title
                    $('#frmLogger').modal('show'); // show bootstrap modal when complete loaded
                } else {
                    $('[name="idtemp"]').val(data.TRANS_ID);
                    $('[name="txt_transID"]').val(data.TRANS_ID);
                    $('[name="txt_transDesc"]').val(data.TRANS_DESC);
                    $('.modal-title').text('Master Barang Logger'); // Set Title to Bootstrap modal title
                    $('#frmLogger').modal('show'); // show bootstrap modal when complete loaded
                    table_logger.ajax.reload(null);
                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    $('#btn_reset').click(function() { //button reset event click

        $('[name="txt_nmkary"]').select2().val('').trigger('change');
        table.ajax.reload(); //just reload table
        scrollWin();
    });

    $('#btn_cari').click(function() { //button filter event click
        table.ajax.reload(); //just reload table
        scrollWin();
    });

    function scrollWin() {
        window.scrollBy(0, 500);
    };



    function showgambar(kodebrg) {
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        // alert(kodebrg);
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_masterbarang/ajax_showimage') ?>/" + kodebrg,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                if (data.gambar1 != '') {
                    $('#openimage #gbr').attr("src", "assets/barang/" + data.gambar1);
                } else if (data.gambar1 == '') {
                    $('#openimage #gbr').attr("src", "assets/barang/test.jpeg");
                }
                $('#showgambar').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text(data.namabrg); // Set Title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }



    function delete_data(id) {
        var data_id = id;
        var urls = '<?= site_url("C_masterbarang/delete_permanen/"); ?>';
        swal({
                title: "Are you sure?",
                text: "Do you realy want to delete permanen this imaginary file?! Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: urls + data_id,
                        dataType: "JSON",
                        success: function(data) {
                            if (data.is_error == true) {
                                swal('Oopps', data.error_message, 'error');
                            } else {
                                swal({
                                    title: "Info",
                                    text: "Good luck Bro, data telah berhasil di delete permanen .",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 1111
                                });
                            }
                            table.ajax.reload();
                        },
                        error: function(data) {
                            swal("NOT Disabled!", "Something blew up.", "error");
                        }
                    });
                } else {
                    swal("Your imaginary file is still disable!");
                }
            })
    }





    function disable_data(id) {
        var data_id = id;
        var urls = '<?= site_url("C_masterbarang/delete_archive/"); ?>';
        swal({
                title: "Are you sure?",
                text: "Do you realy want to disable this data?!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: urls + data_id,
                        dataType: "JSON",
                        success: function(data) {
                            if (data.is_error == true) {
                                swal('Oopps', data.error_message, 'error');
                            } else {

                                swal({
                                    title: "Info",
                                    text: "Good luck Bro, Disable data berhasil .",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 1111
                                });
                            }
                            table.ajax.reload();
                        },
                        error: function(data) {
                            swal("NOT Disabled!", "Something blew up.", "error");
                        }
                    });

                } else {
                    swal("Your imaginary file is safe!");
                }
            })
    }

    function recover(id) {
        var data_id = id;
        var urls = '<?= site_url("C_masterbarang/recovery/"); ?>';
        swal({
                title: "Are you sure?",
                text: "Do you realy want to recover this data?!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: urls + data_id,
                        dataType: "JSON",
                        success: function(data) {
                            if (data.is_error == true) {
                                swal('Oopps', data.error_message, 'error');
                            } else {
                                swal({
                                    title: "Info",
                                    text: "Good luck Bro, recovery data berhasil .",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 1111
                                });
                            }
                            table.ajax.reload();
                        },
                        error: function(data) {
                            swal("NOT Disabled!", "Something blew up.", "error");
                        }
                    });
                } else {
                    swal("Your imaginary file is safe!");
                }
            })
    }
</script>