<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Manajemen Users<?= $this->endSection() ?>
<?= $this->section('header_title') ?>Kelola Pengguna Sistem<?= $this->endSection() ?>

<!-- MENU SIDEBAR ADMIN -->
<?= $this->section('sidebar_menu') ?>
<?= $this->include('admin/sidebar') ?>
<?= $this->endSection() ?>

<!-- CONTENT MANAJEMEN USERS -->
<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Flash Message Success -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-xl flex justify-between items-center">
            <span><?= session()->getFlashdata('success') ?></span>
            <button onclick="this.parentElement.remove()" class="font-bold text-emerald-900">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Flash Message Error -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="p-4 bg-rose-100 border border-rose-300 text-rose-800 rounded-xl flex justify-between items-center">
            <span><?= session()->getFlashdata('error') ?></span>
            <button onclick="this.parentElement.remove()" class="font-bold text-rose-900">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Action Bar & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar Pengguna / Tim Lapangan</h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola data akun Admin, Kordes, Relawan, dan Saksi.</p>
        </div>
        <a href="<?= base_url('admin/users/create') ?>" class="inline-flex items-center justify-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah User Baru</span>
        </a>
    </div>

    <!-- Tabel Data Users -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs tracking-wider">
                        <th class="p-4 font-semibold">Nama Lengkap</th>
                        <th class="p-4 font-semibold">No. HP</th>
                        <th class="p-4 font-semibold">Role</th>
                        <th class="p-4 font-semibold">Wilayah Penugasan</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($users)) : ?>
                        <?php foreach ($users as $user) : ?>
                            <?php
                            $dusun = $user['nama_dusun'] ?? null;
                            $tps   = $user['no_tps'] ?? null;
                            ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4 font-medium text-slate-800"><?= esc($user['nama_lengkap']) ?></td>
                                <td class="p-4 text-slate-600"><?= esc($user['no_hp']) ?></td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                                        <?= $user['role'] === 'admin' ? 'bg-purple-100 text-purple-700' : '' ?>
                                        <?= $user['role'] === 'kordes' ? 'bg-blue-100 text-blue-700' : '' ?>
                                        <?= $user['role'] === 'relawan' ? 'bg-emerald-100 text-emerald-700' : '' ?>
                                        <?= $user['role'] === 'saksi' ? 'bg-amber-100 text-amber-700' : '' ?>
                                    ">
                                        <?= strtoupper($user['role']) ?>
                                    </span>
                                </td>
                                <td class="p-4 text-slate-600">
                                    <?php if (!empty($dusun)) : ?>
                                        <?= esc($dusun) ?> <?= !empty($tps) ? '(TPS ' . esc($tps) . ')' : '' ?>
                                    <?php else : ?>
                                        <span class="text-slate-400 italic">Semua Wilayah / Pusat</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4">
                                    <?php if ($user['status_aktif'] == 1) : ?>
                                        <span class="inline-flex items-center gap-1.5 px-2 py-1 text-xs font-medium bg-emerald-50 text-emerald-600 rounded-md">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    <?php else : ?>
                                        <span class="inline-flex items-center gap-1.5 px-2 py-1 text-xs font-medium bg-rose-50 text-rose-600 rounded-md">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="inline-flex items-center space-x-2">
                                        <a href="<?= base_url('admin/users/edit/' . $user['id_user']) ?>" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition" title="Edit User">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <a href="<?= base_url('admin/users/delete/' . $user['id_user']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')" class="p-1.5 text-slate-500 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition" title="Hapus User">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">Belum ada data user. Silakan tambahkan user baru.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>