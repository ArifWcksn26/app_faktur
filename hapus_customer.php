<?php
include 'koneksi.php';

$id_customer = $_GET['id'];

$sql = "DELETE FROM customer WHERE id_customer='$id_customer'";

if ($conn->query($sql) === TRUE) {
    header("Location: tampil_customer.php");
} else {
    echo "Error: " . $conn->error;
}
?>
