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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white/90">Filter Paket Pengadaan</h2>
                        <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">Filter data pemenang</p>
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
                            <form method="get" action="/cari-data-paket-pengadaan">
                                <div
                                    class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                                    <!-- Elements -->
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Unit Organisasi
                                            </label>
                                            <div
                                                x-data="{ isOptionSelected: false }"
                                                class="relative z-20 bg-transparent">
                                                <select
                                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                                    @change="isOptionSelected = true" name="organisasi">
                                                    <?php foreach ($listmasterunit as $unit) : ?>
                                                        <option
                                                            value="<?= strtoupper($unit['id_unit_organisasi']); ?>"
                                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                            <?= strtoupper($unit['nama_unit_organisasi']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span
                                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
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
                                        <div>
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Jenis Pekerjaan
                                            </label>
                                            <div
                                                x-data="{ isOptionSelected: false }"
                                                class="relative z-20 bg-transparent">
                                                <select
                                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                                    @change="isOptionSelected = true" name="jenis_pekerjaan">
                                                    <?php foreach ($listjenispekerjaan as $jenis) : ?>
                                                        <option
                                                            value="<?= strtoupper($jenis['id_master_jenis_pengadaan']); ?>"
                                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                            <?= strtoupper($jenis['nama_master_jenis_pengadaan']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span
                                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
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
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Lokasi Pekerjaan
                                            </label>
                                            <div>
                                                <select
                                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                                    @change="isOptionSelected = true" name="lokasi_pekerjaan">
                                                    <?php foreach ($listlokasipekerjaan as $lokasi) : ?>
                                                        <option
                                                            value="<?= strtoupper($lokasi['id_lokasi_provinsi']); ?>"
                                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                            <?= strtoupper($lokasi['nama_provinsi']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span
                                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
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
                                        <div>
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Tahun
                                            </label>
                                            <div
                                                x-data="{ isOptionSelected: false }"
                                                class="relative z-20 bg-transparent">
                                                <select
                                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                                    @change="isOptionSelected = true" name="tahun">
                                                    <?php
                                                    // Generate options for the current year and the two previous years (3 years total)
                                                    $currentYear = (int) date('Y');
                                                    for ($i = 0; $i < 3; $i++) :
                                                        $year = $currentYear - $i;
                                                    ?>
                                                        <option value="<?= $year ?>" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                            <?= $year ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                                <span
                                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
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
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Nilai dari
                                            </label>
                                            <input
                                                type="number" name="harga_min"
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                        </div>
                                        <div>
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Sampai dengan
                                            </label>
                                            <input
                                                type="number" name="harga_max"
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Keyword / Nama Paket Pengadaan
                                        </label>
                                        <input
                                            type="text" name="nama_paket"
                                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                    </div>
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
                                    <!-- Elements -->


                                </div>

                            </form>
                        </div>
                    </div>
                    <!-- test end-->
                </div>
            </div>
        </div>
        <?= $this->endSection() ?>