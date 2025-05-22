<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_customer = $_POST['id_customer'];
    $nama_customer = $_POST['nama_customer'];
    $perusahaan_cust = $_POST['perusahaan_cust'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE customer SET nama_customer='$nama_customer', perusahaan_cust='$perusahaan_cust', alamat='$alamat' WHERE id_customer='$id_customer'";

    if ($conn->query($sql) === TRUE) {
        header("Location: tampil_customer.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $id_customer = $_GET['id'];
    $sql = "SELECT * FROM customer WHERE id_customer='$id_customer'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Customer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1>Ubah Customer</h1>
    <form method="post">
        <input type="hidden" name="id_customer" value="<?php echo $data['id_customer']; ?>">
        <div class="form-group">
            <label>Nama Customer</label>
            <input type="text" class="form-control" name="nama_customer" value="<?php echo $data['nama_customer']; ?>" required>
        </div>
        <div class="form-group">
            <label>Perusahaan</label>
            <input type="text" class="form-control" name="perusahaan_cust" value="<?php echo $data['perusahaan_cust']; ?>" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" class="form-control" name="alamat" value="<?php echo $data['alamat']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Ubah</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>