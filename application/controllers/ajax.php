<?php

//membuat koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "dorder");

//variabel nim yang dikirimkan form.php
$kodebrg = $_GET['kodebrg'];

//mengambil data
$query = mysqli_query($koneksi, "select * from inv.dorder where kodebrg='$kodebrg'");
$userid = mysqli_fetch_array($query);
$data = array(
    'kodebrg'      =>  @$userid['kodebrg'],
    'namabrg'     =>  @$userid['namabrg'],
    'qtyorder'     =>  @$userid['qtyorder'],

);

//tampil data
echo json_encode($data);
