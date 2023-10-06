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
                                Input Barang </i></button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="display" id="datatable_list">
                        <div id="button"></div>
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Kasir</th>
                                <th>Customer</th>
                                <th>ppn</th>
                                <th>Total</th>
                                <th>Payment Methode</th>
                                <th>tgl</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Invoice</th>
                                <th>Kasir</th>
                                <th>Customer</th>
                                <th>ppn</th>
                                <th>Total</th>
                                <th>Payment Methode</th>
                                <th>tgl</th>
                                <th>action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('penjualan/payment') ?>
<?php $this->load->view('penjualan/detail') ?>
<?php $this->load->view('penjualan/input') ?>

<?php $this->load->view('penjualan/showbarang') ?>
<script type="text/javascript">
    $('.modal').css('overflow-y', 'auto');
    var table_penjualan;
    $(document).ready(function(e) {
        table_penjualan = $('#datatable_list').DataTable({
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
            "info": true,
            // "scrollY": 455,
            "scrollX": true,
            "order": [], //Initial no order.
            "ajax": {
                "url": "<?php echo site_url('C_penjualan/ajax_list') ?>",
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
        var buttons = new $.fn.dataTable.Buttons(table_penjualan, {}).container().appendTo($('#button'));

    })

    function detail(id_penjualan) {
        // $('#frmModal')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('c_penjualan/ajax_detail') ?>/" + id_penjualan,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_jual"]').val(data.id_jual);
                $('[name="idtemp"]').val(data.id_jual);
                $('.modal-title').text('  Detailjual'); // Set Title to Bootstrap modal title
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
        $('.modal-title').text('  Input Pembelian'); // Set Title to Bootstrap modal title
    });
</script>