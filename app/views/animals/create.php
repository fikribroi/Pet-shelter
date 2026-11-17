<?php
// Form tambah data hewan
?>

<div class="max-w-2xl mx-auto">
    <!-- Header dan tombol kembali -->
    <div class="mb-6">
        <a href="<?= Router::url('dashboard') ?>" class="inline-flex items-center gap-1.5 text-xs text-stone-500 hover:text-forest-800 font-medium mb-2 transition">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Kembali ke Dashboard</span>
        </a>
        <h1 class="text-2xl font-heading font-extrabold text-stone-900 tracking-tight">
            Tambah Data Hewan Baru
        </h1>
        <p class="text-xs sm:text-sm text-stone-500 mt-1">
            Lengkapi data satwa shelter, penempatan lokasi, dan centang jenis vaksin yang telah diberikan.
        </p>
    </div>

    <!-- Kotak kartu formulir hewan -->
    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-sm overflow-hidden p-6 sm:p-8">
        <form method="POST" action="<?= Router::url('animals', 'store') ?>" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

            <!-- Input ID dan nama hewan -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-1">
                    <label for="id" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                        ID Hewan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="id" 
                           name="id" 
                           value="<?= htmlspecialchars($formData['id'] ?? $suggestedId) ?>" 
                           maxlength="10" 
                           required 
                           class="w-full px-3.5 py-2.5 bg-stone-50 border <?= isset($errors['id']) ? 'border-rose-400 ring-1 ring-rose-400' : 'border-stone-200' ?> rounded-xl text-sm font-mono font-bold text-stone-800 focus:outline-none focus:ring-2 focus:ring-forest-800/10 focus:border-forest-800 transition">
                    <?php if (isset($errors['id'])): ?>
                        <p class="text-xs text-rose-500 mt-1"><?= $errors['id'] ?></p>
                    <?php else: ?>
                        <p class="text-[11px] text-stone-400 mt-1">Maks. 10 karakter (Unik)</p>
                    <?php endif; ?>
                </div>

                <div class="sm:col-span-2">
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                        Nama Hewan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="<?= htmlspecialchars($formData['name'] ?? '') ?>" 
                           placeholder="Contoh: Boni, Milo, Bella..." 
                           maxlength="100" 
                           required 
                           class="w-full px-3.5 py-2.5 bg-white border <?= isset($errors['name']) ? 'border-rose-400 ring-1 ring-rose-400' : 'border-stone-200' ?> rounded-xl text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-forest-800/10 focus:border-forest-800 transition">
                    <?php if (isset($errors['name'])): ?>
                        <p class="text-xs text-rose-500 mt-1"><?= $errors['name'] ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Input umur dan shelter -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-1">
                    <label for="age" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                        Umur (Tahun) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               id="age" 
                               name="age" 
                               min="0" 
                               max="99" 
                               value="<?= htmlspecialchars((string)($formData['age'] ?? '')) ?>" 
                               placeholder="0" 
                               required 
                               class="w-full px-3.5 py-2.5 bg-white border <?= isset($errors['age']) ? 'border-rose-400 ring-1 ring-rose-400' : 'border-stone-200' ?> rounded-xl text-sm text-stone-800 focus:outline-none focus:ring-2 focus:ring-forest-800/10 focus:border-forest-800 transition">
                        <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs text-stone-400 pointer-events-none">
                            Tahun
                        </span>
                    </div>
                    <?php if (isset($errors['age'])): ?>
                        <p class="text-xs text-rose-500 mt-1"><?= $errors['age'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="sm:col-span-2">
                    <label for="shelter_id" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                        Shelter Penampungan <span class="text-rose-500">*</span>
                    </label>
                    <select id="shelter_id" 
                            name="shelter_id" 
                            required 
                            class="w-full px-3.5 py-2.5 bg-white border <?= isset($errors['shelter_id']) ? 'border-rose-400 ring-1 ring-rose-400' : 'border-stone-200' ?> rounded-xl text-sm text-stone-800 focus:outline-none focus:ring-2 focus:ring-forest-800/10 focus:border-forest-800 transition">
                        <option value="">-- Pilih Lokasi Shelter --</option>
                        <?php foreach ($shelters as $s): ?>
                            <option value="<?= htmlspecialchars($s['id']) ?>" <?= ($formData['shelter_id'] ?? '') === $s['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['name']) ?> (<?= $s['id'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['shelter_id'])): ?>
                        <p class="text-xs text-rose-500 mt-1"><?= $errors['shelter_id'] ?></p>
                    <?php else: ?>
                        <p class="text-[11px] text-stone-400 mt-1">Relasi: Satu hewan terdaftar di satu shelter</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pilihan checkbox jenis vaksin -->
            <div class="pt-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                    Jenis Vaksin yang Diterima
                </label>
                <p class="text-xs text-stone-500 mb-3">
                    Centang seluruh vaksin yang telah diberikan pada hewan ini (Relasi Banyak-ke-Banyak).
                </p>

                <?php if (empty($vaccines)): ?>
                    <div class="p-4 rounded-xl bg-stone-50 border border-stone-200 text-xs text-stone-500">
                        Belum ada data master vaksin. Silakan tambahkan melalui menu <a href="<?= Router::url('vaccines', 'create') ?>" class="text-forest-800 underline font-semibold">Daftar Vaksin</a> terlebih dahulu.
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <?php 
                        $selectedVaccines = (array)($formData['vaccines'] ?? []);
                        foreach ($vaccines as $vac): 
                            $isChecked = in_array($vac['id'], $selectedVaccines);
                        ?>
                            <label class="custom-checkbox-card relative flex items-center p-3 rounded-xl border border-stone-200 hover:border-forest-700/60 cursor-pointer transition select-none bg-stone-50/50">
                                <input type="checkbox" 
                                       name="vaccines[]" 
                                       value="<?= htmlspecialchars($vac['id']) ?>" 
                                       <?= $isChecked ? 'checked' : '' ?> 
                                       class="w-4 h-4 text-forest-800 rounded border-stone-300 focus:ring-forest-800 mr-3">
                                <div class="flex-1">
                                    <span class="text-xs font-bold text-stone-800 block"><?= htmlspecialchars($vac['name']) ?></span>
                                    <span class="text-[10px] text-stone-400 font-mono"><?= htmlspecialchars($vac['id']) ?></span>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Tombol aksi formulir hewan -->
            <div class="pt-4 border-t border-stone-100 flex items-center justify-end gap-3">
                <a href="<?= Router::url('dashboard') ?>" 
                   class="px-5 py-2.5 rounded-xl border border-stone-200 text-stone-600 hover:bg-stone-50 text-xs sm:text-sm font-medium transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-forest-800 hover:bg-forest-900 text-white text-xs sm:text-sm font-semibold transition shadow-sm">
                    Simpan Data Hewan
                </button>
            </div>
        </form>
    </div>
</div>
