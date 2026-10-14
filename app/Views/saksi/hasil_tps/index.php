<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Input Suara & Foto C1<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Form Entry Hasil TPS<?= $this->endSection() ?>

<!-- MENU KHUSUS SAKSI (SIDEBAR) -->
<?= $this->section('sidebar_menu') ?>
<div class="px-4 py-6 space-y-6">
    <nav class="space-y-1.5">
        <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Menu Saksi</p>

        <!-- Dashboard Saksi -->
        <a href="<?= base_url('saksi/dashboard') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors <?= uri_string() == 'saksi/dashboard' || uri_string() == 'saksi' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        <!-- Input Suara & Foto C1 -->
        <a href="<?= base_url('saksi/hasil-tps') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors <?= uri_string() == 'saksi/hasil-tps' || uri_string() == 'saksi/input-hasil' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Input Suara & Foto C1
        </a>
    </nav>
</div>
<?= $this->endSection() ?>

<!-- CONTENT INPUT HASIL TPS -->
<?= $this->section('content') ?>
<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-4xl mx-auto space-y-6 py-4">

    <!-- Flash Error Handling -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-sm">
            <div class="flex items-center gap-2 font-bold mb-1">
                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Terjadi kesalahan input:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-700 pl-7">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Flash Success Handling -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="font-semibold text-xs sm:text-sm"><?= session()->getFlashdata('success'); ?></p>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('saksi/hasil-tps/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>

        <!-- Section 1: Perolehan Suara Paslon -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-800">1. Perolehan Suara Pasangan Calon</h3>
                <p class="text-xs text-slate-500 mt-0.5">Masukkan jumlah perolehan suara sah masing-masing paslon sesuai berita acara C1 Plano.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php if (!empty($paslon)) : ?>
                    <?php foreach ($paslon as $p) :
                        $paslonId = $p['id_paslon'];
                        $noUrut   = $p['no_urut'];
                        $nama     = $p['nama_calon'] . ($p['nama_wakil'] && $p['nama_wakil'] != '-' ? ' & ' . $p['nama_wakil'] : '');
                    ?>
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 flex items-center justify-between gap-4 hover:border-indigo-200 transition">
                            <div>
                                <span class="px-2 py-0.5 rounded bg-indigo-100 text-indigo-700 text-xs font-bold">
                                    No. <?= esc($noUrut); ?>
                                </span>
                                <h4 class="font-semibold text-slate-800 text-sm mt-1.5"><?= esc($nama); ?></h4>
                            </div>
                            <div class="w-32">
                                <input type="number"
                                    name="suara_paslon[<?= esc($paslonId); ?>]"
                                    value="<?= old("suara_paslon.$paslonId", 0) ?>"
                                    placeholder="0"
                                    min="0"
                                    required
                                    class="w-full px-3 py-2 text-right font-bold text-slate-800 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm shadow-sm transition">
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-span-2 py-6 text-center text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                        <p class="text-xs italic">Data pasangan calon belum dikonfigurasi oleh admin.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Section 2: Upload Dokumen C1 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-800">2. Upload Foto Form C1 Plano</h3>
                <p class="text-xs text-slate-500 mt-0.5">Unggah foto fisik berita acara atau lembar C1 Plano sebagai bukti (Format: JPG, PNG, Maks 2MB).</p>
            </div>

            <div class="flex items-center justify-center w-full">
                <label for="foto_c1" class="relative flex flex-col items-center justify-center w-full min-h-[160px] border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100/80 transition overflow-hidden p-4">

                    <!-- Box Preview Gambar -->
                    <div id="preview-container" class="hidden w-full flex flex-col items-center justify-center space-y-2">
                        <img id="image-preview" src="#" alt="Preview C1" class="max-h-48 rounded-lg object-contain border border-slate-200 shadow-sm" />
                        <p id="file-name" class="text-xs font-semibold text-slate-600 truncate max-w-full"></p>
                        <span class="text-[11px] text-indigo-600 font-medium">Klik untuk mengganti foto</span>
                    </div>

                    <!-- Placeholder Bawaan -->
                    <div id="upload-placeholder" class="flex flex-col items-center justify-center text-center">
                        <svg class="w-10 h-10 mb-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-xs text-slate-600 font-semibold mb-1">Pilih berkas foto C1 atau ambil gambar</p>
                        <p class="text-[10px] text-slate-400">PNG, JPG atau JPEG (Maksimal 2MB)</p>
                    </div>

                    <input type="file" id="foto_c1" name="foto_c1" accept="image/png, image/jpeg, image/jpg" required class="hidden" />
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-3 pt-2">
            <a href="<?= base_url('saksi/dashboard') ?>" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-100 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                Kirim Laporan TPS
            </button>
        </div>
    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pratinjau (Preview) Upload Foto C1
        const fileInput = document.getElementById('foto_c1');
        const previewContainer = document.getElementById('preview-container');
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const imagePreview = document.getElementById('image-preview');
        const fileName = document.getElementById('file-name');

        fileInput.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                // Validasi Ukuran File (Maksimal 2MB = 2097152 bytes)
                if (file.size > 2097152) {
                    alert('Ukuran file terlalu besar! Maksimal ukuran berkas adalah 2MB.');
                    this.value = '';
                    previewContainer.classList.add('hidden');
                    uploadPlaceholder.classList.remove('hidden');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    fileName.textContent = file.name;
                    previewContainer.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
                uploadPlaceholder.classList.remove('hidden');
            }
        });
    });
</script>
<?= $this->endSection() ?>