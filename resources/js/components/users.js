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
            return d.toLocaleString();
        }
    }
};