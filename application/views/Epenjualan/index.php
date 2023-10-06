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
                <div class="mb-2 row">
                    <h1>TOTAL</h1>
                    <div class="mb-2 row">
                        <div id="sums">
                            <h3><?php echo $sum; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="POST" id="inputFrm" class="theme-form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 row">
                        <button id="btn_show" type="button" class="btn btn-primary"><i class="fa fa-search"> Barang</i></button>
                    </div>
                    <hr>
                    <div class="mb-2 row">
                        <label class="col-sm-4 col-form-label" for="layanan">Opsi</label>
                        <div class="col-sm-8">
                            <select name="layanan" id="layanan" class="form-control select2">
                                <option value="1">Produk</option>
                                <option value="2">Jasa</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 row">
                        <input hidden class="form-control" id="kodebrg" name="kodebrg" type="text" placeholder="kode Barang">
                        <input class="form-control" id="namabrg" name="namabrg" type="text" placeholder="Nama Barang">
                    </div>
                    <hr>
                    <div class="mb-2 row">
                        <input class="form-control" id="barcode" name="barcode" type="text" placeholder="Barcode Barang">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card ">
                <div class="card-body">
                    <div class="mb-2 row">
                        <input class="form-control" id="hjual" name="hjual" type="text" placeholder="H Jual">
                    </div>
                    <div class="stok">
                        <div class="mb-2 row" hidden>
                            <input class="form-control" id="stok" name="stok" type="text" placeholder="stok" readonly>
                            <input class="form-control" id="stokbaru" name="stokbaru" type="text" placeholder="stokbaru">
                        </div>
                        <hr>
                        <div class="mb-2 row">
                            <input class="form-control" id="jumlah" name="jumlah" type="text" placeholder="QTY">
                        </div>
                        <hr>
                        <div class="mb-2 row" style="text-align: center;">
                            <div class="col-sm">
                                <button type="submit" id="btnSave" class="btn btn-pill btn-outline-primary-2x btn-air-primary">
                                    <i class="fa fa-send-o">Submit</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display" id="datatable_list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>ID Jual</th>
                                <th>Nama Barang</th>
                                <th>kode_detail</th>
                                <th>harga_jual</th>
                                <th>qty</th>
                                <th>total</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>ID Jual</th>
                                <th>Nama Barang</th>
                                <th>kode_detail</th>
                                <th>harga_jual</th>
                                <th>qty</th>
                                <th>total</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-2 row">
                    <button type="button" id="btn_pay" class="btn btn-primary"><i class="fa fa-paper-plane-o m-right-xs"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('epenjualan/payment') ?>
<?php $this->load->view('epenjualan/showbarang') ?>

<script type="text/javascript">
    $('.modal').css('overflow-y', 'auto');

    var sum;
    $(document).ready(function() {
        setInterval(function() {
            $("#sums").load(window.location.href + " #sums");
        }, 2500);
    });

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
                "url": "<?php echo site_url('C_Epenjualan/ajax_list') ?>",
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



    function edit_data(id_detail) {
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        // alert(kodebrg);
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_Epembelian/ajax_edit') ?>/" + id_detail,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="namabarang"]').val(data.namabrg);
                $('[name="hargabeli"]').val(data.harga_beli);
                $('[name="hargajual"]').val(data.harga_jual);
                $('[name="jumlah"]').val(data.qty);
                $('[name="id_detail"]').val(data.id_detail);

                $('#frmEdit').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Data Barang'); // Set Title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    $(".stok").keyup(function() {
        var stok = parseInt($("#stok").val())
        var qty = parseInt($("#jumlah").val())


        var stokbaru = stok - qty;
        $("#stokbaru").attr("value", stokbaru)
    });
    $('#inputFrm').submit(function(e) {
        urls = "<?php echo site_url('C_Epenjualan/input_proses') ?>";
        var data = new FormData($('#inputFrm')[0]);
        $.ajax({
            url: urls,
            type: 'POST',
            data: data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                var out = jQuery.parseJSON(data);
                if (out.is_error == true) {
                    swal({
                        title: 'Error Bro',
                        text: out['error_message'],
                        showConfirmButton: false,
                        html: true,
                        timer: 1999,
                        type: "error"
                    });
                } else {
                    swal({
                        title: 'Hore',
                        text: out['succes_message'],
                        showConfirmButton: false,
                        timer: 1999,
                        type: "success"
                    });
                    table.ajax.reload(null, false);
                    document.getElementById("inputFrm").reset();
                    $('#frmInput').modal('hide');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal({
                    title: 'Crash Bro',
                    showConfirmButton: false,
                    timer: 1999,
                    type: "error"
                });
            }
        });
        e.preventDefault();
    });


    function scrollWin() {
        window.scrollBy(0, 500);
    };

    function scrollWin() {
        window.scrollBy(0, 500);
    };
    $('#btn_input').click(function() { //button filter event click
        $('#frmInput').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('  Tambah PO'); // Set Title to Bootstrap modal title
        $('[name="txt_input_level"]').val(null).trigger('change');
        $('[name="txt_input_employee"]').val(null).trigger('change');
    });

    function delete_data(id) {
        var data_id = id;
        var urls = '<?= site_url("C_Epembelian/delete_permanen/"); ?>';
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

    function previewGambar() {
        const image = document.querySelector('#gambar');
        const imgPreview = document.querySelector('.gambar-preview');
        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }

    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');
        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
    $('#btn_show').click(function() { //button filter event click
        $('#showbarang').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('PILIH Barang'); // Set Title to Bootstrap modal title
    });
    $('#btn_sup').click(function() { //button filter event click
        $('#showsup').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('PILIH Suplier'); // Set Title to Bootstrap modal title
    });
    $('#btn_pay').click(function() { //button filter event click
        $('#show_pay').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Payment'); // Set Title to Bootstrap modal title
    });

    function pilihbarang(kodebrg) {
        $.ajax({
            url: "<?php echo site_url('C_pembelian/ajax_show') ?>/" + kodebrg,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="kodebrg"]').val(data.kodebrg);
                $('[name="barcode"]').val(data.barcode);
                $('[name="namabrg"]').val(data.namabrg);
                $('[name="hbeli"]').val(data.hpp);
                $('[name="hjual"]').val(data.hjual1);
                $('[name="stok"]').val(data.stokawal);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }


    function pilihsup(kodesup) {
        $.ajax({
            url: "<?php echo site_url('C_Epembelian/ajax_show_sup') ?>/" + kodesup,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="kodesup"]').val(data.kodesup);
                $('[name="namasup"]').val(data.namasup);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    $('#simpanjual').submit(function(e) {
        urls = "<?php echo site_url('C_Epenjualan/simpan_penjualan') ?>";
        var data = new FormData($('#simpanjual')[0]);
        $.ajax({
            url: urls,
            type: 'POST',
            data: data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                var out = jQuery.parseJSON(data);
                if (out.is_error == true) {
                    swal({
                        title: 'Error Bro',
                        text: out['error_message'],
                        showConfirmButton: false,
                        html: true,
                        timer: 1999,
                        type: "error"
                    });
                } else {
                    swal({
                        title: 'Hore',
                        text: out['succes_message'],
                        showConfirmButton: false,
                        timer: 1999,
                        type: "success"
                    });
                    table.ajax.reload(null, false);
                    document.getElementById("simpanjual").reset();
                    $('#simpanjual').modal('hide');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal({
                    title: 'Crash Bro',
                    showConfirmButton: false,
                    timer: 1999,
                    type: "error"
                });
            }
        });
        e.preventDefault();
    });
</script>