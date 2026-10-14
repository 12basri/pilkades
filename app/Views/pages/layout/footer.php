<!-- Footer -->
<footer class="bg-white border-t border-slate-200 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            
            <!-- Kolom 1: Brand & Informasi Singkat -->
            <div class="md:col-span-5 space-y-3">
                <div class="flex items-center space-x-3">
                    <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo Posko" class="w-8 h-8 object-contain">
                    <div>
                        <h2 class="font-bold text-slate-900 leading-tight">POSKO PILKADES</h2>
                        <p class="text-[10px] text-slate-500 font-semibold tracking-wider uppercase">Sistem Pemenangan</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed max-w-sm">
                    Platform manajemen data pemilih, pengawalan tps, serta tabulasi suara internal untuk mendukung pemenangan calon kepala desa secara terstruktur dan terukur.
                </p>
            </div>

            <!-- Kolom 2: Navigasi Cepat -->
            <div class="md:col-span-3 space-y-2">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Navigasi Utama</h3>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li>
                        <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-1.5 hover:text-blue-600 transition">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('paslon') ?>" class="inline-flex items-center gap-1.5 hover:text-blue-600 transition">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Data Paslon
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('informasi') ?>" class="inline-flex items-center gap-1.5 hover:text-blue-600 transition">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Informasi & Berita
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Kolom 3: Akses Internal & Tim -->
            <div class="md:col-span-4 space-y-2">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Akses Internal</h3>
                <p class="text-xs text-slate-500">Khusus untuk Tim Relawan, Kordes, dan Saksi TPS terdaftar.</p>
                <div class="pt-1">
                </div>
            </div>

        </div>

        <!-- Garis Pemisah & Copyright -->
        <div class="border-t border-slate-100 mt-8 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            
            <div class="flex items-center space-x-3 text-slate-400">
                <span class="text-[11px]">Sistem Informasi Internal v1.0</span>
            </div>
        </div>
    </div>
</footer>