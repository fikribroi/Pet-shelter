<?php
// Tampilan dashboard utama sistem
?>

<!-- Bagian statistik ringkasan data -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-stone-900 tracking-tight">
                Pusat Data Hewan Shelter
            </h1>
            <p class="text-sm text-stone-500 mt-1">
                Kelola pendataan hewan, penempatan shelter, serta riwayat jenis vaksinasi secara terpadu.
            </p>
        </div>

        <!-- Tombol akses cepat modul -->
        <div class="flex items-center gap-2.5 flex-wrap">
            <a href="<?= Router::url('shelters') ?>" 
               class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-stone-50 text-stone-700 rounded-xl text-xs sm:text-sm font-semibold border border-stone-200 transition shadow-sm">
                <i data-lucide="building-2" class="w-4 h-4 text-forest-700"></i>
                <span>Kelola Shelter (<?= $totalShelters ?>)</span>
            </a>
            <a href="<?= Router::url('vaccines') ?>" 
               class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-stone-50 text-stone-700 rounded-xl text-xs sm:text-sm font-semibold border border-stone-200 transition shadow-sm">
                <i data-lucide="syringe" class="w-4 h-4 text-forest-700"></i>
                <span>Kelola Vaksin (<?= $totalVaccines ?>)</span>
            </a>
        </div>
    </div>

    <!-- Tiga kartu indikator statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Kartu total data hewan -->
        <div class="bg-white rounded-2xl p-5 border border-stone-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-400 mb-1">Total Hewan Terdata</p>
                <h3 class="text-3xl font-heading font-extrabold text-forest-900"><?= $totalAnimals ?></h3>
                <p class="text-[11px] text-stone-500 mt-1">Dalam perawatan shelter</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-forest-50 text-forest-800 flex items-center justify-center border border-forest-100/80">
                <i data-lucide="paw-print" class="w-6 h-6 text-forest-700"></i>
            </div>
        </div>

        <!-- Kartu total data shelter -->
        <div class="bg-white rounded-2xl p-5 border border-stone-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-400 mb-1">Shelter Terdaftar</p>
                <h3 class="text-3xl font-heading font-extrabold text-forest-900"><?= $totalShelters ?></h3>
                <p class="text-[11px] text-stone-500 mt-1">Lokasi penampungan aktif</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center border border-amber-100/80">
                <i data-lucide="building-2" class="w-6 h-6 text-amber-600"></i>
            </div>
        </div>

        <!-- Kartu total jenis vaksin -->
        <div class="bg-white rounded-2xl p-5 border border-stone-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-400 mb-1">Jenis Vaksin Tersedia</p>
                <h3 class="text-3xl font-heading font-extrabold text-forest-900"><?= $totalVaccines ?></h3>
                <p class="text-[11px] text-stone-500 mt-1">Katalog vaksinasi satwa</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-100/80">
                <i data-lucide="shield-check" class="w-6 h-6 text-emerald-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tabel data utama hewan -->
<div class="bg-white rounded-2xl border border-stone-200/90 shadow-sm overflow-hidden">
    <!-- Formulir pencarian dan filter -->
    <div class="p-4 sm:p-5 border-b border-stone-100 bg-stone-50/40">
        <form method="GET" action="index.php" class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">
            <input type="hidden" name="page" value="dashboard">

            <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-3">
                <!-- Input pencarian nama hewan -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           value="<?= htmlspecialchars($search) ?>" 
                           placeholder="Cari nama hewan..." 
                           class="w-full pl-10 pr-3.5 py-2 bg-white border border-stone-200 rounded-xl text-xs sm:text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-forest-800/10 focus:border-forest-800 transition">
                </div>

                <!-- Dropdown filter lokasi shelter -->
                <div>
                    <select name="shelter_id" 
                            class="w-full px-3.5 py-2 bg-white border border-stone-200 rounded-xl text-xs sm:text-sm text-stone-800 focus:outline-none focus:ring-2 focus:ring-forest-800/10 focus:border-forest-800 transition">
                        <option value="">Semua Shelter (Lokasi)</option>
                        <?php foreach ($shelters as $s): ?>
                            <option value="<?= htmlspecialchars($s['id']) ?>" <?= $selectedShelter === $s['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['name']) ?> (<?= $s['animal_count'] ?> hewan)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Pilihan kolom pengurutan data -->
                <div>
                    <select name="sort_by" 
                            class="w-full px-3.5 py-2 bg-white border border-stone-200 rounded-xl text-xs sm:text-sm text-stone-800 focus:outline-none focus:ring-2 focus:ring-forest-800/10 focus:border-forest-800 transition">
                        <option value="name" <?= $sortBy === 'name' ? 'selected' : '' ?>>Urutkan: Nama Hewan</option>
                        <option value="age" <?= $sortBy === 'age' ? 'selected' : '' ?>>Urutkan: Umur</option>
                        <option value="id" <?= $sortBy === 'id' ? 'selected' : '' ?>>Urutkan: ID Hewan</option>
                    </select>
                </div>
            </div>

            <!-- Tombol filter dan reset -->
            <div class="flex items-center gap-2 shrink-0">
                <select name="sort_order" class="px-3 py-2 bg-white border border-stone-200 rounded-xl text-xs sm:text-sm text-stone-800 focus:outline-none focus:border-forest-800">
                    <option value="ASC" <?= strtoupper($sortOrder) === 'ASC' ? 'selected' : '' ?>>A-Z / Naik</option>
                    <option value="DESC" <?= strtoupper($sortOrder) === 'DESC' ? 'selected' : '' ?>>Z-A / Turun</option>
                </select>

                <button type="submit" 
                        class="px-4 py-2 bg-forest-800 hover:bg-forest-900 text-white rounded-xl text-xs sm:text-sm font-semibold transition shadow-sm">
                    Terapkan
                </button>

                <?php if (!empty($search) || !empty($selectedShelter) || $sortBy !== 'name' || $sortOrder !== 'ASC'): ?>
                    <a href="<?= Router::url('dashboard') ?>" 
                       class="px-3 py-2 bg-stone-100 hover:bg-stone-200 text-stone-600 rounded-xl text-xs sm:text-sm font-medium transition" title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Tabel daftar data hewan -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs sm:text-sm">
            <thead>
                <tr class="border-b border-stone-200 bg-stone-50/70 text-stone-500 font-semibold text-[11px] uppercase tracking-wider">
                    <th class="py-3.5 px-4 sm:px-6">ID & Nama Hewan</th>
                    <th class="py-3.5 px-4 sm:px-6">Nama Shelter</th>
                    <th class="py-3.5 px-4 sm:px-6">Umur</th>
                    <th class="py-3.5 px-4 sm:px-6">Jenis Vaksin</th>
                    <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100 text-stone-700">
                <?php if (empty($animals)): ?>
                    <tr>
                        <td colspan="5" class="py-12 px-4 text-center">
                            <div class="max-w-xs mx-auto">
                                <div class="w-12 h-12 rounded-full bg-stone-100 text-stone-400 flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="inbox" class="w-6 h-6"></i>
                                </div>
                                <h4 class="font-bold text-stone-800 text-sm mb-1">Tidak Ada Data Hewan</h4>
                                <p class="text-xs text-stone-500 mb-4">
                                    <?= !empty($search) || !empty($selectedShelter) ? 'Tidak ditemukan data dengan kata kunci atau filter yang Anda pilih.' : 'Belum ada data hewan yang tersimpan di sistem.' ?>
                                </p>
                                <a href="<?= Router::url('animals', 'create') ?>" 
                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-forest-800 text-white rounded-xl text-xs font-semibold hover:bg-forest-900 transition">
                                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                    <span>Tambah Hewan Baru</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($animals as $animal): ?>
                        <tr class="hover:bg-stone-50/80 transition-smooth group">
                            <!-- Kolom nama hewan -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-forest-100 text-forest-800 font-bold flex items-center justify-center text-xs shrink-0 border border-forest-200">
                                        <?= strtoupper(substr($animal['name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="font-bold text-stone-900 group-hover:text-forest-800 transition">
                                            <?= htmlspecialchars($animal['name']) ?>
                                        </div>
                                        <div class="text-[11px] text-stone-400 font-mono">
                                            <?= htmlspecialchars($animal['id']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Kolom shelter relasi satu-banyak -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-stone-100 text-stone-700 text-xs font-medium border border-stone-200/60">
                                    <i data-lucide="home" class="w-3.5 h-3.5 text-forest-700"></i>
                                    <span><?= htmlspecialchars($animal['shelter_name']) ?></span>
                                </div>
                            </td>

                            <!-- Kolom umur hewan -->
                            <td class="py-4 px-4 sm:px-6 font-medium text-stone-600">
                                <span class="inline-block px-2 py-0.5 rounded-md bg-stone-100 text-stone-700 text-xs font-semibold">
                                    <?= (int) $animal['age'] ?> Tahun
                                </span>
                            </td>

                            <!-- Kolom vaksin relasi banyak-banyak -->
                            <td class="py-4 px-4 sm:px-6">
                                <?php if (!empty($animal['vaccine_names'])): ?>
                                    <div class="flex flex-wrap gap-1.5 max-w-md">
                                        <?php 
                                        $vList = explode(', ', $animal['vaccine_names']);
                                        foreach ($vList as $vac): 
                                        ?>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                                                <i data-lucide="check" class="w-3 h-3 text-emerald-600"></i>
                                                <?= htmlspecialchars($vac) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-stone-100 text-stone-500 border border-stone-200">
                                        Belum Divaksin
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Kolom tombol aksi -->
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="<?= Router::url('animals', 'edit', ['id' => $animal['id']]) ?>" 
                                       class="p-2 rounded-lg text-stone-500 hover:text-forest-800 hover:bg-forest-50 transition" 
                                       title="Edit Data Hewan">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <button type="button" 
                                            onclick="openDeleteModal({
                                                actionUrl: '<?= Router::url('animals', 'delete') ?>',
                                                id: '<?= htmlspecialchars($animal['id']) ?>',
                                                name: '<?= htmlspecialchars(addslashes($animal['name'])) ?> (<?= $animal['id'] ?>)',
                                                message: 'Data hewan ini akan dihapus permanen beserta relasi vaksinnya.'
                                            })"
                                            class="p-2 rounded-lg text-stone-400 hover:text-rose-600 hover:bg-rose-50 transition" 
                                            title="Hapus Data Hewan">
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
            Menampilkan <span class="font-bold text-stone-800"><?= count($animals) ?></span> data hewan
            <?php if (!empty($search) || !empty($selectedShelter)): ?>
                (dari total <?= $totalAnimals ?> hewan)
            <?php endif; ?>
        </div>
    </div>
</div>
