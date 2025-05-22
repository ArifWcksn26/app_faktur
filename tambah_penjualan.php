<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_customer = $_POST['id_customer'];
    $id_perusahaan = $_POST['id_perusahaan'];
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $tanggal = $_POST['tanggal'];
    $due_date = $_POST['due_date'];
    $metode_bayar = $_POST['metode_bayar'];
    $ppn = $_POST['ppn'];
    $dp = $_POST['dp'];
    $grand_total = $_POST['grand_total'];
    $user = $_POST['user'];

    // Insert ke tabel faktur
    $sql_faktur = "INSERT INTO faktur (id_customer, id_perusahaan, tanggal, due_date, metode_bayar, ppn, dp, grand_total, user) 
                   VALUES ('$id_customer', '$id_perusahaan', '$tanggal', '$due_date', '$metode_bayar', '$ppn', '$dp', '$grand_total', '$user')";

    if ($conn->query($sql_faktur) === TRUE) {
        $no_faktur = $conn->insert_id; // Ambil ID faktur yang baru saja ditambahkan

        // Insert ke tabel detail_faktur
        $sql_detail = "INSERT INTO detail_faktur (no_faktur, id_produk, qty, harga) 
                       VALUES ('$no_faktur', '$id_produk', '$qty', '$price')";
        $conn->query($sql_detail);

        header("Location: tampil_penjualan.php");
    } else {
        echo "Error: " . $sql_faktur . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1>Tambah Transaksi</h1>
    <form method="post">
        <div class="form-group">
            <label>ID Customer</label>
            <input type="number" class="form-control" name="id_customer" required>
        </div>
        <div class="form-group">
            <label>ID Perusahaan</label>
            <input type="number" class="form-control" name="id_perusahaan" required>
        </div>
        <div class="form-group">
            <label>ID Produk</label>
            <input type="number" class="form-control" name="id_produk" required>
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" class="form-control" name="qty" required>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" step="0.01" class="form-control" name="price" required>
        </div>
        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" class="form-control" name="tanggal" required>
        </div>
        <div class="form-group">
            <label>Jatuh Tempo</label>
            <input type="date" class="form-control" name="due_date" required>
        </div>
        <div class="form-group">
            <label>Metode Bayar</label>
            <input type="text" class="form-control" name="metode_bayar" required>
        </div>
        <div class="form-group">
            <label>PPN</label>
            <input type="number" step="0.01" class="form-control" name="ppn" required>
        </div>
        <div class="form-group">
            <label>DP</label>
            <input type="number" step="0.01" class="form-control" name="dp" required>
        </div>
        <div class="form-group">
            <label>Grand Total</label>
            <input type="number" step="0.01" class="form-control" name="grand_total" required>
        </div>
        <div class="form-group">
            <label>User</label>
            <input type="text" class="form-control" name="user" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>