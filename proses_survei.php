<?php
include "koneksi.php";

$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
$produk = $_POST['produk'];
$rating = $_POST['rating'];
$saran = $_POST['saran'];

mysqli_query($conn,"INSERT INTO survei
(nama,kelas,produk,rating,saran)
VALUES
('$nama','$kelas','$produk','$rating','$saran')");

echo "<script>alert('Terima kasih! Data survei telah terkirim.'); window.location='index.html';</script>";
?>
