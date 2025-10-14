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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white/90">Paket Pengadaan By Pemenang</h2>
                        <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">Get data paket pengadaan By Pemenang</p>
                    </div>
                </div>
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

                        <div
                            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                            <div class="px-5 py-4 sm:px-6 sm:py-5">
                                <h3
                                    class="text-base font-medium text-gray-800 dark:text-white/90">
                                    Filter
                                </h3>
                            </div>
                            <div
                                class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                                <!-- Elements -->
                                <div>
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Keyword Nama Pemenang
                                    </label>
                                    <input
                                        type="text"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
                                <!-- Elements -->


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- test end-->
        </div>
    </div>
</div>
<?= $this->endSection() ?>