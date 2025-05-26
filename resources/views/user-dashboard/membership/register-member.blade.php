@extends('user-dashboard.layouts.menu')

@section('title', 'Konfirmasi Langganan')

@section('content')
    <section>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <a href="{{ route('membership.list') }}">
                    <img style="width: 20px;" src="{{ asset('asset/arrow-left .svg') }}" alt="">
                </a>
            </div>
        </div>
    </section>

    <section>
        <h1>Konfirmasi Pembelian Paket</h1>
    </section>

    <section style="height: 100vh;">
        <form id="transaction-form" enctype="multipart/form-data" onsubmit="return false;">
            @csrf
            {{-- Hidden inputs untuk data paket --}}
            <input type="hidden" name="package_id" value="{{ $package->id }}">
            <input type="hidden" name="nama_paket" value="{{ $package->name }}">
            <input type="hidden" name="jumlah_hari" value="{{ $package->duration_in_days }}">
            <input type="hidden" name="total" value="{{ $package->price }}">

            <div class="register-package row text-start mt-4">
                <div class="col"><b>Nama</b></div>
                <div class="col">: {{ Auth::user()->name }}</div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Nama Paket</b></div>
                <div class="col">: {{ $package->name }}</div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Jumlah Hari</b></div>
                <div class="col">: {{ $package->duration_in_days }} Hari</div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Total</b></div>
                <div class="col">: Rp{{ number_format($package->price, 0, ',', '.') }}</div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Metode Pembayaran</b></div>
                <div class="col">: Online Payment</div>
            </div>

            <div class="btn-wrapper mt-4">
                <button type="submit" id="submit-button" class="finish">Bayar</button>
            </div>
        </form>
    </section>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
document.getElementById('submit-button').addEventListener('click', function () {
    const form = document.getElementById('transaction-form');
    const formData = new FormData(form);

    fetch("{{ route('membership.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => {
        if (response.redirected) {
            window.location.href = response.url;
            return null;
        }
        return response.json();
    })
    .then(data => {
        if (!data) return;

        if (data.snap_token) {
            snap.pay(data.snap_token, {
                onSuccess: function (result) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran berhasil!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = "{{ route('membership.index') }}";
                    });
                },
                onPending: function (result) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pembayaran tertunda',
                        text: 'Silakan selesaikan pembayaran untuk mengaktifkan membership.',
                        showConfirmButton: true,
                    }).then(() => {
                        window.location.href = "{{ route('membership.index') }}";
                    });
                },
                onError: function (result) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan pembayaran',
                        text: 'Silakan coba lagi.',
                    });
                },
                onClose: function () {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pembayaran tertunda',
                        text: 'Popup pembayaran ditutup. Silakan selesaikan pembayaran di menu transaksi untuk mengaktifkan membership.',
                        showConfirmButton: true,
                    }).then(() => {
                        window.location.href = "{{ route('membership.index') }}";
                    });
                }
            });
        } else {
            // Another payment method
            window.location.href = "{{ route('membership.index') }}";
        }
    })
    .catch(error => {
        console.error(error);
        alert("Terjadi kesalahan saat mengirim data.");
    });
});
</script>

@endsection
