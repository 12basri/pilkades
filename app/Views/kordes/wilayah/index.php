<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Data Wilayah<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Wilayah & Target Suara<?= $this->endSection() ?>

<!-- MENU KHUSUS KORDES / KOR-RT -->
<?= $this->section('sidebar_menu') ?>
    <?= $this->include('kordes/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-6">
    
    <!-- Header Page -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                <?= esc($title); ?>
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Informasi pembagian wilayah Dusun, TPS, dan pencapaian target suara yang terdaftar dalam sistem.
            </p>
        </div>
    </div>

    <!-- Alert Flashdata -->
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

    <!-- Table Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Wilayah & Progress Suara</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Dusun</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. TPS</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pemilih</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target Suara</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasti Pilih</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress Target</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                    <?php if (!empty($wilayah_list)) : ?>
                        <?php $no = 1; foreach ($wilayah_list as $w) : ?>
                            <?php 
                                $target = (int)($w['target_suara'] ?? 0);
                                $pasti  = (int)($w['pasti_pilih'] ?? 0);
                                $persen = $target > 0 ? min(100, round(($pasti / $target) * 100)) : 0;
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900"><?= $no++; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-indigo-600">
                                    Dusun <?= esc($w['nama_dusun'] ?? '-'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">
                                    TPS <?= esc($w['no_tps'] ?? '-'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                    <?= number_format($w['total_pemilih'] ?? 0, 0, ',', '.'); ?> Orang
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-semibold">
                                    <?= number_format($target, 0, ',', '.'); ?> Suara
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-emerald-600 font-semibold">
                                    <?= number_format($pasti, 0, ',', '.'); ?> Suara
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 max-w-[100px] mb-1">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: <?= $persen; ?>%"></div>
                                    </div>
                                    <span class="text-xs text-gray-500 font-medium"><?= $persen; ?>% Tercapai</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 italic">Belum ada data wilayah.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>