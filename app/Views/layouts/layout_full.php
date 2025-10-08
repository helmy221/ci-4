<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Login | TailAdmin') ?></title>

    <?php if (ENVIRONMENT === 'development'): ?>
        <script type="module" src="http://localhost:5173/js/app.js"></script>
    <?php else: ?>
        <link rel="stylesheet" href="<?= base_url('build/assets/app.css') ?>">
        <script type="module" src="<?= base_url('build/assets/app.js') ?>"></script>
    <?php endif; ?>
</head>

<body
    x-data="{ darkMode: false }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'))"
    :class="{'dark bg-gray-900': darkMode === true}"
    class="min-h-screen flex flex-col">
    <?= $this->include('partials/preloader') ?>
    <?= $this->include('partials/alert') ?>

    <!-- Wrapper Login -->
    <div class="flex-grow flex items-center justify-center bg-white dark:bg-gray-900">
        <div class="w-full max-w-md px-6">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Footer -->
    <?= $this->include('partials/footer') ?>
</body>

</html>