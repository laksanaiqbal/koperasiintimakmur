<div class="modal fade bd-example-modal-lg" id="show_pay" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-image">
                    &nbsp<h4 class="modal-title" id="myLargeModalLabel">
                </i></h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="openimage">
                <div class="col-sm-12">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-10" style="margin-left: auto; margin-right:auto;">
                                <div class="hitung">
                                    <form method="POST" id="simpanjual" class="theme-form" enctype="multipart/form-data">
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="namacus">Cust</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="namacus" id="namacus">
                                                    <option value="1">UMUM</option>
                                                    <?php foreach ($datacus as $data) : ?>
                                                        <option value="<?php echo $data->kodecus ?>"><?php echo $data->namacus ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="total">Total</label>
                                            <div class="col-sm-9">
                                                <input value="<?php echo $sum; ?>" class="form-control" id="total" name="total" type="number" placeholder="Type Jumlah Here" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="diskon">Diskon (%)</label>
                                            <div class="col-sm-3">
                                                <input value="0" class="form-control" id="diskon" name="diskon" type="number" placeholder="Type Jumlah Here">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="metode">Payment</label>
                                            <div class="col-sm-9">
                                                <div class="checkbox">
                                                    <input type="radio" name="metode" id="cash" value="Cash" checked> Cash
                                                    <input type="radio" name="metode" id="kredit" value="Kredit"> Kredit
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="bayar">Bayar</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="bayar" name="bayar" type="number" placeholder="Type Jumlah Here">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-sm-3 col-form-label" for="kembalian">Kembalian</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="kembalian" name="kembalian" type="number" placeholder="Type Jumlah Here" readonly>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                                            <button type="submit" id="btnSave" class="btn btn-pill btn-outline-primary-2x btn-air-primary">
                                                <i class="fa fa-send-o">Pay!</i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".hitung").keyup(function() {
        var bil1 = parseInt($("#total").val())
        var bil2 = parseInt($("#bayar").val())
        var diskon = parseInt($("#diskon").val())

        var hdiskon = bil1 * (diskon / 100);
        var hbaru = bil1 - hdiskon;
        var kembalian = bil2 - hbaru;
        $("#kembalian").attr("value", kembalian)
    });
    $(".cust").keyup(function() {
        var cus1 = parseInt($("#namacus").val())
        $("#cust").attr("value", cus1)
    })
    $(document).ready(function() {
        $('#kodecus').select2();
        $('#layanan').select2();
        $('[name="namacus"]').select2();
    });
    $(document).ready(function() {
        $("#namacus").select2({
            dropdownParent: $("#show_pay")
        });
    });
</script>