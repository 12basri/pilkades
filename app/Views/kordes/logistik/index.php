<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Kelola Logistik<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Logistik & Distribusi<?= $this->endSection() ?>

<!-- MENU KHUSUS KORDES / KOR-RT -->
<?= $this->section('sidebar_menu') ?>
    <?= $this->include('kordes/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-8">
    
    <!-- Header Page -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                <?= esc($title); ?>
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Pantau ketersediaan barang logistik dan riwayat distribusinya ke setiap wilayah.
            </p>
        </div>
    </div>

    <!-- Alert Flashdata Success -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="rounded-xl bg-green-50 p-4 border border-green-200 shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800"><?= session()->getFlashdata('success'); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Alert Flashdata Error -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="rounded-xl bg-red-50 p-4 border border-red-200 shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 8 0 000 16zm-1-9v4a1 1 0 102 0V9a1 1 0 10-2 0zm0-4a1 1 0 102 0 1 1 0 00-2 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800"><?= session()->getFlashdata('error'); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Section 1: Tabel Stok Logistik -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Stok Logistik Tersedia</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Awal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Tersisa</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                    <?php if (!empty($logistik_list)) : ?>
                        <?php $no = 1; foreach ($logistik_list as $item) : ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900"><?= $no++; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-indigo-600"><?= esc($item['nama_barang']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                    <?= number_format($item['stok_awal'] ?? 0, 0, ',', '.'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <?= number_format($item['stok_tersisa'] ?? 0, 0, ',', '.'); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 italic">Belum ada data barang logistik.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 2: Tabel Riwayat Distribusi -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Distribusi Logistik</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Out</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan Wilayah</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Keluar</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                    <?php if (!empty($distribusi_list)) : ?>
                        <?php $no = 1; foreach ($distribusi_list as $d) : ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900"><?= $no++; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900"><?= esc($d['nama_barang'] ?? '-'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-red-600 font-semibold">
                                    -<?= number_format($d['jumlah'] ?? 0, 0, ',', '.'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?= esc($d['nama_dusun'] ?? '-'); ?> (TPS <?= esc($d['no_tps'] ?? '-'); ?>)
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600"><?= esc($d['nama_petugas'] ?? '-'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                        $status = $d['status'] ?? 'diproses';
                                        $badgeClass = match($status) {
                                            'diterima' => 'bg-emerald-100 text-emerald-800',
                                            'dikirim'  => 'bg-blue-100 text-blue-800',
                                            default    => 'bg-amber-100 text-amber-800',
                                        };
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $badgeClass ?>">
                                        <?= ucfirst(esc($status)) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500"><?= esc($d['tanggal_distribusi'] ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 italic">Belum ada riwayat pengeluaran/distribusi barang.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>