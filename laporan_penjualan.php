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
               pr.nama_produk
        FROM faktur f 
        JOIN customer c ON f.id_customer = c.id_customer 
        JOIN perusahaan p ON f.id_perusahaan = p.id_perusahaan 
        JOIN detail_faktur df ON f.no_faktur = df.no_faktur
        JOIN produk pr ON df.id_produk = pr.id_produk";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Laporan Penjualan</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
    <!-- Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" />
</head>
<body>

<div class="container mt-4">
    <h1>Laporan Penjualan</h1>
    <table id="laporanPenjualan" class="table table-bordered table-striped">
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
                <th>Qty</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['no_faktur']) ?></td>
                <td><?= htmlspecialchars($row['nama_customer']) ?></td>
                <td><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
                <td><?= htmlspecialchars($row['tanggal']) ?></td>
                <td><?= htmlspecialchars($row['due_date']) ?></td>
                <td><?= htmlspecialchars($row['metode_bayar']) ?></td>
                <td><?= number_format($row['ppn'], 2, ',', '.') ?></td>
                <td><?= number_format($row['dp'], 2, ',', '.') ?></td>
                <td><?= number_format($row['grand_total'], 2, ',', '.') ?></td>
                <td><?= htmlspecialchars($row['user']) ?></td>
                <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                <td><?= (int)$row['qty'] ?></td>
                <td><?= number_format($row['price'], 2, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<!-- Buttons -->
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<!-- JSZip untuk export Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<!-- pdfmake untuk export PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(document).ready(function() {
    $('#laporanPenjualan').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        pageLength: 10,
        order: [[ 3, 'desc' ]] // Urutkan berdasarkan tanggal terbaru
    });
});
</script>

</body>
</html>
