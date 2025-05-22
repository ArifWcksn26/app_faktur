<?php
include 'koneksi.php';

$id_produk = $_GET['id'];

$sql = "DELETE FROM produk WHERE id_produk='$id_produk'";

if ($conn->query($sql) === TRUE) {
    header("Location: tampil_produk.php");
} else {
    echo "Error: " . $conn->error;
}
?>