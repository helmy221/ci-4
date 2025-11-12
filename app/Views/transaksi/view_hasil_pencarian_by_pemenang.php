<?= $this->extend('layouts/layout') ?>
<?= $this->section('content') ?>
<div x-data="TransaksiPemenangUI()" x-show="!loaded">
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

                        <div class="overflow-x-auto rounded-lg border">
                            <table id="resultsTable" class="min-w-full table-auto divide-y divide-gray-200" style="width:100%">
                                <thead class="bg-gray-50 text-center">
                                    <tr>
                                        <th class="col-name px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ketua Pokja</th>
                                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Pemenang</th>
                                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga Perkiraan Sendiri</th>
                                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    <?php if (!empty($hasil)): ?>
                                        <?php foreach ($hasil as $t): ?>
                                            <tr class="hover:bg-gray-50">
                                                <td class="col-name px-6 py-4 text-sm text-gray-700"><?= esc($t['nama_paket']) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= esc($t['ketua_pokja']) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= esc($t['pemenang']) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-right" data-order="<?= (float) $t['harga_perkiraan_sendiri'] ?>">Rp <?= number_format($t['harga_perkiraan_sendiri'], 0, ',', '.') ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-right">
                                                    <button @click='openEditModalPemenang(<?= json_encode($t, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'
                                                        class=" group/btn inline-flex items-center px-3 py-2 text-xs font-semibold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-all duration-200 transform hover:scale-105">
                                                        <svg class="w-4 h-4 mr-1.5 group-hover/btn:rotate-20 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                                                        </svg>
                                                        Cek SKP
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-500 text-center">Tidak ada data ditemukan.</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- test end-->
                </div>
            </div>
        </div>

        <!-- DataTables assets (CDN) and init script -->
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">-->
        <link rel="stylesheet" href="<?= base_url('assets/jquery.dataTables.min.css') ?>">
        <style>
            /* Tweak DataTables controls to match Tailwind-like appearance */
            .dataTables_wrapper .dataTables_filter input {
                padding: 0.5rem 0.75rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.375rem;
                background: #fff;
                color: #111827;
                margin-left: 0.5rem;
            }

            .dataTables_wrapper .dataTables_length select {
                padding: 0.35rem 0.5rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.375rem;
                background: #fff;
                color: #111827;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 0.35rem 0.6rem;
                margin: 0 0.15rem;
                border-radius: 0.35rem;
                border: 1px solid transparent;
                background: #f3f4f6;
                color: #111827;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: #3b82f6;
                color: #ffffff !important;
                border-color: #3b82f6;
            }

            /* Table layout and column wrapping */
            #resultsTable {
                table-layout: fixed;
            }

            #resultsTable .col-name {
                width: 40%;
                white-space: normal;
                word-break: break-word;
            }

            /* Make table font size slightly smaller for a compact view */
            #resultsTable th,
            #resultsTable td {
                font-size: 0.75rem;
                /* 12px */
            }

            /* Reduce cell padding to match smaller font */
            #resultsTable td,
            #resultsTable th {
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
        </style>
        <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
        <script src="<?= base_url('assets/jquery-3.6.0.min.js') ?>"></script>
        <!--<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>-->
        <script src="<?= base_url('assets/jquery.dataTables.min.js') ?>"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize DataTable on the results table
                if (typeof $ !== 'undefined' && $('#resultsTable').length) {
                    // Normalize tbody when template outputs a single <td colspan="N"> placeholder
                    try {
                        var $table = $('#resultsTable');
                        var headerCount = $table.find('thead tr').first().find('th').length;
                        var $tbody = $table.find('tbody');
                        var $rows = $tbody.find('tr');
                        if ($rows.length === 1) {
                            var tdCount = $rows.first().find('td').length;
                            if (tdCount === 1) {
                                var $onlyTd = $rows.first().find('td').first();
                                var colspan = parseInt($onlyTd.attr('colspan') || '0', 10);
                                if (colspan > 1 && colspan !== headerCount) {
                                    var msg = $onlyTd.html();
                                    var newCells = '<td class="px-6 py-4 text-sm text-gray-500 text-center">' + msg + '</td>';
                                    for (var i = 1; i < headerCount; i++) newCells += '<td></td>';
                                    $rows.first().html(newCells);
                                }
                            }
                        }
                        var firstRowCellCount = $table.find('tbody tr').first().find('td').length || 0;
                        if (headerCount !== firstRowCellCount) {
                            console.warn('DataTables init aborted: header columns (%d) != first row cells (%d)', headerCount, firstRowCellCount);
                            return;
                        }
                    } catch (e) {
                        console.warn('Error while normalizing table rows for DataTables:', e);
                    }

                    $('#resultsTable').DataTable({
                        responsive: true,
                        pageLength: 10,
                        lengthChange: true,
                        ordering: true,
                        order: [
                            [1, 'desc']
                        ], // default order by Tahun desc
                        columnDefs: [
                            // Price column: format as Indonesian Rupiah using createdCell so sorting uses data-order attribute
                            {
                                targets: 3,
                                searchable: false,
                                createdCell: function(td, cellData, rowData, row, col) {
                                    var raw = $(td).data('order');
                                    if (raw !== undefined && raw !== null && raw !== '') {
                                        try {
                                            var nf = new Intl.NumberFormat('id-ID', {
                                                style: 'currency',
                                                currency: 'IDR',
                                                maximumFractionDigits: 0
                                            });
                                            $(td).text(nf.format(Number(raw)));
                                        } catch (e) {
                                            // Fallback to simple formatting
                                            $(td).text('Rp ' + Number(raw).toLocaleString('id-ID'));
                                        }
                                    }
                                }
                            }
                        ],
                        language: {
                            paginate: {
                                previous: '&larr;',
                                next: '&rarr;'
                            },
                            search: 'Cari:',
                            lengthMenu: 'Tampilkan _MENU_ baris'
                        }
                    });
                }
            });
        </script>
        <?= $this->include('transaksi/view_hasil_pencarian_by_pemenang_detail') ?>
        <?= $this->endSection() ?>