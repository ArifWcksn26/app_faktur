<?php
include 'koneksi.php';

$sql = "SELECT * FROM perusahaan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Perusahaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1>Data Perusahaan</h1>
    <a href="tambah_perusahaan.php" class="btn btn-primary mb-3">Tambah Perusahaan</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Perusahaan</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Fax</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id_perusahaan']; ?></td>
                <td><?php echo $row['nama_perusahaan']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['no_telp']; ?></td>
                <td><?php echo $row['fax']; ?></td>
                <td>
                    <a href="ubah_perusahaan.php?id=<?php echo $row['id_perusahaan']; ?>" class="btn btn-warning">Ubah</a>
                    <a href="hapus_perusahaan.php?id=<?php echo $row['id_perusahaan']; ?>" class="btn btn-danger">Hapus</a>
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