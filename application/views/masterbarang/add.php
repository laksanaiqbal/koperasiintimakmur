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
                                 <label class="col-sm-3 col-form-label" for="txt_input_kodebrg">Kode Barang</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="txt_input_kodebrg" name="txt_input_kodebrg" type="number" placeholder="Type Code Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_barcode">Barcode</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="txt_input_barcode" name="txt_input_barcode" type="number" placeholder="Type Barcode Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_namabrg">Nama Barang</label>
                                 <div class="col-sm-6">
                                     <input class="form-control" id="txt_input_namabrg" name="txt_input_namabrg" type="text" placeholder="Type Name Here">
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
                             <!-- <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_dept">Departemen</label>
                                 <div class="col-sm-3">
                                     <select name="txt_input_dept" id="txt_input_dept">
                                         <option value="">--pilih--</option>
                                         <?php foreach ($datadept as $data) : ?>
                                             <option value="<?php echo $data->idcabang ?>"><?php echo $data->namacabang ?></option>
                                         <?php endforeach ?>
                                     </select>
                                 </div>
                             </div> -->
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_satuan">Satuan</label>
                                 <div class="col-sm-3">
                                     <select name="txt_input_satuan" id="txt_input_satuan">
                                         <option value="">--pilih--</option>
                                         <?php foreach ($datasat as $data) : ?>
                                             <option value="<?php echo $data->kodesat ?>"><?php echo $data->namasat ?></option>
                                         <?php endforeach ?>
                                     </select>
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_stokakhir">Stok</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="txt_input_stokakhir" name="txt_input_stokakhir" type="text" placeholder="Type Stock Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_hpp">HPP</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="txt_input_hpp" name="txt_input_hpp" type="text" placeholder="Type HPP Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_hjual">Price</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="txt_input_hjual" name="txt_input_hjual" type="text" placeholder="Type Price Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="gambar1">Gambar</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="gambar1" name="gambar1" type="file">
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
         urls = "<?php echo site_url('C_masterbarang/input_proses') ?>";
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