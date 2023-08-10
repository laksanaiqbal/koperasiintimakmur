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
                <form class="theme-form">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="txt_tgl_start">From</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="txt_tgl_start" name="txt_tgl_start" type="date"
                                placeholder="Filter By Username">
                        </div>
                        <label class="col-sm-1 col-form-label" for="txt_tgl_end">To</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="txt_tgl_end" name="txt_tgl_end" type="date"
                                placeholder="Filter By Username">
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
                </form>
                <hr>
                <div class="table-responsive">
                    <!-- <table class="display" id="export-button"> -->
                    <table class="display" id="datatable_list">
                        <div id="button"></div>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Periode</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Cost</th>
                                <th>Profit(Rp)</th>
                                <th>Profit(%)</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Periode</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Cost</th>
                                <th>Profit(Rp)</th>
                                <th>Profit(%)</th>
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
        "autoWidth": true,
        // "scrollY": 455,
        "scrollX": true,
        "order": [], //Initial no order.
        "ajax": {
            "url": "<?php echo site_url('C_profit/ajax_list') ?>",
            "type": "POST",
            "data": function(data) {
                $('#loader').hide();
                data.txt_tgl_start = $('#txt_tgl_start').val();
                data.txt_tgl_end = $('#txt_tgl_end').val();
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
    $('#datatable_list').on('draw.dt', function() {
        // re-calculate the sum whenever the table is re-displayed:
        doSum();
    });
    // This provides the sum of all records:
    function doSum() {
        // get the DataTables API object:
        var table = $('#datatable_list').DataTable();
        // set up the initial (unsummed) data array for the footer row:
        var totals = ['', '', '', 0, 0, 0, ''];
        // iterate all rows - use table.rows( {search: 'applied'} ).data()
        // if you want to sum only filtered (visible) rows:
        totals = table.rows().data()
            // sum the amounts:
            .reduce(function(sum, record) {
                for (let i = 3; i <= 5; i++) {
                    sum[i] = sum[i] + numberFromString(record[i]);
                }
                return sum;
            }, totals);
        // place the sum in the relevant footer cell:
        for (let i = 3; i <= 5; i++) {
            var column = table.column(i);
            $(column.footer()).html(formatNumber(parseFloat(totals[i].toFixed(2))));
        }
    }

    function numberFromString(s) {
        return typeof s === 'string' ?
            s.replace(/[\$,]/g, '') * 1 :
            typeof s === 'number' ?
            s : 0;
    }

    function formatNumber(n) {
        return n.toLocaleString(); // or whatever you prefer here
    }
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
    $('.modal-title').text('  Add User'); // Set Title to Bootstrap modal title
});
</script>