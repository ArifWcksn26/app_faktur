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
            height: 100vh;
            margin: 0;
        }
        .content {
            flex: 1;
            display: flex;
            overflow: auto;
        }
        .sidebar {
            width: 250px;
            background: #f8f9fa;
            padding: 15px;
            border-right: 1px solid #dee2e6;
        }
        .main {
            flex: 1;
            padding: 15px;
            background: #ffffff;
        }
        header {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        footer {
            background: #f1f1f1;
            padding: 10px;
            position: relative;
            bottom: -330px;
            width: 100%;
        }
        .transition {
            transition: all 0.3s ease;
        }

        .fade-in {
            opacity: 0;
            transition: opacity 0.5s ease-in;
        }

        .fade-in.active {
            opacity: 1;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <header class="bg-primary text-white text-center p-3">
        <h1>Aplikasi Faktur Penjualan</h1>
    </header>

    <div class="content">
        <nav class="sidebar">
            <h4>Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tampil_customer.php">Data Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tampil_perusahaan.php">Data Perusahaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tampil_produk.php">Data Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tampil_penjualan.php">Data Transaksi</a>
                </li>                
            </ul>
        </nav>

        <div class="main">
            <h2>Selamat Datang</h2>
            <p>Silakan pilih menu di samping untuk mengelola data.</p>
        </div>
    </div>

    <footer class="text-center">
        &copy; 2025 Aplikasi Faktur Penjualan
    </footer>
</div>

<style>
.fade-in {
    opacity: 0;
    transition: opacity 0.5s ease-in;
}

.fade-in.active {
    opacity: 1;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const elements = document.querySelectorAll('.fade-in');
    elements.forEach(el => {
        el.classList.add('active');
    });
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>

