<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pemenangan Kades</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg border border-slate-200 p-8">

        <!-- Tombol Kembali ke Beranda -->
        <div class="mb-4">
            <a href="<?= base_url('/') ?>" class="inline-flex items-center text-xs font-medium text-slate-500 hover:text-blue-600 transition duration-150">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Header / Logo PNG -->
        <div class="text-center mb-6">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo Aplikasi" class="w-16 h-16 mx-auto mb-3 object-contain">
            <h2 class="text-2xl font-bold text-slate-800">Sistem Pemenangan</h2>
            <p class="text-sm text-slate-500 mt-1">Aplikasi Manajemen Pilkades</p>
        </div>

        <!-- Alert Notifikasi Flashdata Error -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form action="<?= base_url('/login/process') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="no_hp" class="block text-sm font-medium text-slate-700 mb-1">Nomor HP / WhatsApp</label>
                <!-- Atribut mobile: inputmode numeric & tel untuk memicu numpad HP -->
                <input type="tel" id="no_hp" name="no_hp" value="<?= old('no_hp') ?>" required placeholder="Contoh: 08123456789"
                    inputmode="numeric"
                    autocomplete="tel"
                    autocorrect="off"
                    autocapitalize="none"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-150 text-slate-800 placeholder-slate-400">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required placeholder="••••••••"
                        autocomplete="current-password"
                        autocorrect="off"
                        autocapitalize="none"
                        class="w-full px-4 py-2.5 pr-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-150 text-slate-800 placeholder-slate-400">

                    <!-- Tombol Toggle Lihat Password -->
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg id="eyeOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eyeClosed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 013.122-.563c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.025 3.582M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                Masuk Ke Akun
            </button>
        </form>

        <!-- Footer Card -->
        <div class="mt-6 text-center text-xs text-slate-400">
            &copy; 2026 Tim Pemenangan Kades. All rights reserved.
        </div>
    </div>

    <!-- Script JS -->
    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');
        const noHpInput = document.getElementById('no_hp');

        // Toggle Password
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        });

        // Hapus otomatis spasi atau karakter non-angka saat pengguna mengetik di HP
        noHpInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    </script>
</body>

</html>