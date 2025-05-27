<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('common/css/verifikasi.css') }}">


<div class="login-container">
    <div class="mb-4 text-sm text-gray-600">
        Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi email Anda dengan mengklik tautan yang baru saja
        kami kirim.
        Jika Anda belum menerima email, kami akan dengan senang hati mengirimkan ulang.
    </div>

    @if (session('status') === 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            Tautan verifikasi baru telah dikirim ke alamat email Anda.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <button>
                    Kirim Ulang Email Verifikasi
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit">
                Logout
            </button>
        </form>
    </div>
</div>
