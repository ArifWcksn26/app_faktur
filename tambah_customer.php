

<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_customer = $_POST['nama_customer'];
    $perusahaan_cust = $_POST['perusahaan_cust'];
    $alamat = $_POST['alamat'];

    $sql = "INSERT INTO customer (nama_customer, perusahaan_cust, alamat) VALUES ('$nama_customer', '$perusahaan_cust', '$alamat')";

    if ($conn->query($sql) === TRUE) {
        header("Location: tampil_customer.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Customer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1>Tambah Customer</h1>
    <form method="post">
        <div class="form-group">
            <label>Nama Customer</label>
            <input type="text" class="form-control" name="nama_customer" required>
        </div>
        <div class="form-group">
            <label>Perusahaan</label>
            <input type="text" class="form-control" name="perusahaan_cust" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" class="form-control" name="alamat" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
</div>

<script>
function validateForm() {
    const namaCustomer = document.forms["customerForm"]["nama_customer"].value;
    const perusahaan = document.forms["customerForm"]["perusahaan_cust"].value;
    const alamat = document.forms["customerForm"]["alamat"].value;

    if (namaCustomer == "" || perusahaan == "" || alamat == "") {
        alert("Semua field harus diisi!");
        return false;
    }
}
</script>

<form name="customerForm" method="post" onsubmit="return validateForm()">

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

