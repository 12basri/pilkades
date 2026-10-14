<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Kelola Logistik<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Inventaris & Stok Logistik Posko<?= $this->endSection() ?>

<?= $this->section('sidebar_menu') ?>
<?= $this->include('admin/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
// Perhitungan statistik berdasarkan kolom database yang benar ('jumlah' dan 'status')
$totalJumlahBarang = array_reduce($logistik ?? [], function ($carry, $item) {
    $val = is_array($item) ? ($item['jumlah'] ?? 0) : ($item->jumlah ?? 0);
    return $carry + (int)$val;
}, 0);

$totalStokAwal = array_reduce($logistik ?? [], function ($carry, $item) {
    $status = is_array($item) ? ($item['status'] ?? '') : ($item->status ?? '');
    $jumlah = is_array($item) ? ($item['jumlah'] ?? 0) : ($item->jumlah ?? 0);
    return $carry + ($status === 'stok_awal' ? (int)$jumlah : 0);
}, 0);

$totalDikirim = array_reduce($logistik ?? [], function ($carry, $item) {
    $status = is_array($item) ? ($item['status'] ?? '') : ($item->status ?? '');
    $jumlah = is_array($item) ? ($item['jumlah'] ?? 0) : ($item->jumlah ?? 0);
    return $carry + ($status === 'dikirim' ? (int)$jumlah : 0);
}, 0);

$totalDiterima = array_reduce($logistik ?? [], function ($carry, $item) {
    $status = is_array($item) ? ($item['status'] ?? '') : ($item->status ?? '');
    $jumlah = is_array($item) ? ($item['jumlah'] ?? 0) : ($item->jumlah ?? 0);
    return $carry + ($status === 'diterima' ? (int)$jumlah : 0);
}, 0);
?>

<div class="space-y-6">

    <!-- Ringkasan Statistik Logistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">Total Items / Jenis</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1"><?= count($logistik ?? []) ?></h4>
            </div>
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold">
                📦
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">Total Stok Awal Posko</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1">
                    <?= number_format($totalStokAwal) ?>
                </h4>
            </div>
            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center font-bold">
                📊
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">Dalam Pengiriman</p>
                <h4 class="text-2xl font-bold text-amber-600 mt-1">
                    <?= number_format($totalDikirim) ?>
                </h4>
            </div>
            <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center font-bold">
                🚚
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">Diterima di Wilayah</p>
                <h4 class="text-2xl font-bold text-emerald-600 mt-1">
                    <?= number_format($totalDiterima) ?>
                </h4>
            </div>
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center font-bold">
                ✅
            </div>
        </div>
    </div>

    <!-- Header Control Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar Inventaris & Distribusi Logistik</h3>
            <p class="text-xs text-slate-500">Pantau ketersediaan kaus, spanduk, kalender, dan distribusi atribut kampanye.</p>
        </div>

        <button type="button" onclick="openLogistikModal('create')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Logistik
        </button>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm">
            <ul class="list-disc list-inside space-y-1">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Table Section -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs border-b border-slate-200">
                    <tr>
                        <th class="p-4">No</th>
                        <th class="p-4">Nama Barang</th>
                        <th class="p-4 text-center">Jumlah</th>
                        <th class="p-4">Tujuan / Wilayah</th>
                        <th class="p-4 text-center">Status Logistik</th>
                        <th class="p-4">Keterangan</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($logistik)): ?>
                        <?php $i = 1;
                        foreach ($logistik as $l): ?>
                            <?php
                            $id = is_array($l) ? ($l['id_logistik'] ?? '') : ($l->id_logistik ?? '');
                            $namaBarang = is_array($l) ? ($l['nama_barang'] ?? '-') : ($l->nama_barang ?? '-');
                            $jumlah = is_array($l) ? ($l['jumlah'] ?? 0) : ($l->jumlah ?? 0);
                            $idWilayah = is_array($l) ? ($l['id_wilayah'] ?? '') : ($l->id_wilayah ?? '');
                            $namaDusun = is_array($l) ? ($l['nama_dusun'] ?? '-') : ($l->nama_dusun ?? '-');
                            $status = is_array($l) ? ($l['status'] ?? 'stok_awal') : ($l->status ?? 'stok_awal');
                            $keterangan = is_array($l) ? ($l['keterangan'] ?? '') : ($l->keterangan ?? '');
                            ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4 text-slate-500"><?= $i++ ?></td>
                                <td class="p-4 font-semibold text-slate-800">
                                    <?= esc($namaBarang) ?>
                                </td>
                                <td class="p-4 text-center font-bold text-slate-800 font-mono text-base">
                                    <?= number_format($jumlah) ?>
                                </td>
                                <td class="p-4 text-slate-600">
                                    <?= !empty($idWilayah) ? esc($namaDusun) : '<span class="text-slate-400 italic">Posko Utama</span>' ?>
                                </td>
                                <td class="p-4 text-center">
                                    <?php if ($status === 'diterima'): ?>
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            Diterima
                                        </span>
                                    <?php elseif ($status === 'dikirim'): ?>
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                            Dikirim
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                            Stok Awal
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-slate-500 text-xs">
                                    <?= !empty($keterangan) ? esc($keterangan) : '-' ?>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button"
                                            data-id="<?= $id ?>"
                                            data-nama="<?= esc($namaBarang) ?>"
                                            data-jumlah="<?= $jumlah ?>"
                                            data-wilayah="<?= $idWilayah ?>"
                                            data-status="<?= $status ?>"
                                            data-keterangan="<?= esc($keterangan) ?>"
                                            onclick="editLogistik(this)"
                                            class="px-2.5 py-1.5 text-xs bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg font-medium transition">
                                            Edit
                                        </button>

                                        <a href="<?= base_url('admin/logistik/delete/' . $id) ?>"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus barang <?= esc($namaBarang, 'js') ?>?')"
                                            class="px-2.5 py-1.5 text-xs bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg font-medium transition">
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">Belum ada data barang logistik.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form (Tambah / Edit Logistik) -->
<div id="logistikModal" class="fixed inset-0 bg-slate-900/50 hidden backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl border border-slate-200 w-full max-w-md overflow-hidden">
        <div class="flex justify-between items-center p-5 border-b border-slate-100">
            <h4 id="logistikModalTitle" class="font-bold text-slate-800">Tambah Logistik</h4>
            <button type="button" onclick="closeLogistikModal()" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
        </div>

        <form id="logistikForm" action="<?= base_url('admin/logistik/store') ?>" method="POST" class="p-5 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" id="logistik_id" name="id_logistik">

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Nama Barang / Atribut</label>
                <input type="text" name="nama_barang" id="l_nama_barang" required
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                    placeholder="Contoh: Kaus Paslon Size L, Spanduk 3x1">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Jumlah</label>
                <input type="number" name="jumlah" id="l_jumlah" required min="0"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                    placeholder="100">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Wilayah Tujuan (Opsional)</label>
                <select name="id_wilayah" id="l_id_wilayah" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">-- Posko Utama (Tanpa Wilayah) --</option>
                    <?php if (!empty($wilayah)): ?>
                        <?php foreach ($wilayah as $w): ?>
                            <option value="<?= is_array($w) ? $w['id_wilayah'] : $w->id_wilayah ?>">
                                <?= esc(is_array($w) ? $w['nama_dusun'] : $w->nama_dusun) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Status Logistik</label>
                <select name="status" id="l_status" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="stok_awal">Stok Awal</option>
                    <option value="dikirim">Dikirim</option>
                    <option value="diterima">Diterima</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Keterangan</label>
                <textarea name="keterangan" id="l_keterangan" rows="2"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                    placeholder="Catatan tambahan..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeLogistikModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Control Script -->
<script>
    function openLogistikModal(mode) {
        const modal = document.getElementById('logistikModal');
        const form = document.getElementById('logistikForm');
        const title = document.getElementById('logistikModalTitle');

        modal.classList.remove('hidden');

        if (mode === 'create') {
            title.innerText = 'Tambah Logistik';
            form.action = "<?= base_url('admin/logistik/store') ?>";
            form.reset();
            document.getElementById('logistik_id').value = '';
        }
    }

    function editLogistik(button) {
        const modal = document.getElementById('logistikModal');
        const form = document.getElementById('logistikForm');
        const title = document.getElementById('logistikModalTitle');

        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const jumlah = button.getAttribute('data-jumlah');
        const wilayah = button.getAttribute('data-wilayah');
        const status = button.getAttribute('data-status');
        const keterangan = button.getAttribute('data-keterangan');

        modal.classList.remove('hidden');
        title.innerText = 'Edit Logistik';
        form.action = "<?= base_url('admin/logistik/update') ?>/" + id;

        document.getElementById('logistik_id').value = id;
        document.getElementById('l_nama_barang').value = nama;
        document.getElementById('l_jumlah').value = jumlah;
        document.getElementById('l_id_wilayah').value = wilayah;
        document.getElementById('l_status').value = status;
        document.getElementById('l_keterangan').value = keterangan;
    }

    function closeLogistikModal() {
        document.getElementById('logistikModal').classList.add('hidden');
    }
</script>
<?= $this->endSection() ?>