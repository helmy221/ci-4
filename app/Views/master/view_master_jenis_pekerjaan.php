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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white/90">Jenis Pengadaan</h2>
                        <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">Data Jenis Pengadaan</p>
                    </div>
                </div>
                <button @click="showAddModal = true" class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Jenis Pengadaan
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
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"> User </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"> Project Name </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"> Team </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"> Status </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"> Budget </p>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <!-- table header end -->
                            <!-- table body start -->
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                <tr>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 overflow-hidden rounded-full">
                                                    <img src="./images/user/user-17.jpg" alt="brand" />
                                                </div>
                                                <div>
                                                    <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90"> Lindsey Curtis </span>
                                                    <span class="block text-gray-500 text-theme-xs dark:text-gray-400"> Web Designer </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400"> Agency Website </p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <div class="flex -space-x-2">
                                                <div class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                                    <img src="./images/user/user-22.jpg" alt="user" />
                                                </div>
                                                <div class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                                    <img src="./images/user/user-23.jpg" alt="user" />
                                                </div>
                                                <div class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                                    <img src="./images/user/user-24.jpg" alt="user" />
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500"> Active </p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">3.9K</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 overflow-hidden rounded-full">
                                                    <img src="./images/user/user-18.jpg" alt="brand" />
                                                </div>
                                                <div>
                                                    <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                        Kaiya George
                                                    </span>
                                                    <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                                        Project Manager
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                Technology
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <div class="flex -space-x-2">
                                                <div class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                                    <img src="./images/user/user-25.jpg" alt="user" />
                                                </div>
                                                <div class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                                    <img src="./images/user/user-26.jpg" alt="user" />
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="rounded-full bg-warning-50 px-2 py-0.5 text-theme-xs font-medium text-warning-700 dark:bg-warning-500/15 dark:text-warning-400">
                                                Pending
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                24.9K
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- test end-->
        </div>
    </div>


    <!-- Add Jenis Pengadaan Modal -->
    <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-96">
            <h3 class="text-xl font-bold mb-4">Add Jenis Pengadaan</h3>
            <form @submit.prevent="submitAddUser">
                <!-- Elements start -->
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nama Jenis Pengadaan
                    </label>
                    <input type="text" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Kode Jenis Pengadaan
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
</div>
<?= $this->endSection() ?>