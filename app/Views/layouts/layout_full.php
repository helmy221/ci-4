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
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #ffffff 100%);
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .content-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: space-between;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body x-data="{ darkMode: false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'))" :class="{'dark bg-gray-900': darkMode === true}" class="antialiased gradient-bg min-h-screen">
    <!-- Background geometric shapes -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-10 left-10 w-20 h-20 bg-white opacity-10 rounded-full floating-animation"></div>
        <div class="absolute top-32 right-20 w-16 h-16 bg-blue-300 opacity-20 rounded-lg" style="animation-delay: -2s;"></div>
        <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-white opacity-15 rounded-full floating-animation" style="animation-delay: -4s;"></div>
        <div class="absolute bottom-32 right-1/3 w-24 h-24 bg-blue-200 opacity-10 rounded-lg floating-animation" style="animation-delay: -1s;"></div>
    </div>

    <?= $this->include('partials/alert') ?>

    <!-- Wrapper Login -->
    <div class="content-wrapper items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="mx-auto w-20 h-20 bg-white rounded-full shadow-lg flex items-center justify-center mb-6">
                    <!-- <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg> -->
                    <img src="<?= base_url('tailadmin/images/logo/logo-pandu.png') ?>" alt="Logo" class="w-10 h-10">
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Welcome Back
                </h2>
                <!-- <p class="text-blue-100">
                    Sign in to {{ config('app.name', 'Laravel Boilerplate') }}
                </p> -->
            </div>
            <?= $this->renderSection('content') ?>
        </div>
        <!-- Footer -->
        <div class="footer text-xs text-blue-100">
            <p>
                &copy; <?= date('Y') ?> <span class="font-semibold">Pandu</span>. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>