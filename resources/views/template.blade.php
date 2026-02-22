@php
    use Illuminate\Support\Facades\DB;

    $jumlahRestok = DB::table('data_barang')
        ->whereColumn('jumlah', '<=', 'min_stok')
        ->where('status', 1)
        ->count();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
   

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

        .sidebar a.active {
            background: #16355f;
            font-weight: bold;
            border-left: 4px solid #ffffff;
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
        <a href="{{ route('dashboard') }}" 
        class="{{ Route::is('dashboard') ? 'active' : '' }}">
            <i class="bi-house"></i> Dashboard
        </a>

        <a href="{{ route('penjualan.index') }}" 
        class="{{ Route::is('penjualan.*') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i> Penjualan
        </a>

        <a href="{{ route('barang.index') }}" 
        class="{{ Route::is('barang.*') ? 'active' : '' }}">
            <i class="bi bi-box"></i> Barang
        </a>

        <a href="{{ route('pembelian.index') }}" 
            class="{{ Route::is('pembelian.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-repeat"></i> Pembelian

                @if($jumlahRestok > 0)
                    <span class="badge bg-danger ms-2">
                        {{ $jumlahRestok }}
                    </span>
                @endif
        </a>

        <a href="{{ route('deadstock.index') }}" 
        class="{{ Route::is('deadstock.*') ? 'active' : '' }}">
            <i class="bi bi-archive"></i> Dead Stock
        </a>

        <a href="{{ route('kategori.index') }}" 
        class="{{ Route::is('kategori.*') ? 'active' : '' }}">
            <i class="bi-grid"></i> Kategori
        </a>
    </div>

   <div class="logout">
        <a href="#" class="text-danger fw-bold" 
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

</div>

<div class="content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
