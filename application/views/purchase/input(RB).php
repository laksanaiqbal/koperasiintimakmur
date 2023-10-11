<div class="modal fade bd-example-modal-lg" tabindex="-1" id="forminput" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" id="inputFrm" class="theme-form" enctype="multipart/form-data">
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label" for="cabang">Cabang</label>
                                    <div class="col-md-6">
                                        <select name="cabang" id="cabang" class="form-control select2">
                                            <?php foreach ($datacabang as $data) : ?>
                                                <option value="<?php echo $data->idcabang ?>"><?php echo $data->namacabang ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label" for="payment">Payment</label>
                                    <div class="col-md-6">
                                        <select name="payment" id="payment" class="form-control select2">
                                            <option value="0">Cash</option>
                                            <option value="1">Hutang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label" for="namasup">Suplier</label>
                                    <div class="col-md-6">
                                        <input class="form-control" id="namasup" name="namasup" type="text" placeholder="Type Namasup Here" readonly required>
                                    </div>
                                    <div class="col-md-2">
                                        <button id="btn_sup" type="button" class="btn btn-primary"><i class="fa fa-search"> Suplier</i></button>
                                    </div>
                                    <div class="col-sm-6" hidden>
                                        <input class="form-control" id="kodesup" name="kodesup" type="text" placeholder="Type kodesup Here" readonly required>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-2 row">
                                    <button id="btn_show" type="button" class="btn btn-primary"><i class="fa fa-search"> Barang</i></button>
                                </div>
                                <br>
                                <div class="mb-2 row">
                                    <label class="col-md-2 col-form-label" for="namabrg">Nama</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="namabrg" name="namabrg" type="text" placeholder="Type Nama Here" readonly>
                                    </div>
                                    <label class="col-md-2 col-form-label" for="hbeli">H.Beli</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="hbeli" name="hbeli" type="text" placeholder="Type Jumlah Here">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-2 col-form-label" for="Barcode">Barcode</label>
                                    <div class="col-md-4">
                                        <input readonly class="form-control" id="barcode" name="barcode" type="text" placeholder="Type kode Here" readonly>
                                    </div>
                                    <div class="col-md-4" hidden>
                                        <input readonly class="form-control" id="kodebrg" name="kodebrg" type="text" placeholder="Type kode Here">
                                    </div>
                                    <label class="col-md-2 col-form-label" for="hjual">H.Jual</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="hjual" name="hjual" type="text" placeholder="Type Jumlah Here">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-md-2 col-form-label" for="qty">QTY</label>
                                    <div class="col-md-4">
                                        <input class="form-control" id="qty" name="qty" type="number" placeholder="Type Jumlah Here" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row" style="text-align: center;">
                                    <div class="col-md-12">
                                        <button type="submit" id="btnSave" class="btn btn-pill btn-outline-primary-2x btn-air-primary">
                                            <i class="fa fa-send-o">Submit</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="display" id="datatable_list">
                                    <div id="button"></div>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Nama Barang</th>
                                            <th>harga_beli</th>
                                            <th>harga_jual</th>
                                            <th>qty</th>
                                            <th>total</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <br>
                            <div class="mb-2 row" style="text-align: right;">
                                <h2>TOTAL</h2>
                                <hr>
                                <div id="sums">
                                    <h1><?php echo $sum; ?></h1>
                                    <input hidden value="<?php echo $sum; ?>" class="form-control" id="totals" name="totals" type="number" placeholder="Type Jumlah Here">
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <button type="button" id="btn_CO" class="btn btn-primary"><i class="fa fa-paper-plane-o m-right-xs"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>