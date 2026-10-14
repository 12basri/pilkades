<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Posko Pemenangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <?= $this->include('pages/layout/header') ?>

    <!-- Main Container -->
    <div class="flex-1 flex max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 gap-6">
        
        <!-- Sidebar Navigation (Hanya muncul jika halaman mengisi section 'sidebar_menu') -->
        <?php if ($this->renderSection('sidebar_menu')) : ?>
            <aside class="w-64 bg-white rounded-2xl border border-slate-200 shadow-sm flex-shrink-0 hidden md:block self-start sticky top-20">
                <?= $this->renderSection('sidebar_menu') ?>
            </aside>
        <?php endif; ?>

        <!-- Dynamic Content -->
        <main class="flex-1 min-w-0">
            <?= $this->renderSection('content') ?>
        </main>

    </div>

    <!-- Footer -->
    <?= $this->include('pages/layout/footer') ?>

</body>
</html>