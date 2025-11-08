window.paketPengadaan = function() {
    return {
        loading: true,
        file: null,
        isUploading: false,
        progress: 0,
        showUploadModal: false,
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
        }
    }
}