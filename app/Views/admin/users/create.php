<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Tambah User Baru<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Form Tambah Pengguna Sistem<?= $this->endSection() ?>

<!-- MENU SIDEBAR ADMIN -->
<?= $this->section('sidebar_menu') ?>
<?= $this->include('admin/sidebar') ?>
<?= $this->endSection() ?>

<!-- CONTENT FORM TAMBAH USER -->
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Navigasi Kembali -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Tambah Tim / User Baru</h3>
            <p class="text-xs text-slate-500 mt-0.5">Isi formulir di bawah ini untuk mendaftarkan akun baru ke sistem.</p>
        </div>
        <a href="<?= base_url('admin/users') ?>" class="inline-flex items-center space-x-2 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium text-sm rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Alert Validation Errors -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="p-4 bg-rose-100 border border-rose-300 text-rose-800 rounded-xl text-sm">
            <p class="font-bold mb-1">Terjadi kesalahan validasi:</p>
            <ul class="list-disc list-inside space-y-1">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form Container -->
    <form action="<?= base_url('admin/users/store') ?>" method="post" class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-6">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required placeholder="Contoh: Ahmad Subagja" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
            </div>

            <!-- No. HP / WhatsApp -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP / WhatsApp <span class="text-rose-500">*</span></label>
                <input type="text" name="no_hp" value="<?= old('no_hp') ?>" required placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-rose-500">*</span></label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
            </div>

            <!-- Role Akses -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Role Akses <span class="text-rose-500">*</span></label>
                <select name="role" required class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm bg-white">
                    <option value="" disabled selected>-- Pilih Role --</option>
                    <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="kordes" <?= old('role') === 'kordes' ? 'selected' : '' ?>>Kordes (Koordinator Desa)</option>
                    <option value="relawan" <?= old('role') === 'relawan' ? 'selected' : '' ?>>Relawan</option>
                    <option value="saksi" <?= old('role') === 'saksi' ? 'selected' : '' ?>>Saksi TPS</option>
                </select>
            </div>
        </div>

        <hr class="border-slate-100">

        <!-- Wilayah Penugasan -->
        <h4 class="font-bold text-slate-800 text-sm">Wilayah Penugasan (Opsional)</h4>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Wilayah / TPS</label>
                <select name="id_wilayah" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm bg-white">
                    <option value="">-- Tanpa Wilayah (Umum/Admin) --</option>
                    <?php if (!empty($wilayah)) : ?>
                        <?php foreach ($wilayah as $w) : ?>
                            <?php
                            $dusun = $w['nama_dusun'] ?? $w['dusun'] ?? 'Dusun -';
                            $tps   = $w['no_tps'] ?? null;
                            ?>
                            <option value="<?= $w['id_wilayah'] ?>" <?= old('id_wilayah') == $w['id_wilayah'] ? 'selected' : '' ?>>
                                <?= esc($dusun) ?><?= !empty($tps) ? ' - TPS ' . esc($tps) : '' ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-3 pt-4">
            <a href="<?= base_url('admin/users') ?>" class="px-5 py-2.5 rounded-lg border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium text-sm transition">Batal</a>
            <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-sm transition">Simpan User</button>
        </div>
    </form>

</div>

<?= $this->endSection() ?>