<?php
include 'koneksi.php';

$id_perusahaan = $_GET['id'];

$sql = "DELETE FROM perusahaan WHERE id_perusahaan='$id_perusahaan'";

if ($conn->query($sql) === TRUE) {
    header("Location: tampil_perusahaan.php");
} else {
    echo "Error: " . $conn->error;
}
?>