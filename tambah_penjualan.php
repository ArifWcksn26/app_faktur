<?php
include 'koneksi.php';

// Ambil data customer, perusahaan, dan produk untuk dropdown
$data_customer = $conn->query("SELECT id_customer, nama_customer FROM customer");
$data_perusahaan = $conn->query("SELECT id_perusahaan, nama_perusahaan FROM perusahaan");
$data_produk = $conn->query("SELECT id_produk, nama_produk FROM produk");

// Siapkan HTML option untuk produk
$data_produk->data_seek(0);
$option_produk_html = '';
while ($row = $data_produk->fetch_assoc()) {
    $option_produk_html .= "<option value='{$row['id_produk']}'>{$row['nama_produk']}</option>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_customer = $_POST['id_customer'];
    $id_perusahaan = $_POST['id_perusahaan'];
    $tanggal = $_POST['tanggal'];
    $due_date = $_POST['due_date'];
    $metode_bayar = $_POST['metode_bayar'];
    $ppn = $_POST['ppn'];
    $dp = $_POST['dp'];
    $user = $_POST['user'];

    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];

    // Hitung total harga
    $total_harga = 0;
    for ($i = 0; $i < count($id_produk); $i++) {
        $total_harga += $qty[$i] * $price[$i];
    }

    // Hitung PPN
    $total_ppn = ($total_harga * $ppn) / 100;

    // Hitung grand total
    $grand_total = $total_harga + $total_ppn - $dp;

    // Insert ke tabel faktur
    $sql_faktur = "INSERT INTO faktur (id_customer, id_perusahaan, tanggal, due_date, metode_bayar, ppn, dp, grand_total, user) 
                   VALUES ('$id_customer', '$id_perusahaan', '$tanggal', '$due_date', '$metode_bayar', '$total_ppn', '$dp', '$grand_total', '$user')";

    if ($conn->query($sql_faktur) === TRUE) {
        $no_faktur = $conn->insert_id;

        // Insert ke tabel detail_faktur
        for ($i = 0; $i < count($id_produk); $i++) {
            $id = $id_produk[$i];
            $q = $qty[$i];
            $h = $price[$i];
            $conn->query("INSERT INTO detail_faktur (no_faktur, id_produk, qty, price) VALUES ('$no_faktur', '$id', '$q', '$h')");
        }

        header("Location: tampil_penjualan.php");
        exit();
    } else {
        echo "Gagal: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Tambah Penjualan</h2>
    <form method="post">
        <div class="form-group">
            <label>Customer</label>
            <select name="id_customer" class="form-control" required>
                <option value="">-- Pilih Customer --</option>
                <?php while ($row = $data_customer->fetch_assoc()): ?>
                    <option value="<?= $row['id_customer'] ?>"><?= $row['nama_customer'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Perusahaan</label>
            <select name="id_perusahaan" class="form-control" required>
                <option value="">-- Pilih Perusahaan --</option>
                <?php while ($row = $data_perusahaan->fetch_assoc()): ?>
                    <option value="<?= $row['id_perusahaan'] ?>"><?= $row['nama_perusahaan'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div id="produk-container">
            <label>Produk</label>
            <div class="row mb-2">
                <div class="col-md-4">
                    <select name="id_produk[]" class="form-control" required>
                        <?= $option_produk_html ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="qty[]" class="form-control" placeholder="Qty" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="price[]" class="form-control" placeholder="Harga" required>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-success mb-3" onclick="tambahProduk()">+ Produk</button>

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
            <label>PPN (%)</label>
            <input type="number" step="0.01" class="form-control" name="ppn" required>
        </div>
        <div class="form-group">
            <label>DP</label>
            <input type="number" step="0.01" class="form-control" name="dp" required>
        </div>
        <div class="form-group">
            <label>User</label>
            <input type="text" class="form-control" name="user" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
function tambahProduk() {
    const container = document.getElementById('produk-container');
    const html = `
        <div class="row mb-2">
            <div class="col-md-4">
                <select name="id_produk[]" class="form-control" required>
                    <?= $option_produk_html ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="qty[]" class="form-control" placeholder="Qty" required>
            </div>
            <div class="col-md-3">
                <input type="number" step="0.01" name="price[]" class="form-control" placeholder="Harga" required>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}
</script>

</body>
</html>
