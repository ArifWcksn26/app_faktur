<?php
// hapus_perusahaan.php
include 'koneksi.php'; // Pastikan file koneksi.php ada dan berfungsi

// Set header untuk respons JSON
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_perusahaan = $_GET['id'];

    // Mulai transaksi database untuk memastikan semua operasi berhasil atau tidak sama sekali
    $conn->begin_transaction();

    try {
        // LANGKAH 1: Ambil semua nomor faktur yang terkait dengan id_perusahaan ini
        // Ini diperlukan untuk menghapus detail faktur terlebih dahulu
        $sql_get_fakturs = "SELECT no_faktur FROM faktur WHERE id_perusahaan = ?";
        $stmt_get_fakturs = $conn->prepare($sql_get_fakturs);
        // PENTING: Sesuaikan 's' atau 'i' dengan tipe data id_perusahaan di database Anda
        // Jika id_perusahaan Anda adalah INTEGER, gunakan 'i'. Jika VARCHAR/STRING, gunakan 's'.
        $stmt_get_fakturs->bind_param("s", $id_perusahaan); // Menggunakan 's' (string) sebagai default
        $stmt_get_fakturs->execute();
        $result_fakturs = $stmt_get_fakturs->get_result();
        $fakturs_to_delete = [];
        while ($row = $result_fakturs->fetch_assoc()) {
            $fakturs_to_delete[] = $row['no_faktur'];
        }
        $stmt_get_fakturs->close();

        // LANGKAH 2: Hapus detail faktur terlebih dahulu untuk semua faktur yang akan dihapus
        if (!empty($fakturs_to_delete)) {
            // Buat placeholder untuk query IN clause (contoh: ?, ?, ?)
            $placeholders = implode(',', array_fill(0, count($fakturs_to_delete), '?'));
            $sql_delete_details = "DELETE FROM detail_faktur WHERE no_faktur IN ($placeholders)";
            $stmt_delete_details = $conn->prepare($sql_delete_details);
            // Tentukan tipe data untuk setiap placeholder (asumsi no_faktur adalah string 's')
            $types = str_repeat('s', count($fakturs_to_delete));
            // Bind parameter menggunakan unpack operator (...)
            $stmt_delete_details->bind_param($types, ...$fakturs_to_delete);

            if (!$stmt_delete_details->execute()) {
                throw new Exception("Gagal menghapus detail faktur terkait: " . $stmt_delete_details->error);
            }
            $stmt_delete_details->close();

            // LANGKAH 3: Hapus faktur-faktur yang terkait
            $sql_delete_fakturs = "DELETE FROM faktur WHERE no_faktur IN ($placeholders)"; // Re-use placeholders
            $stmt_delete_fakturs = $conn->prepare($sql_delete_fakturs);
            $stmt_delete_fakturs->bind_param($types, ...$fakturs_to_delete);
            if (!$stmt_delete_fakturs->execute()) {
                throw new Exception("Gagal menghapus faktur terkait: " . $stmt_delete_fakturs->error);
            }
            $stmt_delete_fakturs->close();
        }

        // LANGKAH 4: Akhirnya, hapus perusahaan itu sendiri
        $sql_delete_perusahaan = "DELETE FROM perusahaan WHERE id_perusahaan = ?";
        $stmt_delete_perusahaan = $conn->prepare($sql_delete_perusahaan);
        $stmt_delete_perusahaan->bind_param("s", $id_perusahaan); // Menggunakan 's' (string) sebagai default
        if (!$stmt_delete_perusahaan->execute()) {
            throw new Exception("Gagal menghapus perusahaan: " . $stmt_delete_perusahaan->error);
        }
        $stmt_delete_perusahaan->close();

        $conn->commit(); // Commit transaksi jika semua berhasil
        $response['success'] = true;
        $response['message'] = "Data perusahaan dan semua faktur serta detailnya berhasil dihapus.";

    } catch (Exception $e) {
        $conn->rollback(); // Rollback transaksi jika terjadi error
        $response['message'] = $e->getMessage();
    }

} else {
    $response['message'] = "ID perusahaan tidak disediakan.";
}

echo json_encode($response);
$conn->close();
?>