@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Profile Member')

@section('content')
    <section style="margin-top: 40px;">
        <div class="profile-setting">
            <img src="{{ asset('asset/user.svg') }}" alt="Member" class="profile-img-setting">
            <h2>Anna Suarez</h2>
            <p class="email">hello@reallygreatsite.com</p>
        </div>
    </section>
    <section style="margin-top: 20px;">
        <div class="settings-container">
            <h4>General Settings</h4>

            <div class="setting-item">
                <img src="{{ asset('asset/profile.svg') }}" alt="user icon" class="icon-setting">
                <div class="setting-text">
                    <strong>Nama</strong>
                    <p>Fulan bin Fulan</p>
                </div>
                <span class="arrow">›</span>
            </div>

            <div class="setting-item">
                <img src="{{ asset('asset/mail.svg') }}" alt="mail icon" class="icon-setting">
                <div class="setting-text">
                    <strong>Email</strong>
                    <p>hello@reallygreatsite.com</p>
                </div>
                <span class="arrow">›</span>
            </div>

            <div class="setting-item">
                <img src="{{ asset('asset/key.svg') }}" alt="key icon" class="icon-setting">
                <div class="setting-text">
                    <strong>Password</strong>
                    <p>**********</p>
                </div>
                <span class="arrow">›</span>
            </div>

            <div class="setting-item">
                <img src="{{ asset('asset/phone.svg') }}" alt="phone icon" class="icon-setting">
                <div class="setting-text">
                    <strong>Nomor HP</strong>
                    <p>89898989898989</p>
                </div>
                <span class="arrow">›</span>
            </div>

            <div class="setting-item">
                <img src="{{ asset('asset/calender.svg') }}" alt="calendar icon" class="icon-setting">
                <div class="setting-text">
                    <strong>Bergabung</strong>
                    <p>01 November 1999</p>
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
            <h3 id="modal-title">Edit</h3>
            <form id="modal-form">
                <div class="form-group">
                    <label for="modal-input-1" id="label1">Nama</label>
                    <input type="text" id="modal-input-1" name="input1" required>
                </div>
                <button type="submit" class="btn-save">Save</button>
            </form>
        </div>
    </div>
    <!-- Email Modal -->
    <div id="modalEmail" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('modalEmail')">&times;</span>
            <h3 id="modal-title">Edit</h3>
            <form id="modal-form">
                <div class="form-group" id="group-email">
                    <label for="modal-input-2" id="label2">Email</label>
                    <input type="email" id="modal-input-2" name="input2">
                </div>
                <button type="submit" class="btn-save">Save</button>
            </form>
        </div>
    </div>
    <!-- Modal Password -->
    <div id="modalPassword" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('modalPassword')">&times;</span>
            <h3>Ubah Password</h3>
            <form>
                <div class="form-group">
                    <label>Password Lama</label>
                    <input type="password" placeholder="Password lama">
                </div>
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" placeholder="Password baru">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" placeholder="Konfirmasi password">
                </div>
                <button type="submit" class="btn-save">Simpan</button>
            </form>
        </div>
    </div>
    <!-- Modal HP -->
    <div id="modalPhone" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('modalPhone')">&times;</span>
            <h3>Edit Nomor HP</h3>
            <form>
                <div class="form-group">
                    <label>Nomor HP</label>
                    <input type="text" placeholder="Masukkan nomor HP">
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

        // Klik masing-masing item
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
