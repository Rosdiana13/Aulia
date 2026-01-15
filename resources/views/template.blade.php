<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f5f6fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #1F447A;
            position: fixed;
            display: flex;
            flex-direction: column;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
        }

        .sidebar a:hover {
            background: #16355f;
        }

        .sidebar .menu {
            flex: 1;
        }

        .logout {
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .logo img {
            max-height: 80px;
        }
    </style>
</head>
<body>

<div class="sidebar">

    <!-- Logo -->
    <div class="logo text-center py-3 border-bottom">
        <img src="{{ asset('storage/images/Logo_AuliaWhite.png') }}" class="img-fluid">
        <div class="text-white mt-2 fw-bold">Toko Aulia</div>
    </div>

    <!-- Menu -->
    <div class="menu">
        <a href="/penjualan"><i class="bi bi-cash-stack"></i> Penjualan</a>
        <a href="/barang"><i class="bi bi-box"></i> Tambah Barang</a>
        <a href="/restok"><i class="bi bi-arrow-repeat"></i> Restok</a>
        <a href="/laporan"><i class="bi bi-file-earmark-text"></i> Laporan Penjualan</a>
    </div>

    <!-- Logout -->
    <div class="logout">
        <a href="/logout" class="text-danger fw-bold">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
    </div>

</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>
