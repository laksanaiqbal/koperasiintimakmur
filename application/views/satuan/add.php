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
                                 <label class="col-sm-3 col-form-label" for="txt_input_kodesat">Kode Satuan</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="txt_input_kodesat" name="txt_input_kodesat" type="text" placeholder="Type Code Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_namasat">Nama Satuan</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="txt_input_namasat" name="txt_input_namasat" type="text" placeholder="Type Name Here">
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
         urls = "<?php echo site_url('C_satuan/input_proses') ?>";
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