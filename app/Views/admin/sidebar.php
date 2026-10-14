<?php
// Helper closure untuk mengecek route aktif (termasuk sub-route / child URI)
$activeClass = function ($path) {
    $currentUri = uri_string();
    return ($currentUri === $path || str_starts_with($currentUri, $path . '/'))
        ? 'bg-blue-600 text-white font-semibold shadow-sm'
        : 'text-slate-400 hover:bg-slate-800 hover:text-white';
};
?>

<a href="<?= base_url('admin/dashboard') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg <?= $activeClass('admin/dashboard') ?> transition">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
    </svg>
    <span>Dashboard Admin</span>
</a>

<a href="<?= base_url('admin/users') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg <?= $activeClass('admin/users') ?> transition">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
    <span>Manajemen Users</span>
</a>

<a href="<?= base_url('admin/paslon') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg <?= $activeClass('admin/paslon') ?> transition">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
    </svg>
    <span>Data Paslon</span>
</a>

<a href="<?= base_url('admin/wilayah') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg <?= $activeClass('admin/wilayah') ?> transition">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
    <span>Wilayah / Target</span>
</a>

<a href="<?= base_url('admin/pemilih') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg <?= $activeClass('admin/pemilih') ?> transition">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
    </svg>
    <span>Data Pemilih</span>
</a>

<a href="<?= base_url('admin/logistik') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg <?= $activeClass('admin/logistik') ?> transition">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
    </svg>
    <span>Logistik & Stok</span>
</a>

<a href="<?= base_url('admin/hasil-tps') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg <?= $activeClass('admin/hasil-tps') ?> transition">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span>Validasi C1 / Hasil TPS</span>
</a>