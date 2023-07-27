const headerMenu = document.querySelector('.header-menu-burger');
const mobileMenu = document.querySelector('.mobile-menu');
const mobileMenuClose = document.querySelector('.mobile-menu__close');
const body = document.querySelector('body');


if(headerMenu) {
  headerMenu.addEventListener('click', (e) => {
    body.classList.add('fixed');
    mobileMenu.classList.add('active');
  });
}


if(mobileMenuClose) {
  mobileMenuClose.addEventListener('click', (e) => {
    body.classList.remove('fixed');
    mobileMenu.classList.remove('active');
  });  
}


if(document.getElementById("a-select")) {
  NiceSelect.bind(document.getElementById("a-select"), {searchable: true});
}