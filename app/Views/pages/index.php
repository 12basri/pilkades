<?= $this->extend('pages/layout/main') ?>

<?= $this->section('title') ?>Beranda Utama<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-8">

    <!-- Hero Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 rounded-2xl p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 border border-slate-800">
        <div class="space-y-3 max-w-2xl">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-300 border border-blue-400/30">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Posko Digital Transparan
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight">Sistem Monitoring Pemenangan Pilkades</h1>
            <p class="text-slate-300 text-sm leading-relaxed">
                Pusat data terintegrasi untuk pengawalan perolehan suara, pendataan dukungan warga, serta rekapitulasi cepat saksi TPS.
            </p>
        </div>
        <div class="flex-shrink-0">
            <a href="<?= base_url('login') ?>" class="px-6 py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm rounded-xl shadow-lg transition inline-block">
                Masuk Portal Saksi →
            </a>
        </div>
    </div>

    <!-- Overview Ringkasan Paslon -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-900">Pasangan Calon</h3>
            <a href="<?= base_url('paslon') ?>" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat Detail →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <?php if (!empty($paslon)) : ?>
                <?php foreach ($paslon as $p) : ?>
                    <div class="rounded-xl border border-slate-200 p-5 bg-slate-50/50 space-y-3 hover:border-blue-300 transition flex flex-col justify-between">
                        <div class="space-y-3">
                            
                            <!-- Foto Paslon -->
                            <?php if (!empty($p['foto'])) : ?>
                                <div class="w-full h-48 rounded-lg overflow-hidden bg-slate-200 mb-2">
                                    <img src="<?= base_url('uploads/paslon/' . $p['foto']) ?>" alt="Foto Paslon" class="w-full h-full object-cover">
                                </div>
                            <?php endif; ?>

                            <!-- Nomor Urut -->
                            <div>
                                <span class="px-3 py-1 bg-blue-600 text-white font-bold text-xs rounded-lg inline-block mb-2">
                                    No. Urut <?= esc($p['no_urut']); ?>
                                </span>

                                <!-- Nama Calon Kepala Desa -->
                                <h4 class="text-lg font-bold text-slate-800 leading-snug">
                                    <?= esc($p['nama_calon']); ?>
                                </h4>

                                <!-- Nama Wakil -->
                                <?php if (!empty($p['nama_wakil'])) : ?>
                                    <p class="text-xs font-medium text-slate-500 mt-1">
                                        Wakil: <?= esc($p['nama_wakil']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-span-3 text-center py-8 text-slate-400 italic text-sm border border-dashed border-slate-200 rounded-xl">
                    Data pasangan calon belum dimasukkan.
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<?= $this->endSection() ?>