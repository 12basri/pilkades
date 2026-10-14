<aside class="w-full md:w-64 bg-slate-900 text-slate-300 flex-shrink-0">
    <!-- Brand / Logo -->
    <div class="p-4 border-b border-slate-800 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-indigo-600 rounded-lg text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="font-bold text-lg text-white tracking-wide">POSKO PILKADES</span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-1 text-sm font-medium">
        <?php $role = session()->get('role') ?? 'admin'; ?>

        <!-- 1. DASHBOARD (All Roles) -->
        <a href="<?= base_url($role . '/dashboard') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg bg-indigo-600 text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- 2. DATA PEMILIH (Admin, Kordes, Kor-RT, Relawan) -->
        <?php if (in_array($role, ['admin', 'kordes', 'kor_rt', 'relawan'])): ?>
        <a href="<?= base_url($role . '/pemilih') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span>Data Pemilih</span>
        </a>
        <?php endif; ?>

        <!-- 3. LOGISTIK & DISTRIBUSI (Tabel: logistik & distribusi_logistik) -->
        <?php if (in_array($role, ['admin', 'kordes', 'relawan'])): ?>
        <a href="<?= base_url($role . '/logistik') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <span>Logistik & Distribusi</span>
        </a>
        <?php endif; ?>

        <!-- 4. HASIL TPS / REAL COUNT (Tabel: hasil_tps) -->
        <?php if (in_array($role, ['admin', 'kordes', 'saksi'])): ?>
        <a href="<?= base_url($role . '/hasil-tps') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 022 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span>Hasil TPS / C1</span>
        </a>
        <?php endif; ?>

        <!-- 5. WILAYAH / DUSUN & RT (Tabel: wilayah) - Khusus Admin & Kordes -->
        <?php if (in_array($role, ['admin', 'kordes'])): ?>
        <a href="<?= base_url($role . '/wilayah') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>Data Wilayah</span>
        </a>
        <?php endif; ?>

        <!-- 6. PASLON (Tabel: paslon) - Khusus Admin -->
        <?php if ($role === 'admin'): ?>
        <a href="<?= base_url('admin/paslon') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Data Paslon</span>
        </a>

        <!-- 7. MANAJEMEN USER / TIM (Tabel: users) - Khusus Admin -->
        <a href="<?= base_url('admin/users') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span>Pengguna / Tim</span>
        </a>
        <?php endif; ?>
    </nav>
</aside>