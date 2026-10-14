<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Posko Pilkades</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js Plugins & Core Script -->
    <style>
        /* Mencegah elemen berkedip sebelum Alpine selesai dimuat */
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100 font-sans antialiased text-slate-800">

    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- SIDEBAR OVERLAY (Mobile) -->
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/60 z-40 hidden md:hidden transition-opacity"></div>

        <!-- SIDEBAR NAVIGASI -->
        <aside id="sidebar" class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out w-64 bg-[#0f172a] text-slate-300 z-50 flex flex-col justify-between border-r border-slate-800 flex-shrink-0">
            <div>
                <!-- Brand / Logo Posko Header -->
                <div class="p-4 border-b border-slate-800/80 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo Posko" class="w-9 h-9 object-contain flex-shrink-0">
                        <div>
                            <h1 class="font-bold text-sm text-white tracking-wider uppercase leading-tight">POSKO PILKADES</h1>
                            <span class="inline-block mt-0.5 px-1.5 py-0.5 bg-blue-600/30 text-blue-400 text-[9px] font-extrabold tracking-widest uppercase rounded">
                                SISTEM PEMENANGAN
                            </span>
                        </div>
                    </div>
                    <!-- Close Button Mobile -->
                    <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-white p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Navigasi Menu Sidebar -->
                <nav class="p-3 space-y-1 text-sm font-medium">
                    <?= $this->renderSection('sidebar_menu') ?>
                </nav>
            </div>

            <!-- Widget Logo Paslon di Bawah Sidebar -->
            <div class="p-3 m-3 bg-[#17233d]/60 rounded-xl border border-slate-700/40 flex items-center space-x-3">
                <div class="w-12 h-10 rounded-lg bg-blue-900/40 border border-blue-500/30 flex items-center justify-center text-blue-400 font-black text-[10px] leading-tight text-center uppercase flex-shrink-0 overflow-hidden">
                    <img src="<?= base_url('assets/img/logo-paslon.png') ?>" alt="Logo Paslon" class="w-full h-full object-cover">
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-white truncate">Paslon No. 01</p>
                    <p class="text-[11px] text-slate-400 truncate">Pilkades 2026</p>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT CONTAINER -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Topbar Header -->
            <header class="bg-white border-b border-slate-200 px-4 md:px-6 py-3.5 flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-3">
                    <button onclick="toggleSidebar()" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h2 class="text-base md:text-xl font-bold text-slate-800 tracking-tight truncate">
                        <?= $this->renderSection('header_title') ?>
                    </h2>
                </div>

                <!-- User Profile Bar -->
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-800 leading-snug">
                            <?= session()->get('nama_lengkap') ?? 'Admin Posko' ?>
                        </p>
                        <p class="text-[11px] text-emerald-600 font-semibold tracking-wider uppercase flex items-center justify-end space-x-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span><?= session()->get('role') ?? 'ADMIN' ?></span>
                        </p>
                    </div>

                    <!-- Profile Avatar Icon -->
                    <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 border border-blue-200 flex items-center justify-center font-bold text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>

                    <!-- Tombol Logout -->
                    <a href="<?= base_url('logout') ?>" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Logout">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </a>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-4 md:p-6 overflow-y-auto flex-1">
                <?= $this->renderSection('content') ?>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-200 px-6 py-3 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2">
                <div class="flex items-center space-x-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>&copy; <?= date('Y') ?> Posko Pemenangan Pilkades.</span>
                </div>
                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-500 border border-slate-200">v1.0.0</span>
            </footer>

        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>