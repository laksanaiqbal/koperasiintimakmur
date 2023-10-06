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
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form class="theme-form">
                    <div class="mb-3 row">
                        <div class="col-sm-5">
                            <button id="btn_input" class="btn btn-pill btn-outline-info btn-air-info" type="button" title="btn btn-pill btn-outline-info btn-air-info"><i class="fa fa-plus-square">
                                    Input Satuan </i></button>
                        </div>
                    </div>
                    <!-- <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="txt_nmkary">Item Name</label>
                        <div class="col-sm-9">
                            <?php
                            $this->db->select("kodesat,namasat");
                            $this->db->from('satuan a');
                            $this->db->order_by('kodesat', 'ASC');
                            $satuans = $this->db->get(); ?>
                            <select id="txt_nmkary" name="txt_nmkary">
                                <option value="">Silahkan Pilih</option>
                                <?php
                                foreach ($satuans->result() as $rowsatuans) {
                                    echo "<option value='$rowsatuans->kodesat'>$rowsatuans->namasat</option>";
                                }
                                ?>
                            </select>
                        </div>
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
                    </div> -->
                </form>
                <!-- <hr> -->
                <div class="table-responsive">
                    <!-- <table class="display" id="export-button"> -->
                    <table class="display" id="datatable_list">
                        <div id="button"></div>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('satuan/add') ?>
<?php $this->load->view('satuan/edit') ?>
<script type="text/javascript">
    var table;
    $(document).ready(function(e) {
        table = $('#datatable_list').DataTable({
            // "lengthMenu": [
            //     [10, 25, 50, -1],
            //     [10, 25, 50, "All"]
            // ],
            "lengthMenu": [
                [50, 75, 100, -1],
                [50, 75, 100, "All"]
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
                "url": "<?php echo site_url('C_satuan/ajax_list') ?>",
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
        var buttons = new $.fn.dataTable.Buttons(table, {}).container().appendTo($('#button'));
    })

    $('#btn_reset').click(function() { //button reset event click
        // $('[name="txt_tgl_start"]').val("");
        // $('[name="txt_tgl_end"]').val("");
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
    $('#btn_input').click(function() { //button filter event click
        $('#frmInput').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('  Tambah Satuan'); // Set Title to Bootstrap modal title
        $('[name="txt_input_level"]').val(null).trigger('change');
        $('[name="txt_input_employee"]').val(null).trigger('change');
    });

    function edit_data(kodesat) {
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        // alert(kodesat);
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_satuan/ajax_edit') ?>/" + kodesat,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="kodesat"]').val(data.kodesat);
                $('[name="namasat"]').val(data.namasat);
                $('[name="jumlah"]').val(data.jumpcs);

                $('#frmEdit').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Data Satuan'); // Set Title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function delete_data(id) {
        var data_id = id;
        var urls = '<?= site_url("C_satuan/delete_permanen/"); ?>';
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
</script>