<!-- Modal Konfirmasi dengan Alpine.js -->
<div x-data="{
        showModal: false, 
        title: '', 
        text: '', 
        method: '', 
        params: [], 
        confirmText: 'Yes, proceed!', 
        cancelText: 'Cancel',
        
        fetchMethod() {
            const method = this.method;  // Mengambil nama metode
            const params = this.params;  // Mengambil parameter metode

            console.log(`Method: ${method}`);
            console.log(`Params:`, params);

            // Pastikan showConfirm dipanggil dengan benar
            window.showConfirm(this.title, this.text, this.confirmText, this.cancelText).then(result => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, jalankan metode yang diteruskan
                    if (typeof window[method] === 'function') {
                        console.log(`Calling method: ${method}`);
                        window[method](...params)  // Memanggil metode dan meneruskan parameter
                            .then(response => {
                                console.log(response);
                                this.showModal = false;  // Menutup modal setelah aksi selesai
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                this.showModal = false;  // Menutup modal meskipun ada error
                            });
                    } else {
                        console.error(`Method ${method} not found`);
                        this.showModal = false;
                    }
                } else {
                    this.showModal = false;
                }
            });
        }
    }"
    x-show="showModal"
    @show-confirm.window="showModal = true; title = $event.detail.title; text = $event.detail.text; method = $event.detail.method; params = $event.detail.params; confirmText = $event.detail.confirmText; cancelText = $event.detail.cancelText"
    class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50"
    style="display: none;">
    <!-- Modal Content -->
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-xl font-semibold" x-text="title"></h2>
        <p class="mt-4" x-text="text"></p>
        <div class="mt-6 flex justify-end space-x-4">
            <button @click="fetchMethod()" class="px-4 py-2 bg-blue-600 text-white rounded" x-text="confirmText"></button>
            <button @click="showModal = false" class="px-4 py-2 bg-red-600 text-white rounded" x-text="cancelText"></button>
        </div>
    </div>
</div>