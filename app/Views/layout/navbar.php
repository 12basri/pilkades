<header class="bg-white border-b border-slate-200 py-4 px-6 flex justify-between items-center shadow-sm">
    <h2 class="text-lg font-semibold text-slate-800">Ringkasan Pemenangan</h2>
    <div class="flex items-center gap-4">
        <div class="text-right">
            <p class="text-sm font-medium text-slate-800"><?= esc($nama_user ?? 'Admin') ?></p>
            <p class="text-xs text-slate-500 capitalize">Administrator</p>
        </div>
        <a href="<?= base_url('/logout') ?>" class="px-3 py-1.5 text-xs font-medium text-red-600 border border-red-200 rounded-md hover:bg-red-50 transition">
            Keluar
        </a>
    </div>
</header>