document.addEventListener('DOMContentLoaded', function() {
    // Obtener todos los enlaces de paginación
    var pgnLinks = document.querySelectorAll('.pgn__num');
    var pgnPrev = document.querySelector('.pgn__prev');
    var pgnNext = document.querySelector('.pgn__next');
    var divs = document.querySelectorAll('.column.events-list__item');
    var currentPage = 1;

    function showDiv(pageNum) {
        divs.forEach(function(div) {
            div.classList.add('hidden');
        });
        divs[pageNum - 1].classList.remove('hidden');
    }

    function updatePagination() {
        var currentLink = document.querySelector('.pgn__num.current');
        currentLink.classList.remove('current');
        var newLink = document.querySelector('.pgn__num:nth-child(' + currentPage + ')');
        newLink.classList.add('current');
    }

    pgnLinks.forEach(function(link, index) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var pageNum = index + 1;
            currentPage = pageNum;
            showDiv(currentPage);
            updatePagination();
        });
    });

    pgnPrev.addEventListener('click', function(event) {
        event.preventDefault();
        currentPage = Math.max(1, currentPage - 1);
        showDiv(currentPage);
        updatePagination();
    });

    pgnNext.addEventListener('click', function(event) {
        event.preventDefault();
        currentPage = Math.min(divs.length, currentPage + 1);
        showDiv(currentPage);
        updatePagination();
    });

    // Mostrar el div inicial al cargar la página
    showDiv(currentPage);
});