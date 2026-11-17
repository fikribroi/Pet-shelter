// Skrip interaktivitas aplikasi antarmuka
document.addEventListener('DOMContentLoaded', () => {
    // Inisialisasi ikon Lucide
    if (window.lucide) {
        window.lucide.createIcons();
    }

    // Navigasi menu mobile drawer
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileDrawer = document.getElementById('mobileDrawer');
    const mobileDrawerBackdrop = document.getElementById('mobileDrawerBackdrop');
    const closeDrawerBtn = document.getElementById('closeDrawerBtn');

    function openMobileDrawer() {
        if (!mobileDrawer) return;
        mobileDrawer.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeMobileDrawer() {
        if (!mobileDrawer) return;
        mobileDrawer.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openMobileDrawer);
    if (closeDrawerBtn) closeDrawerBtn.addEventListener('click', closeMobileDrawer);
    if (mobileDrawerBackdrop) mobileDrawerBackdrop.addEventListener('click', closeMobileDrawer);

    // Otomatis hilangkan pesan notifikasi
    const toastAlert = document.getElementById('toastAlert');
    if (toastAlert) {
        setTimeout(() => {
            toastAlert.style.opacity = '0';
            toastAlert.style.transform = 'translateY(-10px)';
            toastAlert.style.transition = 'all 0.3s ease';
            setTimeout(() => toastAlert.remove(), 300);
        }, 4500);
    }

    // Buka modal konfirmasi hapus
    window.openDeleteModal = function (config) {
        const modal = document.getElementById('deleteConfirmModal');
        const form = document.getElementById('deleteConfirmForm');
        const idInput = document.getElementById('deleteConfirmId');
        const itemName = document.getElementById('deleteConfirmItemName');
        const customMessage = document.getElementById('deleteConfirmMessage');

        if (!modal || !form || !idInput) return;

        form.action = config.actionUrl;
        idInput.value = config.id;
        if (itemName) itemName.textContent = config.name || config.id;
        if (customMessage && config.message) {
            customMessage.textContent = config.message;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
        if (window.lucide) window.lucide.createIcons();
    };

    // Tutup modal konfirmasi hapus
    window.closeDeleteModal = function () {
        const modal = document.getElementById('deleteConfirmModal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    };

    const modalBackdrop = document.getElementById('deleteConfirmModalBackdrop');
    if (modalBackdrop) {
        modalBackdrop.addEventListener('click', window.closeDeleteModal);
    }

    // Tutup saat tombol escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            window.closeDeleteModal();
            closeMobileDrawer();
        }
    });
});
