<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Dashboard Admin<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Panel Utama Admin Posko<?= $this->endSection() ?>

<!-- CALL SEPARATE SIDEBAR MENU -->
<?= $this->section('sidebar_menu') ?>
<?= $this->include('admin/sidebar') ?>
<?= $this->endSection() ?>

<!-- CONTENT DASHBOARD ADMIN -->
<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-6">

    <!-- Card Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl p-6 text-white shadow-md flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-xl font-bold">Selamat Datang, Admin Posko! 👋</h3>
            <p class="text-blue-100 text-sm mt-1">Pantau statistik pemenangan, pemetaan pemilih, dan alokasi logistik secara real-time dari database.</p>
        </div>
        <span class="px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-lg text-xs font-semibold">Realtime Database Sync</span>
    </div>

    <!-- Ringkasan KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total DPT / Pemilih</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1"><?= number_format($totalDpt) ?></h4>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Target Suara</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1"><?= number_format($targetPemenangan) ?></h4>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pasti Pilih</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1"><?= number_format($pemilihPasti) ?></h4>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total TPS Terdaftar</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1"><?= number_format($totalTps) ?> TPS</h4>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0v-4m0 0h4m-4 0V9m0 0h4m-4 0V5" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Section Grafik Utama -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <h4 class="font-bold text-slate-800 mb-4">Target Suara vs Pemilih Pasti per Dusun</h4>
            <div class="h-72">
                <canvas id="chartWilayah"></canvas>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <h4 class="font-bold text-slate-800 mb-4">Status Pemetaan Pemilih</h4>
            <div class="h-72 flex items-center justify-center">
                <canvas id="chartPemilih"></canvas>
            </div>
        </div>
    </div>

    <!-- Section Grafik Logistik -->
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <h4 class="font-bold text-slate-800 mb-4">Alokasi Logistik per Dusun</h4>
        <div class="h-64">
            <canvas id="chartLogistik"></canvas>
        </div>
    </div>

</div>

<!-- SCRIPT GRAPH DINAMIS -->
<script>
    const dataWilayah = <?= json_encode($chartWilayah) ?>;
    const dataKlasifikasi = <?= json_encode($chartKlasifikasi) ?>;
    const dataLogistik = <?= json_encode($chartLogistik) ?>;

    // 1. Grafik Bar - Target vs Pemilih Pasti per Dusun
    new Chart(document.getElementById('chartWilayah').getContext('2d'), {
        type: 'bar',
        data: {
            labels: dataWilayah.labels,
            datasets: [{
                    label: 'Target Suara',
                    data: dataWilayah.target,
                    backgroundColor: '#cbd5e1',
                    borderRadius: 6
                },
                {
                    label: 'Pemilih Pasti',
                    data: dataWilayah.pasti,
                    backgroundColor: '#2563eb',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // 2. Grafik Doughnut - Klasifikasi Sikap Pemilih
    new Chart(document.getElementById('chartPemilih').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Pasti Pilih', 'Ragu-ragu', 'Lawan', 'Belum Didata'],
            datasets: [{
                data: [dataKlasifikasi.pasti, dataKlasifikasi.ragu, dataKlasifikasi.lawan, dataKlasifikasi.belum],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#cbd5e1'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // 3. Grafik Bar - Distribusi Logistik per Dusun
    new Chart(document.getElementById('chartLogistik').getContext('2d'), {
        type: 'bar',
        data: {
            labels: dataLogistik.labels,
            datasets: [{
                label: 'Total Unit Logistik Ter-alokasi',
                data: dataLogistik.data,
                backgroundColor: '#6366f1',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>