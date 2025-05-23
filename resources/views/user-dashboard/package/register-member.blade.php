@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Daftar Member')

@section('content')

    <section>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <a href="{{ route('package-member.list') }}">
                    <img style="width: 20px;" src="{{ asset('asset/arrow-left .svg') }}" alt="">
                </a>
            </div>
        </div>
    </section>
    <section>
        <h1>Pesanan Saya</h1>
    </section>
    <section style="height: 100vh;">
        <form method="POST" action="/bayar">
            @csrf <!-- jika kamu pakai Laravel -->

            <div style="margin-top: 40px;" class="register-package row text-start">
                <div class="col"><b>Nama</b></div>
                <div class="col">: Fulan bin Fulan
                    <input type="hidden" name="nama" value="Fulan bin Fulan">
                </div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Nama Paket</b></div>
                <div class="col">: Paket 1 Bulan
                    <input type="hidden" name="nama_paket" value="Paket 1 Bulan">
                </div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Jumlah Hari</b></div>
                <div class="col">: 30 Hari
                    <input type="hidden" name="jumlah_hari" value="30">
                </div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Total</b></div>
                <div class="col">: Rp250.000
                    <input type="hidden" name="total" value="250000">
                </div>
            </div>
            <div class="register-package row text-start align-items-center mb-3">
                <div class="col"><b>Metode Pembayaran</b></div>
                <div class="col">: Online Payment
                    <input type="hidden" name="metode_pembayaran" value="Online Payment">
                </div>
            </div>
            <div class="btn-wrapper">
                <button type="submit" class="finish">Bayar</button>
            </div>
        </form>
    </section>


@endsection
