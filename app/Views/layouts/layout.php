<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?= esc($title ?? 'Dashboard | TailAdmin') ?></title>
    <script>
        // Set token dari session PHP ke global JS
        const check = "<?= auth()->check() ?>";
        if (check) {
            window.jwtToken = "<?= auth()->user()->token() ?? '' ?>";
            console.log("TOKEN : ", window.jwtToken);
        } else {
            window.location.href = "/login";
        };
    </script>


    <?php if (ENVIRONMENT === 'development'): ?>
        <script type="module" src="http://localhost:5173/js/app.js"></script>
    <?php else: ?>
        <link rel="stylesheet" href="<?= base_url('build/assets/app.css') ?>">
        <script type="module" src="<?= base_url('build/assets/app.js') ?>"></script>
    <?php endif; ?>

    <style>
        /* Modern Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slideInRight {
            animation: slideInRight 0.4s ease-out;
        }

        /* Glassmorphism Effects */
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Animasi Sidebar */
        .sidebar {
            transition: transform 0.3s ease-out, width 0.3s ease-out;
            /* Menambahkan transisi pada perubahan posisi translate dan lebar */
        }

        .sidebar-header {
            transition: justify-content 0.3s ease-out;
            /* Menambahkan transisi pada header */
        }

        .swal-backdrop-custom {
            z-index: 999999 !important;
            /* Set a high z-index for the backdrop */
        }
    </style>
</head>

<body
    x-data="{ page: 'ecommerce', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
    $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}">
    <!-- Preloader -->
    <?= $this->include('partials/preloader') ?>
    <?= $this->include('partials/alert') ?>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?= $this->include('partials/sidebar') ?>

        <!-- Content Area -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <!-- Overlay -->
            <?= $this->include('partials/overlay') ?>

            <!-- Header -->
            <?= $this->include('partials/header') ?>

            <!-- Main Content -->
            <main>
                <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
                    <!-- Breadcrumb Start -->
                    <div x-data="{ pageName: `<?= $page ?>`}">
                        <?= $this->include('partials/breadcrumb') ?>
                    </div>
                    <!-- Breadcrumb End -->
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
            <!-- Footer -->
            <?= $this->include('partials/footer') ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.showConfirm = function(title, text, confirmText = 'Yes, proceed!', cancelText = 'Cancel') {
            return Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                reverseButtons: true,
                customClass: {
                    backdrop: 'swal-backdrop-custom' // Add custom class for the popup
                }
            }).then((result) => {
                // Optionally, handle the result here
                return result;
            });
        };
    </script>
</body>

</html>