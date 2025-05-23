@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Package')

@section('content')

    <section>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <a href="{{ route('package-member.index') }}">
                    <img style="width: 20px;" src="{{ asset('asset/arrow-left .svg') }}" alt="">
                </a>
            </div>
        </div>
    </section>
    <section>
        <h1>Pesanan Saya</h1>
    </section>
    <section>
        <div style="margin-top: 40px;" class="register-package row text-start">
            <div class="col"><b>Nama</b></div>
            <div class="col">: Fulan bin Fulan</div>
        </div>
        <div class="register-package row text-start">
            <div class="col"><b>Nama Paket</b></div>
            <div class="col">: Paket 1 Bulan</div>
        </div>
        <div class="register-package row text-start">
            <div class="col"><b>Jumlah Hari</b></div>
            <div class="col">: 30 Hari</div>
        </div>
        <div class="register-package row text-start">
            <div class="col"><b>Total</b></div>
            <div class="col">: Rp250.000</div>
        </div>
        <div class="register-package row text-start align-items-center mb-3">
            <div class="col-md-3"><b>Metode Pembayaran</b></div>
            <div class="col-md-9">
                <select class="form-select" name="payment_method" required>
                    <option value="" disabled selected>Pilih metode</option>
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer (TF)</option>
                </select>
            </div>
        </div>
        <div class="btn-wrapper">
            <button class="finish">Selesai</button>
        </div>

    </section>

@endsection
