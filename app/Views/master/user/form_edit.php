<!-- Add/Edit User Modal -->
<div x-data="{ showEditModal: false, editForm: { id: null, username: '', nama_lengkap: '', status: 1, roles: [], id_master_organisasi: null} }"
    x-show="showEditModal"
    @open-edit-modal.window="(event) => { editForm = event.detail.user; showEditModal = true; }"
    class="fixed inset-0 flex items-center justify-center overflow-y-auto modal z-99999 bg-black/50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-96">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold mb-4">Edit User</h3>
            <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="mt-3">
            <div class="space-y-6">
                <form @submit.prevent="submitEditUser">
                    <div class="space-y-6 border-gray-100 dark:border-gray-800">
                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Username
                            </label>
                            <input
                                type="text"
                                x-bind:value="editForm.username"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                x-ref="usernameEdit" />
                        </div>

                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Fullname
                            </label>
                            <input
                                type="text"
                                x-bind:value="editForm.nama_lengkap"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                x-ref="nama_lengkapEdit" />
                        </div>
                        <!-- Elements -->
                        <div>
                            <label class="flex items-center mt-3">
                                <input
                                    type="checkbox"
                                    x-bind:checked="editForm.status == 1"
                                    x-ref="statusEdit"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                <span class="ml-2">Active</span>
                            </label>
                        </div>

                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Units
                            </label>
                            <div
                                x-data="{ 
                                isOptionSelected: false,
                                }"
                                class="relative z-20 bg-transparent">
                                <select
                                    x-model="selectedJabatan"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                        Select Option
                                    </option>
                                    <!-- Loop through units and display as options -->
                                    <template x-for="jabatan in jabatans" :key="jabatan.id_master_jabatan">
                                        <option :value="jabatan.id_master_jabatan" x-text="jabatan.nama_jabatan"></option>
                                    </template>
                                </select>
                                <span
                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg
                                        class="stroke-current"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"
                                            stroke=""
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Units
                            </label>
                            <div
                                x-data="{ 
                                isOptionSelected: false,
                                }"
                                class="relative z-20 bg-transparent">
                                <select
                                    x-model="selectedUnit"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                        Select Option
                                    </option>
                                    <!-- Loop through units and display as options -->
                                    <template x-for="unit in units" :key="unit.id_unit_organisasi">
                                        <option :value="unit.id_unit_organisasi" x-text="unit.nama_unit_organisasi"></option>
                                    </template>
                                </select>
                                <span
                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg
                                        class="stroke-current"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"
                                            stroke=""
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Roles -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Roles</label>
                            <div x-show="roles.length > 0"
                                class="space-y-2 max-h-32 overflow-y-auto border border-gray-300 rounded-md p-3">
                                <template x-for="role in roles" :key="role.id_role">
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            :value="role.id_role"
                                            :checked="selectedRoles.some(selectedRole => selectedRole.id_role === role.id_role)"
                                            @change="toggleRole(role)"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <div class="ml-2">
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100"
                                                x-text="role.display_name"></span>
                                            <p class="text-xs text-gray-500 dark:text-gray-400"
                                                x-show="role.description"
                                                x-text="role.description"></p>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" @click="showEditModal = false" class="ml-2 px-4 py-2 border rounded">Cancel</button>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>