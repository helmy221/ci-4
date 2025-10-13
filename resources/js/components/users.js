window.UserUI = function() {
    return {
        users: [],
        loading: true,
        showAddModal: false,
        form: { username: '', email: '' },

        async loadUsers() {
            this.loading = true;
            try {
                const res = await fetch('/api/users');
                const data = await res.json();
                if (data.status === 'success') {
                    this.users = data.data;
                    // console.log(this.users);
                } else {
                    console.error('Failed to load users');
                    this.users = [];
                }
            } catch (err) {
                console.error(err);
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
                    // Hapus user dari array lokal agar UI langsung update
                    this.users = this.users.filter(u => u.id !== userId);
                } else {
                    alert(data.message || 'Failed to delete user');
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