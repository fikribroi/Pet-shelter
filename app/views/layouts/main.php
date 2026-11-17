<?php
// Layout utama antarmuka sistem
$activeMenu = $activeMenu ?? 'dashboard';
$pageTitle  = $pageTitle ?? 'TemuTeduh';
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F7F9F7]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> — TemuTeduh</title>
    
    <!-- Impor Google Fonts Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Framework Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        forest: {
                            50: '#F4F7F5',
                            100: '#E6EFE8',
                            200: '#C8DBD0',
                            300: '#A4C3AF',
                            400: '#78977B',
                            500: '#527756',
                            600: '#3D5C41',
                            700: '#2C4530',
                            800: '#183B36',
                            900: '#122D29',
                            950: '#0B1B18',
                        },
                        leaf: '#78977B',
                        mint: '#E6EFE8',
                        amberAccent: '#D6A653',
                        stoneDark: '#24332F',
                    },
                    fontFamily: {
                        sans: ['"DM Sans"', '-apple-system', 'sans-serif'],
                        heading: ['"Manrope"', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Berkas stylesheet custom aplikasi -->
    <link rel="stylesheet" href="assets/css/app.css">

    <!-- Ikon antarmuka Lucide CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="h-full flex flex-col font-sans text-stoneDark bg-[#F7F9F7] antialiased selection:bg-forest-100 selection:text-forest-900">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar navigasi layar desktop -->
        <aside class="hidden md:flex flex-col w-64 bg-forest-900 text-white shrink-0 border-r border-forest-800 select-none">
            <!-- Header logo identitas brand -->
            <div class="p-6 border-b border-forest-800/80">
                <a href="<?= Router::url('dashboard') ?>" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-forest-800 text-forest-100 flex items-center justify-center border border-forest-700/60 shadow-inner group-hover:bg-forest-700 transition">
                        <i data-lucide="paw-print" class="w-5 h-5 text-amberAccent"></i>
                    </div>
                    <div>
                        <div class="font-heading font-extrabold text-lg tracking-tight text-white flex items-center gap-1.5">
                            TemuTeduh
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        </div>
                        <p class="text-xs text-forest-300 font-medium">Shelter Management</p>
                    </div>
                </a>
            </div>

            <!-- Daftar menu navigasi utama -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <div class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-forest-400">
                    Menu Utama
                </div>

                <!-- Menu dashboard dan hewan -->
                <a href="<?= Router::url('dashboard') ?>" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition <?= $activeMenu === 'dashboard' ? 'bg-forest-800 text-white shadow-sm font-semibold border-l-4 border-amberAccent pl-2.5' : 'text-forest-200 hover:bg-forest-800/60 hover:text-white' ?>">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 <?= $activeMenu === 'dashboard' ? 'text-amberAccent' : 'text-forest-400' ?>"></i>
                    <span>Dashboard & Hewan</span>
                </a>

                <!-- Menu kelola daftar shelter -->
                <a href="<?= Router::url('shelters') ?>" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition <?= $activeMenu === 'shelters' ? 'bg-forest-800 text-white shadow-sm font-semibold border-l-4 border-amberAccent pl-2.5' : 'text-forest-200 hover:bg-forest-800/60 hover:text-white' ?>">
                    <i data-lucide="building-2" class="w-4 h-4 <?= $activeMenu === 'shelters' ? 'text-amberAccent' : 'text-forest-400' ?>"></i>
                    <span>Daftar Shelter</span>
                </a>

                <!-- Menu kelola daftar vaksin -->
                <a href="<?= Router::url('vaccines') ?>" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition <?= $activeMenu === 'vaccines' ? 'bg-forest-800 text-white shadow-sm font-semibold border-l-4 border-amberAccent pl-2.5' : 'text-forest-200 hover:bg-forest-800/60 hover:text-white' ?>">
                    <i data-lucide="syringe" class="w-4 h-4 <?= $activeMenu === 'vaccines' ? 'text-amberAccent' : 'text-forest-400' ?>"></i>
                    <span>Daftar Vaksin</span>
                </a>

                <div class="pt-6 px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-forest-400">
                    Aksi Cepat
                </div>

                <a href="<?= Router::url('animals', 'create') ?>" 
                   class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-medium text-forest-300 hover:bg-forest-800/40 hover:text-white transition">
                    <i data-lucide="plus-circle" class="w-3.5 h-3.5 text-forest-400"></i>
                    <span>Tambah Hewan Baru</span>
                </a>
                <a href="<?= Router::url('shelters', 'create') ?>" 
                   class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-medium text-forest-300 hover:bg-forest-800/40 hover:text-white transition">
                    <i data-lucide="plus-circle" class="w-3.5 h-3.5 text-forest-400"></i>
                    <span>Tambah Shelter</span>
                </a>
                <a href="<?= Router::url('vaccines', 'create') ?>" 
                   class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-medium text-forest-300 hover:bg-forest-800/40 hover:text-white transition">
                    <i data-lucide="plus-circle" class="w-3.5 h-3.5 text-forest-400"></i>
                    <span>Tambah Vaksin</span>
                </a>
            </nav>

        </aside>

        <!-- Menu drawer navigasi mobile -->
        <div id="mobileDrawer" class="fixed inset-0 z-50 hidden md:hidden">
            <div id="mobileDrawerBackdrop" class="fixed inset-0 bg-stone-900/60 backdrop-blur-sm transition-opacity"></div>
            <div class="fixed inset-y-0 left-0 w-72 bg-forest-900 text-white shadow-2xl flex flex-col z-10">
                <div class="p-5 border-b border-forest-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-forest-800 flex items-center justify-center">
                            <i data-lucide="paw-print" class="w-5 h-5 text-amberAccent"></i>
                        </div>
                        <div>
                            <div class="font-heading font-bold text-white text-base">TemuTeduh</div>
                            <div class="text-[11px] text-forest-300">Shelter Management</div>
                        </div>
                    </div>
                    <button id="closeDrawerBtn" class="p-1.5 rounded-lg text-forest-300 hover:text-white hover:bg-forest-800 transition" aria-label="Tutup Menu">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="<?= Router::url('dashboard') ?>" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition <?= $activeMenu === 'dashboard' ? 'bg-forest-800 text-white font-semibold' : 'text-forest-200 hover:bg-forest-800/60' ?>">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>Dashboard & Hewan</span>
                    </a>
                    <a href="<?= Router::url('shelters') ?>" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition <?= $activeMenu === 'shelters' ? 'bg-forest-800 text-white font-semibold' : 'text-forest-200 hover:bg-forest-800/60' ?>">
                        <i data-lucide="building-2" class="w-4 h-4"></i>
                        <span>Daftar Shelter</span>
                    </a>
                    <a href="<?= Router::url('vaccines') ?>" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition <?= $activeMenu === 'vaccines' ? 'bg-forest-800 text-white font-semibold' : 'text-forest-200 hover:bg-forest-800/60' ?>">
                        <i data-lucide="syringe" class="w-4 h-4"></i>
                        <span>Daftar Vaksin</span>
                    </a>
                </nav>

                <div class="p-4 border-t border-forest-800 text-xs text-forest-400">
                    Proyek PBO Sistem Informasi
                </div>
            </div>
        </div>

        <!-- Area konten utama halaman -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#F7F9F7]">
            <!-- Bar navigasi bagian atas -->
            <header class="bg-white border-b border-stone-200 shrink-0 z-10">
                <div class="px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg text-stone-600 hover:bg-stone-100 transition" aria-label="Buka Menu">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                        <div class="hidden sm:flex items-center gap-2 text-xs text-stone-500 font-medium">
                            <a href="<?= Router::url('dashboard') ?>" class="hover:text-forest-800">TemuTeduh</a>
                            <i data-lucide="chevron-right" class="w-3 h-3 text-stone-400"></i>
                            <span class="text-stone-800 font-semibold"><?= htmlspecialchars($pageTitle) ?></span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden lg:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-stone-100/80 text-stone-600 text-xs font-medium border border-stone-200/60">
                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-stone-400"></i>
                            <span><?= date('l, d M Y') ?></span>
                        </div>
                        <a href="<?= Router::url('animals', 'create') ?>" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-forest-800 hover:bg-forest-900 text-white rounded-xl text-xs sm:text-sm font-semibold transition shadow-sm hover:shadow">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            <span>Tambah Hewan</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Kotak pesan flash notifikasi -->
            <?php if (!empty($flash)): ?>
                <div id="toastAlert" class="px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="flex items-center gap-3 p-4 rounded-xl border text-sm <?= $flash['type'] === 'success' ? 'bg-emerald-50 text-emerald-900 border-emerald-200' : ($flash['type'] === 'error' ? 'bg-rose-50 text-rose-900 border-rose-200' : 'bg-amber-50 text-amber-900 border-amber-200') ?> shadow-sm animate-fade-in">
                        <i data-lucide="<?= $flash['type'] === 'success' ? 'check-circle' : 'alert-circle' ?>" class="w-5 h-5 shrink-0 <?= $flash['type'] === 'success' ? 'text-emerald-600' : ($flash['type'] === 'error' ? 'text-rose-600' : 'text-amber-600') ?>"></i>
                        <p class="flex-1 font-medium"><?= htmlspecialchars($flash['message']) ?></p>
                        <button onclick="document.getElementById('toastAlert').remove()" class="p-1 rounded-lg hover:bg-black/5 transition" aria-label="Tutup Notifikasi">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Slot wadah konten dinamis -->
            <main class="flex-1 overflow-y-auto px-4 sm:px-6 lg:px-8 py-6">
                <?= $content ?>
            </main>
        </div>
    </div>

    <!-- Modal konfirmasi penghapusan data -->
    <div id="deleteConfirmModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="deleteConfirmModalBackdrop" class="fixed inset-0 bg-stone-900/50 backdrop-blur-sm transition-opacity"></div>
        <div class="relative bg-white rounded-2xl shadow-xl border border-stone-200 max-w-md w-full p-6 text-center z-10 animate-fade-in">
            <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 mx-auto flex items-center justify-center mb-4 border border-rose-100">
                <i data-lucide="trash-2" class="w-6 h-6"></i>
            </div>
            <h3 class="font-heading font-bold text-lg text-stone-900 mb-1">Konfirmasi Penghapusan</h3>
            <p class="text-sm text-stone-500 mb-2">
                Apakah Anda yakin ingin menghapus data:
            </p>
            <div id="deleteConfirmItemName" class="font-semibold text-stone-900 bg-stone-50 py-1.5 px-3 rounded-lg inline-block text-sm border border-stone-200 mb-4">
                Data Item
            </div>
            <p id="deleteConfirmMessage" class="text-xs text-stone-400 mb-6 leading-relaxed">
                Tindakan ini akan menghapus data dari sistem dan tidak dapat dibatalkan.
            </p>

            <form id="deleteConfirmForm" method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                <input type="hidden" name="id" id="deleteConfirmId" value="">

                <div class="flex items-center justify-center gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="w-1/2 px-4 py-2.5 rounded-xl border border-stone-200 text-stone-700 hover:bg-stone-50 font-medium text-sm transition">
                        Batal
                    </button>
                    <button type="submit" class="w-1/2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm transition shadow-sm">
                        Ya, Hapus Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Muat skrip JavaScript aplikasi -->
    <script src="assets/js/app.js"></script>
</body>
</html>
