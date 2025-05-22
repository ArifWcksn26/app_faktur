<?php
include 'koneksi.php';

$no_faktur = $_GET['id'];

// Hapus detail faktur
$sql_detail = "DELETE FROM detail_faktur WHERE no_faktur='$no_faktur'";
$conn->query($sql_detail);

// Hapus faktur
$sql = "DELETE FROM faktur WHERE no_faktur='$no_faktur'";

if ($conn->query($sql) === TRUE) {
    header("Location: tampil_penjualan.php");
} else {
    echo "Error: " . $conn->error;
}
?>