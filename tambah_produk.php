<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $price = $_POST['price'];
    $jenis = $_POST['jenis'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO produk (nama_produk, price, jenis, stock) VALUES ('$nama_produk', '$price', '$jenis', '$stock')";

    if ($conn->query($sql) === TRUE) {
        header("Location: tampil_produk.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1>Tambah Produk</h1>
    <form method="post">
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" class="form-control" name="nama_produk" required>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" step="0.01" class="form-control" name="price" required>
        </div>
        <div class="form-group">
            <label>Jenis</label>
            <input type="text" class="form-control" name="jenis" required>
        </div>
        <div class="form-group">
            <label>Stok</label>
            <input type="number" class="form-control" name="stock" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>