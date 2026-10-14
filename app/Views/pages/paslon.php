<?= $this->extend('pages/layout/main') ?>

<?= $this->section('title') ?>Data Pasangan Calon<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Profil & Visi Misi Kandidat</h2>
        <p class="text-slate-500 text-xs mt-1">Daftar resmi pasangan calon kepala desa dalam agenda pemilihan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php if (!empty($paslon)) : ?>
            <?php foreach ($paslon as $p) : ?>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <span class="px-4 py-1.5 bg-blue-600 text-white font-extrabold text-sm rounded-xl">
                            Nomor Urut <?= esc($p['no_urut']); ?>
                        </span>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-slate-800"><?= esc($p['nama_paslon']); ?></h3>
                    </div>

                    <div class="space-y-2 pt-2">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Visi & Misi</h4>
                        <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <?= esc($p['visi_misi'] ?? 'Belum ada rincian visi & misi.'); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-span-2 bg-white p-8 text-center rounded-2xl border border-slate-200 text-slate-400 text-sm">
                Belum ada data kandidat yang terdaftar.
            </div>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>