<?php
include 'koneksi.php';

$no_faktur = $_GET['id'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update faktur
    $id_customer = $_POST['id_customer'];
    $id_perusahaan = $_POST['id_perusahaan'];
    $tanggal = $_POST['tanggal'];
    $due_date = $_POST['due_date'];
    $metode_bayar = $_POST['metode_bayar'];
    $ppn = $_POST['ppn'];
    $dp = $_POST['dp'];
    $grand_total = $_POST['grand_total'];
    $user = $_POST['user'];

    $conn->query("UPDATE faktur SET 
        id_customer='$id_customer', 
        id_perusahaan='$id_perusahaan',
        tanggal='$tanggal', 
        due_date='$due_date', 
        metode_bayar='$metode_bayar', 
        ppn='$ppn', 
        dp='$dp', 
        grand_total='$grand_total',
        user='$user'
        WHERE no_faktur='$no_faktur'");

    // Hapus detail lama
    $conn->query("DELETE FROM detail_faktur WHERE no_faktur='$no_faktur'");

    // Tambahkan detail baru
    foreach ($_POST['id_produk'] as $i => $id_produk) {
        $qty = $_POST['qty'][$i];
        $price = $_POST['price'][$i];
        $conn->query("INSERT INTO detail_faktur (no_faktur, id_produk, qty, price) 
                      VALUES ('$no_faktur', '$id_produk', '$qty', '$price')");
    }

    header("Location: tampil_penjualan.php");
    exit;
}

// Ambil data faktur
$faktur = $conn->query("SELECT * FROM faktur WHERE no_faktur='$no_faktur'")->fetch_assoc();
$detail = $conn->query("SELECT * FROM detail_faktur WHERE no_faktur='$no_faktur'");
$produk = $conn->query("SELECT * FROM produk");
$customer = $conn->query("SELECT * FROM customer");
$perusahaan = $conn->query("SELECT * FROM perusahaan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Ubah Transaksi - No Faktur: <?= $faktur['no_faktur'] ?></h2>
    <form method="POST">
        <input type="hidden" name="no_faktur" value="<?= $faktur['no_faktur'] ?>">

        <div class="form-group">
            <label>Customer</label>
            <select name="id_customer" class="form-control" required>
                <?php while ($row = $customer->fetch_assoc()): ?>
                    <option value="<?= $row['id_customer'] ?>" <?= $row['id_customer'] == $faktur['id_customer'] ? 'selected' : '' ?>>
                        <?= $row['nama_customer'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Perusahaan</label>
            <select name="id_perusahaan" class="form-control" required>
                <?php while ($row = $perusahaan->fetch_assoc()): ?>
                    <option value="<?= $row['id_perusahaan'] ?>" <?= $row['id_perusahaan'] == $faktur['id_perusahaan'] ? 'selected' : '' ?>>
                        <?= $row['nama_perusahaan'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $faktur['tanggal'] ?>" required>
        </div>

        <div class="form-group">
            <label>Jatuh Tempo</label>
            <input type="date" name="due_date" class="form-control" value="<?= $faktur['due_date'] ?>" required>
        </div>

        <div class="form-group">
            <label>Metode Bayar</label>
            <input type="text" name="metode_bayar" class="form-control" value="<?= $faktur['metode_bayar'] ?>" required>
        </div>

        <hr>
        <h5>Produk & Detail</h5>
        <div id="produk-container">
            <?php foreach ($detail as $index => $d): ?>
            <div class="row mb-2">
                <div class="col-md-4">
                    <select name="id_produk[]" class="form-control" required>
                        <?php
                        $produk->data_seek(0); // reset pointer
                        while ($p = $produk->fetch_assoc()):
                        ?>
                        <option value="<?= $p['id_produk'] ?>" <?= $p['id_produk'] == $d['id_produk'] ? 'selected' : '' ?>>
                            <?= $p['nama_produk'] ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="qty[]" class="form-control" value="<?= $d['qty'] ?>" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="price[]" class="form-control" value="<?= $d['price'] ?>" required>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="form-group">
            <label>PPN</label>
            <input type="number" step="0.01" name="ppn" class="form-control" value="<?= $faktur['ppn'] ?>" required>
        </div>

        <div class="form-group">
            <label>DP</label>
            <input type="number" step="0.01" name="dp" class="form-control" value="<?= $faktur['dp'] ?>" required>
        </div>

        <div class="form-group">
            <label>Grand Total</label>
            <input type="number" step="0.01" name="grand_total" class="form-control" value="<?= $faktur['grand_total'] ?>" required>
        </div>

        <div class="form-group">
            <label>User</label>
            <input type="text" name="user" class="form-control" value="<?= $faktur['user'] ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="tampil_penjualan.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
