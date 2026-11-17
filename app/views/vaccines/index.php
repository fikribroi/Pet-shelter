<?php
// Tampilan daftar data vaksin
?>

<!-- Header judul modul vaksin -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-heading font-extrabold text-stone-900 tracking-tight">
            Manajemen Data Vaksin
        </h1>
        <p class="text-xs sm:text-sm text-stone-500 mt-1">
            Katalog jenis vaksin satwa shelter beserta jumlah hewan yang telah divaksinasi.
        </p>
    </div>

    <a href="<?= Router::url('vaccines', 'create') ?>" 
       class="inline-flex items-center gap-2 px-4 py-2 bg-forest-800 hover:bg-forest-900 text-white rounded-xl text-xs sm:text-sm font-semibold transition shadow-sm self-start sm:self-auto">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Tambah Vaksin Baru</span>
    </a>
</div>

<!-- Kartu tabel data vaksin -->
<div class="bg-white rounded-2xl border border-stone-200/90 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs sm:text-sm">
            <thead>
                <tr class="border-b border-stone-200 bg-stone-50/70 text-stone-500 font-semibold text-[11px] uppercase tracking-wider">
                    <th class="py-3.5 px-4 sm:px-6">ID Vaksin</th>
                    <th class="py-3.5 px-4 sm:px-6">Jenis Vaksin</th>
                    <th class="py-3.5 px-4 sm:px-6">Jumlah Hewan Tervaksinasi</th>
                    <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100 text-stone-700">
                <?php if (empty($vaccines)): ?>
                    <tr>
                        <td colspan="4" class="py-12 px-4 text-center">
                            <div class="max-w-xs mx-auto">
                                <div class="w-12 h-12 rounded-full bg-stone-100 text-stone-400 flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="syringe" class="w-6 h-6"></i>
                                </div>
                                <h4 class="font-bold text-stone-800 text-sm mb-1">Belum Ada Jenis Vaksin</h4>
                                <p class="text-xs text-stone-500 mb-4">Tambahkan jenis vaksin satwa pertama Anda.</p>
                                <a href="<?= Router::url('vaccines', 'create') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-forest-800 text-white rounded-xl text-xs font-semibold hover:bg-forest-900 transition">
                                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                    <span>Tambah Vaksin</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($vaccines as $v): ?>
                        <tr class="hover:bg-stone-50/80 transition-smooth group">
                            <!-- Kolom ID jenis vaksin -->
                            <td class="py-4 px-4 sm:px-6 font-mono font-bold text-stone-800">
                                <span class="px-2.5 py-1 rounded-lg bg-stone-100 border border-stone-200 text-xs">
                                    <?= htmlspecialchars($v['id']) ?>
                                </span>
                            </td>

                            <!-- Kolom nama jenis vaksin -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="font-bold text-stone-900 group-hover:text-forest-800 transition">
                                    <?= htmlspecialchars($v['name']) ?>
                                </div>
                                <div class="text-[11px] text-stone-400">
                                    Vaksinasi Medis Satwa
                                </div>
                            </td>

                            <!-- Kolom jumlah hewan tervaksinasi -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold <?= $v['animal_count'] > 0 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-stone-100 text-stone-500 border border-stone-200' ?>">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                                    <span><?= $v['animal_count'] ?> Hewan</span>
                                </div>
                            </td>

                            <!-- Kolom tombol aksi -->
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="<?= Router::url('vaccines', 'edit', ['id' => $v['id']]) ?>" 
                                       class="p-2 rounded-lg text-stone-500 hover:text-forest-800 hover:bg-forest-50 transition" 
                                       title="Edit Vaksin">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <button type="button" 
                                            onclick="openDeleteModal({
                                                actionUrl: '<?= Router::url('vaccines', 'delete') ?>',
                                                id: '<?= htmlspecialchars($v['id']) ?>',
                                                name: '<?= htmlspecialchars(addslashes($v['name'])) ?> (<?= $v['id'] ?>)',
                                                message: 'Menghapus jenis vaksin ini akan otomatis membersihkan status vaksinasi terkait pada hewan.'
                                            })"
                                            class="p-2 rounded-lg text-stone-400 hover:text-rose-600 hover:bg-rose-50 transition" 
                                            title="Hapus Vaksin">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Bagian footer tabel -->
    <div class="p-4 border-t border-stone-100 bg-stone-50/50 flex items-center justify-between text-xs text-stone-500">
        <div>
            Total <span class="font-bold text-stone-800"><?= count($vaccines) ?></span> Jenis Vaksin Terdaftar
        </div>
    </div>
</div>
