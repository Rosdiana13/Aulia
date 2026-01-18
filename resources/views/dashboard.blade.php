@extends('template')

@section('title','Dashboard')

@section('content')

@if(session('login_success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Berhasil!</strong> {{ session('login_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <div class="alert alert-success">
        Selamat Datang, <strong>{{ Auth::user()->nama_pengguna }}</strong>! 
        Anda masuk sebagai <strong>{{ Auth::user()->jabatan }}</strong>.
    </div>

    <script>
    // Gunakan fungsi ini agar script menunggu seluruh halaman siap
    window.onload = function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(function() {
                // Tambahkan class 'fade' dari Bootstrap untuk animasi halus
                alert.classList.add('fade');
                // Tunggu 500ms (durasi animasi fade) baru hapus dari layar
                setTimeout(() => alert.remove(), 500);
            }, 3000); // Tampil selama 3 detik
        }
    };
</script>
@endsection



