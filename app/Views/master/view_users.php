<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div x-data="UserUI()" x-show="!loaded">
    <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="bg-gradient-to-r  px-6 py-6 border-b border-gray-200 dark:border-gray-800 dark:bg-">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white/90">Users Management</h2>
                        <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">Manage system users and their access</p>
                    </div>
                </div>
                <button @click="showAddModal = true" class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add User
                </button>
            </div>
        </div>

        <div class="overflow-x-auto" x-init="loadUsers()">
            <!-- Loading Spinner -->
            <div x-show="loading" class="flex justify-center items-center my-4">
                <div class="h-12 w-12 animate-spin rounded-full border-4 border-solid border-blue-500 border-t-transparent"></div>
            </div>

            <table id="usersTable" x-data-show="!loading" class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider transition-colors duration-200 rounded-tl-xl dark:text-gray-400">
                            <div class="flex items-center space-x-2">
                                <span>no</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider transition-colors duration-200 rounded-tl-xl dark:text-gray-400">
                            <div class="flex items-center space-x-2">
                                <span>Username</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider transition-colors duration-200 dark:text-gray-400">
                            <div class="flex items-center space-x-2">
                                <span>Fullname</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-gray-400">Roles</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-gray-400">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-gray-400">Created</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-tr-xl dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-10 dark:dark:bg-white/[0.03]">
                    <template x-for="user in users" :key="user.id">
                        <tr class="border-gray-100 text-xs">
                            <td class="px-4 py-2 border-b dark:text-gray-400 border-gray-100" x-text="user.id"></td>
                            <td class="px-4 py-2 border-b dark:text-gray-400 border-gray-100" x-text="user.username"></td>
                            <td class="px-4 py-2 border-b dark:text-gray-400 border-gray-100" x-text="user.nama_lengkap"></td>
                            <!-- <td class="px-4 py-2 border-b dark:text-gray-400 border-gray-100" x-text="formatRoles(user.roles)"></td> -->
                            <td class="px-4 py-2 border-b dark:text-gray-400 border-gray-100">
                                <template x-if="user.roles && user.roles.length > 0">
                                    <template x-for="role in user.roles" :key="role.id">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 shadow-sm">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                            <span x-text="user.roles"></span>
                                        </span>
                                    </template>
                                </template>
                            </td>
                            <!-- <td class="px-4 py-2 border-b dark:text-gray-400 border-gray-100" x-text="user.status"></td> -->
                            <td class="px-4 py-2 border-b dark:text-gray-400 border-gray-100">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold shadow-sm"
                                    :class="user.status == 1
                                    ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-800'
                                    : 'bg-gradient-to-r from-red-100 to-pink-100 text-red-800'">
                                    <div
                                        class="w-2 h-2 rounded-full mr-2"
                                        :class="user.status == 1 ? 'bg-green-500 animate-pulse' : 'bg-red-500'">
                                    </div>
                                    <span x-text="user.status == 1? 'Active' : 'Inactive'"></span>
                                </span>
                            </td>

                            <!-- <td class="px-4 py-2 border-b dark:text-gray-400 border-gray-100" x-text="formatDate(user.created_at)"></td> -->
                            <td class="px-4 py-2 border-b dark:text-gray-400 border-gray-100">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <div class="font-xs" x-text="formatDate(user.created_at)"></div>
                                        <div class="text-xs" x-text="timeAgo(user.created_at)"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2 border-b dark:text-gray-400 border-gray-100">
                                <button
                                    class="group/btn inline-flex items-center px-3 py-2 text-xs font-semibold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-4 h-4 mr-1.5 group-hover/btn:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </button>
                                <button
                                    @click="ShowConfirm(
                                                 user.status == 1 ? 'Confirm Deactivate' : 'Confirm Activate',  // title
                                                 user.status == 1 ? 'Are you sure you want to deactivate this user?' : 'Are you sure you want to activate this user?',  // text
                                                 user.status == 1 ? 'Yes, deactivate it!' : 'Yes, activate it!',  // confirmText
                                                'Cancel',  // cancelText
                                                'nonActiveUser',  // method
                                                [user.id]  // params (an array of parameters, in this case user ID)
                                                )"
                                    class="group/btn inline-flex items-center px-3 py-2 text-xs font-semibold rounded-lg transition-all duration-200 transform hover:scale-105
                                    text-yellow-600 bg-yellow-50 hover:bg-yellow-100 hover:text-yellow-700">
                                    <svg class="w-4 h-4 mr-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            :d="user.status == 1 
                                            ? 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728'
                                            : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'">
                                        </path>
                                    </svg>
                                    <span x-text="user.status == 1 ? 'Deactivate' : 'Activate'"></span>
                                </button>
                                <!-- <button
                                    @click="nonActiveUser(user.id)"
                                    class="group/btn inline-flex items-center px-3 py-2 text-xs font-semibold rounded-lg transition-all duration-200 transform hover:scale-105
                                    text-yellow-600 bg-yellow-50 hover:bg-yellow-100 hover:text-yellow-700">
                                    <svg class="w-4 h-4 mr-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            :d="user.status == 1 
                                            ? 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728'
                                            : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'">
                                        </path>
                                    </svg>
                                    <span x-text="user.status == 1 ? 'Deactivate' : 'Activate'"></span>
                                </button> -->
                            </td>
                        </tr>
                    </template>
                    <tr x-show="!users.length && !loading">
                        <td colspan="6" class="text-center py-4 text-gray-500">No users found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add User Modal -->
    <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-96">
            <h3 class="text-xl font-bold mb-4">Add User</h3>
            <form @submit.prevent="submitAddUser">
                <input type="text" placeholder="Username" x-model="form.username" class="w-full mb-2 px-3 py-2 border rounded" />
                <input type="email" placeholder="Email" x-model="form.email" class="w-full mb-2 px-3 py-2 border rounded" />
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                <button type="button" @click="showAddModal=false" class="ml-2 px-4 py-2 border rounded">Cancel</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>