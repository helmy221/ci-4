<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<!--<div x-data="UserUI()" x-show="!loaded">-->
<div x-data="UserUI()">
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white/90">Unit Organisasi</h2>
                        <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">Data Unit Organisasi</p>
                    </div>
                </div>
                <button @click="showAddModal = true" class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Unit Organisasi
                </button>
            </div>
        </div>


        <div class="overflow-x-auto" x-init="loadUsers()">
            <!-- Loading Spinner -->
            <div x-show="loading" class="flex justify-center items-center my-4">
                <div class="h-12 w-12 animate-spin rounded-full border-4 border-solid border-blue-500 border-t-transparent"></div>
            </div>
            <!-- test start-->
            <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="max-w-full overflow-x-auto">
                        <table class="min-w-full">
                            <!-- table header start -->
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <th class="px-5 py-3 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"> id </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"> Unit Organisasi </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"> Kode Unit Organisasi </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"> Keterangan </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"> Status </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"> Aksi </p>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <!-- table header end -->
                            <!-- table body start -->
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                <?php if (!empty($organisasi) && is_array($organisasi)) : ?>
                                    <?php foreach ($organisasi as $org) : ?>
                                        <tr>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400"> <?= $org['id_unit_organisasi'] ?> </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400"> <?= $org['nama_unit_organisasi'] ?> </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400"> <?= $org['kode_unit_organisasi'] ?> </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500"> <?= $org['keterangan'] ?> </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <?php if (isset($org['is_active']) && ($org['is_active'] == '1' || $org['is_active'] === 1)): ?>
                                                        <p class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">Aktif</p>
                                                    <?php else: ?>
                                                        <p class="rounded-full bg-danger-50 px-2 py-0.5 text-theme-xs font-medium text-danger-700 dark:bg-danger-500/15 dark:text-danger-500">Non aktif</p>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center space-x-2">
                                                    <button type="button" @click="openEditModal({ id: <?= $org['id_unit_organisasi'] ?>, nama: <?= json_encode($org['nama_unit_organisasi']) ?>, kode: <?= json_encode($org['kode_unit_organisasi']) ?>, keterangan: <?= json_encode($org['keterangan']) ?>, is_active: <?= json_encode($org['is_active']) ?> })" class="text-sm px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded">Edit</button>
                                                    <button type="button" class="text-sm px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded">Delete</button>
                                                </div>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <tr>
                                        <td class="px-5 py-4 sm:px-6" colspan="5">
                                            <div class="text-center text-gray-500">No data available.</div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- test end-->
        </div>
    </div>


    <!-- Add Organisasi Modal -->
    <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-96">
            <h3 class="text-xl font-bold mb-4">Add Unit Organisasi</h3>
            <form @submit.prevent="submitAddUser">
                <!-- Elements start -->
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nama Unit Organisasi
                    </label>
                    <input type="text" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Kode Unit Organisasi
                    </label>
                    <input type="text" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Keterangan
                    </label>
                    <textarea placeholder="Enter a description..." type="text" rows="3" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"></textarea>
                </div>
                <!-- Elements end -->
                <br>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                <button type="button" @click="showAddModal=false" class="ml-2 px-4 py-2 border rounded">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Edit Modal (uses UserUI() scope) -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-96">
            <h3 class="text-xl font-bold mb-4">Edit Unit Organisasi</h3>
            <form @submit.prevent="submitEditUser()">
                <input type="hidden" x-model="editForm.id">
                <div class="mb-3">
                    <label class="block text-sm">Nama Unit Organisasi</label>
                    <input x-model="editForm.nama" type="text" class="w-full rounded border px-3 py-2" />
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Kode Unit Organisasi</label>
                    <input x-model="editForm.kode" type="text" class="w-full rounded border px-3 py-2" />
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Keterangan</label>
                    <textarea x-model="editForm.keterangan" rows="3" class="w-full rounded border px-3 py-2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Status</label>
                    <select x-model="editForm.is_active" class="w-full rounded border px-3 py-2">
                        <option value="1">Aktif</option>
                        <option value="0">Non aktif</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="showEditModal=false" class="mr-2 px-4 py-2 border rounded">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>