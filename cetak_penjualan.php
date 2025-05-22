<?php
include 'koneksi.php';

$no_faktur = $_GET['id'] ?? '';

if (!$no_faktur) {
    die("Nomor faktur tidak ditemukan.");
}

// Ambil data faktur dan detail
$sql = "SELECT f.no_faktur, f.tanggal, f.due_date, f.metode_bayar, f.ppn, f.dp, f.grand_total, f.user,
               c.nama_customer, c.alamat AS alamat_customer,
               p.nama_perusahaan, p.alamat AS alamat_perusahaan,
               df.qty, df.price, pr.nama_produk
        FROM faktur f
        JOIN customer c ON f.id_customer = c.id_customer
        JOIN perusahaan p ON f.id_perusahaan = p.id_perusahaan
        JOIN detail_faktur df ON f.no_faktur = df.no_faktur
        JOIN produk pr ON df.id_produk = pr.id_produk
        WHERE f.no_faktur = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $no_faktur);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Faktur tidak ditemukan.");
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$info = $data[0]; // Data umum
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Faktur <?= $info['no_faktur'] ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
        body { font-size: 14px; }
        h2 { margin-bottom: 20px; }
        table td, table th { vertical-align: middle; }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2>Faktur Penjualan</h2>
    <table class="table table-bordered">
        <tr><th>No Faktur</th><td><?= $info['no_faktur'] ?></td></tr>
        <tr><th>Tanggal</th><td><?= $info['tanggal'] ?></td></tr>
        <tr><th>Jatuh Tempo</th><td><?= $info['due_date'] ?></td></tr>
        <tr><th>Customer</th><td><?= $info['nama_customer'] ?> - <?= $info['alamat_customer'] ?></td></tr>
        <tr><th>Perusahaan</th><td><?= $info['nama_perusahaan'] ?> - <?= $info['alamat_perusahaan'] ?></td></tr>
        <tr><th>Metode Bayar</th><td><?= $info['metode_bayar'] ?></td></tr>
        <tr><th>User Input</th><td><?= $info['user'] ?></td></tr>
    </table>

    <h5>Detail Produk</h5>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $subtotal = 0;
            foreach ($data as $item):
                $line = $item['qty'] * $item['price'];
                $subtotal += $line;
            ?>
            <tr>
                <td><?= $item['nama_produk'] ?></td>
                <td><?= $item['qty'] ?></td>
                <td><?= number_format($item['price'], 0, ',', '.') ?></td>
                <td><?= number_format($line, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="table table-bordered w-50">
        <tr><th>Subtotal</th><td><?= number_format($subtotal, 0, ',', '.') ?></td></tr>
        <tr><th>PPN</th><td><?= number_format($info['ppn'], 0, ',', '.') ?></td></tr>
        <tr><th>DP</th><td><?= number_format($info['dp'], 0, ',', '.') ?></td></tr>
        <tr><th><strong>Grand Total</strong></th><td><strong><?= number_format($info['grand_total'], 0, ',', '.') ?></strong></td></tr>
    </table>

    <button onclick="window.print()" class="btn btn-primary no-print">Print</button>
    <a href="index.php" class="btn btn-secondary no-print">Kembali</a>
</div>

</body>
</html>
