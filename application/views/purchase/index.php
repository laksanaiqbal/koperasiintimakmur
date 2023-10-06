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
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="mb-2 row">
                    <label class="col-sm-3 col-form-label" for="diskon">Diskon</label>
                    <span><i>Note: Diskon disini merupakan diskon keseluruhan dari pembelian. Jika diskon di nota adalah diskon per satuan, maka harap dijumlahkan secara keseluruhan.</i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="mb-2 row">
                    <h1>TOTAL</h1>
                    <hr>
                    <div class="mb-2 row">
                        <div id="sums">
                            <h3><?php echo $sum; ?></h3>
                            <input hidden value="<?php echo $sum; ?>" class="form-control" id="totals" name="totals" type="number" placeholder="Type Jumlah Here">
                        </div>
                        <br>
                        <button type="button" id="btn_CO" class="btn btn-primary"><i class="fa fa-paper-plane-o m-right-xs"></i> Simpan</button>
                    </div>
                </div>
            </div>
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
                        <label class="col-sm-2 col-form-label" for="kode_beli">Kode Beli</label>
                        <div class="col-sm-9">
                            <?php
                            $this->db->select("id_pembelian,kode_beli");
                            $this->db->from('pembelian a');
                            $this->db->order_by('id_pembelian', 'ASC');
                            $pembelian = $this->db->get(); ?>
                            <select id="kode_beli" name="kode_beli">
                                <option value="">Silahkan Pilih</option>
                                <?php
                                foreach ($pembelian->result() as $rowpembelian) {
                                    echo "<option value='$rowpembelian->id_pembelian'>$rowpembelian->kode_beli</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <br>
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
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="display" id="datatable_pembelian">
                        <div id="button_pembelian"></div>
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Faktur</th>
                                <th>Tgl.Faktur</th>
                                <th>diskon</th>
                                <th>total</th>
                                <th>Payment</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>Kode</th>
                                <th>Faktur</th>
                                <th>Tgl.Faktur</th>
                                <th>diskon</th>
                                <th>total</th>
                                <th>Payment</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('purchase/input') ?>
<?php $this->load->view('purchase/showbarang') ?>
<?php $this->load->view('purchase/CO') ?>
<?php $this->load->view('purchase/suplier') ?>
<?php $this->load->view('purchase/edit') ?>
<?php $this->load->view('purchase/detail') ?>


<script type="text/javascript">
    $('.modal').css('overflow-y', 'auto');
    $(document).ready(function(e) {
        setInterval(function() {
            $("#sums").load(window.location.href + " #sums");
            $("#sum").load(window.location.href + " #sum");
        }, 2500);
        $("#kode_beli").select2({
            dropdownParent: $("#frm_index")
        });
    })
    var tables;
    $(document).ready(function(e) {
        tables = $('#datatable_list').DataTable({
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
                "url": "<?php echo site_url('C_pembelian/ajax_list_Epembelian') ?>",
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

    var table_pembelian;
    $(document).ready(function(e) {
        table_pembelian = $('#datatable_pembelian').DataTable({
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
                "url": "<?php echo site_url('C_pembelian/ajax_list_pembelian') ?>",
                "type": "POST",
                "data": function(data) {
                    $('#loader').hide();
                    data.kode_beli = $('#kode_beli').val();
                    data.txt_tgl_start = $('#txt_tgl_start').val();
                    data.txt_tgl_end = $('#txt_tgl_end').val();
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
        var buttons = new $.fn.dataTable.Buttons(table_pembelian, {}).container().appendTo($('#button_pembelian'));
    })

    function edit_data(id_detail) {
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        // alert(kodebrg);
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_pembelian/ajax_edit') ?>/" + id_detail,
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

    $('#inputFrm').submit(function(e) {
        urls = "<?php echo site_url('C_pembelian/input_proses') ?>";
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
                        timer: 1000,
                        type: "error"
                    });
                } else {
                    swal({
                        title: 'Hore',
                        text: out['succes_message'],
                        showConfirmButton: false,
                        timer: 1000,
                        type: "success"
                    });
                    // location.reload()
                    tables.ajax.reload(null, false);
                    document.getElementById("inputFrm").reset();
                    $('#frmInput').modal('hide');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal({
                    title: 'Crash Bro',
                    showConfirmButton: false,
                    timer: 1000,
                    type: "error"
                });
            }
        });
        e.preventDefault();
    });


    $('#btn_reset').click(function() { //button reset event click
        $('[name="kode_beli"]').select2().val('').trigger('change');
        $('[name="txt_tgl_start"]').val('');
        $('[name="txt_tgl_end"]').val('');

        table_pembelian.ajax.reload(); //just reload table
        //just reload table1
        scrollWin();
    });


    $('#btn_cari').click(function() { //button filter event click
        table_pembelian.ajax.reload(); //just reload table
        scrollWin();
    });

    function scrollWin() {
        window.scrollBy(0, 500);
    };
    $('#btn_input').click(function() { //button filter event click
        $('#forminput').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('  Input Pembelian'); // Set Title to Bootstrap modal title
    });
    $('#btnSave').click(function() { //button filter event click
        $('#forminput').modal('close'); // show bootstrap modal when complete loaded
    });

    function delete_data(id) {
        var data_id = id;
        var urls = '<?= site_url("C_pembelian/delete_permanen/"); ?>';
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
                            tables.ajax.reload();
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
    $('#btn_CO').click(function() { //button filter event click
        $('#show_co').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Pembayaran'); // Set Title to Bootstrap modal title
        var totals = parseInt($("#totals").val())
        $("#total").attr("value", totals)
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
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }


    function pilihsup(kodesup) {
        $.ajax({
            url: "<?php echo site_url('C_pembelian/ajax_show_sup') ?>/" + kodesup,
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
    $('#simpanBeli').submit(function(e) {
        urls = "<?php echo site_url('C_pembelian/simpan_pembelian') ?>";
        var data = new FormData($('#simpanBeli')[0]);
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
                        timer: 1000,
                        type: "error"
                    });
                } else {
                    swal({
                        title: 'Hore',
                        text: out['succes_message'],
                        showConfirmButton: false,
                        timer: 1000,
                        type: "success"
                    });
                    tables.ajax.reload(null, false);
                    table_pembelian.ajax.reload(null, false);
                    document.getElementById("simpanBeli").reset();
                    $('#simpanBeli').modal('hide');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal({
                    title: 'Crash Bro',
                    showConfirmButton: false,
                    timer: 1000,
                    type: "error"
                });
            }
        });
        e.preventDefault();
    });

    function detail(id_pembelian) {
        // $('#frmModal')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('C_pembelian/ajax_detail') ?>/" + id_pembelian,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_pembelian"]').val(data.id_beli);
                $('[name="idtemp"]').val(data.id_beli);
                $('.modal-title').text('  DetailPembelian'); // Set Title to Bootstrap modal title
                $('#show_detail').modal('show'); // show bootstrap modal when complete loaded
                table_detail.ajax.reload(null);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function status(id) {
        var data_id = id;
        var urls = '<?= site_url("C_pembelian/status/"); ?>';
        swal({
                title: "Are you sure?",
                text: "Do you realy want to Change Status this data?!",
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
                                    text: "Good luck Bro, Status Change data berhasil .",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 1111
                                });
                            }
                            table_detail.ajax.reload();
                        },
                        error: function(data) {
                            swal("NOT Change!", "Something blew up.", "error");
                        }
                    });
                    // swal("Poof! Your imaginary file has been disable!", {
                    //     icon: "success",
                    // });
                } else {
                    swal("Your file is safe!");
                }
            })
    }
</script>