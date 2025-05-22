<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $fax = $_POST['fax'];

    $sql = "INSERT INTO perusahaan (nama_perusahaan, alamat, no_telp, fax) VALUES ('$nama_perusahaan', '$alamat', '$no_telp', '$fax')";

    if ($conn->query($sql) === TRUE) {
        header("Location: tampil_perusahaan.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Perusahaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1>Tambah Perusahaan</h1>
    <form method="post">
        <div class="form-group">
            <label>Nama Perusahaan</label>
            <input type="text" class="form-control" name="nama_perusahaan" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" class="form-control" name="alamat" required>
        </div>
        <div class="form-group">
            <label>No Telepon</label>
            <input type="text" class="form-control" name="no_telp" required>
        </div>
        <div class="form-group">
            <label>Fax</label>
            <input type="text" class="form-control" name="fax">
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>