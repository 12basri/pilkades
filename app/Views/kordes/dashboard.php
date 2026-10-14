<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Dashboard Kordes<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Dashboard Kordes / Kor-RT<?= $this->endSection() ?>

<!-- MENU KHUSUS KORDES / KOR-RT -->
<?= $this->section('sidebar_menu') ?>
    <?= $this->include('kordes/sidebar') ?>
<?= $this->endSection() ?>

<!-- CONTENT DASHBOARD KORDES -->
<?= $this->section('content') ?>
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-7xl mx-auto space-y-6 py-2">

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-indigo-700 to-indigo-500 rounded-2xl p-6 text-white shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold">Selamat Datang, Koordinator Dusun</h2>
            <p class="text-indigo-100 text-sm mt-1">
                Pantau pergerakan basis suara, pengelolaan pemilih, dan distribusi logistik di wilayah tanggung jawab Anda.
            </p>
        </div>
        <div class="flex items-center space-x-3 shrink-0">
            <a href="<?= base_url('kordes/pemilih/tambah') ?>" class="px-4 py-2.5 bg-white text-indigo-700 font-semibold rounded-xl text-sm shadow hover:bg-indigo-50 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pemilih
            </a>
        </div>
    </div>

    <!-- Summary KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Pemilih Terdata -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Pemilih</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1"><?= esc($total_pemilih ?? 0) ?></h4>
                <p class="text-xs text-emerald-600 mt-1 font-medium">✓ Terdata di Wilayah</p>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>

        <!-- Target Suara -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Target Suara</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1"><?= esc($target_suara ?? 0) ?></h4>
                <p class="text-xs text-slate-500 mt-1 font-medium">Capaian: <span class="font-bold text-indigo-600"><?= esc($persentase_target ?? 0) ?>%</span></p>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>

        <!-- Relawan Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Relawan Aktif</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1"><?= esc($total_relawan ?? 0) ?></h4>
                <p class="text-xs text-indigo-600 mt-1 font-medium">Bertugas di Lapangan</p>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>

        <!-- Logistik Masuk -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Logistik Masuk</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1"><?= esc($total_logistik ?? 0) ?></h4>
                <p class="text-xs text-slate-500 mt-1 font-medium">Item Terdistribusi</p>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- Section Dua Kolom: Quick Action & Progress Pemilih Terbaru -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Navigasi Pintas -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Menu Kerja Utama</h3>
                <p class="text-xs text-slate-500 mt-0.5">Akses cepat ke tugas harian Kordes / Kor-RT:</p>
            </div>

            <div class="space-y-3 pt-2">
                <a href="<?= base_url('kordes/pemilih') ?>" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 hover:border-indigo-200 hover:bg-indigo-50/50 transition group">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm shrink-0">1</div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 group-hover:text-indigo-600 transition">Data Pemilih</p>
                            <p class="text-xs text-slate-500">Kelola & verifikasi basis suara</p>
                        </div>
                    </div>
                    <span class="text-slate-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-transform">→</span>
                </a>

                <a href="<?= base_url('kordes/logistik') ?>" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 hover:border-amber-200 hover:bg-amber-50/50 transition group">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center font-bold text-sm shrink-0">2</div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 group-hover:text-amber-600 transition">Pantau Logistik</p>
                            <p class="text-xs text-slate-500">Cek penerimaan & pembagian</p>
                        </div>
                    </div>
                    <span class="text-slate-400 group-hover:text-amber-600 group-hover:translate-x-1 transition-transform">→</span>
                </a>

                <a href="<?= base_url('kordes/wilayah') ?>" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition group">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-sm shrink-0">3</div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 group-hover:text-emerald-600 transition">Wilayah Kerja</p>
                            <p class="text-xs text-slate-500">Pemetaan Dusun & TPS</p>
                        </div>
                    </div>
                    <span class="text-slate-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>
        </div>

        <!-- Tabel Pemilih Terbaru -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Pemilih Terdaftar Baru</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar pemilih yang baru diinput di wilayah Anda</p>
                    </div>
                    <a href="<?= base_url('kordes/pemilih') ?>" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">Lihat Semua →</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Dusun / TPS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Relawan Input</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            <?php if (!empty($pemilih_terbaru)) : ?>
                                <?php foreach ($pemilih_terbaru as $p) : ?>
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-6 py-4 font-semibold text-slate-800"><?= esc($p['nama'] ?? 'Tanpa Nama') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs">
                                            <?= esc($p['nama_dusun'] ?? '-') ?> / TPS <?= esc($p['no_tps'] ?? '-') ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php 
                                                $statusKey = $p['status_pilihan'] ?? 'belum_didata';
                                                
                                                switch ($statusKey) {
                                                    case 'pasti_pilih':
                                                        $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                                                        $label = 'Pasti Pilih';
                                                        break;
                                                    case 'ragu_ragu':
                                                        $badgeClass = 'bg-amber-50 text-amber-700 border-amber-100';
                                                        $label = 'Ragu-Ragu';
                                                        break;
                                                    case 'lawan':
                                                        $badgeClass = 'bg-rose-50 text-rose-700 border-rose-100';
                                                        $label = 'Lawan';
                                                        break;
                                                    default:
                                                        $badgeClass = 'bg-slate-100 text-slate-600 border-slate-200';
                                                        $label = 'Belum Didata';
                                                        break;
                                                }
                                            ?>
                                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium border <?= $badgeClass ?>">
                                                <?= esc($label) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-slate-500 text-xs"><?= esc($p['nama_relawan'] ?? 'Kordes') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400 italic">Belum ada data pemilih terbaru di wilayah ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
<?= $this->endSection() ?>