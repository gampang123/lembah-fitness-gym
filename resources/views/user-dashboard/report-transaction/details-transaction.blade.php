@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Detail Transaksi')

@section('content')
    <section>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <a href="{{ route('report-transaction-member.index') }}">
                    <img style="width: 20px;" src="{{ asset('asset/arrow-left .svg') }}" alt="Back">
                </a>
            </div>
        </div>
    </section>

    <section class="transaction-detail">
        <div class="transaction-card">

            {{-- Ribbon Status --}}
            <div class="ribbon">
                <span
                    style="
        background-color: 
            {{ $transaction->status == 'paid' ? '#28a745' : ($transaction->status == 'pending' ? '#ffc107' : '#e74c3c') }};
        color: {{ $transaction->status == 'pending' ? 'black' : 'white' }};
        text-transform: uppercase;">
                    {{ $transaction->status ?? 'UNPAID' }}
                </span>
            </div>


            <!-- Logo -->
            <div class="logo-wrapper">
                <img src="{{ asset('asset/logo-circle.svg') }}" alt="Logo" />
            </div>

            <!-- Informasi Pembayaran -->
            <div class="payment-info">
                <p class="label">Pembayaran via</p>
                <p class="value">Online Payment</p>
                <p class="label">Jumlah Pembayaran</p>
                <p class="amount">
                    Rp{{ number_format($transaction->total_payment ?? ($transaction->package->price ?? 0), 0, ',', '.') }}
                </p>
            </div>

            <!-- Detail Transaksi -->
            <div style="margin-top: 40px;" class="register-package row text-start">
                <div class="col"><b>Nama</b></div>
                <div class="col">: {{ $transaction->member->user->name ?? '-' }}
                    <input type="hidden" name="nama" value="{{ $transaction->member->user->name ?? '-' }}">
                </div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Nama Paket</b></div>
                <div class="col">: {{ $transaction->package->name ?? '-' }}
                    <input type="hidden" name="nama_paket" value="{{ $transaction->package->name ?? '-' }}">
                </div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Jumlah Hari</b></div>
                <div class="col">: {{ $transaction->package->duration_in_days ?? '-' }} Hari
                    <input type="hidden" name="jumlah_hari" value="{{ $transaction->package->duration ?? '-' }}">
                </div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Total</b></div>
                <div class="col">:
                    Rp{{ number_format($transaction->total_payment ?? ($transaction->package->price ?? 0), 0, ',', '.') }}
                    <input type="hidden" name="total" value="{{ $transaction->total_payment ?? 0 }}">
                </div>
            </div>

            <!-- Tombol -->
            <div class="btn-wrapper mt-4">
                @if($transaction->status === 'pending' && $transaction->payment_method === 'online_payment')
                    <button class="finish continue-payment-btn" data-snap-token="{{ $transaction->midtrans_snap_token }}" title="Lanjutkan Pembayaran">
                        Lanjutkan Pembayaran
                    </button>
                @endif
            </div>
        </div>
    </section>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
document.querySelectorAll('.continue-payment-btn').forEach(button => {
    button.addEventListener('click', function() {
        const snapToken = this.getAttribute('data-snap-token');
        if (!snapToken) {
            alert('Token pembayaran tidak tersedia.');
            return;
        }

        snap.pay(snapToken, {
            onSuccess: function(result) {
                alert('Pembayaran berhasil!');
                window.location.reload();
            },
            onPending: function(result) {
                alert('Pembayaran tertunda. Silakan selesaikan pembayaran Anda.');
                window.location.reload();
            },
            onError: function(result) {
                alert('Terjadi kesalahan pembayaran.');
            },
            onClose: function() {
                alert('Popup pembayaran ditutup.');
            }
        });
    });
});
</script>
@endsection
