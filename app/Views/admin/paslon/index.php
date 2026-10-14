<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Manajemen Paslon<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Data Pasangan Calon<?= $this->endSection() ?>

<!-- MENU SIDEBAR ADMIN -->
<?= $this->section('sidebar_menu') ?>
<?= $this->include('admin/sidebar') ?>
<?= $this->endSection() ?>

<!-- KONTEN UTAMA PASLON -->
<?= $this->section('content') ?>
<div class="space-y-6">

    <!-- Header & Tombol Tambah Data -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-5 rounded-xl border border-slate-200 shadow-sm gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar Pasangan Calon</h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola nomor urut, foto resmi, dan nama calon.</p>
        </div>
        <a href="<?= base_url('admin/paslon/create') ?>" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Paslon</span>
        </a>
    </div>

    <!-- Alert Notifikasi Sukses -->
    <?php if (session()->getFlashdata('success')) : ?>
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

    <!-- Grid Kartu Paslon -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($paslon)): ?>
            <?php foreach ($paslon as $row):
                // Deteksi otomatis Primary Key agar tidak merusak sistem apapun nama kolomnya
                $paslonId = $row['id_paslon'] ?? $row['id'] ?? $row['id_calon'] ?? '';
            ?>
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between hover:border-blue-300 transition">
                    <div>
                        <!-- Badge Nomor Urut & Foto Paslon -->
                        <div class="relative bg-slate-100 h-52 flex items-center justify-center overflow-hidden border-b border-slate-100">
                            <!-- Badge No. Urut -->
                            <div class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow">
                                Nomor Urut <?= esc($row['no_urut'] ?? '-') ?>
                            </div>

                            <!-- Gambar Paslon -->
                            <?php if (!empty($row['foto']) && file_exists('uploads/paslon/' . $row['foto'])): ?>
                                <img src="<?= base_url('uploads/paslon/' . $row['foto']) ?>" alt="Foto Paslon <?= esc($row['no_urut'] ?? '') ?>" class="w-full h-full object-cover object-top">
                            <?php else: ?>
                                <div class="text-center p-4">
                                    <div class="w-16 h-16 bg-slate-200 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-2 font-bold text-xl">
                                        <?= esc($row['no_urut'] ?? '-') ?>
                                    </div>
                                    <span class="text-xs text-slate-400 italic">Foto belum diunggah</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Info Paslon -->
                        <div class="p-5">
                            <div>
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Calon Kepala Desa</span>
                                <h4 class="text-base font-bold text-slate-800 line-clamp-1"><?= esc($row['nama_calon'] ?? '-') ?></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi (Edit & Hapus) -->
                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end space-x-2">
                        <a href="<?= base_url('admin/paslon/edit/' . $paslonId) ?>" class="px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 text-xs font-medium rounded-lg transition inline-flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Edit</span>
                        </a>

                        <button type="button" onclick="confirmDelete('<?= base_url('admin/paslon/delete/' . $paslonId) ?>', '<?= esc($row['nama_calon'] ?? 'Paslon') ?>')" class="px-3 py-1.5 bg-rose-50 border border-rose-200 hover:bg-rose-100 text-rose-600 text-xs font-medium rounded-lg transition inline-flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Hapus</span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full bg-white p-12 text-center rounded-xl border border-slate-200">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h4 class="font-bold text-slate-700">Belum ada Pasangan Calon</h4>
                <p class="text-xs text-slate-400 mt-1 mb-4">Silakan tambahkan data pasangan calon baru untuk memulai.</p>
                <a href="<?= base_url('admin/paslon/create') ?>" class="inline-flex items-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                    + Tambah Paslon
                </a>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 space-y-4">
        <h3 class="text-lg font-bold text-slate-800">Konfirmasi Hapus</h3>
        <p class="text-sm text-slate-600">Apakah Anda yakin ingin menghapus data paslon <strong id="deletePaslonName" class="text-slate-800"></strong>?</p>
        <div class="flex justify-end space-x-3 pt-2">
            <button onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
            <a id="confirmDeleteBtn" href="#" class="px-4 py-2 text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition">Hapus</a>
        </div>
    </div>
</div>

<script>
    function confirmDelete(url, name) {
        document.getElementById('deletePaslonName').innerText = name;
        document.getElementById('confirmDeleteBtn').setAttribute('href', url);
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
<?= $this->endSection() ?>