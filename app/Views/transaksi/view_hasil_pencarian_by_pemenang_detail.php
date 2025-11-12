<!-- Add/Edit User Modal -->
<div x-show="showEditModalPemenang"
    class="fixed inset-0 flex items-center justify-center overflow-y-auto modal z-99999 bg-black/50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-10/12 md:w-8/12 lg:w-6/12 max-w-4xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold mb-4">Detail Pemenang Paket</h3>
            <button @click="closeEditModal" class="text-gray-400 hover:text-gray-600 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="mt-3">
            <div class="space-y-6">
                <form @submit.prevent="submitEditUnit">
                    <div class="space-y-6 border-gray-100 dark:border-gray-800">

                        <!-- Paket list for selected pemenang -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Daftar Paket untuk: <span x-text="editForm.pemenang"></span></h4>

                                <div class="ml-4 flex items-center space-x-2">
                                    <span class="text-md text-gray-800">Sisa kemampuan paket : </span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-100 text-green-800 text-sm font-large" x-text="Math.max(0, 6 - (paketList ? paketList.length : 0))"></span>
                                </div>
                            </div>

                            <template x-if="paketList && paketList.length">
                                <div class="max-h-64 overflow-auto border rounded">
                                    <table class="min-w-full text-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-3 py-2 text-left">#</th>
                                                <th class="px-3 py-2 text-left">Nama Paket</th>
                                                <th class="px-3 py-2 text-left">Tahun</th>
                                                <th class="px-3 py-2 text-left">HPS</th>
                                                <th class="px-3 py-2 text-left">Persentase Nilai Kontrak</th>
                                                <th class="px-3 py-2 text-left">Nilai Kontrak</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(p, idx) in paketList" :key="p.nama_paket + idx">
                                                <tr class="border-b">
                                                    <td class="px-3 py-2" x-text="idx + 1"></td>
                                                    <td class="px-3 py-2" x-text="p.nama_paket"></td>
                                                    <td class="px-3 py-2" x-text="p.tahun"></td>
                                                    <td class="px-3 py-2" x-text="formatRupiah(p.harga_perkiraan_sendiri)"></td>

                                                    <!-- Persentase Nilai Kontrak (editable per paket) -->
                                                    <td class="px-3 py-2">
                                                        <div class="relative">
                                                            <input type="number" inputmode="decimal" min="0" max="100" step="0.01"
                                                                x-model.number="p.persentase_nilai_kontrak"
                                                                class="w-full pl-2 pr-10 h-8 text-sm border rounded" />
                                                            <span class="absolute right-2 top-1/2 -translate-y-1/2 text-sm text-gray-500">%</span>
                                                        </div>
                                                    </td>

                                                    <!-- Nilai Kontrak = Persentase / 100 * HPS -->
                                                    <td class="px-3 py-2">
                                                        <span x-text="formatRupiah(((Number(p.persentase_nilai_kontrak)||0)/100) * (Number(p.harga_perkiraan_sendiri)||0))"></span>
                                                    </td>

                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </template>

                            <template x-if="!paketList || paketList.length === 0">
                                <div class="text-sm text-gray-500 italic">Tidak ada paket untuk pemenang ini.</div>
                            </template>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>