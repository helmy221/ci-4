<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div x-data="paketPengadaan()" x-show="!loaded">
    <div x-data="{ showUploadModal: false, showAddModal: false }">
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
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white/90">All Paket Pengadaan</h2>
                            <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">All data paket pengadaan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="showUploadModal = true" class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Upload Paket Pengadaan
                        </button>
                        <button @click="showAddModal = true" class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Paket Pengadaan
                        </button>
                    </div>
                </div>

                <!-- Datatable -->
                <div class="mt-6 flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-6">
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input x-model="search" type="text" placeholder="Search Paket Pengadaan by Nama Paket"
                                class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                @change="loadPaketPengadaan()">
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <select x-model="perPage" class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all duration-200"
                            @change="page = 1; loadPaketPengadaan()">
                            <option value="5">5 per page</option>
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="relative overflow-x-auto" x-init="loadPaketPengadaan()">
                <!-- <div class="overflow-x-auto"> -->
                <!-- Loading Spinner -->
                <template x-if="loading">
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/80 dark:bg-gray-900/70 z-10 backdrop-blur-sm">
                        <div class="h-12 w-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                        <p class="mt-3 text-sm font-medium text-gray-600 dark:text-gray-300">Memuat data...</p>
                    </div>
                </template>

                <!-- test start-->
                <table id="paketPengadaanTable" x-data-show="!loading" class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider transition-colors duration-200 rounded-tl-xl dark:text-gray-400">
                                <div class="flex items-center space-x-2">
                                    <span>no</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider transition-colors duration-200 rounded-tl-xl dark:text-gray-400">
                                <div class="flex items-center space-x-2">
                                    <span>Nama Paket</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider transition-colors duration-200 dark:text-gray-400">
                                <div class="flex items-center space-x-2">
                                    <span>Lokasi</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider transition-colors duration-200 dark:text-gray-400">
                                <div class="flex items-center space-x-2">
                                    <span>HPS</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider transition-colors duration-200 dark:text-gray-400">
                                <div class="flex items-center space-x-2">
                                    <span>Pemenang</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider transition-colors duration-200 dark:text-gray-400">
                                <div class="flex items-center space-x-2">
                                    <span>Tanggal Penentapan</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-tr-xl dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-10 dark:dark:bg-white/[0.03]">
                        <template x-for="paketPengadaanData in paketPengadaan" :key="paketPengadaanData.id_transaksi_pemenang">
                            <tr class="border-gray-100 text-xs">
                                <td class="px-2 py-2 border-b dark:text-gray-200 border-gray-100" x-text="paketPengadaanData.no"></td>
                                <td class="px-2 py-2 border-b dark:text-gray-400 border-gray-100" x-text="paketPengadaanData.nama_paket"></td>
                                <td class="px-2 py-2 border-b dark:text-gray-400 border-gray-100 whitespace-nowrap" x-text="paketPengadaanData.provinsi"></td>
                                <td class="px-2 py-2 border-b dark:text-gray-400 border-gray-100 whitespace-nowrap" x-text="$rupiah(paketPengadaanData.harga_perkiraan_sendiri)"></td>
                                <td class="px-2 py-2 border-b dark:text-gray-400 border-gray-100" x-text="paketPengadaanData.pemenang"></td>
                                <td class="px-2 py-2 border-b dark:text-gray-400 border-gray-100" x-text="paketPengadaanData.tanggal_penetapan"></td>
                                <td class="px-4 py-2 border-b dark:text-gray-400 border-gray-100 whitespace-nowrap">
                                    <button @click="openEditModal(user)"
                                        class=" group/btn inline-flex items-center px-3 py-2 text-xs font-semibold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-1.5 group-hover/btn:rotate-20 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                                        </svg>
                                        Detail
                                    </button>
                                    <!-- Edit -->
                                    <button @click="openEditModal(user)"
                                        class="group/btn inline-flex items-center px-3 py-2 text-xs font-semibold rounded-lg transition-all duration-200 transform hover:scale-105
                                            text-yellow-600 bg-yellow-50 hover:bg-yellow-100 hover:text-yellow-700">
                                        <svg class="w-4 h-4 mr-1.5 group-hover/btn:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <button @click="openEditModal(user)"
                                        class="group/btn inline-flex items-center px-3 py-2 text-xs font-semibold rounded-lg transition-all duration-200 transform hover:scale-105
                                            text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700">
                                        <svg class="w-4 h-4 mr-1.5 group-hover/btn:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="!paketPengadaan.length && !loading">
                            <td colspan="6" class="text-center py-4 text-gray-500">No Paket Pengadaan found</td>
                        </tr>
                    </tbody>
                </table>
                <!-- test end-->
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-t border-gray-200 rounded-b-2xl">
                <div class="flex justify-between items-center">

                    <!-- Page Number Display -->
                    <div class="flex items-center">
                        <span class="text-sm font-semibold text-gray-700">
                            Showing
                            <span x-text="(page - 1) * perPage + 1"></span> to
                            <span x-text="Math.min(page * perPage, total)"></span>
                            of <span x-text="total"></span> users
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!-- Previous Page Button -->
                        <button
                            :disabled="page === 1"
                            @click="page = Math.max(1, page - 1); loadPaketPengadaan()"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md disabled:bg-gray-400">
                            Previous
                        </button>

                        <!-- Page Numbers with Ellipsis -->
                        <template x-if="page > 3">
                            <button
                                @click="page = 1; loadPaketPengadaan()"
                                class="px-4 py-2 bg-white hover:bg-gray-50 text-blue-600 rounded-md">
                                1
                            </button>
                        </template>

                        <template x-if="page > 4">
                            <span class="px-4 py-2 text-gray-500">...</span>
                        </template>

                        <!-- Loop through pages to create page links (Maximum 5 pages) -->
                        <template x-for="pageNum in visiblePages" :key="pageNum">
                            <button
                                @click="page = pageNum; loadPaketPengadaan()"
                                :class="{'bg-blue-600 text-white': page === pageNum, 'bg-white hover:bg-gray-50 text-blue-600': page !== pageNum}"
                                class="px-4 py-2 rounded-md transition-all duration-200">
                                <span x-text="pageNum"></span>
                            </button>
                        </template>

                        <template x-if="page < pages - 2">
                            <span class="px-4 py-2 text-gray-500">...</span>
                        </template>

                        <template x-if="page < pages - 3">
                            <button
                                @click="page = pages; loadPaketPengadaan()"
                                class="px-4 py-2 bg-white hover:bg-gray-50 text-blue-600 rounded-md">
                                <span x-text="pages"></span>
                            </button>
                        </template>

                        <!-- Next Page Button -->
                        <button
                            :disabled="page === pages"
                            @click="page = Math.min(pages, page + 1); loadPaketPengadaan()"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md disabled:bg-gray-400">
                            Next
                        </button>
                    </div>
                </div>

            </div>
        </div>


        <!-- Add upload Modal -->
        <div x-show="showUploadModal"
            class="fixed inset-0 flex items-center justify-center overflow-y-auto modal z-99999 bg-black/50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl max-h-[90vh]">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold mb-4">Upload Paket Pengadaan</h3>
                    <button @click="showUploadModal=false" class="text-gray-400 hover:text-gray-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="mt-3">
                    <div class="space-y-6">
                        <form @submit.prevent="submitUpload">
                            <div class="space-y-6 border-gray-100 dark:border-gray-800">
                                <!-- Elements -->
                                <div class="flex justify-start mt-3">
                                    <div>
                                        <label
                                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Download Template
                                        </label>
                                        <button @click="download_template()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                            Download
                                        </button>
                                    </div>
                                </div>
                                <!-- Elements -->
                                <div class="flex justify-start mt-3">
                                    <div>
                                        <label
                                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Upload file
                                        </label>
                                        <input
                                            type="file"
                                            @change="handleFileUpload"
                                            accept=".xlsx,.xls,.csv"
                                            class="focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:text-white/90 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 dark:placeholder:text-gray-400" />
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button" @click="showUploadModal=false" class="ml-2 px-4 py-2 hover:bg-gray-50 border rounded">Cancel</button>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded" :disabled="!file">
                                        Upload
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add add Modal -->
        <!-- Add/Edit User Modal -->


        <!--<div x-show="showAddModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 overflow-y-auto">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-96">
            <h3 class="text-xl font-bold mb-4">Add Paket Pengadaan</h3>
            <form @submit.prevent="submitAddUser">

                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nama Paket Pengadaan
                    </label>
                    <input type="text" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Kode Unit Organisasi
                    </label>
                    <input type="text" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Ketua Kelompok Kerja
                    </label>
                    <input type="text" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Lokasi
                    </label>
                    <input type="text" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        % Nilai Kontrak
                    </label>
                    <input type="text" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Keterangan
                    </label>
                    <textarea placeholder="Enter a description..." type="text" rows="3" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"></textarea>
                </div>

                <br>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                <button type="button" @click="showAddModal=false" class="ml-2 px-4 py-2 border rounded">Cancel</button>
            </form>
        </div>
    </div>-->

        <!-- Modal Background -->
        <div x-show="showAddModal"
            class="fixed inset-0 z-99999 flex justify-center bg-black/50 overflow-y-auto pt-20">
            <!-- Modal Box -->
            <div class="relative bg-white dark:bg-gray-800 w-full max-w-2xl mx-auto my-10 rounded-2xl shadow-xl flex flex-col max-h-[90vh]">
                <!-- Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Tambah Paket Pengadaan
                    </h3>
                </div>

                <!-- Body -->
                <div class="p-6 overflow-y-auto">
                    <form @submit.prevent="submitAddUser" class="space-y-5">
                        <!-- ✏️ Masukkan semua input kamu di dalam sini -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Nama Paket Pengadaan
                            </label>
                            <input
                                type="text"
                                placeholder="Masukkan nama paket"
                                class="w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Unit Organisasi
                            </label>
                            <select
                                class="w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                                <option value="0">Pilih Unit Organisasi</option>
                                <option>SDA - Direktorat Jenderal Sumber Daya Air</option>
                                <option>BM - Direktorat Jenderal Bina Marga</option>
                                <option>CK - Direktorat Jenderal Cipta Karya</option>
                                <option>PS - Direktorat Jenderal Prasarana Strategis</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Nama Ketua Kelompok Kerja
                            </label>
                            <input
                                type="text"
                                placeholder="Masukkan nama ketua kelompok kerja"
                                class="w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Lokasi Pekerjaan
                            </label>
                            <select
                                class="w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                                <option value="0">Pilih Lokasi Pekerjaan</option>
                                <option>Jawa Barat</option>
                                <option>Luar Jawa Barat</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Nilai Kontrak (%)
                            </label>
                            <input
                                type="number"
                                placeholder="Masukkan nilai kontrak"
                                class="w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Nilai Harga Perkiraan Sendiri (Rp)
                            </label>
                            <input
                                type="number"
                                placeholder="Masukkan nilai HPS"
                                class="w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Nama Pemenang
                            </label>
                            <input
                                type="text"
                                placeholder="Masukkan nama pemenang"
                                class="w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                        <!--<div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                            Nomor Kontrak
                        </label>
                        <input
                            type="text"
                            placeholder="Contoh: 123/SPK/2025"
                            class="w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                    </div>-->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Jenis Pengadaan
                            </label>
                            <select
                                class="w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                                <option>Pilih jenis pengadaan</option>
                                <option>JK - Jasa Konsultansi Konstruksi</option>
                                <option>PK - Pekerjaan Konstruksi</option>
                            </select>
                        </div>
                        <!--<div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                            Tahun Anggaran
                        </label>
                        <input
                            type="text"
                            placeholder="Contoh: 2025"
                            class="w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                    </div>-->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Tanggal Penetapan Pemenang Awal
                            </label>
                            <input
                                type="date"
                                class="w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Tanggal Penetapan Pemenang Final
                            </label>
                            <input
                                type="date"
                                class="w-full h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Keterangan
                            </label>
                            <textarea
                                placeholder="Masukkan keterangan..."
                                rows="3"
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"></textarea>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div
                    class="p-6 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3 bg-white dark:bg-gray-800 rounded-b-2xl">
                    <button
                        type="button"
                        @click="showAddModal = false"
                        class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>