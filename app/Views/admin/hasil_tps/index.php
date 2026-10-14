<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Hasil Perhitungan TPS<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Hasil TPS & Verifikasi Form C1<?= $this->endSection() ?>

<?= $this->section('sidebar_menu') ?>
<?= $this->include('admin/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <!-- Header Control Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Laporan Perolehan Suara TPS</h3>
            <p class="text-xs text-slate-500">Rekapitulasi perolehan suara dan bukti foto Form C1 dari Saksi.</p>
        </div>

        <button type="button" onclick="openHasilModal('create')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Hasil TPS
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
                        <th class="p-4">TPS / Wilayah</th>
                        <th class="p-4">Paslon</th>
                        <th class="p-4 text-center">Jumlah Suara</th>
                        <th class="p-4">Saksi</th>
                        <th class="p-4 text-center">Bukti C1</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($hasil)): ?>
                        <?php $i = 1;
                        foreach ($hasil as $h): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4 text-slate-500"><?= $i++ ?></td>
                                <td class="p-4 font-semibold text-slate-800">
                                    TPS <?= esc($h['no_tps'] ?? '-') ?>
                                    <span class="block text-xs font-normal text-slate-500">
                                        <?= esc($h['nama_dusun'] ?? '-') ?>
                                    </span>
                                </td>
                                <td class="p-4 text-slate-700">
                                    <span class="font-bold text-slate-900">[<?= esc($h['no_urut'] ?? '-') ?>]</span> <?= esc($h['nama_calon'] ?? 'Paslon Dihapus') ?>
                                </td>
                                <td class="p-4 text-center font-bold text-blue-600 font-mono text-base">
                                    <?= number_format($h['jumlah_suara']) ?>
                                </td>
                                <td class="p-4 text-slate-600 text-xs">
                                    <?= esc($h['nama_saksi'] ?? '-') ?>
                                </td>
                                <td class="p-4 text-center">
                                    <?php if (!empty($h['foto_c1'])): ?>
                                        <button type="button"
                                            onclick="previewFoto('<?= base_url('uploads/c1/' . $h['foto_c1']) ?>')"
                                            class="px-2.5 py-1 text-xs bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-md font-medium transition inline-flex items-center gap-1">
                                            🔍 Lihat Foto
                                        </button>
                                    <?php else: ?>
                                        <span class="text-xs text-slate-400 italic">Belum Upload</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-center">
                                    <form action="<?= base_url('admin/hasil-tps/update-status/' . $h['id_hasil']) ?>" method="POST">
                                        <?= csrf_field() ?>
                                        <select name="status_validasi" onchange="this.form.submit()" class="text-xs px-2 py-1 rounded-md border font-medium focus:outline-none transition cursor-pointer 
                                            <?= $h['status_validasi'] == 'terverifikasi' ? 'bg-emerald-50 text-emerald-700 border-emerald-300' : ($h['status_validasi'] == 'ditolak' ? 'bg-rose-50 text-rose-700 border-rose-300' : 'bg-amber-50 text-amber-700 border-amber-300') ?>">
                                            <option value="pending" <?= $h['status_validasi'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="terverifikasi" <?= $h['status_validasi'] == 'terverifikasi' ? 'selected' : '' ?>>Terverifikasi</option>
                                            <option value="ditolak" <?= $h['status_validasi'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button"
                                            data-id="<?= $h['id_hasil'] ?>"
                                            data-wilayah="<?= $h['id_wilayah'] ?>"
                                            data-saksi="<?= $h['id_saksi'] ?>"
                                            data-paslon="<?= $h['id_paslon'] ?>"
                                            data-suara="<?= $h['jumlah_suara'] ?>"
                                            data-foto="<?= esc($h['foto_c1'] ?? '') ?>"
                                            onclick="editHasil(this)"
                                            class="px-2.5 py-1.5 text-xs bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg font-medium transition">
                                            Edit
                                        </button>

                                        <a href="<?= base_url('admin/hasil-tps/delete/' . $h['id_hasil']) ?>"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data hasil TPS ini?')"
                                            class="px-2.5 py-1.5 text-xs bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg font-medium transition">
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400">Belum ada data hasil perhitungan TPS.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Input & Edit Hasil TPS -->
<div id="hasilModal" class="fixed inset-0 bg-slate-900/50 hidden backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl border border-slate-200 w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center p-5 border-b border-slate-100">
            <h4 id="hasilModalTitle" class="font-bold text-slate-800">Input Hasil Perhitungan TPS</h4>
            <button type="button" onclick="closeHasilModal()" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
        </div>

        <form id="hasilForm" action="<?= base_url('admin/hasil-tps/store') ?>" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
            <?= csrf_field() ?>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Wilayah & TPS</label>
                <select name="id_wilayah" id="f_id_wilayah" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                    <option value="">-- Pilih Wilayah & TPS --</option>
                    <?php foreach ($wilayah as $w): ?>
                        <option value="<?= $w['id_wilayah'] ?>">
                            <?= esc($w['nama_dusun']) ?> - TPS <?= esc($w['no_tps']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Saksi Reporting</label>
                    <select name="id_saksi" id="f_id_saksi" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Saksi --</option>
                        <?php foreach ($saksi as $s): ?>
                            <option value="<?= $s['id_user'] ?>"><?= esc($s['nama_lengkap']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Paslon</label>
                    <select name="id_paslon" id="f_id_paslon" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Paslon --</option>
                        <?php foreach ($paslon as $p): ?>
                            <option value="<?= $p['id_paslon'] ?>">
                                [<?= $p['no_urut'] ?>] <?= esc($p['nama_calon']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Jumlah Suara</label>
                <input type="number" name="jumlah_suara" id="f_jumlah_suara" required min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500" placeholder="0">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Upload Foto Form C1</label>
                <input type="file" name="foto_c1" accept="image/*" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                <p id="foto_info" class="text-[11px] text-slate-400 mt-1 hidden">*Biarkan kosong jika tidak ingin mengubah foto C1 yang sudah ada.</p>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeHasilModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                    Simpan Hasil TPS
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Preview Foto C1 -->
<div id="previewModal" class="fixed inset-0 bg-slate-900/80 hidden backdrop-blur-sm flex items-center justify-center z-50 p-4" onclick="closePreview()">
    <div class="relative max-w-3xl w-full bg-white rounded-xl overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center p-4 border-b border-slate-100">
            <h5 class="font-bold text-slate-800 text-sm">Bukti Foto Form C1</h5>
            <button type="button" onclick="closePreview()" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
        </div>
        <div class="p-2 flex justify-center bg-slate-900">
            <img id="imgPreview" src="" alt="Foto C1" class="max-h-[75vh] object-contain rounded">
        </div>
    </div>
</div>

<!-- JavaScript Modal Control -->
<script>
    function openHasilModal(mode) {
        const modal = document.getElementById('hasilModal');
        const form = document.getElementById('hasilForm');
        const title = document.getElementById('hasilModalTitle');
        const fotoInfo = document.getElementById('foto_info');

        modal.classList.remove('hidden');

        if (mode === 'create') {
            title.innerText = 'Input Hasil Perhitungan TPS';
            form.action = "<?= base_url('admin/hasil-tps/store') ?>";
            form.reset();
            fotoInfo.classList.add('hidden');
        }
    }

    function editHasil(button) {
        const modal = document.getElementById('hasilModal');
        const form = document.getElementById('hasilForm');
        const title = document.getElementById('hasilModalTitle');
        const fotoInfo = document.getElementById('foto_info');

        const id = button.getAttribute('data-id');
        const wilayah = button.getAttribute('data-wilayah');
        const saksi = button.getAttribute('data-saksi');
        const paslon = button.getAttribute('data-paslon');
        const suara = button.getAttribute('data-suara');

        modal.classList.remove('hidden');
        title.innerText = 'Edit Hasil Perhitungan TPS';
        form.action = "<?= base_url('admin/hasil-tps/update') ?>/" + id;

        document.getElementById('f_id_wilayah').value = wilayah;
        document.getElementById('f_id_saksi').value = saksi;
        document.getElementById('f_id_paslon').value = paslon;
        document.getElementById('f_jumlah_suara').value = suara;

        fotoInfo.classList.remove('hidden');
    }

    function closeHasilModal() {
        document.getElementById('hasilModal').classList.add('hidden');
    }

    function previewFoto(src) {
        document.getElementById('imgPreview').src = src;
        document.getElementById('previewModal').classList.remove('hidden');
    }

    function closePreview() {
        document.getElementById('previewModal').classList.add('hidden');
        document.getElementById('imgPreview').src = '';
    }
</script>
<?= $this->endSection() ?>