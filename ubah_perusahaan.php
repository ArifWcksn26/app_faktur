<?php
include 'koneksi.php';

// --- Debugging: Cek apa yang diterima di $_GET ---
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// var_dump($_GET);
// --- Akhir Debugging ---

$pesan_error = '';
$data_perusahaan = []; // Inisialisasi array untuk menghindari error jika data tidak ditemukan

// Cek apakah ada parameter 'id' di URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_perusahaan = $_GET['id'];

    // Ambil data perusahaan berdasarkan ID
    $sql = "SELECT id_perusahaan, nama_perusahaan, alamat, no_telp, fax FROM perusahaan WHERE id_perusahaan = ?";
    $stmt = $conn->prepare($sql);

    // PENTING: Gunakan 'i' jika id_perusahaan adalah INTEGER di database Anda, atau 's' jika VARCHAR/STRING
    $stmt->bind_param("s", $id_perusahaan); // Menggunakan 's' karena ID bisa saja string atau kombinasi karakter
    // Jika ID Anda pasti angka, lebih baik gunakan: $stmt->bind_param("i", $id_perusahaan);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data_perusahaan = $result->fetch_assoc();
    } else {
        $pesan_error = "Data perusahaan dengan ID '" . htmlspecialchars($id_perusahaan) . "' tidak ditemukan.";
    }
    $stmt->close();
} else {
    $pesan_error = "ID perusahaan tidak disediakan atau kosong.";
}

// Proses update data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_perusahaan_post = $_POST['id_perusahaan'] ?? null;
    $nama_perusahaan = $_POST['nama_perusahaan'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $no_telp = $_POST['no_telp'] ?? '';
    $fax = $_POST['fax'] ?? '';

    // Validasi dasar
    if (empty($id_perusahaan_post)) {
        $pesan_error = "ID perusahaan untuk update tidak ditemukan.";
    } elseif (empty($nama_perusahaan) || empty($alamat)) {
        $pesan_error = "Nama perusahaan dan alamat tidak boleh kosong.";
    } else {
        $sql_update = "UPDATE perusahaan SET
                       nama_perusahaan = ?,
                       alamat = ?,
                       no_telp = ?,
                       fax = ?
                       WHERE id_perusahaan = ?";
        $stmt_update = $conn->prepare($sql_update);
        // 'sssss' -> s=string (nama), s=string (alamat), s=string (no_telp), s=string (fax), s=string (id_perusahaan)
        // Jika ID Anda integer, ubah menjadi 'ssssi' dan pastikan $id_perusahaan_post adalah integer
        $stmt_update->bind_param("sssss", $nama_perusahaan, $alamat, $no_telp, $fax, $id_perusahaan_post);

        if ($stmt_update->execute()) {
            // Redirect kembali ke halaman tampil_perusahaan.php setelah berhasil diubah
            header("Location: tampil_perusahaan.php?status=success_update");
            exit;
        } else {
            $pesan_error = "Gagal memperbarui data: " . $stmt_update->error;
        }
        $stmt_update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Data Perusahaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 600px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h1>Ubah Data Perusahaan</h1>
    <hr>

    <?php if (!empty($pesan_error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $pesan_error; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($data_perusahaan['id_perusahaan'])): // Tampilkan form hanya jika data ditemukan ?>
        <form action="ubah_perusahaan.php" method="post">
            <input type="hidden" name="id_perusahaan" value="<?php echo htmlspecialchars($data_perusahaan['id_perusahaan']); ?>">

            <div class="form-group">
                <label for="nama_perusahaan">Nama Perusahaan:</label>
                <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="<?php echo htmlspecialchars($data_perusahaan['nama_perusahaan']); ?>" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($data_perusahaan['alamat']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="no_telp">No Telepon:</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo htmlspecialchars($data_perusahaan['no_telp']); ?>">
            </div>

            <div class="form-group">
                <label for="fax">Fax:</label>
                <input type="text" class="form-control" id="fax" name="fax" value="<?php echo htmlspecialchars($data_perusahaan['fax']); ?>">
            </div>

            <button type="submit" class="btn btn-primary">Ubah Data</button>
            <a href="tampil_perusahaan.php" class="btn btn-secondary">Batal</a>
        </form>
    <?php else: ?>
        <p class="text-muted">Tidak dapat menampilkan formulir karena ID perusahaan tidak valid atau data tidak ditemukan.</p>
        <a href="tampil_perusahaan.php" class="btn btn-secondary">Kembali ke Data Perusahaan</a>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>