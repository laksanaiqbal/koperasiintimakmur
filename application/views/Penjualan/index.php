<div class="page-title">
    <div class="row">
        <div class="col-6">
            <h5><?php echo $title_form; ?></h5>
        </div>
        <div class="col-6">
            <ol class="breadcrumb">
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
                <div class="mb-3 row">
                    <div class="col-sm-5">
                        <button id="btn_input" class="btn btn-pill btn-outline-info btn-air-info" type="button" title="btn btn-pill btn-outline-info btn-air-info"><i class="fa fa-plus-square">
                                Input Penjualan </i></button>
                    </div>
                </div>
                <form class="theme-form" id="frm_index">
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="txt_tgl_start">From</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="txt_tgl_start" name="txt_tgl_start" type="date">
                        </div>
                        <label class="col-sm-1 col-form-label" for="txt_tgl_end">To</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="txt_tgl_end" name="txt_tgl_end" type="date">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="nojual">No. Jual</label>
                        <div class="col-sm-9">
                            <?php
                            $this->db->select("nojual");
                            $this->db->from('hjual a');
                            $this->db->order_by('nojual', 'ASC');
                            $penjualan = $this->db->get(); ?>
                            <select id="nojual" name="nojual">
                                <option value="">Silahkan Pilih</option>
                                <?php
                                foreach ($penjualan->result() as $rowpenjualan) {
                                    echo "<option value='$rowpenjualan->nojual'>$rowpenjualan->nojual</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="kodecus">Cust</label>
                        <div class="col-sm-9">
                            <?php
                            $this->db->select("a.kodecus, b.namacus");
                            $this->db->from('hjual a');
                            $this->db->join('customer b', 'a.kodecus=b.kodecus');
                            $this->db->order_by('nojual', 'ASC');
                            $cus = $this->db->get(); ?>
                            <select id="kodecus" name="kodecus">
                                <option value="">Silahkan Pilih</option>
                                <?php
                                foreach ($cus->result() as $rowcus) {
                                    echo "<option value='$rowcus->kodecus'>$rowcus->namacus</option>";
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
                <div class="table-responsive">
                    <table class="display" id="datatable_list">
                        <div id="button"></div>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>nojual</th>
                                <th>Customer</th>
                                <th>Payment Methode</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Total</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>nojual</th>
                                <th>Customer</th>
                                <th>Payment Methode</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Total</th>
                                <th>action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('penjualan/detail') ?>
<?php $this->load->view('penjualan/input') ?>
<?php $this->load->view('penjualan/payment') ?>
<?php $this->load->view('penjualan/showbarang') ?>
<script type="text/javascript">
    $('.modal').css('overflow-y', 'auto');
    $(document).ready(function(e) {

        $("#nojual").select2({
            dropdownParent: $("#frm_index")
        });
        $("#kodecus").select2({
            dropdownParent: $("#frm_index")
        });
    })
    $(document).ready(function(e) {
        setInterval(function() {
            $("#sums").load(window.location.href + " #sums");
        }, 2500);
    })
    var table_penjualan;
    $(document).ready(function(e) {
        table_penjualan = $('#datatable_list').DataTable({
            // "lengthMenu": [
            //     [10, 25, 50, -1],
            //     [10, 25, 50, "All"]
            // ],
            "lengthMenu": [
                [5, 50, 75, 100, -1],
                [5, 50, 75, 100, "All"]
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
            // "scrollY": 455,
            "scrollX": true,
            "order": [], //Initial no order.
            "ajax": {
                "url": "<?php echo site_url('C_penjualan/ajax_list') ?>",
                "type": "POST",
                "data": function(data) {
                    $('#loader').hide();
                    data.nojual = $('#nojual').val();
                    data.txt_tgl_start = $('#txt_tgl_start').val();
                    data.txt_tgl_end = $('#txt_tgl_end').val();
                    data.kodecus = $('#kodecus').val();
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
        var buttons = new $.fn.dataTable.Buttons(table_penjualan, {}).container().appendTo($('#button'));

    })
    $('#btn_reset').click(function() { //button reset event click
        $('[name="nojual"]').select2().val('').trigger('change');
        $('[name="txt_tgl_start"]').val('');
        $('[name="txt_tgl_end"]').val('');
        $('[name="kodecus"]').select2().val('').trigger('change');

        table_penjualan.ajax.reload(); //just reload table
        //just reload table1
        scrollWin();
    });
    $('#btn_cari').click(function() { //button filter event click
        table_penjualan.ajax.reload(); //just reload table
        scrollWin();
    });

    function detail(nojual) {
        // $('#frmModal')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_penjualan/ajax_detail') ?>/" + nojual,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_jual"]').val(data.nojual);
                $('[name="idtemp"]').val(data.nojual);
                $('.modal-title').text('  Detail Penjualan'); // Set Title to Bootstrap modal title
                $('#show_detail').modal('show'); // show bootstrap modal when complete loaded
                table_detail.ajax.reload(null);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    $('#btn_input').click(function() { //button filter event click
        $('#forminput').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('  Input Penjualan'); // Set Title to Bootstrap modal title
    });
</script>