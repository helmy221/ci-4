<!-- Add/Edit User Modal -->
<div x-show="showAddModal"
    class="fixed inset-0 flex items-center justify-center overflow-y-auto modal z-99999 bg-black/50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-5/12">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold mb-4">Add Unit Organisasi</h3>
            <button @click="closeAddModal()" class="text-gray-400 hover:text-gray-600 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="mt-3">
            <div class="space-y-6">
                <form @submit.prevent="submitAddUnit">
                    <div class="space-y-6 border-gray-100 dark:border-gray-800">
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Elements -->
                            <div>
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Nama Unit Organisasi
                                </label>
                                <input
                                    type="text"
                                    x-ref="nama_unit_organisasiInput"
                                    x-model="AddForm.nama_unit_organisasi"
                                    placeholder="Direktorat ..."
                                    @input="clearError('nama_unit_organisasi')"
                                    :class=" errors.nama_unit_organisasi ? 'dark:bg-dark-900 border-error-300 shadow-theme-xs focus:border-error-300 focus:ring-error-500/10 dark:border-error-700 dark:focus:border-error-800 w-full rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30'
                                        : 'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30'" />
                                <p x-show="errors.nama_unit_organisasi" x-text="errors.nama_unit_organisasi" class="text-sm text-red-600 mt-1"></p>
                            </div>

                            <!-- Elements -->
                            <div>
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Kode Unit Organisasi
                                </label>
                                <input
                                    type="text"
                                    placeholder="Initials"
                                    x-model="AddForm.kode_unit_organisasi"
                                    @input="clearError('kode_unit_organisasi')"
                                    :class=" errors.kode_unit_organisasi ? 'dark:bg-dark-900 border-error-300 shadow-theme-xs focus:border-error-300 focus:ring-error-500/10 dark:border-error-700 dark:focus:border-error-800 w-full rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30'
                                        : 'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30'" />
                                <p x-show="errors.kode_unit_organisasi" x-text="errors.kode_unit_organisasi" class="text-sm text-red-600 mt-1"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-2">
                            <!-- Elements -->
                            <div>
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Keterangan
                                </label>
                                <textarea
                                    x-model="AddForm.keterangan"
                                    rows="3"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    placeholder="Keterangan tambahan..."></textarea>
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
                                            x-model="AddForm.is_active"
                                            true-value="1"
                                            false-value="0"
                                            class="sr-only" />
                                        <div
                                            :class="AddForm.is_active == 1 ? 'border-brand-500 bg-brand-500' : 'bg-transparent border-gray-300 dark:border-gray-700'"
                                            class="hover:border-brand-500 dark:hover:border-brand-500 mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]">
                                            <span :class="AddForm.is_active == 1 ? '' : 'opacity-0'">
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