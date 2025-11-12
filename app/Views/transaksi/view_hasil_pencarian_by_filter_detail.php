<!-- Add/Edit User Modal -->
<div x-show="showEditModalFilter"
    class="fixed inset-0 flex items-start justify-center overflow-y-auto modal z-99999 bg-black/50 pt-24">
    <!-- dialog: constrained width, max height and internal scroll to avoid overlapping header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl w-11/12 md:w-8/12 lg:w-6/12 max-h-[80vh] flex flex-col">
        <!-- Sticky header so title and close button remain visible while body scrolls -->
        <div class="px-6 py-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-10">
            <h3 class="text-xl font-bold">Detail Paket</h3>
            <button @click="closeEditModal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Scrollable body -->
        <div class="p-6 overflow-y-auto flex-1">
            <div class="space-y-6">
                <form @submit.prevent="submitEditUnit">
                    <div class="space-y-6 border-gray-100 dark:border-gray-800">

                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nama Paket
                            </label>
                            <input
                                type="text"
                                x-bind:value="editForm.nama_paket"
                                readonly
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                x-ref="id_unit_organisasiEdit" />
                        </div>

                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Ketua Pokja
                            </label>
                            <input
                                type="text"
                                x-bind:value="editForm.ketua_pokja"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                x-ref="nama_unitEdit" />
                        </div>

                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Harga Perkiraan Sendiri
                            </label>
                            <!-- Hidden raw value (kept for form submission or internal logic) -->
                            <input type="hidden" x-model="editForm.harga_perkiraan_sendiri" x-ref="hargaRaw" />

                            <!-- Readonly formatted display -->
                            <input
                                type="text"
                                readonly
                                x-bind:value="formatRupiah(editForm.harga_perkiraan_sendiri)"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                x-ref="hargaFormatted" />
                        </div>

                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Persentase Nilai Kontrak
                            </label>
                            <input
                                type="text"
                                x-bind:value="editForm.persentase_nilai_kontrak"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                x-ref="keteranganEdit" />
                        </div>

                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nilai Kontrak
                            </label>
                            <!-- Keep a hidden raw value for submission and internal logic -->
                            <input type="hidden" x-model="editForm.nilai_kontrak" x-ref="nilaiRaw" />

                            <!-- Compute nilai_kontrak whenever persentase or harga changes -->
                            <div x-effect="editForm.nilai_kontrak = ((Number(editForm.persentase_nilai_kontrak) || 0) / 100) * (Number(editForm.harga_perkiraan_sendiri) || 0)"></div>

                            <!-- Readonly formatted display -->
                            <input
                                type="text"
                                readonly
                                x-bind:value="formatRupiah(editForm.nilai_kontrak)"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                x-ref="nilaiFormatted" />
                        </div>

                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Pemenang
                            </label>
                            <input
                                type="text"
                                x-bind:value="editForm.pemenang"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                x-ref="keteranganEdit" />
                        </div>

                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Durasi Pemilihan Penyedia
                            </label>
                            <input
                                type="text"
                                x-bind:value="editForm.durasi_pemilihan"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                x-ref="keteranganEdit" />
                        </div>

                        <!-- Elements -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Tanggal Penetapan Pemenang
                            </label>
                            <input
                                type="text"
                                x-bind:value="editForm.tanggal_penetapan_final"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                x-ref="keteranganEdit" />
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>