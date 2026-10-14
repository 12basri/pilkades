<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Edit Pasangan Calon<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Form Edit Paslon<?= $this->endSection() ?>

<?= $this->section('sidebar_menu') ?>
<?= $this->include('admin/sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Edit Pasangan Calon</h3>
            <p class="text-xs text-slate-500 mt-0.5">Ubah data nomor urut, nama calon, atau foto paslon.</p>
        </div>
        <a href="<?= base_url('admin/paslon') ?>" class="inline-flex items-center space-x-2 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium text-sm rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

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

    <!-- PERBAIKAN UTAMA: Menggunakan $paslon['id_paslon'] -->
    <form action="<?= base_url('admin/paslon/update/' . $paslon['id_paslon']) ?>" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-6">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Urut <span class="text-rose-500">*</span></label>
                <input type="number" name="no_urut" value="<?= old('no_urut', $paslon['no_urut']) ?>" required min="1" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none transition text-sm">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Calon Kades <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_calon" value="<?= old('nama_calon', $paslon['nama_calon']) ?>" required class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none transition text-sm">
            </div>
        </div>

        <!-- Input Nama Wakil (Disembunyikan) -->
        <input type="hidden" name="nama_wakil" value="<?= old('nama_wakil', $paslon['nama_wakil'] ?? '') ?>">

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Paslon <span class="text-xs font-normal text-slate-400">(Biarkan kosong jika tidak diubah)</span></label>

            <?php if (!empty($paslon['foto'])) : ?>
                <div class="mb-3 flex items-center space-x-3">
                    <img src="<?= base_url('uploads/paslon/' . $paslon['foto']) ?>" alt="Foto" class="w-16 h-16 object-cover rounded-lg border border-slate-200 shadow-sm">
                    <span class="text-xs text-slate-500">Foto saat ini</span>
                </div>
            <?php endif; ?>

            <input type="file" name="foto" accept="image/png, image/jpeg, image/jpg" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition border border-slate-300 rounded-lg cursor-pointer">
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="<?= base_url('admin/paslon') ?>" class="px-5 py-2.5 rounded-lg border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium text-sm transition">Batal</a>
            <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-sm transition">Perbarui Paslon</button>
        </div>
    </form>

</div>

<?= $this->endSection() ?>