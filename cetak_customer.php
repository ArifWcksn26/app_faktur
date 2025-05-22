<?php
include 'koneksi.php';

$sql = "SELECT * FROM customer";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview/Cetak Data Customer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h1>Data Customer</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Customer</th>
                <th>Perusahaan</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id_customer']; ?></td>
                <td><?php echo $row['nama_customer']; ?></td>
                <td><?php echo $row['perusahaan_cust']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <button onclick="printContent()" class="btn btn-primary no-print">Print</button>
    <a href="tampil_customer.php" class="btn btn-secondary no-print">Kembali</a>
</div>

<script>
    function printContent() {
        window.print();
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
