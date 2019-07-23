$('.carousel .carousel-item').each(function () {
  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));

  // Affiche 3 cartes par slide 
  for (var i = 0; i < 3; i++) {
    next = next.next();
    if (!next.length) {
      next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));
  }
});

// jQuery(document).ready(function ($) {
//   $('.carousel-indicators > li:first').addClass('active');
//   $('.carousel-inner > .carousel-item:first').addClass('active');
//   $('.carousel').carousel({
//     interval: 2000
//   });
// });