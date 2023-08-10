<div class="page-title">
    <div class="row">
        <div class="col-6">
            <h5><?php echo $title_form; ?></h5>
        </div>
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo site_url('Welcome'); ?>"><i
                            class="fa fa-home">Dashboard</i></a></li>
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
                        <label class="col-sm-3 col-form-label" for="txt_nmkary">Month</label>
                        <div class="col-sm-9">
                            <select id="txt_cari_bln" name="txt_cari_bln"
                                class="js-example-placeholder-multiple col-sm-12 select2">
                                <option value="">Silahkan Pilih Periode</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="txt_nmkary">Year</label>
                        <div class="col-sm-9">
                            <select id="txt_cari_thn" name="txt_cari_thn"
                                class="js-example-placeholder-multiple col-sm-12 select2">
                                <?php $kuya=date('Y');?>
                                <?php echo "<option value='$kuya'>" ?>Default This Year</option>
                                <?php
							for ($i = date('Y'); $i >= date('Y') - 5; $i -= 1) {
								echo "<option value='$i'> $i </option>";
							}
							?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-7">
                        </div>
                        <div class="col-sm-5">
                            <button id="btn_reset" class="btn btn-pill btn-outline-info btn-air-info" type="button"
                                title="btn btn-pill btn-outline-info btn-air-info"><i class="fa fa-refresh"> Reload
                                    Record</i></button>
                            <button id="btn_cari" class="btn btn-pill btn-outline-info btn-air-info" type="button"
                                title="btn btn-pill btn-outline-info btn-air-info"><i class="fa fa-send-o"> Find
                                    Record</i></button>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-8 row">
                        <label class="col-sm-8 col-form-label"><b>If not filtered, Default data is Total Purchase @
                                This year</b></label>
                    </div>
                </form>
                <div class="table-responsive">
                    <!-- <table class="display" id="export-button"> -->
                    <table class="display" id="datatable_list">
                        <div id="button"></div>
                        <thead>
                            <tr>
                                <th>Purchase Amount</th>
                                <th>Payment Amount</th>
                                <th>Billing Amount</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('member_billing_periode/detail') ?>
<script type="text/javascript">
var table;
$(document).ready(function(e) {
    table = $('#datatable_list').DataTable({
        "createdRow": function(row, data, dataIndex) {
            $(row).addClass('white');
        },
        "paging": false,
        "lengthChange": false,
        // "pagingType": "full_numbers",
        "oLanguage": {
            "sProcessing": '<center><img alt src="<?php echo base_url('assets/mt/assets/images/loading/loading-4.gif'); ?>" style="opacity: 1.0;filter: alpha(opacity=100);"></center>'
        },
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "searching": false,
        "autoWidth": true,
        // "scrollY": false,
        "scrollX": true,
        "order": [], //Initial no order.
        "ajax": {
            "url": "<?php echo site_url('C_member_billing_periode/ajax_list') ?>",
            "type": "POST",
            "data": function(data) {
                $('#loader').hide();
                data.txt_cari_bln = $('#txt_cari_bln').val();
                data.txt_cari_thn = $('#txt_cari_thn').val();
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
    // var buttons = new $.fn.dataTable.Buttons(table, {}).container().appendTo($('#button'));
})

$('#btn_reset').click(function() { //button reset event click
    $('[name="txt_cari_bln"]').select2().val('').trigger('change');
    $('[name="txt_cari_thn"]').select2().val('2023').trigger('change');
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

function view_details(id) {
    // alert(id);
    // $('#frmModal')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    //Ajax Load data from ajax
    $.ajax({
        url: "<?php echo site_url('C_member_billing_periode/ajax_purch_details') ?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="bulan_temp"]').val(document.getElementById("txt_cari_bln").value);
            // $('[name="txt_month_periode"]').val(document.getElementById("txt_cari_bln").value);
            $('[name="txt_year_periode"]').val(document.getElementById("txt_cari_thn").value);
            $('.modal-title').text('  My Purchase Detail List !!!'); // Set Title to Bootstrap modal title
            view_purch_detail();
            bulan();
            $('#frm_details').modal('show'); // show bootstrap modal when complete loaded
            // table_logger.ajax.reload(null);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}
</script>