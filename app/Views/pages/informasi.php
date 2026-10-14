<?= $this->extend('pages/layout/main') ?>

<?= $this->section('title') ?>Pusat Informasi<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-2">
        <h2 class="text-xl font-bold text-slate-900">Informasi & Pengumuman Posko</h2>
        <p class="text-slate-500 text-xs">Petunjuk operasional dan pembaruan kegiatan tim lapangan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold">1</div>
            <h3 class="font-bold text-slate-800">Sistem Pelaporan Saksi</h3>
            <p class="text-slate-600 text-xs leading-relaxed"> Sampaikan laporan penghitungan dari TPS resmi melalui portal login khusus yang telah ditugaskan oleh koordinator desa. </p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold">2</div>
            <h3 class="font-bold text-slate-800">Verifikasi Berkas Form C1</h3>
            <p class="text-slate-600 text-xs leading-relaxed"> Seluruh saksi diwajibkan mengunggah foto bukti fisik formulir rekapitulasi untuk diverifikasi oleh tim internal pusat data. </p>
        </div>
    </div>

</div>
<?= $this->endSection() ?>