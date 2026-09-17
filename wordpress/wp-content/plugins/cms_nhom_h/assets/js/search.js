document.addEventListener('DOMContentLoaded', function () {
    const searchButton = document.querySelector('.cms-header-search-button, .cms-header-search-icon, #cms-search-toggle');
    const searchBox = document.querySelector('#cms-search-box');

    if (!searchButton || !searchBox) {
        return;
    }

    searchButton.addEventListener('click', function (e) {
        e.preventDefault();
        searchBox.classList.toggle('active');

        if (searchBox.classList.contains('active')) {
            const input = searchBox.querySelector('input');

            if (input) {
                input.focus();
            }
        }
    });
});