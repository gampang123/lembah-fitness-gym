@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Profile Member')

@section('content')
    <section style="margin-top: 40px;">
        <div class="profile-setting">
            <img src="{{ asset('asset/user-profile.svg') }}" alt="Member" class="profile-img-setting">
            <h2>{{ Auth::user()->name }}</h2>
            <p class="email">{{ auth()->user()->email }}</p>
        </div>
    </section>
    <section style="margin-top: 20px;">
        <div class="settings-container">
            <h4>General Settings</h4>

            <div class="setting-item">
                <img src="{{ asset('asset/profile.svg') }}" alt="user icon" class="icon-setting">
                <div class="setting-text">
                    <strong>Nama</strong>
                    <p>{{ Auth::user()->name }}</p>
                </div>
                <span class="arrow">›</span>
            </div>

            <div class="setting-item">
                <img src="{{ asset('asset/mail.svg') }}" alt="mail icon" class="icon-setting">
                <div class="setting-text">
                    <strong>Email</strong>
                    <p>{{ auth()->user()->email }}</p>
                </div>
                <span class="arrow">›</span>
            </div>

            <div class="setting-item">
                <img src="{{ asset('asset/key.svg') }}" alt="key icon" class="icon-setting">
                <div class="setting-text">
                    <strong>Password</strong>
                    <p>********</p>
                </div>
                <span class="arrow">›</span>
            </div>

            <div class="setting-item">
                <img src="{{ asset('asset/phone.svg') }}" alt="phone icon" class="icon-setting">
                <div class="setting-text">
                    <strong>Nomor HP</strong>
                    <p>{{ auth()->user()->phone }}</p>
                </div>
                <span class="arrow">›</span>
            </div>

            <div class="setting-item">
                <img src="{{ asset('asset/calender.svg') }}" alt="calendar icon" class="icon-setting">
                <div class="setting-text">
                    <strong>Bergabung</strong>
                    <p>{{ auth()->user()->created_at }}</p>
                </div>
                <span class="arrow">›</span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="setting-item">
                    <img src="{{ asset('asset/quit.svg') }}" alt="quit icon" class="icon-setting">
                    <div class="setting-text">
                        <strong style="color: white;">Keluar</strong>
                    </div>
                </button>
            </form>

        </div>
    </section>


    <!-- Modal -->
    <div id="modalNama" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('modalNama')">&times;</span>
            <h3 id="modal-title">Edit Nama</h3>

            <form id="modal-form" method="POST" action="{{ route('profile-member.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-save">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Email Modal -->
    <div id="modalEmail" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('modalEmail')">&times;</span>
            <h3 id="modal-title">Edit Email</h3>

            <form method="POST" action="{{ route('profile-member.updateEmail') }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-save">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Modal Password -->
    <div id="modalPassword" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('modalPassword')">&times;</span>
            <h3>Ubah Password</h3>

            <form method="POST" action="{{ route('profile-member.updatePassword') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password">Password Lama</label>
                    <input id="current_password" name="current_password" type="password" placeholder="Password lama"
                        required autocomplete="current-password">
                    @error('current_password')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input id="password" name="password" type="password" placeholder="Password baru" required
                        autocomplete="new-password">
                    @error('password')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        placeholder="Konfirmasi password" required autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-save">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Modal HP -->
    <!-- Modal HP -->
    <div id="modalPhone" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('modalPhone')">&times;</span>
            <h3>Edit Nomor HP</h3>
            <form method="POST" action="{{ route('profile-member.updatePhone') }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="phone">Nomor HP</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                        required>
                    @error('phone')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-save">Simpan</button>
            </form>
        </div>
    </div>


    <script>
        function closeModal(id) {
            document.getElementById(id).style.display = "none";
        }

        function openModal(id) {
            document.getElementById(id).style.display = "flex";
        }

        document.querySelectorAll(".setting-item").forEach((item) => {
            item.addEventListener("click", () => {
                const label = item.querySelector("strong").textContent;

                switch (label) {
                    case "Nama":
                        openModal("modalNama");
                        break;
                    case "Email":
                        openModal("modalEmail");
                        break;
                    case "Password":
                        openModal("modalPassword");
                        break;
                    case "Nomor HP":
                        openModal("modalPhone");
                        break;
                }
            });
        });

        // Klik luar modal tutup
        window.onclick = function(event) {
            document.querySelectorAll(".modal").forEach(modal => {
                if (event.target == modal) modal.style.display = "none";
            });
        };
    </script>


@endsection
