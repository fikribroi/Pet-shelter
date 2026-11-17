<?php
// Tampilan daftar data shelter
?>

<!-- Header judul modul shelter -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-heading font-extrabold text-stone-900 tracking-tight">
            Manajemen Data Shelter
        </h1>
        <p class="text-xs sm:text-sm text-stone-500 mt-1">
            Daftar lokasi shelter/penampungan yang terdaftar beserta jumlah hewan binaan aktif.
        </p>
    </div>

    <a href="<?= Router::url('shelters', 'create') ?>" 
       class="inline-flex items-center gap-2 px-4 py-2 bg-forest-800 hover:bg-forest-900 text-white rounded-xl text-xs sm:text-sm font-semibold transition shadow-sm self-start sm:self-auto">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Tambah Shelter Baru</span>
    </a>
</div>

<!-- Kartu tabel data shelter -->
<div class="bg-white rounded-2xl border border-stone-200/90 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs sm:text-sm">
            <thead>
                <tr class="border-b border-stone-200 bg-stone-50/70 text-stone-500 font-semibold text-[11px] uppercase tracking-wider">
                    <th class="py-3.5 px-4 sm:px-6">ID Shelter</th>
                    <th class="py-3.5 px-4 sm:px-6">Nama Shelter</th>
                    <th class="py-3.5 px-4 sm:px-6">Jumlah Hewan</th>
                    <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100 text-stone-700">
                <?php if (empty($shelters)): ?>
                    <tr>
                        <td colspan="4" class="py-12 px-4 text-center">
                            <div class="max-w-xs mx-auto">
                                <div class="w-12 h-12 rounded-full bg-stone-100 text-stone-400 flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="building-2" class="w-6 h-6"></i>
                                </div>
                                <h4 class="font-bold text-stone-800 text-sm mb-1">Belum Ada Shelter</h4>
                                <p class="text-xs text-stone-500 mb-4">Tambahkan lokasi shelter pertama Anda.</p>
                                <a href="<?= Router::url('shelters', 'create') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-forest-800 text-white rounded-xl text-xs font-semibold hover:bg-forest-900 transition">
                                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                    <span>Tambah Shelter</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($shelters as $s): ?>
                        <tr class="hover:bg-stone-50/80 transition-smooth group">
                            <!-- Kolom ID shelter -->
                            <td class="py-4 px-4 sm:px-6 font-mono font-bold text-stone-800">
                                <span class="px-2.5 py-1 rounded-lg bg-stone-100 border border-stone-200 text-xs">
                                    <?= htmlspecialchars($s['id']) ?>
                                </span>
                            </td>

                            <!-- Kolom nama shelter -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="font-bold text-stone-900 group-hover:text-forest-800 transition">
                                    <?= htmlspecialchars($s['name']) ?>
                                </div>
                                <div class="text-[11px] text-stone-400">
                                    Lokasi Penampungan Hewan
                                </div>
                            </td>

                            <!-- Kolom jumlah hewan -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold <?= $s['animal_count'] > 0 ? 'bg-forest-50 text-forest-800 border border-forest-200' : 'bg-stone-100 text-stone-500 border border-stone-200' ?>">
                                    <i data-lucide="paw-print" class="w-3.5 h-3.5"></i>
                                    <span><?= $s['animal_count'] ?> Hewan</span>
                                </div>
                            </td>

                            <!-- Kolom tombol aksi -->
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="<?= Router::url('shelters', 'edit', ['id' => $s['id']]) ?>" 
                                       class="p-2 rounded-lg text-stone-500 hover:text-forest-800 hover:bg-forest-50 transition" 
                                       title="Edit Shelter">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <button type="button" 
                                            onclick="openDeleteModal({
                                                actionUrl: '<?= Router::url('shelters', 'delete') ?>',
                                                id: '<?= htmlspecialchars($s['id']) ?>',
                                                name: '<?= htmlspecialchars(addslashes($s['name'])) ?> (<?= $s['id'] ?>)',
                                                message: <?= $s['animal_count'] > 0 ? "'Perhatian: Shelter ini masih menaungi " . $s['animal_count'] . " hewan. Penghapusan akan ditolak demi integritas relasi data.'" : "'Data shelter ini akan dihapus permanen.'" ?>
                                            })"
                                            class="p-2 rounded-lg text-stone-400 hover:text-rose-600 hover:bg-rose-50 transition" 
                                            title="Hapus Shelter">
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
            Total <span class="font-bold text-stone-800"><?= count($shelters) ?></span> Shelter Terdaftar
        </div>
    </div>
</div>
