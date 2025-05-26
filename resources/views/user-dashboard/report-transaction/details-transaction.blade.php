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
                <form method="POST" action="/selesai">
                    @csrf
                    <button type="submit" class="finish">
                        {{ $transaction->status == 'unpaid' ? 'Bayar Sekarang' : 'Selesai' }}
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
