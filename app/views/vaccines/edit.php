<?php
// Form edit jenis vaksin
?>

<div class="max-w-xl mx-auto">
    <!-- Header dan navigasi kembali -->
    <div class="mb-6">
        <a href="<?= Router::url('vaccines') ?>" class="inline-flex items-center gap-1.5 text-xs text-stone-500 hover:text-forest-800 font-medium mb-2 transition">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Kembali ke Daftar Vaksin</span>
        </a>
        <h1 class="text-2xl font-heading font-extrabold text-stone-900 tracking-tight">
            Edit Data Vaksin
        </h1>
        <p class="text-xs sm:text-sm text-stone-500 mt-1">
            Perbarui nama jenis vaksin medis satwa.
        </p>
    </div>

    <!-- Kotak kartu form vaksin -->
    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-sm overflow-hidden p-6 sm:p-8">
        <form method="POST" action="<?= Router::url('vaccines', 'update') ?>" class="space-y-5">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
            <input type="hidden" name="id" value="<?= htmlspecialchars($formData['id']) ?>">

            <!-- Kolom ID vaksin readonly -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                    ID Vaksin (Kunci Utama)
                </label>
                <input type="text" 
                       value="<?= htmlspecialchars($formData['id']) ?>" 
                       disabled 
                       class="w-full px-3.5 py-2.5 bg-stone-100 border border-stone-200 rounded-xl text-sm font-mono font-bold text-stone-600 cursor-not-allowed">
                <p class="text-[11px] text-stone-400 mt-1">ID tidak dapat diubah</p>
            </div>

            <!-- Input nama jenis vaksin -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                    Nama Jenis Vaksin <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="<?= htmlspecialchars($formData['name'] ?? '') ?>" 
                       maxlength="100" 
                       required 
                       class="w-full px-3.5 py-2.5 bg-white border <?= isset($errors['name']) ? 'border-rose-400 ring-1 ring-rose-400' : 'border-stone-200' ?> rounded-xl text-sm text-stone-800 focus:outline-none focus:ring-2 focus:ring-forest-800/10 focus:border-forest-800 transition">
                <?php if (isset($errors['name'])): ?>
                    <p class="text-xs text-rose-500 mt-1"><?= $errors['name'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Tombol aksi formulir vaksin -->
            <div class="pt-4 border-t border-stone-100 flex items-center justify-end gap-3">
                <a href="<?= Router::url('vaccines') ?>" 
                   class="px-5 py-2.5 rounded-xl border border-stone-200 text-stone-600 hover:bg-stone-50 text-xs sm:text-sm font-medium transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-forest-800 hover:bg-forest-900 text-white text-xs sm:text-sm font-semibold transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
