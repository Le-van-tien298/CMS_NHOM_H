document.addEventListener('DOMContentLoaded', function () {

    const btnSearchToggle = document.getElementById('btn-toggle-search');
    const searchPopup = document.getElementById('header-search-popup');

    if (btnSearchToggle && searchPopup) {
        btnSearchToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            searchPopup.classList.toggle('is-open');
            if (searchPopup.classList.contains('is-open')) {
                const searchInput = searchPopup.querySelector('.search-large-input');
                if (searchInput) setTimeout(() => searchInput.focus(), 100);
            }
        });

        document.addEventListener('click', function (e) {
            if (!searchPopup.contains(e.target) && !btnSearchToggle.contains(e.target)) {
                searchPopup.classList.remove('is-open');
            }
        });
    }

    // 2. LOGIC MỚI: BẬT / TẮT MENU DRAWER CHO NÚT "... Menu"
    const btnMenuToggle = document.getElementById('btn-toggle-menu');
    const menuDrawer = document.getElementById('cms-menu-drawer');
    const drawerOverlay = document.getElementById('cms-drawer-overlay');
    const btnCloseDrawer = document.getElementById('btn-close-drawer');

    function openDrawer() {
        if (menuDrawer && drawerOverlay) {
            menuDrawer.classList.add('is-active');
            drawerOverlay.classList.add('is-active');
            document.body.style.overflow = 'hidden'; // Khóa cuộn trang khi menu mở
        }
    }

    function closeDrawer() {
        if (menuDrawer && drawerOverlay) {
            menuDrawer.classList.remove('is-active');
            drawerOverlay.classList.remove('is-active');
            document.body.style.overflow = ''; // Mở lại cuộn trang
        }
    }

    if (btnMenuToggle) {
        btnMenuToggle.addEventListener('click', function (e) {
            e.preventDefault();
            openDrawer();
        });
    }

    if (btnCloseDrawer) {
        btnCloseDrawer.addEventListener('click', closeDrawer);
    }

    if (drawerOverlay) {
        drawerOverlay.addEventListener('click', closeDrawer);
    }
});