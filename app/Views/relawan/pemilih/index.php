<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Data Pemilih<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Kelola Data Pemilih<?= $this->endSection() ?>

<?= $this->section('sidebar_menu') ?>
    <?= $this->include('relawan/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<!-- Tailwind CSS via CDN (Online) -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">
    
    <!-- Header Page & Tombol Tambah -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight sm:text-3xl">
                <?= esc($title); ?>
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Daftar pemilih yang telah didata di wilayah Anda.
            </p>
        </div>
        <div>
            <a href="<?= base_url('relawan/pemilih/create'); ?>" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pemilih
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="rounded-2xl bg-emerald-50 p-4 border border-emerald-200/80 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 text-emerald-500">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-emerald-800"><?= session()->getFlashdata('success'); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Table Container Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
        
        <!-- Header Table & Form Pencarian -->
        <div class="p-5 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-gray-900">Daftar Pemilih Terdata</h3>
            
            <form action="<?= base_url('relawan/pemilih'); ?>" method="get" class="flex items-center gap-2">
                <div class="relative rounded-xl shadow-sm min-w-[240px]">
                    <input type="text" name="keyword" value="<?= esc($keyword ?? ''); ?>" placeholder="Cari Nama, NIK, Alamat..." class="w-full pl-3.5 pr-10 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <?php if (!empty($keyword)): ?>
                        <a href="<?= base_url('relawan/pemilih'); ?>" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            &#x2715;
                        </a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="px-4 py-2 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 transition-all">
                    Cari
                </button>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/75">
                    <tr>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama / NIK</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">JK / Usia</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Wilayah (TPS)</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Pemilih</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aspirasi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100 text-sm text-gray-700">
                    <?php if (!empty($pemilih_list)) : ?>
                        <?php 
                            // Menghitung Nomor Urut Sesuai Halaman Paginasi Active
                            $currentPage = (int) ($pager->getCurrentPage('pemilih') ?? 1);
                            $perPage     = (int) ($pager->getPerPage('pemilih') ?? 10);
                            $no          = 1 + ($perPage * ($currentPage - 1));
                        ?>
                        <?php foreach ($pemilih_list as $p) : ?>
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900"><?= $no++; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900"><?= esc($p['nama']); ?></div>
                                    <div class="text-xs text-gray-400 mt-0.5"><?= esc($p['nik'] ?? 'NIK Tidak Ada'); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                    <span class="font-medium text-gray-800"><?= esc($p['jenis_kelamin']); ?></span> 
                                    <?= $p['usia'] ? '<span class="text-gray-400">('.esc($p['usia']).' Thn)</span>' : ''; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-800">
                                    <span>Dusun <?= esc($p['nama_dusun'] ?? '-'); ?></span> 
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-600 ml-1.5 border border-gray-200/60">
                                        TPS <?= esc($p['no_tps'] ?? '-'); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                        $status = $p['status_pemilih'] ?? 'belum_didata';
                                        $badgeClass = match($status) {
                                            'pasti_pilih' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'ragu_ragu'   => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'lawan'       => 'bg-rose-50 text-rose-700 border-rose-200',
                                            default       => 'bg-gray-50 text-gray-600 border-gray-200',
                                        };
                                        $label = match($status) {
                                            'pasti_pilih' => 'Pasti Pilih',
                                            'ragu_ragu'   => 'Ragu-Ragu',
                                            'lawan'       => 'Lawan',
                                            default       => 'Belum Didata',
                                        };
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border <?= $badgeClass; ?>">
                                        <?= $label; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 max-w-xs truncate">
                                    <?= esc($p['keterangan_aspirasi'] ?? '-'); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400 italic">
                                Belum ada data pemilih yang Anda input.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <?php if (!empty($pager)) : ?>
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
                <?= $pager->links('pemilih', 'default_full') ?>
            </div>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection(); ?>