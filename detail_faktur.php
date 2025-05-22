<?php
include 'koneksi.php';

// Ambil data detail faktur dengan join ke produk dan faktur
$sql = "SELECT df.no_faktur, 
               p.nama_produk, 
               df.qty, 
               df.price, 
               (df.qty * df.price) AS total
        FROM detail_faktur df
        JOIN produk p ON df.id_produk = p.id_produk
        JOIN faktur f ON df.no_faktur = f.no_faktur
        ORDER BY df.no_faktur ASC";

$result = $conn->query($sql);

if (!$result) {
    die("Query error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Faktur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1>Detail Faktur</h1>
    <a href="tampil_penjualan.php" class="btn btn-secondary mb-3">Kembali ke Penjualan</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No Faktur</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['no_faktur']; ?></td>
                <td><?php echo $row['nama_produk']; ?></td>
                <td><?php echo $row['qty']; ?></td>
                <td><?php echo number_format($row['price'], 2, ',', '.'); ?></td>
                <td><?php echo number_format($row['total'], 2, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
