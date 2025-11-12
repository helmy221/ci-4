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
                    const startIndex = (page - 1) * limit + 1;

                    this.paketPengadaan = data.data.map((item, index) => ({
                        no: startIndex + index,   // nomor urut global
                        ...item
                    }));
                    // this.paketPengadaan = data.data;  // Set users data
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
        // Detail modal state
        showDetailModal: false,
        detailForm: {},

        openDetailModal(item) {
            // clone to avoid mutating list directly
            this.detailForm = Object.assign({}, item);
            this.showDetailModal = true;
        },

        closeDetailModal() {
            this.showDetailModal = false;
            this.detailForm = {};
        },

        async saveDetail() {
            if (!this.detailForm || !this.detailForm.id_transaksi_pemenang) {
                showNotification('error', 'Error', 'Invalid paket id');
                return;
            }

            const id = this.detailForm.id_transaksi_pemenang;

            // Prepare payload - send only updatable fields
            const payload = {
                nama_paket: this.detailForm.nama_paket,
                ketua_pokja: this.detailForm.ketua_pokja,
                id_lokasi_provinsi: this.detailForm.id_lokasi_provinsi,
                persentase_nilai_kontrak: Number(this.detailForm.persentase_nilai_kontrak) || 0,
                harga_perkiraan_sendiri: Number(this.detailForm.harga_perkiraan_sendiri) || 0,
                pemenang: this.detailForm.pemenang,
                durasi_pemilihan: this.detailForm.durasi_pemilihan,
                tanggal_penetapan: this.detailForm.tanggal_penetapan,
                keterangan: this.detailForm.keterangan,
                id_master_jenis_pengadaan: this.detailForm.id_master_jenis_pengadaan,
                id_unit_organisasi: this.detailForm.id_unit_organisasi
            };

            try {
                const res = await fetch(`/api/transaksi/update/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + window.jwtToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();
                if (res.ok && data.status === 'success') {
                    showNotification('success', 'Berhasil', data.message || 'Paket berhasil disimpan');
                    this.closeDetailModal();
                    this.loadPaketPengadaan();
                } else {
                    showNotification('error', 'Gagal', data.message || 'Gagal menyimpan paket');
                }
            } catch (err) {
                console.error(err);
                showNotification('error', 'Error', err.message || 'Terjadi kesalahan');
            }
        },

        formatRupiah(value) {
            if (value === null || value === undefined || value === '') return '-';
            const num = Number(value);
            if (isNaN(num)) return value;
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(num);
        },
    }
}