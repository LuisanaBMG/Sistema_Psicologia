document.addEventListener('DOMContentLoaded', function () {
    var navbarToggler = document.querySelector('.navbar-toggler');
    var navbar = document.querySelector('.navbar');
    var body = document.body;

    navbarToggler.addEventListener('click', function () {
      var isExpanded = navbar.classList.contains('collapsed');
      var navbarHeight = navbar.offsetHeight;

      if (isExpanded) {
        // Si el menú está cerrado, se mantiene y se habilita el scroll
        body.style.paddingTop = '0px'; 
        body.style.overflow = 'auto'; // Habilita el scroll
      } else {
        // Si el menú está abierto, añade un relleno superior al cuerpo igual a la altura de la barra de navegación y deshabilita el scroll

        body.style.paddingTop = navbarHeight + 'px'; 
        body.style.overflow = 'auto'; // Deshabilita el scroll
      }
    });
  });