<!-- Top Navigation Bar / Header -->
<header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
        
        <!-- Logo & Title -->
        <a href="<?= base_url('/') ?>" class="flex items-center space-x-3 group flex-shrink-0">
            <!-- Logo PNG Sesuai Kode Asli -->
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo Posko" class="w-9 h-9 object-contain">
            <div>
                <h1 class="font-bold text-slate-900 leading-tight">POSKO PILKADES</h1>
                <p class="text-[10px] text-slate-500 font-semibold tracking-wider uppercase">Sistem Pemenangan</p>
            </div>
        </a>
        
        <!-- Navigation Menu (Desktop Center) -->
        <nav class="hidden md:flex items-center space-x-1">
            <!-- Menu Beranda -->
            <a href="<?= base_url('/') ?>" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-colors <?= uri_string() == '' || uri_string() == '/' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Beranda</span>
            </a>

            <!-- Menu Data Paslon -->
          <!--   <a href="<?= base_url('paslon') ?>" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-colors <?= uri_string() == 'paslon' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>Data Paslon</span>
            </a>

            <!-- Menu Informasi -->
            <!-- <a href="<?= base_url('informasi') ?>" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-colors <?= uri_string() == 'informasi' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Informasi</span>
            </a>  -->
        </nav>

        <!-- Right Action Button (Desktop Only) -->
        <div class="hidden md:flex items-center flex-shrink-0">
            <a href="<?= base_url('login') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                <span>Login</span>
            </a>
        </div>

    </div>

    <!-- Mobile Navigation Bar -->
    <div class="md:hidden border-t border-slate-100 bg-slate-50/80 px-4 py-2 flex items-center justify-between gap-2 overflow-x-auto text-xs font-medium">
        <div class="flex items-center space-x-1.5">
            <!-- Mobile Menu Beranda -->
            <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg whitespace-nowrap transition <?= uri_string() == '' || uri_string() == '/' ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-200' ?>">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Beranda</span>
            </a>

            <!-- Mobile Menu Data Paslon -->
           <!--  <a href="<?= base_url('paslon') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg whitespace-nowrap transition <?= uri_string() == 'paslon' ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-200' ?>">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>Data Paslon</span>
            </a> -->

            <!-- Mobile Menu Informasi -->
            <!-- <a href="<?= base_url('informasi') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg whitespace-nowrap transition <?= uri_string() == 'informasi' ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-200' ?>">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Informasi</span>
            </a> -->
        </div>

        <!-- Tombol Login untuk Tampilan Mobile -->
        <a href="<?= base_url('login') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white font-semibold rounded-lg whitespace-nowrap flex-shrink-0 shadow-sm active:scale-95 transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            <span>Login</span>
        </a>
    </div>
</header>