 <!-- <div class="col-sm-12">
     <div class="card"> tabindex="-1"  -->
 <div class="modal fade bd-example-modal-xl" tabindex="-1" id="frmEdit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <i class="fa fa-group">
                     &nbsp<h4 class="modal-title" id="myLargeModalLabel">
                 </i></h4>
                 <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <div class="col-sm-12">
                     <div class="card-body">
                         <form method="POST" id="frm_Edit" class="theme-form">
                             <input type="hidden" name="idupdate" id="idupdate">
                             <div class="mb-3 row">
                                 <label class="col-sm-2 col-form-label" for="kodebrg">Kode Barang</label>
                                 <div class="col-sm-3">
                                     <input disabled class="form-control" id="kodebrg" name="kodebrg" type="text" placeholder="Type Kode Here" readonly>
                                 </div>
                                 <label class="col-sm-2 col-form-label" for="barcode">Barcode</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="barcode" name="barcode" type="text" placeholder="Type Barcode Here" required>
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-2 col-form-label" for="namabrg">Nama Barang</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="namabrg" name="namabrg" type="text" placeholder="Type Name Here" required>
                                 </div>
                                 <label class="col-sm-2 col-form-label" for="kelompok">Kategori</label>
                                 <div class="col-sm-3">
                                     <select name="kelompok" id="kelompok">
                                         <option value="">--pilih--</option>
                                         <?php foreach ($datakelompok as $data) : ?>
                                             <option value="<?= $data->kodeklmpk ?>"><?php echo "$data->namaklmpk"  ?></option>
                                         <?php endforeach ?>
                                     </select>
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-2 col-form-label" for="satuan">Satuan</label>
                                 <div class="col-sm-3">
                                     <select name="satuan" id="satuan">
                                         <option value="">--pilih--</option>
                                         <?php foreach ($datasat as $data) : ?>
                                             <option value="<?php echo $data->kodesat ?>"><?php echo $data->namasat ?></option>
                                         <?php endforeach ?>
                                     </select>
                                 </div>
                                 <label class="col-sm-2 col-form-label" for="stokawal">Stok</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="stokawal" name="stokawal" type="number" placeholder="Type Stock Here" readonly>
                                 </div>
                             </div>

                             <div class="mb-3 row">
                                 <label class="col-sm-2 col-form-label" for="stokmin">Stok Min</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="stokmin" name="stokmin" type="number" placeholder="Type Stock Min Here">
                                 </div>
                                 <label class="col-sm-2 col-form-label" for="stokmax">Stok Max</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="stokmax" name="stokmax" type="number" placeholder="Type Stock Max Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-2 col-form-label" for="stokakhir">Tambah Stok</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="stokakhir" name="stokakhir" type="number" placeholder="Type Stock Here">
                                 </div>
                                 <label class="col-sm-2 col-form-label" for="hpp">HPP</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="hpp" name="hpp" type="number" placeholder="Type HPP Here" required>
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-2 col-form-label" for="hjual">Price</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="hjual" name="hjual" type="number" placeholder="Type Price Here" required>
                                 </div>
                                 <label class="col-sm-2 col-form-label" for="kodekategori">Kategori</label>
                                 <div class="col-sm-3">
                                     <div class="checkbox">
                                         <input type="radio" name="kodekategori" id="kodekategori" value="1" checked> NON-KONSINYASI
                                         <input type="radio" name="kodekategori" id="kodekategori" value="2"> KONSINYASI
                                     </div>
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-2 col-form-label" for="gambar1">Gambar</label>
                                 <div class="col-sm-2">
                                     <img class="img-preview img-fluid" style="Width: 200px">
                                     <input class="form-control" id="image" name="gambar1" type="file" onchange="previewGambar()">
                                 </div>
                             </div>
                             <div class="card-footer text-end">
                                 <button type="submit" id="btnEdit" class="btn btn-pill btn-outline-primary-2x btn-air-primary"><i class="fa fa-send-o">
                                         Submit</i></button>
                                 <button class="btn btn-pill btn-outline-info-2x btn-air-info" data-bs-dismiss="modal"><i class="fa fa-xing"></i> Cancel</i> </button>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <script type="text/javascript">
     function edit_data(kodebrg) {
         $('.form-group').removeClass('has-error'); // clear error class
         $('.help-block').empty(); // clear error string
         // alert(kodebrg);
         //Ajax Load data from ajax
         $.ajax({
             url: "<?php echo site_url('C_masterbarang/ajax_edit') ?>/" + kodebrg,
             type: "GET",
             dataType: "JSON",
             success: function(data) {
                 $('[name="idupdate"]').val(data.kodebrg);
                 $('[name="kodebrg"]').val(data.kodebrg);
                 $('[name="barcode"]').val(data.barcode);
                 $('#kelompok').val(data.kodeklmpk).trigger('change');
                 $('[name="txt_input_dept"]').val(data.dept);
                 $('#satuan').val(data.kodesat).trigger('change');
                 $('[name="namabrg"]').val(data.namabrg);
                 $('[name="stokawal"]').val(data.stokawal);
                 $('[name="stokakhir"]').val(data.stokakhir);
                 $('[name="stokmin"]').val(data.stokmin);
                 $('[name="stokmax"]').val(data.stokmax);
                 $('[name="hpp"]').val(data.hpp);
                 $('[name="hjual"]').val(data.hjual1);

                 $('#frmEdit').modal('show'); // show bootstrap modal when complete loaded
                 $('.modal-title').text('Edit Data Barang'); // Set Title to Bootstrap modal title
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert('Error get data from ajax');
             }
         });
     }

     function previewGambar() {
         const image = document.querySelector('#image');
         const imgPreview = document.querySelector('.img-preview');
         imgPreview.style.display = 'block';

         const oFReader = new FileReader();
         oFReader.readAsDataURL(image.files[0]);

         oFReader.onload = function(oFREvent) {
             imgPreview.src = oFREvent.target.result;
         }
     }
     $(document).ready(function(e) {
         $("#kelompok").select2({
             dropdownParent: $("#frmEdit")
         });
         $("#satuan").select2({
             dropdownParent: $("#frmEdit")
         });
     });
     $('#frm_Edit').submit(function(e) {
         urls = "<?php echo site_url('C_masterbarang/update_proses') ?>";
         // var data = $(this).serialize();
         var data = new FormData($('#frm_Edit')[0]);
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
                     table.ajax.reload();
                     document.getElementById("frm_Edit").reset();
                     $('#frmEdit').modal('hide');
                 }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 swal({
                     title: 'Crash Bro',
                     // text: out['error_message'],
                     showConfirmButton: false,
                     timer: 1999,
                     type: "error"
                 });
             }
         });
         e.preventDefault();
     });
 </script>