<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $price = $_POST['price'];
    $jenis = $_POST['jenis'];
    $stock = $_POST['stock'];

    $sql = "UPDATE produk SET nama_produk='$nama_produk', price='$price', jenis='$jenis', stock='$stock' WHERE id_produk='$id_produk'";

    if ($conn->query($sql) === TRUE) {
        header("Location: tampil_produk.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $id_produk = $_GET['id'];
    $sql = "SELECT * FROM produk WHERE id_produk='$id_produk'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1>Ubah Produk</h1>
    <form method="post">
        <input type="hidden" name="id_produk" value="<?php echo $data['id_produk']; ?>">
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" class="form-control" name="nama_produk" value="<?php echo $data['nama_produk']; ?>" required>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $data['price']; ?>" required>
        </div>
        <div class="form-group">
            <label>Jenis</label>
            <input type="text" class="form-control" name="jenis" value="<?php echo $data['jenis']; ?>" required>
        </div>
        <div class="form-group">
            <label>Stok</label>
            <input type="number" class="form-control" name="stock" value="<?php echo $data['stock']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Ubah</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>