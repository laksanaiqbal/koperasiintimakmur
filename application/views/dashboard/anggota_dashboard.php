<style>
table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_desc:after,
table.dataTable thead .sorting:before,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_desc:before {
    display: none;
}

.red {
    background-color: rebeccapurple !important;
}
</style>
<div class="page-title">
    <div class="row">
        <div class="col-6">
            <h5><?php echo $title_form; ?></h5>
        </div>
        <div class="col-6">
            <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item"><a href="<?php echo site_url('Welcome'); ?>"><i data-feather="home"></i></a>
                </li> -->
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
                <div class="greeting-user">
                    <h4 class="f-w-600 font-primary" id="greeting">Good Morning</h4>
                    <b>Mr/Mrs <?php echo $this->session->userdata('NAMA');?></b>
                    <p>Below is Your Billing @IntiMart </p> Periode : 1st date <b class="f-w-600 font-info">Until</b>
                    Today
                    <div class="table-responsive">
                        <!-- <table class="display" id="export-button"> -->
                        <table class="display" id="datatable_list">
                            <!-- <div id="button"></div> -->
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
</div>

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
            "url": "<?php echo site_url('Welcome/ajax_list') ?>",
            "type": "POST",
            "data": function(data) {
                $('#loader').hide();
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
</script>