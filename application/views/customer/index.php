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
                        <label class="col-sm-3 col-form-label" for="txt_nmkary">Item Name</label>
                        <div class="col-sm-9">
                            <?php
                            $this->db->select("kodecus,namacus");
                            $this->db->from('customer a');
                            $this->db->order_by('kodecus', 'ASC');
                            $customers = $this->db->get(); ?>
                            <select id="txt_nmkary" name="txt_nmkary">
                                <option value="">Silahkan Pilih</option>
                                <?php
                                foreach ($customers->result() as $rowcustomers) {
                                    echo "<option value='$rowcustomers->kodecus'>$rowcustomers->namacus</option>";
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
                                <th>Kode Cust</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Posisi</th>
                                <th>Nomor HP</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Kode Cust</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Posisi</th>
                                <th>Nomor HP</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

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
                "url": "<?php echo site_url('C_customer/ajax_list') ?>",
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
        $('[name="txt_tgl_start"]').val("");
        $('[name="txt_tgl_end"]').val("");
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
</script>