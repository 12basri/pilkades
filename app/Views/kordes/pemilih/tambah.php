<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Tambah Data Pemilih<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Pemilih / Tambah Data<?= $this->endSection() ?>

<!-- MENU KHUSUS KORDES / KOR-RT -->
<?= $this->section('sidebar_menu') ?>
    <?= $this->include('kordes/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    
    <!-- Header Card -->
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                <?= esc($title); ?>
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Isi formulir di bawah ini untuk menambahkan data pemilih baru ke dalam sistem.
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="<?= base_url('kordes/pemilih'); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Alert Error Validasi -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="rounded-xl bg-red-50 p-4 mb-6 border border-red-200 shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 8 0 100-16 8 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat beberapa kesalahan pengisian:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= esc($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="<?= base_url('kordes/pemilih/store'); ?>" method="post" class="p-6 sm:p-8 space-y-6">
            <?= csrf_field(); ?>

            <!-- Section 1: Data Identitas -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Informasi Identitas</h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    
                    <!-- NIK -->
                    <div class="sm:col-span-1">
                        <label for="nik" class="block text-sm font-medium text-gray-700">NIK (16 Digit)</label>
                        <input type="text" id="nik" name="nik" value="<?= old('nik'); ?>" maxlength="16" placeholder="Masukkan NIK (opsional)" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5 border transition-all">
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="sm:col-span-1">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="nama" name="nama" value="<?= old('nama'); ?>" required placeholder="Masukkan nama sesuai KTP" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5 border transition-all">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5 border bg-white transition-all">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>

                    <!-- Usia -->
                    <div>
                        <label for="usia" class="block text-sm font-medium text-gray-700">Usia (Tahun)</label>
                        <input type="number" id="usia" name="usia" value="<?= old('usia'); ?>" placeholder="Contoh: 35" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5 border transition-all">
                    </div>

                </div>
            </div>

            <!-- Section 2: Data Pemetaan & Domisili -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Wilayah & Status Pemilih</h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    
                    <!-- Wilayah -->
                    <div>
                        <label for="id_wilayah" class="block text-sm font-medium text-gray-700">Wilayah (Dusun & TPS) <span class="text-red-500">*</span></label>
                        <select id="id_wilayah" name="id_wilayah" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5 border bg-white transition-all">
                            <option value="">-- Pilih Wilayah --</option>
                            <?php foreach ($wilayah_list as $w) : ?>
                                <option value="<?= $w['id_wilayah']; ?>" <?= old('id_wilayah') == $w['id_wilayah'] ? 'selected' : ''; ?>>
                                    <?= esc($w['nama_dusun']); ?> - TPS <?= esc($w['no_tps']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Status Pemilih -->
                    <div>
                        <label for="status_pemilih" class="block text-sm font-medium text-gray-700">Status Pemilih</label>
                        <select id="status_pemilih" name="status_pemilih" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5 border bg-white transition-all">
                            <option value="belum_didata" <?= old('status_pemilih') == 'belum_didata' ? 'selected' : ''; ?>>Belum Didata</option>
                            <option value="pasti_pilih" <?= old('status_pemilih') == 'pasti_pilih' ? 'selected' : ''; ?>>Pasti Pilih</option>
                            <option value="ragu_ragu" <?= old('status_pemilih') == 'ragu_ragu' ? 'selected' : ''; ?>>Ragu-ragu</option>
                            <option value="lawan" <?= old('status_pemilih') == 'lawan' ? 'selected' : ''; ?>>Lawan</option>
                        </select>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" rows="2" placeholder="Masukkan nama jalan / nomor rumah..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5 border transition-all"><?= old('alamat'); ?></textarea>
                    </div>

                    <!-- Keterangan / Aspirasi -->
                    <div class="sm:col-span-2">
                        <label for="keterangan_aspirasi" class="block text-sm font-medium text-gray-700">Keterangan / Aspirasi</label>
                        <textarea id="keterangan_aspirasi" name="keterangan_aspirasi" rows="2" placeholder="Catatan khusus atau aspirasi pemilih..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5 border transition-all"><?= old('keterangan_aspirasi'); ?></textarea>
                    </div>

                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-5 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="<?= base_url('kordes/pemilih'); ?>" class="px-5 py-2.5 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-all">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center px-5 py-2.5 rounded-lg border border-transparent text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-all">
                    Simpan Data Pemilih
                </button>
            </div>

        </form>
    </div>
</div>
<?= $this->endSection(); ?>