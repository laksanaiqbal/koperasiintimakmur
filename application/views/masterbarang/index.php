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
                                    Input Barang </i></button>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="txt_nmkary">Item Name</label>
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
                </form>
                <hr>

                <div class="table-responsive">
                    <!-- <table class="display" id="export-button"> -->
                    <table class="display" id="datatable_list">
                        <div id="button"></div>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Barang</th>
                                <th>Barcode</th>
                                <th>Nama</th>
                                <th>Stok</th>
                                <th>HPP</th>
                                <th>Price</th>
                                <th>Profit</th>
                                <th>Total Asset</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Item ID</th>
                                <th>Barcode</th>
                                <th>Nama</th>
                                <th>Stok</th>
                                <th>HPP</th>
                                <th>Price</th>
                                <th>Profit</th>
                                <th>Total Asset</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('masterbarang/add') ?>
<?php $this->load->view('masterbarang/edit') ?>

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
                "url": "<?php echo site_url('C_masterbarang/ajax_list') ?>",
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
        $('#frm_input').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('  Add User Kuya'); // Set Title to Bootstrap modal title
    });

    function scrollWin() {
        window.scrollBy(0, 500);
    };
    $('#btn_input').click(function() { //button filter event click
        $('#frmInput').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('  Tambah Barang'); // Set Title to Bootstrap modal title
        $('[name="txt_input_level"]').val(null).trigger('change');
        $('[name="txt_input_employee"]').val(null).trigger('change');
    });

    function edit_data(kodebrg) {
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        // alert(kodebrg);
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_masterbarang/ajax_edit') ?>/" + kodebrg,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="idupdate"]').val(data.kodebrg);
                $('[name="txt_input_kodebrg"]').val(data.kodebrg);
                $('[name="txt_input_barcode"]').val(data.barcode);
                $('[name="txt_input_kelompok"]').val(data.kelompok);
                $('[name="txt_input_dept"]').val(data.dept);
                $('[name="txt_input_satuan"]').val(data.satuan);
                $('[name="txt_input_namabrg"]').val(data.namabrg);
                $('[name="txt_input_stokakhir"]').val(data.stokakhir);
                $('[name="txt_input_hpp"]').val(data.hpp);
                $('[name="txt_input_hjual"]').val(data.hjual1);

                $('#frmEdit').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Data Barang'); // Set Title to Bootstrap modal title
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
</script>