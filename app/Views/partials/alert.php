<!-- Notification Container -->
<?php $uri = current_url(true)->getPath(); ?>
<?php if ($uri == '/login') { ?>
    <div id="notification-container" class="fixed top-5 right-4 z-[9999]"></div>
<?php } else { ?>
    <div id="notification-container" class="fixed top-20 right-4 z-[9999]"></div>
<?php } ?>
<script>
    const uri = <?= json_encode($uri) ?>;
    // console.log(uri);
    // Fungsi untuk menampilkan notifikasi
    function showNotification(type, title, message) {
        const config = {
            success: {
                border: 'border-emerald-500',
                ring: 'ring-emerald-500',
                iconBg: 'bg-emerald-100',
                iconColor: 'text-emerald-500',
                icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-emerald-500"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m2.293-4.293a1 1 0 00-1.414 0L12 9l-4-4a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0l5-5a1 1 0 000-1.414z" /></svg>',
                bar: 'bg-emerald-500',
            },
            error: {
                border: 'border-red-500',
                ring: 'ring-red-500',
                iconBg: 'bg-red-100',
                iconColor: 'text-red-500',
                icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-red-500"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6L18 18" /></svg>',
                bar: 'bg-red-500',
            },
            warning: {
                border: 'border-yellow-500',
                ring: 'ring-yellow-500',
                iconBg: 'bg-yellow-100',
                iconColor: 'text-yellow-500',
                icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-yellow-500"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 12h2M12 10v4m0 0l-2 2m2-2l2 2" /></svg>',
                bar: 'bg-yellow-500',
            },
            info: {
                border: 'border-blue-500',
                ring: 'ring-blue-500',
                iconBg: 'bg-blue-100',
                iconColor: 'text-blue-500',
                icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-blue-500"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 0l2-2m-2 2l-2 2M12 16v.01M12 3a9 9 0 11-9 9 9 9 0 019-9z" /></svg>',
                bar: 'bg-blue-500',
            }
        };

        const styles = config[type];
        const notification = document.createElement('div');
        if (uri == '/login') {
            notification.classList.add('fixed', 'top-5', 'right-4', 'w-[360px]', 'z-[9999]', 'shadow-md', 'border', 'border-gray-200', 'rounded-lg', 'overflow-hidden', 'transition-all', 'duration-500');
        } else {
            notification.classList.add('fixed', 'top-20', 'right-4', 'w-[360px]', 'z-[9999]', 'shadow-md', 'border', 'border-gray-200', 'rounded-lg', 'overflow-hidden', 'transition-all', 'duration-500');
        }

        notification.innerHTML = `
        <div class="flex items-center px-4 py-3 bg-white relative ${styles.border}">
            <div class="flex items-center justify-center w-10 h-10 ${styles.iconBg} rounded-md mr-3">
                ${styles.icon}
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-800">${title}</p>
                ${message ? `<p class="text-sm text-gray-600">${message}</p>` : ''}
            </div>
            <button onclick="closeNotification()" class="text-gray-400 hover:text-gray-600 absolute right-3 top-3">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
        </div>
        <div class="h-1 ${styles.bar}"></div>
    `;

        // Append notification to container
        document.getElementById('notification-container').appendChild(notification);

        // Animate notification
        notification.classList.add('translate-x-[100%]', 'opacity-0');
        setTimeout(() => {
            notification.classList.remove('translate-x-[100%]', 'opacity-0');
            notification.classList.add('translate-x-[0]', 'opacity-100');
        }, 10);

        // Hide notification
        setTimeout(() => {
            notification.classList.remove('translate-x-[0]', 'opacity-100');
            notification.classList.add('translate-x-[100%]', 'opacity-0');
            setTimeout(() => notification.remove(), 300); // Remove after animation
        }, 3000);
    }

    // Close the notification manually
    function closeNotification() {
        const notification = document.getElementById('notification-container').lastChild;
        notification.classList.add('translate-x-[100%]', 'opacity-0');
        setTimeout(() => notification.remove(), 300);
    }

    // Show notification from session data
    window.onload = function() {
        const notificationData = <?= json_encode(session()->getFlashdata('notification')) ?>;
        if (notificationData) {
            showNotification(notificationData.type, notificationData.title, notificationData.message);
        }
    };
</script>