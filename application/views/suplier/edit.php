 <!-- <div class="col-sm-12">
     <div class="card"> tabindex="-1"  -->
 <div class="modal fade bd-example-modal-lg" tabindex="-1" id="frmEdit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                         <form method="POST" id="frm_Edit" class="theme-form">
                             <div class="mb-3 row" hidden>
                                 <label class="col-sm-3 col-form-label" for="txt_input_kodesup">Kode Sup</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="txt_input_kodesup" name="txt_input_kodesup" type="text" placeholder="Type Code Here" readonly>
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_namasup">Nama Suplier</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="txt_input_namasup" name="txt_input_namasup" type="text" placeholder="Type Suplier Name Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_atasnama">Atas Nama</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="txt_input_atasnama" name="txt_input_atasnama" type="text" placeholder="Type Atas Nama Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_Bank">Nama Bank</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="txt_input_Bank" name="txt_input_Bank" type="text" placeholder="Type Bank Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_ACBank">Rekening</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="txt_input_ACBank" name="txt_input_ACBank" type="number" placeholder="Type Rekening Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_alamat">Alamat</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="txt_input_alamat" name="txt_input_alamat" type="text" placeholder="Type Alamat Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_namaproduk">Produk</label>
                                 <div class="col-sm-9">
                                     <input class="form-control" id="txt_input_namaproduk" name="txt_input_namaproduk" type="text" placeholder="Type Produk Here">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label class="col-sm-3 col-form-label" for="txt_input_hp">Nomor HP</label>
                                 <div class="col-sm-3">
                                     <input class="form-control" id="txt_input_hp" name="txt_input_hp" type="number" placeholder="Type HP Here">
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
 </div>
 <!-- </div>
 </div> -->
 <script type="text/javascript">
     $(document).ready(function(e) {

     });
     $('#frm_Edit').submit(function(e) {
         urls = "<?php echo site_url('C_suplier/update_proses') ?>";
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