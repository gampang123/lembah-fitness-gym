@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Daftar Transaksi</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item">
                        <i class="anticon anticon-home m-r-5"></i>Home
                    </a>
                    <span class="breadcrumb-item active">Daftar Transaksi</span>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <div>
                        <h4>Daftar Transaksi</h4>
                        <p>Tabel ini berisi seluruh data transaksi</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('transaction.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Tambah Transaksi
                        </a>
                        <a href="{{ route('generic.export', ['type' => 'excel', 'model' => 'Transaction']) }}" class="btn btn-success">Export Excel</a>
                        <a href="{{ route('generic.export', ['type' => 'pdf', 'model' => 'Transaction']) }}" class="btn btn-danger">Export PDF</a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif

                <div class="m-t-25 table-responsive">
                    <table id="data-table" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Member</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Status</th>
                                @if(auth()->user()->role_id == 1)
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction as $trx)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $trx->member->user->name }}</td>
                                    <td>{{ $trx->created_at }}</td>
                                    <td>Rp {{ number_format($trx->package->price, 0, ',', '.') }}</td>
                                    <td>{{ $trx->payment_method }}</td>
                                    <td>{{ $trx->status }}</td>
                                    @if(auth()->user()->role_id == 1)
                                    <td>
                                        @if($trx->status === 'pending' && $trx->payment_method === 'online_payment')
                                            <button class="btn btn-warning btn-sm continue-payment-btn" data-snap-token="{{ $trx->midtrans_snap_token }}" title="Lanjutkan Pembayaran">
                                                <i class="fas fa-credit-card"></i>
                                            </button>
                                        @endif

                                        <a href="{{ route('transaction.show', $trx->id) }}" class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-info-circle"></i>
                                        </a>

                                        <form action="{{ route('transaction.destroy', $trx->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus transaksi ini?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

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
