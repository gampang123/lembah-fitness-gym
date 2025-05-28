@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Tambah Transaksi</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Tambah Transaksi</span>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>Form Transaksi</h4>
                <div class="m-t-25">
                    <form id="transaction-form" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Pilih Member</label>
                            <div class="col-sm-10">
                                <select name="member_id" class="form-control">
                                    <option value="">-- Pilih Member --</option>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}">{{ $member->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Pilih Paket</label>
                            <div class="col-sm-10">
                                <select name="package_id" class="form-control">
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->name }} - Rp{{ number_format($package->price) }}</option>
                                    @endforeach
                                </select>
                                @error('package_id')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Metode Pembayaran</label>
                            <div class="col-sm-10">
                                <select name="payment_method" class="form-control">
                                    <option value="">-- Pilih Metode --</option>
                                    <option value="cash">Cash</option>
                                    <option value="online_payment">Online Payment(VA,Transfer,QRIS, E-Wallet, Dll)</option>
                                </select>
                                @error('payment_method')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <a href="{{ route('transaction.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="button" id="submit-button" class="btn btn-primary">Simpan Transaksi</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script> -->

<!-- <script>
document.getElementById('submit-button').addEventListener('click', function () {
    const form = document.getElementById('transaction-form');
    const formData = new FormData(form);
    const paymentMethod = formData.get('payment_method');

    fetch("{{ route('transaction.store') }}", {
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

        if (paymentMethod === 'online_payment' && data.snap_token) {
            snap.pay(data.snap_token, {
                onSuccess: function (result) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran berhasil!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = "{{ route('transaction.index') }}";
                    });
                },
                onPending: function (result) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pembayaran tertunda',
                        text: 'Silakan selesaikan pembayaran untuk mengaktifkan membership.',
                        showConfirmButton: true,
                    }).then(() => {
                        window.location.href = "{{ route('transaction.index') }}";
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
                        text: 'Popup pembayaran ditutup. Silakan selesaikan pembayaran untuk mengaktifkan membership.',
                        showConfirmButton: true,
                    }).then(() => {
                        window.location.href = "{{ route('transaction.index') }}";
                    });
                }
            });
        } else {
            // Another payment method
            window.location.href = "{{ route('transaction.index') }}";
        }
    })
    .catch(error => {
        console.error(error);
        alert("Terjadi kesalahan saat mengirim data.");
    });
});
</script> -->

<script>
    document.getElementById('submit-button').addEventListener('click', function () {
    const form = document.getElementById('transaction-form');
    const formData = new FormData(form);
    const paymentMethod = formData.get('payment_method');

    fetch("{{ route('transaction.store') }}", {
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

        if (paymentMethod === 'online_payment' && data.redirect_url) {
            window.location.href = data.redirect_url;
        } else {
            // Cash or other methods
            window.location.href = "{{ route('transaction.index') }}";
        }
    })
    .catch(error => {
        console.error(error);
        alert("Terjadi kesalahan saat mengirim data.");
    });
});

</script>

@endsection
