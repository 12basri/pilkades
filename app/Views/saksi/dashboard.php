<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Dashboard Saksi<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Panel Saksi TPS<?= $this->endSection() ?>

<!-- MENU KHUSUS SAKSI (SIDEBAR) -->
<?= $this->section('sidebar_menu') ?>
<div class="px-4 py-6 space-y-6">
    <nav class="space-y-1.5">
        <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Menu Saksi</p>

        <!-- Dashboard Saksi -->
        <a href="<?= base_url('saksi/dashboard') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors <?= uri_string() == 'saksi/dashboard' || uri_string() == 'saksi' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <!-- Input Suara & Foto C1 -->
        <a href="<?= base_url('saksi/hasil-tps') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors <?= uri_string() == 'saksi/hasil-tps' || uri_string() == 'saksi/input-hasil' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Input Suara & Foto C1
        </a>
    </nav>
</div>
<?= $this->endSection() ?>

<!-- CONTENT DASHBOARD SAKSI -->
<?= $this->section('content') ?>
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-7xl mx-auto space-y-6">

    <!-- Information Banner -->
    <div class="bg-gradient-to-r from-indigo-700 to-indigo-500 rounded-2xl p-6 text-white shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 bg-indigo-800/50 px-3 py-1 rounded-full text-xs font-medium text-indigo-100 mb-2 border border-indigo-400/30">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Wilayah Tugas: TPS <?= esc($tps_info['no_tps'] ?? $tps_info['nomor_tps'] ?? '01'); ?> - <?= esc($tps_info['nama_dusun'] ?? $tps_info['dusun'] ?? '-'); ?>
            </div>
            <h2 class="text-2xl font-bold">Selamat Datang, Saksi TPS!</h2>
            <p class="text-indigo-100 text-sm mt-1">
                Pastikan seluruh perhitungan perolehan suara paslon dan unggah dokumen Form C1 dilakukan secara akurat.
            </p>
        </div>
        <div>
            <a href="<?= base_url('saksi/hasil-tps') ?>" class="px-4 py-2.5 bg-white text-indigo-700 font-semibold rounded-xl text-sm shadow hover:bg-indigo-50 transition inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Input Perolehan Suara
            </a>
        </div>
    </div>

    <!-- Status Input Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        
        <!-- Status Input C1 -->
        <?php 
            $isSubmitted = in_array(strtolower($status_input ?? ''), ['sudah input', 'terkirim', 'selesai', 'verified']);
            $textStatusColor = $isSubmitted ? 'text-emerald-600' : 'text-amber-600';
            $bgStatusColor = $isSubmitted ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600';
        ?>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Status Laporan C1</p>
                <h4 class="text-lg font-bold mt-1 <?= $textStatusColor ?>">
                    <?= esc($status_input ?? 'Belum Input'); ?>
                </h4>
                <p class="text-xs text-slate-500 mt-0.5">Kondisi data TPS saat ini</p>
            </div>
            <div class="p-3 <?= $bgStatusColor ?> rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Total Paslon -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Paslon Terdaftar</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1"><?= esc($total_paslon ?? 0); ?> Paslon</h4>
                <p class="text-xs text-indigo-600 mt-0.5">Kandidat Pemilihan</p>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>

        <!-- Lokasi TPS -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Lokasi Penugasan</p>
                <h4 class="text-lg font-bold text-slate-800 mt-1">TPS <?= esc($tps_info['no_tps'] ?? $tps_info['nomor_tps'] ?? '01'); ?></h4>
                <p class="text-xs text-slate-500 mt-0.5">
                    <?= esc($tps_info['nama_dusun'] ?? $tps_info['dusun'] ?? '-'); ?>
                    <?= !empty($tps_info['rt_rw']) ? ' (' . esc($tps_info['rt_rw']) . ')' : ''; ?>
                </p>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- Quick Action / Direct Section -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-bold text-slate-800">Laporan C1 & Hasil Suara TPS</h3>
            <p class="text-xs text-slate-500 mt-1">Klik tombol di samping untuk mulai mengisi lembar perolehan suara dan mengunggah foto bukti Form C1.</p>
        </div>
        <a href="<?= base_url('saksi/hasil-tps') ?>" class="w-full sm:w-auto px-5 py-3 bg-indigo-600 text-white font-medium text-sm rounded-xl shadow hover:bg-indigo-700 transition text-center whitespace-nowrap">
            Entry Hasil TPS Sekarang &rarr;
        </a>
    </div>

</div>
<?= $this->endSection() ?>