<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Faktur Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.css" />
    <style>
        body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
    padding-bottom: 50px; /* Sesuaikan dengan tinggi footer Anda (misal: 10px padding + 10px padding + tinggi teks = sekitar 40-50px) */
}
        .content-wrapper {
            flex: 1;
            display: flex;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            background: #f8f9fa;
            padding: 15px;
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            background: #ffffff;
            overflow-y: auto;
        }
        footer {
    background: #f1f1f1;
    padding: 10px;
    text-align: center;
    width: 100%; /* Agar footer mengambil lebar penuh browser */
    position: fixed; /* Menjadikan footer tetap di posisi yang ditentukan */
    bottom: 0;     /* Mengatur footer agar berada di bagian bawah viewport */
    left: 0;       /* Mengatur footer agar dimulai dari sisi kiri viewport */
    z-index: 1000; /* Pastikan footer berada di atas konten lain jika ada */
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1); /* Opsional: Tambahkan sedikit bayangan di atas footer */
}

        .nav-link.active {
            font-weight: bold;
            color: #007bff;
            background-color: #e9ecef;
            border-radius: 0.25rem;
        }
        .nav .collapse .nav-link {
            padding-left: 30px;
        }
    </style>
</head>
<body>

<div class="container-fluid d-flex flex-column h-100 p-0">
    <header class="bg-primary text-white text-center p-3">
        <h1 data-aos="fade-down">Aplikasi Faktur Penjualan</h1>
    </header>

    <div class="content-wrapper">
        <nav class="sidebar">
    <h4>Menu</h4>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link active" href="#" data-target-content="home">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-target-content="customer">Data Customer</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-target-content="perusahaan">Data Perusahaan</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-target-content="produk">Data Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-target-content="transaksi">Data Transaksi</a></li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#submenuReports" role="button" aria-expanded="false">
                Laporan
            </a>
            <div class="collapse" id="submenuReports">
                <ul class="nav flex-column ml-3">
                    <li class="nav-item"><a class="nav-link" href="#" data-target-content="report_produk">Laporan Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-target-content="report_penjualan">Laporan Penjualan</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>


        <div class="main-content" id="mainContent" data-aos="fade-left">
            <h2>Selamat Datang</h2>
            <p>Silakan pilih menu di samping untuk mengelola data.</p>
        </div>
    </div>

    <footer>
        &copy; 2025 Aplikasi Faktur Penjualan
    </footer>
</div>

<!-- SCRIPT -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.js"></script>
<script>
    AOS.init();

    function destroyDataTables() {
        $('#mainContent table').each(function () {
            if ($.fn.DataTable && $.fn.DataTable.isDataTable(this)) {
                $(this).DataTable().destroy();
            }
        });
    }

    function loadContent(contentType) {
        let url = '';
        let defaultContent = '';

        destroyDataTables();
        $('#mainContent').off(); // Bersihkan event

        switch (contentType) {
            case 'home':
                defaultContent = '<h2>Selamat Datang</h2><p>Silakan pilih menu di samping untuk mengelola data.</p>';
                $('#mainContent').html(defaultContent);
                return;
            case 'customer': url = 'tampil_customer.php'; break;
            case 'perusahaan': url = 'tampil_perusahaan.php'; break;
            case 'produk': url = 'tampil_produk.php'; break;
            case 'transaksi': url = 'tampil_penjualan.php'; break;
            case 'report_produk': url = 'laporan_produk.php'; break;
            case 'report_penjualan': url = 'laporan_penjualan.php'; break;
            default:
                $('#mainContent').html('<h2>Halaman Tidak Ditemukan</h2>');
                return;
        }

        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function () {
                $('#mainContent').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Memuat data...</p></div>');
            },
            success: function (response) {
                $('#mainContent').html(response);
                setTimeout(() => {
                    $('#mainContent table').each(function () {
                        if (!$.fn.DataTable.isDataTable(this)) {
                            $(this).DataTable();
                        }
                    });
                }, 0);
            },
            error: function (xhr, status, error) {
                $('#mainContent').html('<div class="alert alert-danger">Gagal memuat data.</div>');
            }
        });
    }

    $(document).ready(function () {
        $('.nav-link[data-target-content]').on('click', function (e) {
            e.preventDefault();
            $('.nav-link[data-target-content]').removeClass('active');
            $(this).addClass('active');

            const target = $(this).data('target-content');
            loadContent(target);
        });

        // Tetapkan Beranda saat load pertama
        loadContent('home');

        // Expand submenu jika aktif
        const activeItem = $('.nav-link.active[data-target-content]').data('target-content');
        if (activeItem === 'report_produk' || activeItem === 'report_penjualan') {
            $('#submenuReports').collapse('show');
        }
    });
</script>
</body>
</html>
