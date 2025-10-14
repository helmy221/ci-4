window.UserUI = function() {
    return {
        users: [],
        loading: true,
        showAddModal: false,
        form: { username: '', email: '' },

        // async loadUsers() {
        //     this.loading = true;
        //     try {
        //         const res = await fetch('/api/users', {
        //         method: 'GET',
        //         headers: {
        //             'Authorization': 'Bearer ' + window.jwtToken,
        //             'Accept': 'application/json'
        //         }
        //         });
        //         const data = await res.json();
        //         if (data.status === 'success') {
        //             this.users = data.data;
        //             // console.log(this.users);
        //         } else {
        //             console.error('Failed to load users');
        //             this.users = [];
        //         }
        //     } catch (err) {
        //         console.error(err);
        //         this.users = [];
        //     } finally {
        //         this.loading = false;
        //     }
        // },

        async loadUsers() {
            this.loading = true;
            try {
                const res = await fetch('/api/users', {
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
                        // window.location.href = "/login";
                    } else {
                        console.error('Failed to load users:', res.statusText);
                    }
                    this.users = [];
                    return;
                }

                // Jika status HTTP 200 OK, lanjutkan parsing data
                const data = await res.json();
                
                // Periksa apakah data.status === 'success'
                if (data.status === 'success') {
                    this.users = data.data;
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

        nonActiveUser(userId) {
            if (!confirm('Are you sure you want to delete this user?')) return;

            fetch(`/api/users/${userId}/softdelete`, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + window.jwtToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    this.users = this.users.filter(u => u.id !== userId);

                    // Tampilkan notification
                    this.notification = {
                        type: 'success',
                        title: 'Success',
                        message: data.message || 'User berhasil non-aktifkan'
                    };

                    // Hilangkan notification setelah 3 detik
                    setTimeout(() => this.notification = null, 3000);
                } else {
                    this.notification = {
                        type: 'error',
                        title: 'Error',
                        message: data.message || 'Gagal menghapus user'
                    };
                    setTimeout(() => this.notification = null, 3000);
                }
            })
            .catch(err => console.error(err));
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