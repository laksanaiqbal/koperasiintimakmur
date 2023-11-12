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
                <div class="mb-3 row">
                    <div class="col-sm-5">
                        <button id="btn_input" class="btn btn-pill btn-outline-secondary btn-air-info" type="button" title="Purchase Input" data-bs-target="#staticBackdrop"><i class="fa fa-plus-square">
                                Purchase Input </i></button>
                    </div>
                </div>
                <form class="theme-form" id="frm_index">
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="txt_tgl_start">From</label>
                        <div class="col-sm-4">
                            <input class="datepicker-here form-control digits" data-language="en" id="txt_tgl_start" name="txt_tgl_start" type="text" placeholder="Choose your date">
                        </div>
                        <label class="col-sm-2 col-form-label" for="txt_tgl_end">To</label>
                        <div class="col-sm-4">
                            <input class="datepicker-here form-control digits" data-language="en" id="txt_tgl_end" name="txt_tgl_end" type="text" placeholder="Choose your date">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="kodebeli">Purchase Code</label>
                        <div class="col-sm-4">
                            <?php
                            $this->db->select("kodebeli");
                            $this->db->from('hbeli a');
                            $this->db->order_by('kodebeli', 'ASC');
                            $pembelian = $this->db->get(); ?>
                            <select id="kodebeli" name="kodebeli">
                                <option value="">Please Select</option>
                                <?php
                                foreach ($pembelian->result() as $rowpembelian) {
                                    echo "<option value='$rowpembelian->kodebeli'>$rowpembelian->kodebeli</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label" for="kodesup">Suplier</label>
                        <div class="col-sm-4">
                            <?php
                            $this->db->select("a.kodesup, b.namasup");
                            $this->db->from('suplier a');
                            $this->db->join('suplier b', 'a.kodesup=b.kodesup');
                            $this->db->order_by('kodesup', 'ASC');
                            $sup = $this->db->get(); ?>
                            <select id="kodesup" name="kodesup">
                                <option value="">Please Select</option>
                                <?php
                                foreach ($sup->result() as $rowsup) {
                                    echo "<option value='$rowsup->kodesup'>$rowsup->namasup</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-sm-12" style="text-align: right;">
                            <button id="btn_reset" class="btn btn-pill btn-outline-info btn-air-info" type="button" title="Reload Record"><i class="fa fa-refresh"> Reload Record</i></button>
                            <button id="btn_cari" class="btn btn-pill btn-outline-info btn-air-info" type="button" title="Find Record"><i class="fa fa-send-o"> Find Record</i></button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="display" id="datatable_pembelian">
                        <div id="button_pembelian"></div>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Purchase Code</th>
                                <th>Store</th>
                                <th>Purchase Date</th>
                                <th>Suplier</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Purchase Code</th>
                                <th>store</th>
                                <th>Purchase Date</th>
                                <th>Suplier</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('purchase/input') ?>
<?php $this->load->view('purchase/inputbarang') ?>
<?php $this->load->view('purchase/process') ?>
<?php $this->load->view('purchase/editpembelian') ?>
<?php $this->load->view('purchase/showbarang') ?>
<?php $this->load->view('purchase/suplier') ?>
<?php $this->load->view('purchase/cetak_pembelian') ?>
<?php $this->load->view('purchase/proses') ?>
<?php $this->load->view('purchase/edit') ?>



<script type="text/javascript">
    $('.modal').css('overflow-y', 'auto');
    $(document).ready(function(e) {
        setInterval(function() {
            $("#sums").load(window.location.href + " #sums");
        }, 2500);
        $("#kodebeli").select2({
            dropdownParent: $("#frm_index")
        });
        $("#kodesup").select2({
            dropdownParent: $("#frm_index")
        });
        $("#cabang").select2({
            dropdownParent: $("#forminput")
        });
        $("#ppn").select2({
            dropdownParent: $("#forminput")
        });
        $("#diskon").select2({
            dropdownParent: $("#forminput")
        });
        $("#faktur").select2({
            dropdownParent: $("#forminput")
        });
        $("#payment").select2({
            dropdownParent: $("#forminput")
        });

    })


    var table_pembelian;
    $(document).ready(function(e) {
        table_pembelian = $('#datatable_pembelian').DataTable({

            "lengthMenu": [
                [10, 50, 75, 100, -1],
                [10, 50, 75, 100, "All"]
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
                    data.kodebeli = $('#kodebeli').val();
                    data.txt_tgl_start = $('#txt_tgl_start').val();
                    data.txt_tgl_end = $('#txt_tgl_end').val();
                    data.kodesup = $('#kodesup').val();
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


    $('#btn_reset').click(function() { //button reset event click
        $('[name="kodebeli"]').select2().val('').trigger('change');
        $('[name="txt_tgl_start"]').val('');
        $('[name="txt_tgl_end"]').val('');
        $('[name="kodesup"]').select2().val('').trigger('change');

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
                            table_pembelian.ajax.reload();
                            table_edit.ajax.reload();
                            table_proses.ajax.reload();
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
    });
    $('#btn_sup').click(function() { //button filter event click
        $('#showsup').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title-sup').text('Choose Suplier'); // Set Title to Bootstrap modal title
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
                $('[name="sat"]').val(data.namasat);
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
                $('[name="kodesups"]').val(data.kodesup);
                $('[name="namasuplier"]').val(data.namasup);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }



    function cancel(id) {
        var data_id = id;
        var urls = '<?= site_url("C_pembelian/cancel/"); ?>';
        swal({
                title: "Are you sure?",
                text: "Do you realy want to Cancel this data?!",
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
                                    text: "Good luck Bro, Cancel data berhasil .",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 1111
                                });
                            }
                            table_pembelian.ajax.reload();
                        },
                        error: function(data) {
                            swal("NOT Change!", "Something blew up.", "error");
                        }
                    });
                }
                // else {
                //     swal("Your file is safe!");
                // }
            })
    }

    function good(id) {
        var data_id = id;
        var urls = '<?= site_url("C_pembelian/good/"); ?>';
        swal({
                title: "Are you sure?",
                text: "Do you realy want to good this data?!",
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
                                    text: "Good luck Bro, good data berhasil .",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 1111
                                });
                            }
                            table_proses.ajax.reload();
                            table_edit.ajax.reload();
                        },
                        error: function(data) {
                            swal("NOT Change!", "Something blew up.", "error");
                        }
                    });
                }
                // else {
                //     swal("Your file is safe!");
                // }
            })
    }
</script>