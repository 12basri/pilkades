<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Data Pemilih<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Kelola Data Pemilih & Aspirasi<?= $this->endSection() ?>

<?= $this->section('sidebar_menu') ?>
<?= $this->include('admin/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// Hitung statistik dalam 1 kali loop untuk performa lebih efisien
$totalPemilih = count($pemilih ?? []);
$pastiPilih = 0;
$raguRagu = 0;
$lawanOrBelum = 0;

if (!empty($pemilih)) {
    foreach ($pemilih as $item) {
        $st = $item['status_pemilih'] ?? '';
        if ($st === 'pasti_pilih') {
            $pastiPilih++;
        } elseif ($st === 'ragu_ragu') {
            $raguRagu++;
        } elseif (in_array($st, ['lawan', 'belum_didata', ''])) {
            $lawanOrBelum++;
        }
    }
}
?>

<div class="space-y-6">

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">Total Pemilih</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1"><?= $totalPemilih ?></h4>
            </div>
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold">
                👥
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">Pasti Pilih</p>
                <h4 class="text-2xl font-bold text-emerald-600 mt-1"><?= $pastiPilih ?></h4>
            </div>
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center font-bold">
                ✅
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">Ragu-Ragu</p>
                <h4 class="text-2xl font-bold text-amber-500 mt-1"><?= $raguRagu ?></h4>
            </div>
            <div class="w-10 h-10 bg-amber-50 text-amber-500 rounded-lg flex items-center justify-center font-bold">
                ❓
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">Lawan / Belum Didata</p>
                <h4 class="text-2xl font-bold text-rose-600 mt-1"><?= $lawanOrBelum ?></h4>
            </div>
            <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-lg flex items-center justify-center font-bold">
                ⚠️
            </div>
        </div>
    </div>

    <!-- Header Control Bar -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar Pemilih Terdata</h3>
            <p class="text-xs text-slate-500">Pemetaan status dan aspirasi pemilih tiap wilayah.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <!-- Search & Filter -->
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari nama, NIK, atau wilayah..."
                class="w-full sm:w-64 px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">

            <select id="statusFilter" onchange="filterTable()" class="w-full sm:w-auto px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                <option value="">Semua Status</option>
                <option value="pasti_pilih">Pasti Pilih</option>
                <option value="ragu_ragu">Ragu-Ragu</option>
                <option value="lawan">Lawan</option>
                <option value="belum_didata">Belum Didata</option>
            </select>

            <!-- Import Data -->
            <button onclick="openImportModal()" class="w-full sm:w-auto whitespace-nowrap px-3 py-2 bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-100 rounded-lg text-sm font-medium transition flex items-center justify-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Import Excel
            </button>

            <!-- Export Data -->
            <a href="<?= base_url('admin/pemilih/export') ?>" class="w-full sm:w-auto whitespace-nowrap px-3 py-2 bg-slate-100 text-slate-700 border border-slate-300 hover:bg-slate-200 rounded-lg text-sm font-medium transition flex items-center justify-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Data
            </a>

            <!-- Tambah Pemilih -->
            <button onclick="openPemilihModal('create')" class="w-full sm:w-auto whitespace-nowrap px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pemilih
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm font-semibold">
            ⚠️ <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm">
            <p class="font-bold mb-1">Gagal menyimpan data:</p>
            <ul class="list-disc list-inside space-y-1">
                <?php
                $errors = session()->getFlashdata('errors');
                if (is_array($errors)):
                    foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach;
                else: ?>
                    <li><?= esc($errors) ?></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Tabel Data Pemilih -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm" id="pemilihTable">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs border-b border-slate-200">
                    <tr>
                        <th class="p-4">Pemilih</th>
                        <th class="p-4">NIK & Usia</th>
                        <th class="p-4">Wilayah & TPS</th>
                        <th class="p-4">Status Sikap</th>
                        <th class="p-4">Aspirasi</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="pemilihTableBody">
                    <?php if (!empty($pemilih)): ?>
                        <?php foreach ($pemilih as $p): ?>
                            <tr class="pemilih-row hover:bg-slate-50 transition" data-status="<?= esc($p['status_pemilih'] ?? 'belum_didata') ?>">
                                <td class="p-4 search-target">
                                    <div class="font-medium text-slate-800"><?= esc($p['nama']) ?></div>
                                    <div class="text-xs text-slate-400"><?= ($p['jenis_kelamin'] ?? '') === 'L' ? 'Laki-laki' : 'Perempuan' ?></div>
                                </td>
                                <td class="p-4 text-slate-600 search-target">
                                    <div class="font-mono text-xs text-slate-700"><?= esc($p['nik'] ?? '-') ?></div>
                                    <div class="text-xs text-slate-400"><?= esc($p['usia'] ?? '0') ?> Tahun</div>
                                </td>
                                <td class="p-4 text-slate-600 search-target">
                                    <div class="font-semibold text-slate-700 text-xs mb-0.5">
                                        <?= esc($p['nama_dusun'] ?? '-') ?> (TPS <?= esc($p['no_tps'] ?? '-') ?>)
                                    </div>
                                    <div class="text-xs text-slate-500 truncate max-w-[150px]"><?= esc($p['alamat'] ?? '-') ?></div>
                                </td>
                                <td class="p-4">
                                    <?php
                                    $status = $p['status_pemilih'] ?? 'belum_didata';
                                    $badgeStyle = match ($status) {
                                        'pasti_pilih' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'ragu_ragu'   => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'lawan'       => 'bg-rose-100 text-rose-800 border-rose-200',
                                        default       => 'bg-slate-100 text-slate-600 border-slate-200',
                                    };
                                    $statusLabel = match ($status) {
                                        'pasti_pilih' => 'Pasti Pilih',
                                        'ragu_ragu'   => 'Ragu-Ragu',
                                        'lawan'       => 'Lawan',
                                        default       => 'Belum Didata',
                                    };
                                    ?>
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full border <?= $badgeStyle ?>">
                                        <?= $statusLabel ?>
                                    </span>
                                </td>
                                <td class="p-4 text-slate-600 max-w-xs truncate" title="<?= esc($p['keterangan_aspirasi'] ?? '') ?>">
                                    <?= esc($p['keterangan_aspirasi'] ?? '-') ?>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button"
                                            onclick='openPemilihModal("edit", <?= json_encode($p, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'
                                            class="px-2.5 py-1.5 text-xs bg-amber-50 text-amber-600 hover:bg-amber-100 border border-amber-200/60 rounded-lg font-medium transition flex items-center gap-1.5"
                                            title="Edit Data">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>

                                        <form action="<?= base_url('admin/pemilih/delete/' . $p['id_pemilih']) ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pemilih ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit"
                                                class="px-2.5 py-1.5 text-xs bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200/60 rounded-lg font-medium transition flex items-center gap-1.5"
                                                title="Hapus Data">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="noDataRow">
                            <td colspan="6" class="p-8 text-center text-slate-400">Belum ada data pemilih terdaftar.</td>
                        </tr>
                    <?php endif; ?>
                    <tr id="noFilterMatchRow" class="hidden">
                        <td colspan="6" class="p-8 text-center text-slate-400">Tidak ada data pemilih yang sesuai dengan pencarian/filter.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="p-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-slate-50/50">
            <div class="text-xs text-slate-500 font-medium">
                Menampilkan <span id="showingStart" class="font-bold text-slate-800">0</span> - <span id="showingEnd" class="font-bold text-slate-800">0</span> dari <span id="totalData" class="font-bold text-slate-800">0</span> data
            </div>

            <div class="flex items-center gap-2" id="paginationControls"></div>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div id="pemilihModal" class="fixed inset-0 bg-slate-900/50 hidden backdrop-blur-sm flex items-center justify-center z-50 p-4" onclick="handleBackdropClick(event, 'pemilihModal')">
    <div class="bg-white rounded-xl shadow-xl border border-slate-200 w-full max-w-lg overflow-hidden my-8">
        <div class="flex justify-between items-center p-5 border-b border-slate-100">
            <h4 id="pemilihModalTitle" class="font-bold text-slate-800">Tambah Pemilih</h4>
            <button type="button" onclick="closePemilihModal()" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
        </div>

        <form id="pemilihForm" action="<?= base_url('admin/pemilih/store') ?>" method="POST" onsubmit="return validateForm()" class="p-5 space-y-4 max-h-[80vh] overflow-y-auto">
            <?= csrf_field() ?>
            <input type="hidden" id="pemilih_id" name="id_pemilih">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">NIK (16 Digit)</label>
                    <input type="text" name="nik" id="p_nik" minlength="16" maxlength="16"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500"
                        placeholder="730..." />
                    <span id="nik_error" class="text-[11px] text-rose-500 hidden mt-1 block"></span>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" id="p_nama" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500"
                        placeholder="Nama sesuai KTP" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="p_jk" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Usia</label>
                    <input type="number" name="usia" id="p_usia"
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500"
                        placeholder="25" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Wilayah / TPS</label>
                    <select name="id_wilayah" id="p_id_wilayah" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Wilayah --</option>
                        <?php if (!empty($wilayah_list)): ?>
                            <?php foreach ($wilayah_list as $w): ?>
                                <option value="<?= $w['id_wilayah'] ?>">
                                    <?= esc($w['nama_dusun']) ?> (TPS <?= esc($w['no_tps']) ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Status Sikap</label>
                    <select name="status_pemilih" id="p_status" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        <option value="belum_didata">Belum Didata</option>
                        <option value="pasti_pilih">Pasti Pilih</option>
                        <option value="ragu_ragu">Ragu-Ragu</option>
                        <option value="lawan">Lawan</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Alamat Rumah</label>
                <textarea name="alamat" id="p_alamat" rows="2"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500"
                    placeholder="Jalan / RT / RW / Dusun"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Keterangan / Aspirasi</label>
                <textarea name="keterangan_aspirasi" id="p_aspirasi" rows="2"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500"
                    placeholder="Catatan permintaan atau aspirasi warga..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closePemilihModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                    Simpan Pemilih
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Upload -->
<div id="importModal" class="fixed inset-0 bg-slate-900/50 hidden backdrop-blur-sm flex items-center justify-center z-50 p-4" onclick="handleBackdropClick(event, 'importModal')">
    <div class="bg-white rounded-xl shadow-xl border border-slate-200 w-full max-w-md overflow-hidden">
        <div class="flex justify-between items-center p-5 border-b border-slate-100">
            <h4 class="font-bold text-slate-800">Import File Data Pemilih</h4>
            <button type="button" onclick="closeImportModal()" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
        </div>

        <form action="<?= base_url('admin/pemilih/import') ?>" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Upload File (Excel / CSV)</label>
                <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-blue-500 file:mr-4 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                <p class="text-[11px] text-slate-400 mt-1">Gunakan format .csv, .xls, atau .xlsx.</p>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeImportModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition">
                    Upload & Import
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentPage = 1;
    const rowsPerPage = 10;
    let visibleRows = [];

    document.addEventListener('DOMContentLoaded', () => {
        filterTable();

        // Tutup modal jika menekan ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closePemilihModal();
                closeImportModal();
            }
        });
    });

    function handleBackdropClick(event, modalId) {
        if (event.target.id === modalId) {
            if (modalId === 'pemilihModal') closePemilihModal();
            if (modalId === 'importModal') closeImportModal();
        }
    }

    function openPemilihModal(mode, data = null) {
        const modal = document.getElementById('pemilihModal');
        const form = document.getElementById('pemilihForm');
        const title = document.getElementById('pemilihModalTitle');
        const nikError = document.getElementById('nik_error');

        if (!modal || !form) return;

        if (nikError) nikError.classList.add('hidden');
        modal.classList.remove('hidden');

        let item = data;
        if (typeof data === 'string') {
            try {
                item = JSON.parse(data);
            } catch (e) {
                console.error("Gagal mengurai data JSON:", e);
            }
        }

        if (mode === 'edit' && item) {
            title.innerText = 'Edit Data Pemilih';
            form.action = "<?= base_url('admin/pemilih/update') ?>/" + (item.id_pemilih || '');

            document.getElementById('pemilih_id').value = item.id_pemilih || '';
            document.getElementById('p_nik').value = item.nik || '';
            document.getElementById('p_nama').value = item.nama || '';
            document.getElementById('p_jk').value = item.jenis_kelamin || 'L';
            document.getElementById('p_usia').value = item.usia || '';
            document.getElementById('p_id_wilayah').value = item.id_wilayah || '';
            document.getElementById('p_status').value = item.status_pemilih || 'belum_didata';
            document.getElementById('p_alamat').value = item.alamat || '';
            document.getElementById('p_aspirasi').value = item.keterangan_aspirasi || '';
        } else {
            title.innerText = 'Tambah Pemilih Baru';
            form.action = "<?= base_url('admin/pemilih/store') ?>";
            form.reset();
            document.getElementById('pemilih_id').value = '';
        }
    }

    function closePemilihModal() {
        document.getElementById('pemilihModal').classList.add('hidden');
    }

    function openImportModal() {
        document.getElementById('importModal').classList.remove('hidden');
    }

    function closeImportModal() {
        document.getElementById('importModal').classList.add('hidden');
    }

    function validateForm() {
        const nikInput = document.getElementById('p_nik');
        const nikError = document.getElementById('nik_error');

        nikInput.value = nikInput.value.replace(/[^0-9]/g, '');

        if (nikInput.value.length > 0 && nikInput.value.length !== 16) {
            nikError.innerText = "NIK harus berjumlah persis 16 digit! (Saat ini: " + nikInput.value.length + " digit)";
            nikError.classList.remove('hidden');
            nikInput.focus();
            return false;
        }

        nikError.classList.add('hidden');
        return true;
    }

    function filterTable() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();
        const selectedStatus = document.getElementById('statusFilter').value;
        const rows = Array.from(document.querySelectorAll('.pemilih-row'));
        const noFilterMatchRow = document.getElementById('noFilterMatchRow');

        visibleRows = rows.filter(row => {
            const rowStatus = row.getAttribute('data-status');
            const searchTargets = row.querySelectorAll('.search-target');
            let textMatch = false;

            searchTargets.forEach(target => {
                if (target.textContent.toLowerCase().includes(searchValue)) {
                    textMatch = true;
                }
            });

            const statusMatch = (selectedStatus === '') || (rowStatus === selectedStatus);
            return textMatch && statusMatch;
        });

        rows.forEach(r => r.style.display = 'none');

        if (noFilterMatchRow) {
            if (rows.length > 0 && visibleRows.length === 0) {
                noFilterMatchRow.classList.remove('hidden');
            } else {
                noFilterMatchRow.classList.add('hidden');
            }
        }

        currentPage = 1;
        renderPagination();
    }

    function renderPagination() {
        const totalData = visibleRows.length;
        const totalPages = Math.ceil(totalData / rowsPerPage);

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        visibleRows.slice(start, end).forEach(row => {
            row.style.display = '';
        });

        document.getElementById('totalData').innerText = totalData;
        document.getElementById('showingStart').innerText = totalData === 0 ? 0 : start + 1;
        document.getElementById('showingEnd').innerText = Math.min(end, totalData);

        const container = document.getElementById('paginationControls');
        container.innerHTML = '';

        if (totalPages <= 1) return;

        const prevBtn = document.createElement('button');
        prevBtn.innerText = '‹ Prev';
        prevBtn.className = `px-3 py-1.5 rounded-lg border text-xs font-medium transition ${
            currentPage === 1 ? 'border-slate-200 text-slate-300 cursor-not-allowed' : 'border-slate-300 text-slate-600 hover:bg-slate-100'
        }`;
        prevBtn.disabled = currentPage === 1;
        prevBtn.onclick = () => {
            currentPage--;
            renderPagination();
        };
        container.appendChild(prevBtn);

        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.innerText = i;
            pageBtn.className = `px-3 py-1.5 rounded-lg border text-xs font-medium transition ${
                i === currentPage ? 'bg-blue-600 text-white border-blue-600' : 'border-slate-300 text-slate-600 hover:bg-slate-100'
            }`;
            pageBtn.onclick = () => {
                currentPage = i;
                renderPagination();
            };
            container.appendChild(pageBtn);
        }

        const nextBtn = document.createElement('button');
        nextBtn.innerText = 'Next ›';
        nextBtn.className = `px-3 py-1.5 rounded-lg border text-xs font-medium transition ${
            currentPage === totalPages ? 'border-slate-200 text-slate-300 cursor-not-allowed' : 'border-slate-300 text-slate-600 hover:bg-slate-100'
        }`;
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.onclick = () => {
            currentPage++;
            renderPagination();
        };
        container.appendChild(nextBtn);
    }
</script>
<?= $this->endSection() ?>