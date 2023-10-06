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
                                 <label class="col-sm-3 col-form-label" for="kodesup">Kode Sup</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="kodesup" name="kodesup" type="random" value="<?php echo rand(100, 1000000); ?>" readonly>
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="namasup">Nama Suplier</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="namasup" name="namasup" type="text" placeholder="Type Suplier Name Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="atasnama">Atas Nama</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="atasnama" name="atasnama" type="text" placeholder="Type Atas Nama Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="bank">Nama Bank</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="bank" name="bank" type="text" placeholder="Type Bank Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="ACBank">Rekening</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="ACBank" name="ACBank" type="number" placeholder="Type Rekening Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="alamat">Alamat</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="alamat" name="alamat" type="text" placeholder="Type Alamat Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="namaproduk">Produk</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="namaproduk" name="namaproduk" type="text" placeholder="Type Produk Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="hp">Nomor HP</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="hp" name="hp" type="number" placeholder="Type HP Here">
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

 <script type="text/javascript">
     $(document).ready(function(e) {

     });
     $('#inputFrm').submit(function(e) {
         urls = "<?php echo site_url('C_suplier/input_proses') ?>";
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