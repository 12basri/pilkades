<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Manajemen Wilayah<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Kelola Wilayah Penugasan<?= $this->endSection() ?>

<?= $this->section('sidebar_menu') ?>
<?= $this->include('admin/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <!-- Header & Action Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Pemetaan Wilayah (Dusun & TPS)</h3>
            <p class="text-xs text-slate-500 mt-0.5">Daftar wilayah operasional dan target perolehan suara per TPS.</p>
        </div>
        <button onclick="openModal('create')" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition inline-flex items-center gap-2 shadow-sm">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Wilayah</span>
        </button>
    </div>

    <!-- Alert Sukses -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Alert Validasi Error General -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm">
            <p class="font-bold mb-1">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside space-y-1">
                <?php foreach ((array) session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Search Form Filter -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
        <form action="<?= base_url('admin/wilayah') ?>" method="GET" class="w-full sm:w-80 flex gap-2">
            <div class="relative w-full">
                <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Cari Dusun atau No. TPS..." class="w-full pl-9 pr-4 py-2 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <button type="submit" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">Cari</button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('admin/wilayah') ?>" class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold rounded-lg transition flex items-center">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs border-b border-slate-200">
                    <tr>
                        <th class="p-4">Nama Dusun</th>
                        <th class="p-4">No. TPS</th>
                        <th class="p-4">Target Suara</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($wilayah)): ?>
                        <?php foreach ($wilayah as $w):
                            $wilayahId = $w['id_wilayah'] ?? $w['id'] ?? '';
                        ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4 font-semibold text-slate-800"><?= esc($w['nama_dusun']) ?></td>
                                <td class="p-4 text-slate-600">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                        TPS <?= esc($w['no_tps']) ?>
                                    </span>
                                </td>
                                <td class="p-4 font-bold text-blue-600"><?= number_format($w['target_suara'], 0, ',', '.') ?> <span class="text-xs font-normal text-slate-500">Suara</span></td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Tombol Edit -->
                                        <button onclick="openModal('edit', <?= htmlspecialchars(json_encode(array_merge($w, ['id_wilayah' => $wilayahId])), ENT_QUOTES, 'UTF-8') ?>)"
                                            class="px-3 py-1.5 text-xs bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 rounded-lg font-medium transition inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button onclick="confirmDelete('<?= base_url('admin/wilayah/delete/' . $wilayahId) ?>', '<?= esc($w['nama_dusun']) ?>', '<?= esc($w['no_tps']) ?>')"
                                            class="px-3 py-1.5 text-xs bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 rounded-lg font-medium transition inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400">
                                <?= !empty($search) ? 'Tidak ada wilayah yang sesuai dengan pencarian.' : 'Belum ada data wilayah.' ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form (Tambah / Edit Wilayah) -->
<div id="wilayahModal" class="fixed inset-0 bg-slate-900/50 hidden backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl border border-slate-200 w-full max-w-md overflow-hidden">
        <div class="flex justify-between items-center p-5 border-b border-slate-100">
            <h4 id="modalTitle" class="font-bold text-slate-800">Tambah Wilayah</h4>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
        </div>

        <form id="wilayahForm" action="<?= base_url('admin/wilayah/store') ?>" method="POST" class="p-5 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" id="wilayah_id" name="id_wilayah" value="<?= old('id_wilayah') ?>">

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Nama Dusun <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_dusun" id="input_nama_dusun" value="<?= old('nama_dusun') ?>" required
                    class="w-full px-3.5 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    placeholder="Contoh: Dusun Lombok">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Nomor TPS <span class="text-rose-500">*</span></label>
                <input type="number" name="no_tps" id="input_no_tps" value="<?= old('no_tps') ?>" required min="1"
                    class="w-full px-3.5 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    placeholder="Contoh: 1">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Target Suara <span class="text-rose-500">*</span></label>
                <input type="number" name="target_suara" id="input_target_suara" value="<?= old('target_suara') ?>" required min="0"
                    class="w-full px-3.5 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    placeholder="Contoh: 150">
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 space-y-4">
        <h3 class="text-lg font-bold text-slate-800">Konfirmasi Hapus</h3>
        <p class="text-sm text-slate-600">Apakah Anda yakin ingin menghapus data wilayah <strong id="deleteWilayahName" class="text-slate-800"></strong>?</p>
        <div class="flex justify-end space-x-3 pt-2">
            <button onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
            <a id="confirmDeleteBtn" href="#" class="px-4 py-2 text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition">Hapus</a>
        </div>
    </div>
</div>

<!-- JavaScript Kontrol Modal -->
<script>
    function openModal(mode, data = null) {
        const modal = document.getElementById('wilayahModal');
        const form = document.getElementById('wilayahForm');
        const title = document.getElementById('modalTitle');

        modal.classList.remove('hidden');

        if (mode === 'edit' && data) {
            title.innerText = 'Edit Data Wilayah';
            form.action = "<?= base_url('admin/wilayah/update') ?>/" + data.id_wilayah;

            document.getElementById('wilayah_id').value = data.id_wilayah;
            document.getElementById('input_nama_dusun').value = data.nama_dusun;
            document.getElementById('input_no_tps').value = data.no_tps;
            document.getElementById('input_target_suara').value = data.target_suara;
        } else {
            title.innerText = 'Tambah Wilayah Baru';
            form.action = "<?= base_url('admin/wilayah/store') ?>";
            form.reset();
            document.getElementById('wilayah_id').value = '';
        }
    }

    function closeModal() {
        document.getElementById('wilayahModal').classList.add('hidden');
    }

    function confirmDelete(url, dusun, tps) {
        document.getElementById('deleteWilayahName').innerText = `${dusun} (TPS ${tps})`;
        document.getElementById('confirmDeleteBtn').setAttribute('href', url);
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Otomatis Buka Modal Jika Ada Validation Error
    <?php if (session()->getFlashdata('errors')): ?>
        document.addEventListener("DOMContentLoaded", function() {
            const oldId = "<?= old('id_wilayah') ?>";
            if (oldId) {
                openModal('edit', {
                    id_wilayah: oldId,
                    nama_dusun: "<?= esc(old('nama_dusun')) ?>",
                    no_tps: "<?= esc(old('no_tps')) ?>",
                    target_suara: "<?= esc(old('target_suara')) ?>"
                });
            } else {
                openModal('create');
            }
        });
    <?php endif; ?>
</script>
<?= $this->endSection() ?>