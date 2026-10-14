<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Tambah Pemilih<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Form Pemilih Baru<?= $this->endSection() ?>

<?= $this->section('sidebar_menu') ?>
    <?= $this->include('relawan/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<!-- Tailwind CSS via CDN (Online) -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

    <!-- Header & Tombol Kembali -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight"><?= esc($title); ?></h2>
            <p class="text-sm text-gray-500 mt-1">Isi formulir di bawah ini untuk mendata calon pemilih baru secara lengkap.</p>
        </div>
        <div>
            <a href="<?= base_url('relawan/pemilih'); ?>" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 rounded-xl shadow-sm text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:text-gray-900 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Alert Validation Errors -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="rounded-2xl bg-red-50 p-5 border border-red-200/80 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 text-red-500">
                    <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="w-full">
                    <h3 class="text-sm font-semibold text-red-800">Terdapat kesalahan pengisian data:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form Input Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
        <form action="<?= base_url('relawan/pemilih/store'); ?>" method="POST" class="p-6 sm:p-8 space-y-6">
            <?= csrf_field(); ?>

            <!-- Grid Konten Form -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-sm font-semibold text-gray-700 mb-1">
                        NIK <span class="text-xs font-normal text-gray-400">(Opsional)</span>
                    </label>
                    <input type="text" name="nik" id="nik" maxlength="16" value="<?= old('nik'); ?>" placeholder="16 Digit NIK" 
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2.5 px-3.5 transition-all">
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" value="<?= old('nama'); ?>" required placeholder="Masukkan nama pemilih" 
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2.5 px-3.5 transition-all">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 mb-1">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_kelamin" id="jenis_kelamin" required 
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2.5 px-3.5 bg-white transition-all">
                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                        <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : ''; ?>>Laki-laki (L)</option>
                        <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : ''; ?>>Perempuan (P)</option>
                    </select>
                </div>

                <!-- Usia -->
                <div>
                    <label for="usia" class="block text-sm font-semibold text-gray-700 mb-1">
                        Usia <span class="text-xs font-normal text-gray-400">(Tahun)</span>
                    </label>
                    <input type="number" name="usia" id="usia" min="17" value="<?= old('usia'); ?>" placeholder="Contoh: 25" 
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2.5 px-3.5 transition-all">
                </div>

                <!-- Wilayah (Dusun & TPS) -->
                <div>
                    <label for="id_wilayah" class="block text-sm font-semibold text-gray-700 mb-1">
                        Wilayah / TPS <span class="text-red-500">*</span>
                    </label>
                    <select name="id_wilayah" id="id_wilayah" required 
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2.5 px-3.5 bg-white transition-all">
                        <option value="" disabled selected>-- Pilih Wilayah Dusun & TPS --</option>
                        <?php foreach ($wilayah as $w) : ?>
                            <option value="<?= $w['id_wilayah']; ?>" <?= old('id_wilayah') == $w['id_wilayah'] ? 'selected' : ''; ?>>
                                Dusun <?= esc($w['nama_dusun']); ?> (TPS <?= esc($w['no_tps']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Status Pemilih -->
                <div>
                    <label for="status_pemilih" class="block text-sm font-semibold text-gray-700 mb-1">
                        Status Dukungan <span class="text-red-500">*</span>
                    </label>
                    <select name="status_pemilih" id="status_pemilih" required 
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2.5 px-3.5 bg-white transition-all">
                        <option value="belum_didata" <?= old('status_pemilih') == 'belum_didata' ? 'selected' : ''; ?>>Belum Didata</option>
                        <option value="pasti_pilih" <?= old('status_pemilih') == 'pasti_pilih' ? 'selected' : ''; ?>>Pasti Pilih</option>
                        <option value="ragu_ragu" <?= old('status_pemilih') == 'ragu_ragu' ? 'selected' : ''; ?>>Ragu-Ragu</option>
                        <option value="lawan" <?= old('status_pemilih') == 'lawan' ? 'selected' : ''; ?>>Lawan</option>
                    </select>
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" rows="2" placeholder="Alamat rumah/RT/RW" 
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2.5 px-3.5 transition-all"><?= old('alamat'); ?></textarea>
            </div>

            <!-- Aspirasi -->
            <div>
                <label for="keterangan_aspirasi" class="block text-sm font-semibold text-gray-700 mb-1">Keterangan / Aspirasi Pemilih</label>
                <textarea name="keterangan_aspirasi" id="keterangan_aspirasi" rows="3" placeholder="Catatan atau masukan dari pemilih..." 
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2.5 px-3.5 transition-all"><?= old('keterangan_aspirasi'); ?></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="<?= base_url('relawan/pemilih'); ?>" class="px-4 py-2.5 text-sm font-semibold text-gray-700 hover:text-gray-900 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Data Pemilih
                </button>
            </div>
        </form>
    </div>

</div>
<?= $this->endSection(); ?>