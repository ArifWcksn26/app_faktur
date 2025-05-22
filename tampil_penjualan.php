<?php
include 'koneksi.php';

$sql = "SELECT f.no_faktur, 
               c.nama_customer, 
               p.nama_perusahaan, 
               f.tanggal, 
               f.due_date, 
               f.metode_bayar, 
               f.ppn, 
               f.dp, 
               f.grand_total, 
               f.user, 
               df.qty, 
               df.price,
               pr.nama_produk  /* Ambil nama produk dari tabel produk */
        FROM faktur f 
        JOIN customer c ON f.id_customer = c.id_customer 
        JOIN perusahaan p ON f.id_perusahaan = p.id_perusahaan 
        JOIN detail_faktur df ON f.no_faktur = df.no_faktur
        JOIN produk pr ON df.id_produk = pr.id_produk"; /* Gabungkan dengan tabel produk */
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1>Data Transaksi Penjualan</h1>
    <a href="tambah_penjualan.php" class="btn btn-primary mb-3">Tambah Transaksi</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No Faktur</th>
                <th>Nama Customer</th>
                <th>Nama Perusahaan</th>
                <th>Tanggal</th>
                <th>Due Date</th>
                <th>Metode Bayar</th>
                <th>PPN</th>
                <th>DP</th>
                <th>Grand Total</th>
                <th>User</th>
                <th>Nama Produk</th>
                <th>Quantity</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['no_faktur']; ?></td>
                <td><?php echo $row['nama_customer']; ?></td>
                <td><?php echo $row['nama_perusahaan']; ?></td>
                <td><?php echo $row['tanggal']; ?></td>
                <td><?php echo $row['due_date']; ?></td>
                <td><?php echo $row['metode_bayar']; ?></td>
                <td><?php echo number_format($row['ppn'], 2, ',', '.'); ?></td>
                <td><?php echo number_format($row['dp'], 2, ',', '.'); ?></td>
                <td><?php echo number_format($row['grand_total'], 2, ',', '.'); ?></td>
                <td><?php echo $row['user']; ?></td>
                <td><?php echo $row['nama_produk']; ?></td> <!-- Hanya menampilkan nama produk -->
                <td><?php echo $row['qty']; ?></td>
                <td><?php echo number_format($row['price'], 2, ',', '.'); ?></td>
                <td>
                    <a href="cetak_penjualan.php?id=<?php echo $row['no_faktur']; ?>" class="btn btn-info">Cetak Faktur</a>
                    <a href="ubah_penjualan.php?id=<?php echo $row['no_faktur']; ?>" class="btn btn-warning">Ubah</a>
                    <a href="hapus_penjualan.php?id=<?php echo $row['no_faktur']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                </td>
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