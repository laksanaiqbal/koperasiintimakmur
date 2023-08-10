<div class="modal fade bd-example-modal-lg" tabindex="-1" id="frm_details" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-bullhorn">
                    &nbsp<h4 class="modal-title" id="myLargeModalLabel">
                </i></h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <!-- <div class="card"> -->
                    <div class="card-body">
                        <form class="theme-form">
                            <input class="form-control" type="hidden" name="bulan_temp" id="bulan_temp">
                            <div class="mb-12 row">
                                <label class="col-sm-2 col-form-label" for="txt_month_periode">Month</label>
                                <div class="col-sm-4">
                                    <input class="form-control" id="txt_month_periode" name="txt_month_periode"
                                        type="text" Readonly>
                                </div>
                                <label class="col-sm-2 col-form-label" for="txt_year_periode">Year</label>
                                <div class="col-sm-4">
                                    <input class="form-control" id="txt_year_periode" name="txt_year_periode"
                                        type="text" Readonly>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="table-responsive">
                            <!-- <b class="f-w-600 font-info"> -->
                            <table class="display f-w-600 font-info" id="purch_details">
                                <div id="btn_purch_details"></div>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <!-- <th>Trans ID</th> -->
                                        <th>Trans Date</th>
                                        <!-- <th>Items ID</th> -->
                                        <th>Items Desc</th>
                                        <th>Unit</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total Price</th>
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
</div>
<script type="text/javascript">
$(document).ready(function(e) {

});

function bulan() {
    var lele = document.getElementById("txt_cari_bln").value;
    // alert(lele);
    if (lele == "") {
        $('[name="txt_month_periode"]').val('All Month');
    } else if (lele == '01') {
        $('[name="txt_month_periode"]').val('Januari');
    } else if (lele == '02') {
        $('[name="txt_month_periode"]').val('Februari');
    } else if (lele == '03') {
        $('[name="txt_month_periode"]').val('Maret');
    } else if (lele == '04') {
        $('[name="txt_month_periode"]').val('April');
    } else if (lele == '05') {
        $('[name="txt_month_periode"]').val('Mei');
    } else if (lele == '06') {
        $('[name="txt_month_periode"]').val('Juni');
    } else if (lele == '07') {
        $('[name="txt_month_periode"]').val('Juli');
    } else if (lele == '08') {
        $('[name="txt_month_periode"]').val('Agustus');
    } else if (lele == '09') {
        $('[name="txt_month_periode"]').val('September');
    } else if (lele == '10') {
        $('[name="txt_month_periode"]').val('Oktober');
    } else if (lele == '11') {
        $('[name="txt_month_periode"]').val('November');
    } else if (lele == '12') {
        $('[name="txt_month_periode"]').val('Desember');
    }
};

function view_purch_detail() {
    // var kuy = document.getElementById("bulan_temp").value;
    // alert(kuy);
    var table_purch_details;
    table_purch_details = $('#purch_details').DataTable({
        // "createdRow": function(row, data, dataIndex) {
        //     $(row).addClass('black');
        // },
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
        "searching": false,
        "autoWidth": true,
        "scrollY": 455,
        "scrollX": true,
        "destroy": true, //destroy for reinitiate
        "order": [], //Initial no order.
        "ajax": {
            "url": "<?php echo site_url('C_member_billing_periode/ajax_list_detail') ?>",
            "type": "POST",
            "data": function(data) {
                $('#loader').hide();
                data.bulan_temp = $('#bulan_temp').val();
                data.txt_year_periode = $('#txt_year_periode').val();
                // table_excels.ajax.reload(null, false);
            }
        },
        //Set column definition initialisation properties.
        "columnDefs": [{
                "targets": [-1], //last column
                "orderable": false, //set not orderable
            },
            {
                "targets": [-2], //2 last column (photo)
                "orderable": false, //set not orderable
            },
        ],

    });
    var buttons = new $.fn.dataTable.Buttons(table_purch_details, {}).container().appendTo($('#btn_purch_details'));
};
</script>