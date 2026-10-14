<div class="px-4 py-6 space-y-6">
    <!-- Navigation Menu -->
    <nav class="space-y-1.5">
        <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Menu Utama</p>

        <!-- Dashboard -->
        <a href="<?= base_url('relawan/dashboard') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors <?= uri_string() == 'relawan/dashboard' || uri_string() == 'relawan' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <!-- Data Pemilih -->
        <a href="<?= base_url('relawan/pemilih') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors <?= uri_string() == 'relawan/pemilih' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Data Pemilih
        </a>

        <!-- Form Tambah Pemilih Baru -->
        <a href="<?= base_url('relawan/pemilih/tambah') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors <?= uri_string() == 'relawan/pemilih/tambah' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            + Input Pemilih Baru
        </a>
    </nav>
</div>