window.paketPengadaan = function() {
    return {
        paketPengadaan: [],
        loading: true,
        file: null,
        isUploading: false,
        progress: 0,
        showUploadModal: false,
        // Pagination params
        page: 1,  // Current page (initialized to 1)
        perPage: 5,  // Items per page (initialized to 10)
        total: 0,  // Total number of users (initialized to 0)
        search: '',  // Search query (initialized to an empty string)
        pages: 0,
        // Pagination params
        get visiblePages() {
            const start = Math.max(1, this.page - 2);  
            const end = Math.min(this.pages, start + 4);  

            return Array.from({ length: end - start + 1 }, (_, i) => start + i);  
        },

        async loadPaketPengadaan() {
            this.loading = true;

            const page = parseInt(this.page, 5) || 1;
            const limit = this.perPage || 5; 
            const search = this.search || '';

            // Prepare query parameters
            const params = new URLSearchParams();
            params.append('page', page);  // Add page
            params.append('limit', limit);  // Add perPage limit
            params.append('search', search);  // Add search query
            
            try {
                const res = await fetch(`/api/transaksi/?${params.toString()}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + window.jwtToken, // Pastikan jwtToken ada
                        'Accept': 'application/json'
                    }
                });

                // Periksa jika status HTTP 200 atau tidak
                if (!res.ok) {
                    // Jika respons status bukan 2xx (misalnya 401 Unauthorized, 403 Forbidden)
                    if (res.status === 401 || res.status === 403) {
                        console.error('Unauthorized. Please log in again.');
                        // Redirect ke halaman login
                        // window.location.href = "/logout";
                    } else {
                        console.error('Failed to load users:', res.statusText);
                    }
                    this.paketPengadaan = [];
                    return;
                }

                // Jika status HTTP 200 OK, lanjutkan parsing data
                const data = await res.json();
                // console.log("Page", data);
                // Periksa apakah data.status === 'success'
                if (data.status === 'success') {
                    this.paketPengadaan = data.data;  // Set users data
                    this.total = data.pagination.total;  // Set total number of users
                    this.pages = data.pagination.pages;  // Set total number of pages
                    // console.log("Page", this.users);
                } else {
                    console.error('Failed to load users. API responded with error:', data.message);
                    this.paketPengadaan = [];
                }
            } catch (err) {
                console.error('Error during fetching users:', err);
                this.paketPengadaan = [];
            } finally {
                this.loading = false;
            }
        },

        handleFileUpload(event) {
            this.file = event.target.files[0];
        },

        async submitUpload() {
            if(!this.file) {
                this.message = 'Pilih file terlebih dahulu';
                return;
            }

            this.isUploading = true;
            this.message = '';
            this.progress = 0;

            const formData = new FormData();
            formData.append('excel_file', this.file);

            try {
                const res = await fetch(`/api/transaksi/uploadPengadaan`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + window.jwtToken, // Pastikan jwtToken ada
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await res.json();
                this.isUploading = false;

                if (result.success) {
                    this.notification = {
                        type: 'success',
                        title: 'Success',
                        message: result.message || 'User berhasil di Update!.'
                    };
                    this.showUploadModal = false;
                } else {
                    this.notification = {
                        type: 'error',
                        title: 'Error',
                        message: result.message || 'Terjadi kesalahan.'
                    };
                }
                if (this.loadPaketPengadaan) {
                    this.loadPaketPengadaan();  // Memuat ulang daftar users setelah update
                }
                showNotification(this.notification.type, this.notification.title, this.notification.message);
                setTimeout(() => this.notification = null, 3000);
            } catch (error) {
                this.isUploading = false;
                this.notification = {
                    type: 'error',
                    title: 'Error',
                    message: error || 'Terjadi kesalahan.'
                };
                showNotification(this.notification.type, this.notification.title, this.notification.message);
                setTimeout(() => this.notification = null, 3000);
            }
        },

        async download_template() {
            try {
                const response = await fetch(`/api/transaksi/download/Template_Form_Daftar_Pemenang.xlsx`, {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + window.jwtToken, // Pastikan jwtToken ada
                        'Accept': 'application/json'
                    },
                });
                if (!response.ok) {
                    const text = await response.text();
                    this.notification = {
                        type: 'error',
                        title: 'Error',
                        message: text  || 'Gagal download file!.'
                    };
                }

                // Konversi response jadi blob
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);

                // Buat link download sementara
                const a = document.createElement("a");
                a.href = url;
                a.download = "Template_Form_Daftar_Pemenang.xlsx";
                document.body.appendChild(a);
                a.click();
                a.remove();

                // Bersihkan URL object
                window.URL.revokeObjectURL(url);
                this.notification = {
                    type: 'success',
                    title: 'Berhasil',
                    message: 'File berhasil diunduh.',
                };
                showNotification(this.notification.type, this.notification.title, this.notification.message);
                setTimeout(() => this.notification = null, 3000);
            } catch (error) {
                this.notification = {
                    type: 'error',
                    title: 'Error',
                    message: error.message || 'Terjadi kesalahan!.'
                };
                showNotification(this.notification.type, this.notification.title, this.notification.message);
                setTimeout(() => this.notification = null, 3000);
            }
            // window.location.href = '/uploads/template/Template_Form_Daftar_Pemenang.xlsx';
        },
    }
}