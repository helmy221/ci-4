window.UserUI = function() {
    return {
        users: [],
        roles: [],
        units: [],
        jabatans: [],
        selectedRoles: [],
        selectedUnit: null,
        selectedJabatan: null,
        loading: true,
        loadingAction: false,
        showAddModal: false,
        showEditModal: false,
        showInactive: false,
        visiblePages: false,
        page: 1,  // Current page (initialized to 1)
        perPage: 5,  // Items per page (initialized to 10)
        total: 0,  // Total number of users (initialized to 0)
        search: '',  // Search query (initialized to an empty string)
        pages: 0,
        AddForm: {},
        editForm: {},
        errors: {},

        get visiblePages() {
            const start = Math.max(1, this.page - 2);  
            const end = Math.min(this.pages, start + 4);  

            return Array.from({ length: end - start + 1 }, (_, i) => start + i);  
        },

        async loadUsers() {
            this.loading = true;

            const page = parseInt(this.page, 5) || 1;
            const limit = this.perPage || 5; 
            const search = this.search || '';

            // Prepare query parameters
            const params = new URLSearchParams();
            params.append('page', page);  // Add page
            params.append('limit', limit);  // Add perPage limit
            params.append('search', search);  // Add search query

            if (this.showInactive) {
                params.append('status', '0');  // Show inactive users if checkbox is checked
            } else {
                params.append('status', '1');  // Show only active users
            }
            
            try {
                const res = await fetch(`/api/users/?${params.toString()}`, {
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
                    this.users = [];
                    return;
                }

                // Jika status HTTP 200 OK, lanjutkan parsing data
                const data = await res.json();
                // console.log("Page", data);
                // Periksa apakah data.status === 'success'
                if (data.status === 'success') {
                    this.users = data.data;  // Set users data
                    this.total = data.pagination.total;  // Set total number of users
                    this.pages = data.pagination.pages;  // Set total number of pages
                    // console.log("Page", this.users);
                } else {
                    console.error('Failed to load users. API responded with error:', data.message);
                    this.users = [];
                }
            } catch (err) {
                console.error('Error during fetching users:', err);
                this.users = [];
            } finally {
                this.loading = false;
            }
        },

        //get Roles
        async loadRoles() {
            this.loadingRoles = true;
            try {
                const res = await fetch('/api/roles', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + window.jwtToken
                }
                });

                if (!res.ok) throw new Error(`HTTP error: ${res.status}`);
                const data = await res.json();

                this.roles = data.data ?? data.roles ?? data; 
                // console.log("Roles : ", this.roles);
            } catch (err) {
                console.error('Gagal load roles:', err);
                this.roles = [];
            } finally {
                this.loadingRoles = false;
            }
        },

        //get Units
        async loadUnits() {
            // this.loadingRoles = true;
            try {
                const res = await fetch('/api/units', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + window.jwtToken // jika pakai JWT
                }
                });

                if (!res.ok) throw new Error(`HTTP error: ${res.status}`);
                const data = await res.json();

                // Pastikan format sesuai (misal data.data atau data langsung)
                this.units = data.data ?? data.units ?? data; 
                // console.log("Units : ", this.units);
            } catch (err) {
                console.error('Gagal load roles:', err);
                this.roles = [];
            } finally {
                this.loadingRoles = false;
            }
        },

        //get jabatan
        async loadJabatan() {
            // this.loadingRoles = true;
            try {
                const res = await fetch('/api/jabatan', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + window.jwtToken // jika pakai JWT
                }
                });

                if (!res.ok) throw new Error(`HTTP error: ${res.status}`);
                const data = await res.json();

                // Pastikan format sesuai (misal data.data atau data langsung)
                this.jabatans = data.data ?? data.jabatans ?? data; 
                // console.log("Units : ", this.units);
            } catch (err) {
                console.error('Gagal load jabatan:', err);
                this.roles = [];
            } finally {
                this.loadingJabatan = false;
            }
        },

        async nonActiveUser(userId) {
            return fetch(`/api/users/${userId}/softdelete`, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + window.jwtToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())  // Parse response as JSON
            .then(data => {
                if (data.status === 'success') {
                    // this.users = this.users.filter(u => u.id !== userId);
                    this.loadUsers();
                    // Tampilkan notification
                    this.notification = {
                        type: 'success',
                        title: 'Success',
                        message: data.message || 'User berhasil non-aktifkan'
                    };

                    // Call showNotification to display the notification
                    showNotification(this.notification.type, this.notification.title, this.notification.message);
                    
                    // Hilangkan notification setelah 3 detik
                    setTimeout(() => this.notification = null, 3000);
                } else {
                    this.notification = {
                        type: 'error',
                        title: 'Error',
                        message: data.message || 'Gagal menghapus user'
                    };

                    // Call showNotification to display the notification
                    showNotification(this.notification.type, this.notification.title, this.notification.message);

                    setTimeout(() => this.notification = null, 3000);
                }
            })
            .catch(err => {
            console.error('Error during fetching:', err);
            // Set error notification for network or other errors
            this.notification = {
                type: 'error',
                title: 'Error',
                message: 'An error occurred while trying to deactivate the user.'
            };

            // Call showNotification to display the error notification
            showNotification(this.notification.type, this.notification.title, this.notification.message);

            });
        },

        validateForm() {
            this.errors = {};
            if (this.showAddModal) {
                if (!this.AddForm.username.trim()) {
                    this.errors.username = 'Username wajib diisi.';
                }
                if (!this.AddForm.nama_lengkap.trim()) {
                    this.errors.nama_lengkap = 'Nama lengkap wajib diisi.';
                }
            }

            if (this.showEditModal) {
                if (!this.editForm.username.trim()) {
                    this.errors.username = 'Username wajib diisi.';
                }
                if (!this.editForm.nama_lengkap.trim()) {
                    this.errors.nama_lengkap = 'Nama lengkap wajib diisi.';
                }
            }

            // return true jika tidak ada error
            return Object.keys(this.errors).length === 0;
        },
        
        clearError(field) {
            if (this.errors[field]) delete this.errors[field];
        },

        async submitAddUser() {
            fetch('/api/users', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(this.form)
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    this.showAddModal = false;
                    this.form = { username: '', email: '' };
                    this.loadUsers(); // Reload users after adding
                } else {
                    alert(data.message || 'Failed to add user');
                }
            }).catch(err => console.error(err));
        },

        async ShowConfirm(title, text, confirmText, cancelText, method, params) {
            this.title = title;
            this.text = text;
            this.confirmText = confirmText;
            this.cancelText = cancelText;

            console.log(`Method: ${method}`);
            console.log(`Params:`, params);

            window.showConfirm(this.title, this.text, this.confirmText, this.cancelText).then(result => {
                if (result.isConfirmed) {
                    if (typeof this[method] === 'function') {
                        console.log(`Calling method: ${method}`);
                        // Call the method dynamically and return the promise
                        this[method](...params)  // Call the method with params
                            .then(response => {
                                console.log(response);  // Handle success
                                this.showModal = false;  // Close modal after action
                            })
                            .catch(error => {
                                console.error('Error:', error);  // Handle error
                                this.showModal = false;  // Close modal even if there's an error
                            });
                    } else {
                        console.error(`Method ${method} not found`);
                        this.showModal = false;
                    }
                } else {
                    this.showModal = false; // Close modal if not confirmed
                }
            });
        },

        async openEditModal(user) {
            this.editForm = JSON.parse(JSON.stringify(user));
            this.selectedRoles = user.roles.map(role => ({
                id_role: role.id_role,
                display_name: role.display_name
            }));
            this.selectedUnit = user.id_master_organisasi;
            this.selectedJabatan = user.id_master_jabatan;
            this.showEditModal = true;
            // console.log('Open Modal Edit:', this.editForm);
        },

        async closeEditModal() {
            this.showEditModal = false;
            this.editForm = {};
            this.selectedRoles = [];
            this.selectedUnit = '';
            this.selectedJabatan = '';
        },

        toggleRole(role) {
            const index = this.selectedRoles.findIndex(selectedRole => selectedRole.id_role === role.id_role);
            if (index !== -1) {
                this.selectedRoles.splice(index, 1);
            } else {
                this.selectedRoles.push({ id_role: role.id_role, display_name: role.display_name });
            }
        },

        async submitEditUser() {
            // Ambil nilai terbaru dari input
            const form_update = {
                id : this.editForm.id,
                username: this.$refs.usernameEdit.value,
                nama_lengkap: this.$refs.nama_lengkapEdit.value,
                status: this.editForm.status,
                roles: this.selectedRoles.map(role => role.id_role),
                id_unit_organisasi: this.selectedUnit,
                id_master_jabatan: this.selectedJabatan
            }
            console.log('Submitting edited user 1:', this.editForm);

            console.log('Submitting edited user 2:', form_update);
            try {
                const res = await fetch(`api/users/update/${form_update.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type' : 'application/json',
                        'Authorization': 'Bearer ' + window.jwtToken
                    },
                    body: JSON.stringify(form_update)
                });
                const data = await res.json();
                // console.log('User updated:', data);
                this.showEditModal = false;
                // Tampilkan notification
                this.notification = {
                    type: 'success',
                    title: 'Success',
                    message: data.message || 'User berhasil di Update!.'
                };

                // Call showNotification to display the notification
                showNotification(this.notification.type, this.notification.title, this.notification.message);
                // Hilangkan notification setelah 3 detik
                setTimeout(() => this.notification = null, 3000);
                if (this.loadUsers) {
                    this.loadUsers();  // Memuat ulang daftar users setelah update
                }
            } catch (err) {
                console.error('Update failed : ', err);
            }
        },

        async openAddModal() {
            this.AddForm = {
                username: '',
                nama_lengkap: '',
                id_master_jabatan: null,
                id_master_organisasi: null,
                password: '12345678',
                roles: [],
                status: 1,
            };
            this.showAddModal = true;
            this.$nextTick(() => this.$refs.usernameInput.focus());
            console.log('Open Modal Add:', this.AddForm);
        },

        async closeAddModal() {
            this.showAddModal = false;
            this.AddForm = { username: '', nama_lengkap: '', status: 1, id_master_jabatan: null, id_master_organisasi: null };
            this.selectedRoles = [];
            this.selectedUnit = '';
            this.selectedJabatan = '';
            
        },

        async submitAddUser() {
            // Ambil nilai terbaru dari input
            this.AddForm = {
                username: this.AddForm.username,
                nama_lengkap: this.AddForm.nama_lengkap,
                id_unit_organisasi: this.selectedUnit,
                id_master_jabatan: this.selectedJabatan,
                password: this.AddForm.password,
                roles: this.selectedRoles.map(role => role.id_role),
                status: this.AddForm.status,
            }
            console.log('Submitting Add user :', this.AddForm);
            if (!this.validateForm()) return;
            this.loadingAction = true;
            try {
                const response = await fetch(`api/users/add`, {
                    method: 'POST',
                    headers: {
                        'Content-Type' : 'application/json',
                        'Authorization': 'Bearer ' + window.jwtToken
                    },
                    body: JSON.stringify(this.AddForm)
                });
                const result  = await response.json();

                
                if (response.ok && result.success) {
                this.notification = {
                    type: 'success',
                    title: 'Success',
                    message: result.message || 'User berhasil di Update!.'
                };
                if (this.loadUsers) {
                    this.loadUsers();  // Memuat ulang daftar users setelah update
                }
                this.showAddModal = false;
                this.AddForm = { username: '', nama_lengkap: '', status: 1, id_master_jabatan: null, id_master_organisasi: null };
                this.selectedRoles = [];
                this.selectedUnit = '';
                this.selectedJabatan = '';
                } else {
                this.notification = {
                    type: 'error',
                    title: 'Error',
                    message: result.message || 'Terjadi kesalahan.'
                };
                }
                showNotification(this.notification.type, this.notification.title, this.notification.message);
                setTimeout(() => this.notification = null, 3000);
            } catch (err) {
                console.error('Update failed : ', err);
                this.notification = {
                    type: 'error',
                    title: 'Error',
                    message: err || 'Terjadi kesalahan.'
                };
                showNotification(this.notification.type, this.notification.title, this.notification.message);
                setTimeout(() => this.notification = null, 3000);
            } finally {
                this.loadingAction = false;
            }
        },

        formatRoles(roles) {
            return roles.join(', ');
        },


        formatDate(dateStr) {
            if (!dateStr) return '-';
            const d = new Date(dateStr);
            // Contoh: Oct 13, 2025
            return d.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
        },

        timeAgo(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            const now = new Date();
            const diff = Math.floor((now - date) / 1000); // detik

            if (diff < 60) return `${diff} seconds ago`;
            if (diff < 3600) return `${Math.floor(diff/60)} minutes ago`;
            if (diff < 86400) return `${Math.floor(diff/3600)} hours ago`;
            return `${Math.floor(diff/86400)} days ago`;
        }
    }
};