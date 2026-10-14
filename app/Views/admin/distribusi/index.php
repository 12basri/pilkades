<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Distribusi Logistik<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Distribusi & Penyaluran Logistik<?= $this->endSection() ?>

<?= $this->section('sidebar_menu') ?>
<?= $this->include('admin/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <!-- Header Control Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Riwayat Penyaluran Logistik</h3>
            <p class="text-xs text-slate-500">Catatan penyerahan barang/atribut kampanye kepada petugas, relawan, dan wilayah.</p>
        </div>

        <button onclick="openCreateModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Catat Distribusi Baru
        </button>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
            <?= esc(session()->getFlashdata('success')) ?>
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
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Barang Logistik</th>
                        <th class="p-4">Petugas / Penerima</th>
                        <th class="p-4">Wilayah Tujuan</th>
                        <th class="p-4 text-center">Jumlah</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4">Keterangan</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($distribusi)): ?>
                        <?php $i = 1;
                        foreach ($distribusi as $d): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4 text-slate-500"><?= $i++ ?></td>
                                <td class="p-4 font-mono text-xs text-slate-600">
                                    <?= date('d/m/Y H:i', strtotime($d['tanggal_distribusi'])) ?>
                                </td>
                                <td class="p-4 font-semibold text-slate-800">
                                    <?= esc($d['nama_barang'] ?? 'Barang Dihapus') ?>
                                </td>
                                <td class="p-4 text-slate-700">
                                    <?= esc($d['nama_petugas'] ?? '-') ?>
                                    <?php if (!empty($d['role_petugas'])): ?>
                                        <span class="text-xs text-slate-400 block">(<?= esc(strtoupper($d['role_petugas'])) ?>)</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-slate-600">
                                    <?php if (!empty($d['nama_dusun'])): ?>
                                        <?= esc($d['nama_dusun']) ?> (TPS <?= esc($d['no_tps'] ?? '-') ?>)
                                    <?php else: ?>
                                        <span class="text-slate-400">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-center font-bold text-blue-600 font-mono">
                                    <?= number_format($d['jumlah']) ?>
                                </td>
                                <td class="p-4 text-center">
                                    <?php
                                    $statusClass = [
                                        'diproses' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'dikirim'  => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'diterima' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    ][$d['status'] ?? 'diproses'] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                                    ?>
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full border <?= $statusClass ?>">
                                        <?= ucfirst(esc($d['status'] ?? 'diproses')) ?>
                                    </span>
                                </td>
                                <td class="p-4 text-slate-500 text-xs italic">
                                    <?= esc($d['keterangan'] ?: '-') ?>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <button onclick='openEditModal(<?= json_encode($d, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'
                                            class="px-2.5 py-1.5 text-xs bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg font-medium transition">
                                            Edit
                                        </button>
                                        <a href="<?= base_url('admin/distribusi/delete/' . $d['id_distribusi']) ?>"
                                            onclick="return confirm('Membatalkan/menghapus catatan ini akan mengembalikan stok barang. Lanjutkan?')"
                                            class="px-2.5 py-1.5 text-xs bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg font-medium transition">
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="p-8 text-center text-slate-400">Belum ada riwayat penyaluran logistik.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Tambah Distribusi -->
<div id="createModal" class="fixed inset-0 bg-slate-900/50 hidden backdrop-blur-sm flex items-center justify-center z-50 p-4" onclick="handleBackdropClick(event, 'createModal')">
    <div class="bg-white rounded-xl shadow-xl border border-slate-200 w-full max-w-lg overflow-hidden" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center p-5 border-b border-slate-100">
            <h4 class="font-bold text-slate-800">Catat Distribusi Logistik</h4>
            <button type="button" onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
        </div>

        <form action="<?= base_url('admin/distribusi/store') ?>" method="POST" class="p-5 space-y-4">
            <?= csrf_field() ?>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Pilih Barang Logistik</label>
                <select name="id_logistik" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                    <option value="">-- Pilih Barang --</option>
                    <?php foreach ($logistik as $l): ?>
                        <option value="<?= $l['id_logistik'] ?>">
                            <?= esc($l['nama_barang']) ?> (Sisa Stok: <?= number_format($l['stok_tersisa']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Petugas / Penanggung Jawab</label>
                    <select name="id_petugas" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Petugas / Relawan --</option>
                        <?php foreach ($relawan as $r): ?>
                            <option value="<?= $r['id_user'] ?>">
                                <?= esc($r['nama_lengkap']) ?> (<?= strtoupper($r['role']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Wilayah Tujuan</label>
                    <select name="id_wilayah" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Wilayah --</option>
                        <?php foreach ($wilayah as $w): ?>
                            <option value="<?= $w['id_wilayah'] ?>">
                                <?= esc($w['nama_dusun']) ?> - TPS <?= esc($w['no_tps']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Jumlah Diserahkan</label>
                    <input type="number" name="jumlah" required min="1" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500" placeholder="0">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Status Penyaluran</label>
                    <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        <option value="diproses">Diproses</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="diterima">Diterima</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Tanggal Penyaluran</label>
                <input type="datetime-local" name="tanggal_distribusi" value="<?= date('Y-m-d\TH:i') ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Keterangan</label>
                <textarea name="keterangan" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500" placeholder="Catatan penyerahan, keperluan kegiatan, dsb."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeCreateModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                    Simpan Distribusi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Form Edit Distribusi -->
<div id="editModal" class="fixed inset-0 bg-slate-900/50 hidden backdrop-blur-sm flex items-center justify-center z-50 p-4" onclick="handleBackdropClick(event, 'editModal')">
    <div class="bg-white rounded-xl shadow-xl border border-slate-200 w-full max-w-lg overflow-hidden" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center p-5 border-b border-slate-100">
            <h4 class="font-bold text-slate-800">Edit Data Distribusi</h4>
            <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
        </div>

        <form id="editForm" method="POST" class="p-5 space-y-4">
            <?= csrf_field() ?>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Pilih Barang Logistik</label>
                <select name="id_logistik" id="edit_id_logistik" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                    <option value="">-- Pilih Barang --</option>
                    <?php foreach ($logistik as $l): ?>
                        <option value="<?= $l['id_logistik'] ?>">
                            <?= esc($l['nama_barang']) ?> (Sisa Stok: <?= number_format($l['stok_tersisa']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Petugas / Penanggung Jawab</label>
                    <select name="id_petugas" id="edit_id_petugas" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Petugas / Relawan --</option>
                        <?php foreach ($relawan as $r): ?>
                            <option value="<?= $r['id_user'] ?>">
                                <?= esc($r['nama_lengkap']) ?> (<?= strtoupper($r['role']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Wilayah Tujuan</label>
                    <select name="id_wilayah" id="edit_id_wilayah" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Wilayah --</option>
                        <?php foreach ($wilayah as $w): ?>
                            <option value="<?= $w['id_wilayah'] ?>">
                                <?= esc($w['nama_dusun']) ?> - TPS <?= esc($w['no_tps']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Jumlah Diserahkan</label>
                    <input type="number" name="jumlah" id="edit_jumlah" required min="1" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Status Penyaluran</label>
                    <select name="status" id="edit_status" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        <option value="diproses">Diproses</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="diterima">Diterima</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Tanggal Penyaluran</label>
                <input type="datetime-local" name="tanggal_distribusi" id="edit_tanggal_distribusi" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Keterangan</label>
                <textarea name="keterangan" id="edit_keterangan" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-medium transition">
                    Update Distribusi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }

    function openEditModal(data) {
        document.getElementById('editForm').action = '<?= base_url('admin/distribusi/update') ?>/' + data.id_distribusi;
        document.getElementById('edit_id_logistik').value = data.id_logistik;
        document.getElementById('edit_id_petugas').value = data.id_petugas || '';
        document.getElementById('edit_id_wilayah').value = data.id_wilayah;
        document.getElementById('edit_jumlah').value = data.jumlah;
        document.getElementById('edit_status').value = data.status || 'diproses';
        document.getElementById('edit_keterangan').value = data.keterangan || '';

        if (data.tanggal_distribusi) {
            // Mengambil substring 'YYYY-MM-DDTHH:mm' dari DB tanpa pengaruh konversi offset jam UTC
            const formattedDate = data.tanggal_distribusi.replace(' ', 'T').substring(0, 16);
            document.getElementById('edit_tanggal_distribusi').value = formattedDate;
        }

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Helper untuk menutup modal saat klik backdrop (area gelap)
    function handleBackdropClick(event, modalId) {
        if (event.target.id === modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    }

    // Menutup modal dengan menekan tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateModal();
            closeEditModal();
        }
    });
</script>
<?= $this->endSection() ?>