<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Dashboard Relawan<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Dashboard Relawan Lapangan<?= $this->endSection() ?>

<!-- MENU KHUSUS RELAWAN -->
<?= $this->section('sidebar_menu') ?>
    <?= $this->include('relawan/sidebar') ?>
<?= $this->endSection() ?>

<!-- CONTENT DASHBOARD RELAWAN -->
<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header Banner / Informasi Wilayah Tugas -->
    <div class="bg-gradient-to-r from-blue-700 to-blue-500 rounded-2xl p-6 text-white shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 bg-blue-800/50 px-3 py-1 rounded-full text-xs font-medium text-blue-100 mb-2 border border-blue-400/30">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Wilayah Tugas: Dusun <?= esc($wilayah['nama_dusun'] ?? '-'); ?> - TPS <?= esc($wilayah['no_tps'] ?? '-'); ?>
            </div>
            <h2 class="text-2xl font-bold">Selamat Bertugas, Relawan!</h2>
            <p class="text-blue-100 text-sm mt-1">
                Fokus pada verifikasi status pendukung dan pendataan pemilih di wilayah target Anda.
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="<?= base_url('relawan/pemilih/create') ?>" class="px-4 py-2.5 bg-white text-blue-700 font-semibold rounded-xl text-sm shadow hover:bg-blue-50 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                + Pendataan Pemilih Baru
            </a>
        </div>
    </div>

    <!-- Ringkasan Target & Capaian Relawan -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        
        <!-- Target Pemilih TPS -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Target TPS</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1"><?= esc($target_pemilih ?? 0); ?> Orang</h4>
                <p class="text-xs text-slate-500 mt-1 font-medium">Target perolehan suara TPS</p>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>

        <!-- Terdata Memilih (Pasti Pilih) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600">Pasti Pilih</p>
                <h4 class="text-2xl font-bold text-emerald-600 mt-1"><?= esc($terdata_memilih ?? 0); ?> Orang</h4>
                <p class="text-xs text-emerald-700/80 mt-1 font-medium">✓ Basis Suara Terkunci</p>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Perlu Kunjungan Ulang / Ragu-Ragu -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-600">Ragu-Ragu</p>
                <h4 class="text-2xl font-bold text-amber-600 mt-1"><?= esc($perlu_kunjungan ?? 0); ?> Orang</h4>
                <p class="text-xs text-amber-700/80 mt-1 font-medium">Perlu pendekatan ulang</p>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- Section Aksi & Daftar Pemilih Terbaru -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Panel Aksi Cepat Lapangan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
            <h3 class="text-base font-bold text-slate-800">Menu Lapangan Relawan</h3>
            <p class="text-xs text-slate-500">Aksi cepat untuk penginputan data dan navigasi:</p>

            <div class="space-y-3 pt-2">
                <a href="<?= base_url('relawan/pemilih/create') ?>" class="flex items-center justify-between p-3.5 rounded-xl border border-blue-100 bg-blue-50/40 hover:bg-blue-50 transition group">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-sm">+</div>
                        <div>
                            <p class="text-sm font-semibold text-blue-900">Input Pemilih Baru</p>
                            <p class="text-xs text-blue-600">Form pendataan & pilihan suara</p>
                        </div>
                    </div>
                    <span class="text-blue-600 group-hover:translate-x-0.5 transition-transform">→</span>
                </a>

                <a href="<?= base_url('relawan/pemilih') ?>" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50 transition group">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Lihat Semua Data</p>
                            <p class="text-xs text-slate-500">Daftar pemilih di wilayah TPS Anda</p>
                        </div>
                    </div>
                    <span class="text-slate-400 group-hover:text-slate-600">→</span>
                </a>
            </div>
        </div>

        <!-- Tabel Pemilih Terakhir Diinput -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Pemilih Terdaftar Terakhir</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Catatan verifikasi terbaru dari kunjungan Anda</p>
                    </div>
                    <a href="<?= base_url('relawan/pemilih') ?>" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Lihat Semua →</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase">Nama / NIK</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase">JK / Usia</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase">Status Pemilih</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            <?php if (!empty($pemilih_terbaru)) : ?>
                                <?php foreach ($pemilih_terbaru as $p) : ?>
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-slate-800"><?= esc($p['nama'] ?? 'Tanpa Nama'); ?></div>
                                            <div class="text-xs text-slate-400">NIK: <?= esc($p['nik'] ?? 'Tidak Ada'); ?></div>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-slate-600">
                                            <span class="font-medium text-slate-800"><?= esc($p['jenis_kelamin'] ?? '-'); ?></span>
                                            <?= !empty($p['usia']) ? '('.esc($p['usia']).' Thn)' : ''; ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php 
                                                $status = $p['status_pemilih'] ?? 'belum_didata';
                                                switch ($status) {
                                                    case 'pasti_pilih':
                                                        $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                                                        $label = '✓ Pasti Pilih';
                                                        break;
                                                    case 'ragu_ragu':
                                                        $badgeClass = 'bg-amber-50 text-amber-700 border-amber-100';
                                                        $label = '? Ragu-Ragu';
                                                        break;
                                                    case 'lawan':
                                                        $badgeClass = 'bg-rose-50 text-rose-700 border-rose-100';
                                                        $label = '✕ Lawan';
                                                        break;
                                                    default:
                                                        $badgeClass = 'bg-slate-100 text-slate-600 border-slate-200';
                                                        $label = 'Belum Didata';
                                                        break;
                                                }
                                            ?>
                                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium border <?= $badgeClass ?>">
                                                <?= esc($label); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-slate-400 italic">Belum ada data pemilih yang diinput. Klik "+ Pendataan Pemilih Baru" untuk memulai.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer & Pagination -->
            <?php if (!empty($pager)) : ?>
                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <div class="text-xs text-slate-500">
                        Menampilkan data terbaru
                    </div>
                    <div class="pagination-container text-xs">
                        <?= $pager->links('default', 'tailwind_pagination') ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>

</div>
<?= $this->endSection() ?>