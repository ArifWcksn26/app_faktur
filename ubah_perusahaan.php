<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_perusahaan = $_POST['id_perusahaan'];
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $fax = $_POST['fax'];

    $sql = "UPDATE perusahaan SET nama_perusahaan='$nama_perusahaan', alamat='$alamat', no_telp='$no_telp', fax='$fax' WHERE id_perusahaan='$id_perusahaan'";

    if ($conn->query($sql) === TRUE) {
        header("Location: tampil_perusahaan.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $id_perusahaan = $_GET['id'];
    $sql = "SELECT * FROM perusahaan WHERE id_perusahaan='$id_perusahaan'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Perusahaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1>Ubah Perusahaan</h1>
    <form method="post">
        <input type="hidden" name="id_perusahaan" value="<?php echo $data['id_perusahaan']; ?>">
        <div class="form-group">
            <label>Nama Perusahaan</label>
            <input type="text" class="form-control" name="nama_perusahaan" value="<?php echo $data['nama_perusahaan']; ?>" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" class="form-control" name="alamat" value="<?php echo $data['alamat']; ?>" required>
        </div>
        <div class="form-group">
            <label>No Telepon</label>
            <input type="text" class="form-control" name="no_telp" value="<?php echo $data['no_telp']; ?>" required>
        </div>
        <div class="form-group">
            <label>Fax</label>
            <input type="text" class="form-control" name="fax" value="<?php echo $data['fax']; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Ubah</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>