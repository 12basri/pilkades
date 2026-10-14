<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Pendataan Pemilih - Kordes<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Pendataan Pemilih Wilayah<?= $this->endSection() ?>

<!-- Layout Menampilkan Sidebar Kordes -->
<?= $this->section('sidebar_menu') ?>
    <?= $this->include('kordes/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar Pemilih Wilayah Anda</h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola data pemilih dan pemetaan suara khusus di tingkat Kordes / Kor-RT.</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-2">
            <!-- Dropdown Export Data -->
            <div class="relative inline-block text-left" x-data="{ open: false }">
                <button @click="open = !open" 
                        @click.away="open = false" 
                        type="button" 
                        class="px-3.5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Export</span>
                    <svg class="w-3.5 h-3.5 ml-0.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Submenu Export -->
                <div x-show="open" 
                     x-cloak
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 z-50 py-1">
                    
                    <a href="<?= site_url('kordes/pemilih/exportExcel') ?>" @click="open = false" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-emerald-600">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Export Excel (.xlsx)
                    </a>
                    <a href="<?= site_url('kordes/pemilih/exportPdf') ?>" target="_blank" @click="open = false" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-rose-600">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Export PDF (.pdf)
                    </a>
                    <a href="<?= site_url('kordes/pemilih/exportCsv') ?>" @click="open = false" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-indigo-600">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002-2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
                        Export CSV (.csv)
                    </a>
                </div>
            </div>

            <!-- Tombol Tambah Pemilih -->
            <a href="<?= site_url('kordes/pemilih/create') ?>" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Pemilih</span>
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 font-bold">&times;</button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 font-bold">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Table Header Filter / Search -->
        <div class="p-4 border-b border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row gap-3 justify-between items-center">
            <form action="<?= site_url('kordes/pemilih') ?>" method="get" class="w-full flex flex-col sm:flex-row gap-3">
                <div class="relative w-full sm:w-72">
                    <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari Nama / NIK / Alamat..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-medium transition">
                    Filter
                </button>
                <?php if (!empty($keyword)): ?>
                    <a href="<?= site_url('kordes/pemilih') ?>" class="px-3.5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-medium transition text-center">
                        Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs border-b border-slate-200">
                    <tr>
                        <th class="p-4 font-semibold">Nama Pemilih</th>
                        <th class="p-4 font-semibold">NIK / Gender / Usia</th>
                        <th class="p-4 font-semibold">Wilayah & TPS</th>
                        <th class="p-4 font-semibold">Status Pemilih</th>
                        <th class="p-4 font-semibold">Aspirasi</th>
                        <th class="p-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($pemilih)): ?>
                        <?php foreach ($pemilih as $p): ?>
                            <!-- Mencegah error 'id' dengan null coalescing ke 'id_pemilih' -->
                            <?php $idPilih = $p['id_pemilih'] ?? $p['id'] ?? null; ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4">
                                    <div class="font-semibold text-slate-800"><?= esc($p['nama'] ?? '-') ?></div>
                                    <div class="text-xs text-slate-400 mt-0.5">
                                        <?= esc($p['alamat'] ?? 'Alamat belum diisi') ?>
                                    </div>
                                </td>
                                <td class="p-4 text-slate-600">
                                    <div class="font-mono text-xs font-medium text-slate-700"><?= esc($p['nik'] ?? '-') ?></div>
                                    <div class="text-xs text-slate-400 mt-0.5">
                                        <?= (($p['jenis_kelamin'] ?? '') === 'L') ? 'Laki-laki' : ((($p['jenis_kelamin'] ?? '') === 'P') ? 'Perempuan' : '-') ?> 
                                        <?= !empty($p['usia']) ? ' • ' . esc($p['usia']) . ' Thn' : '' ?>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="text-xs font-medium text-slate-700">
                                        <?= esc($p['nama_dusun'] ?? '-') ?>
                                    </div>
                                    <span class="inline-block mt-1 px-2.5 py-0.5 text-xs bg-slate-100 text-slate-700 font-semibold rounded-md border border-slate-200">
                                        TPS <?= esc($p['no_tps'] ?? '-') ?>
                                    </span>
                                </td>
                                <td class="p-4">
                                    <?php 
                                        $status = $p['status_pemilih'] ?? '';
                                        $statusClass = match($status) {
                                            'pasti_pilih' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                            'ragu_ragu'   => 'bg-amber-100 text-amber-800 border-amber-200',
                                            'lawan'       => 'bg-rose-100 text-rose-800 border-rose-200',
                                            default       => 'bg-slate-100 text-slate-600 border-slate-200',
                                        };

                                        $statusLabel = match($status) {
                                            'pasti_pilih' => 'Pasti Pilih',
                                            'ragu_ragu'   => 'Ragu-Ragu',
                                            'lawan'       => 'Lawan',
                                            default       => 'Belum Didata',
                                        };
                                    ?>
                                    <span class="inline-block px-2.5 py-1 text-xs font-medium rounded-full border <?= $statusClass ?>">
                                        <?= $statusLabel ?>
                                    </span>
                                </td>
                                <td class="p-4 text-slate-600 max-w-xs truncate" title="<?= esc($p['keterangan_aspirasi'] ?? '') ?>">
                                    <?= esc(!empty($p['keterangan_aspirasi']) ? $p['keterangan_aspirasi'] : '-') ?>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= site_url('kordes/pemilih/edit/' . $idPilih) ?>" class="inline-flex items-center px-3 py-1.5 bg-slate-100 hover:bg-indigo-50 text-slate-700 hover:text-indigo-600 rounded-lg text-xs font-medium transition">
                                            Edit
                                        </a>

                                        <!-- Form Delete -->
                                        <form action="<?= site_url('kordes/pemilih/delete/' . $idPilih) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pemilih ini?');" class="inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-slate-100 hover:bg-rose-50 text-slate-700 hover:text-rose-600 rounded-lg text-xs font-medium transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                Belum ada data pemilih yang terdaftar di wilayah Anda.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <?php if (!empty($pager)): ?>
            <div class="p-4 border-t border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-slate-500">
                    Menampilkan data pemilih
                </div>
                <div class="flex items-center gap-1">
                    <?= $pager->links('pemilih', 'default_full') ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

</div>
<?= $this->endSection() ?>