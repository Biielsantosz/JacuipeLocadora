window.addEventListener('scroll', function() {
    var footer = document.getElementById('footer');
    var scrollPosition = window.scrollY || window.pageYOffset || document.documentElement.scrollTop;

    // Altura total da página
    var pageHeight = document.body.scrollHeight;

    // Altura da janela visível
    var windowHeight = window.innerHeight;

    // Se a posição do scroll estiver perto do final da página
    if (scrollPosition >= pageHeight - windowHeight) {
        footer.style.display = 'block'; // Mostra o footer
    } else {
        footer.style.display = 'none'; // Esconde o footer
    }
});
