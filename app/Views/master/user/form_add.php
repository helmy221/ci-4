<!-- Add/Edit User Modal -->
<div x-show="showAddModal"
    class="fixed inset-0 flex items-center justify-center overflow-y-auto modal z-99999 bg-black/50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-5/12">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold mb-4">Add User</h3>
            <button @click="closeAddModal()" class="text-gray-400 hover:text-gray-600 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="mt-3">
            <div class="space-y-6">
                <form @submit.prevent="submitAddUser">
                    <div class="space-y-6 border-gray-100 dark:border-gray-800">
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Elements -->
                            <div>
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Username
                                </label>
                                <input
                                    type="text"
                                    x-ref="usernameInput"
                                    x-model="AddForm.username"
                                    placeholder="user123"
                                    @input="clearError('username')"
                                    :class=" errors.username ? 'dark:bg-dark-900 border-error-300 shadow-theme-xs focus:border-error-300 focus:ring-error-500/10 dark:border-error-700 dark:focus:border-error-800 w-full rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30'
                                        : 'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30'" />
                                <p x-show="errors.username" x-text="errors.username" class="text-sm text-red-600 mt-1"></p>
                            </div>

                            <!-- Elements -->
                            <div>
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Fullname
                                </label>
                                <input
                                    type="text"
                                    placeholder="User"
                                    x-model="AddForm.nama_lengkap"
                                    @input="clearError('nama_lengkap')"
                                    :class=" errors.nama_lengkap ? 'dark:bg-dark-900 border-error-300 shadow-theme-xs focus:border-error-300 focus:ring-error-500/10 dark:border-error-700 dark:focus:border-error-800 w-full rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30'
                                        : 'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30'" />
                                <p x-show="errors.nama_lengkap" x-text="errors.nama_lengkap" class="text-sm text-red-600 mt-1"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <!-- Elements -->
                            <div>
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Jabatan
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
                        </div>

                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Password
                            </label>
                            <input
                                readonly
                                type="password"
                                x-model="AddForm.password"
                                placeholder="user123"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                            <span class="text-xs italic text-gray-500 dark:text-gray-400">Default Password : 123456</span>
                        </div>

                        <!-- Roles -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Roles</label>
                            <div x-show="roles.length > 0"
                                class="space-y-2 max-h-32 overflow-y-auto border border-gray-300 rounded-md p-3">
                                <div class="grid grid-cols-3 gap-3">
                                    <template x-for="role in roles" :key="role.id_role">
                                        <div>
                                            <label class="flex cursor-pointer items-center">
                                                <input type="checkbox"
                                                    :value="role.id_role"
                                                    :checked="selectedRoles.some(selectedRole => selectedRole.id_role === role.id_role)"
                                                    @change="toggleRole(role)"
                                                    class="sr-only cursor-pointer hover:border-brand-500 dark:hover:border-brand-500 mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]">
                                                <div
                                                    :class="selectedRoles.some(selectedRole => selectedRole.id_role === role.id_role) ? 'border-brand-500 bg-brand-500' : 'bg-transparent border-gray-300 dark:border-gray-700'"
                                                    class="hover:border-brand-500 dark:hover:border-brand-500 mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]">
                                                    <span :class="selectedRoles.some(selectedRole => selectedRole.id_role === role.id_role) ? '' : 'opacity-0'">
                                                        <svg
                                                            width="14"
                                                            height="14"
                                                            viewBox="0 0 14 14"
                                                            fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M11.6666 3.5L5.24992 9.91667L2.33325 7"
                                                                stroke="white"
                                                                stroke-width="1.94437"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="ml-2">
                                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100"
                                                        x-text="role.display_name"></span>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400"
                                                        x-show="role.description"
                                                        x-text="role.description"></p>
                                                </div>
                                            </label>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Elements -->
                        <div class="flex justify-start mt-3">
                            <div>
                                <label
                                    for="checkboxLabelTwoAdd"
                                    class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                    <div class="relative">
                                        <input
                                            type="checkbox"
                                            id="checkboxLabelTwoAdd"
                                            x-model="AddForm.status"
                                            true-value="1"
                                            false-value="0"
                                            class="sr-only" />
                                        <div
                                            :class="AddForm.status == 1 ? 'border-brand-500 bg-brand-500' : 'bg-transparent border-gray-300 dark:border-gray-700'"
                                            class="hover:border-brand-500 dark:hover:border-brand-500 mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]">
                                            <span :class="AddForm.status == 1 ? '' : 'opacity-0'">
                                                <svg
                                                    width="14"
                                                    height="14"
                                                    viewBox="0 0 14 14"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M11.6666 3.5L5.24992 9.91667L2.33325 7"
                                                        stroke="white"
                                                        stroke-width="1.94437"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    Active ?
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" @click="closeAddModal()" class="ml-2 px-4 py-2 hover:bg-gray-50 border rounded">Cancel</button>
                            <!-- <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save</button> -->
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded" x-bind:disabled="loadingAction">
                                <template x-if="loadingAction">
                                    <span>Loading...</span>
                                </template>
                                <template x-if="!loadingAction">
                                    <span>Simpan</span>
                                </template>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>