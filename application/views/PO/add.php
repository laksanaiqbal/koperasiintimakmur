 <!-- <div class="col-sm-12">
     <div class="card"> tabindex="-1"  -->
 <div class="modal fade bd-example-modal-lg" tabindex="-1" id="frmInput" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <i class="fa fa-group">
                     &nbsp<h4 class="modal-title" id="myLargeModalLabel">
                 </i></h4>
                 <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <div class="col-sm-12">
                     <!-- <div class="card"> -->
                     <div class="card-body">
                         <form method="POST" id="inputFrm" class="theme-form" enctype="multipart/form-data">
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_kodebrg">Kode BRG</label>
                                 <div class=" col-sm-3">
                                     <input class="form-control" id="txt_input_kodebrg" name=" txt_input_kodebrg" type="random" value="<?php echo rand(100, 1000000); ?>">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_namabrg">Nama Barang</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="txt_input_namabrg" name="txt_input_namabrg" type="text" placeholder="Type Nama Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_qtyorder">Jumlah</label>
                                 <div class="col-sm-6">
                                     <input class="form-control" id="txt_input_qtyorder" name="txt_input_qtyorder" type="text" placeholder="Type Jumlah Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_kelompok">Kategori</label>
                                 <div class="col-sm-3">
                                     <select name="txt_input_kelompok" id="txt_input_kelompok">
                                         <option value="">--pilih--</option>
                                         <?php foreach ($datakelompok as $data) : ?>
                                             <option value="<?php echo $data->kodeklmpk ?>"><?php echo $data->namaklmpk ?></option>
                                         <?php endforeach ?>
                                     </select>
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_satorder">Satuan</label>
                                 <div class="col-sm-3">
                                     <select name="txt_input_satorder" id="txt_input_satorder">
                                         <option value="">--pilih--</option>
                                         <?php foreach ($datasat as $data) : ?>
                                             <option value="<?php echo $data->kodesat ?>"><?php echo $data->namasat ?></option>
                                         <?php endforeach ?>
                                     </select>
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_suplier">Suplier</label>
                                 <div class="col-sm-3">
                                     <select name="txt_input_suplier" id="txt_input_suplier">
                                         <option value="">--pilih--</option>
                                         <?php foreach ($datasup as $data) : ?>
                                             <option value="<?php echo $data->kodesup ?>"><?php echo $data->namasup ?></option>
                                         <?php endforeach ?>
                                     </select>
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_hbeli">H.Beli</label>
                                 <div class="col-sm-6">
                                     <input class="form-control" id="txt_input_hbeli" name="txt_input_hbeli" type="number" placeholder="Type Hbeli Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="gambar">Gambar</label>
                                 <div class="col-sm-3">
                                     <img class="gambar-preview img-fluid" style="Width: 200px">
                                     <input class="form-control" id="gambar" name="gambar" type="file" onchange="previewGambar()">
                                 </div>
                             </div>
                             <div class="card-footer text-end">
                                 <button type="submit" id="btnSave" class="btn btn-pill btn-outline-primary-2x btn-air-primary"><i class="fa fa-send-o">
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
 </div>
 <!-- </div>
 </div> -->
 <script type="text/javascript">
     $(document).ready(function(e) {

     });
     $('#inputFrm').submit(function(e) {
         urls = "<?php echo site_url('C_PO/input_proses') ?>";
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
 </script>