@extends('layouts.app')

@section('title', 'Presensi Member')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Sesi Member Aktif</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Daftar Sesi Member Aktif</span>
                </nav>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <h4 class="mb-2">Presensi Member</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#scanModal">Scan Barcode</button>
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#manualModal">Presensi Manual</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Member</th>
                                <th>Scan In</th>
                                <th>Waktu Aktif</th>
                                @if(auth()->user()->role_id == 1)
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presences as $index => $presence)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $presence->member->user->name }}</td>
                                <td>{{ $presence->scan_in_at }}</td>
                                <td class="realtime-duration" data-scan="{{ \Carbon\Carbon::parse($presence->scan_in_at)->format('Y-m-d H:i:s') }}">
                                @if(auth()->user()->role_id == 1)
                                <td>
                                    <form action="{{ route('presence.close', $presence->id) }}" method="POST" onsubmit="return confirm('Akhiri sesi ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Akhiri</button>
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

<!-- Modal Scan Barcode -->
<div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="qr-form" action="{{ route('presence.scan.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Scan Barcode</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="stopScanner()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <div id="reader" style="width: 100%; max-width: 500px; margin: auto;"></div>
          <input type="hidden" name="barcode" id="barcode">

          <div id="scan-notification" class="mt-3"></div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Presensi Manual -->
<div class="modal fade" id="manualModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="manual-form" action="{{ route('presence.manual.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Presensi Manual (Input Barcode)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="text" name="barcode" class="form-control" placeholder="Masukkan kode barcode" required>
                    <div id="manual-notification" class="mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Presensi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
  let html5QrcodeScanner;
  let isScanning = false;

  $('#scanModal').on('shown.bs.modal', function () {
    if (!html5QrcodeScanner) {
      html5QrcodeScanner = new Html5Qrcode("reader");
    }
    html5QrcodeScanner.start(
      { facingMode: "environment" },
      {
        fps: 10,
        qrbox: { width: 250, height: 250 }
      },
      (decodedText) => {
        if (isScanning) return;

        isScanning = true;
        $('#barcode').val(decodedText);

        $.ajax({
          url: "{{ route('presence.scan.store') }}",
          method: 'POST',
          data: $('#qr-form').serialize(),
          success: function(response) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: response.message ?? 'Presensi berhasil!',
              timer: 2500,
              timerProgressBar: true,
              showConfirmButton: false,
            });
          },
          error: function(xhr) {
            let errMsg = 'Terjadi kesalahan.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
              errMsg = xhr.responseJSON.message;
            } else if (xhr.responseText) {
              try {
                const res = JSON.parse(xhr.responseText);
                errMsg = res.message || errMsg;
              } catch (e) {}
            }
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: errMsg
            });
          },
          complete: function() {
            setTimeout(() => {
              isScanning = false;
            }, 3000);
          }
        });
      },
      (errorMessage) => {
        // Ignore scan errors (optional)
      }
    ).then(() => {
      console.log("Camera started successfully");
    }).catch(err => {
      console.error("Failed to start camera:", err);
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal mengakses kamera. Pastikan izin kamera sudah diberikan.'
      });
    });
  });

  function stopScanner() {
    if (html5QrcodeScanner) {
      html5QrcodeScanner.stop().then(() => {
        html5QrcodeScanner.clear();
      }).catch(err => {
        console.error("Failed to stop camera:", err);
      });
    }
  }

  $('#scanModal').on('hidden.bs.modal', function () {
    stopScanner();
    isScanning = false;
  });

  $('#manual-form').submit(function(e) {
    e.preventDefault();

    let form = $(this);
    let url = form.attr('action');
    let data = form.serialize();

    $.ajax({
      url: url,
      method: 'POST',
      data: data,
      success: function(response) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: response.message ?? 'Presensi berhasil!',
          timer: 2500,
          timerProgressBar: true,
          showConfirmButton: false,
        });
        form[0].reset();
      },
      error: function(xhr) {
        let errMsg = 'Terjadi kesalahan.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errMsg = xhr.responseJSON.message;
        } else if (xhr.responseText) {
          try {
            const res = JSON.parse(xhr.responseText);
            errMsg = res.message || errMsg;
          } catch (e) {}
        }
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: errMsg
        });
      }
    });
  });

  function updateDurations() {
        const elements = document.querySelectorAll('.realtime-duration');

        elements.forEach(el => {
            const scanInTime = new Date(el.dataset.scan);
            const now = new Date();
            const diffMs = now - scanInTime;

            if (diffMs < 0) {
                el.textContent = "Belum dimulai";
                return;
            }

            const totalSeconds = Math.floor(diffMs / 1000);
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            el.textContent = `${hours} Jam ${minutes} Menit ${seconds} Detik`;
        });
    }

    setInterval(updateDurations, 1000); // Update tiap detik
    updateDurations();
</script>
@endsection
