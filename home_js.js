$(window).scroll(function() {
    $('nav').toggleClass('scrolled', $(this).scrollTop() > 50);
  });
  
$(document).ready(function() {
    const boxes = document.querySelectorAll('.box');
    boxes.forEach((box) => {
      box.addEventListener('mouseenter', () => {
        box.style.transform = 'scale(1.1)';
        box.style.zIndex = '1'; 
      });
  
      box.addEventListener('mouseleave', () => {
        box.style.transform = 'scale(1)';
        box.style.zIndex = '0';
      });
    });
});

$(document).ready(function() {
    $("#sub-header-name").fadeIn(2000);
    $("#logo-img").fadeIn(2000);
    
});

$(window).scroll(function() {
    var containerOffset = $('.container').eq(1).offset().top;
    var windowHeight = $(window).height();
    var scrollPosition = $(this).scrollTop();
  
    if (scrollPosition >= containerOffset - windowHeight + 100) {
      $('#headline, .headline-subheader, .snake-icon, .third-image').fadeIn(1500);
    } else {
      $('#headline, .headline-subheader, .snake-icon, .third-image').fadeOut(200);
    }
  });

$(window).scroll(function() {
    var containerOffset = $('.new-container').offset().top;
    var windowHeight = $(window).height();
    var scrollPosition = $(this).scrollTop();
  
    if (scrollPosition >= containerOffset - windowHeight + 100) {
      $('.headline-2, .box').fadeIn(1000);
    } else {
      $('.headline-2, .box').fadeOut(500);
    }
  });


  $(window).scroll(function() {
    var containerOffset = $('.content-wrapper').offset().top;
    var windowHeight = $(window).height();
    var scrollPosition = $(this).scrollTop();
  
    if (scrollPosition >= containerOffset - windowHeight + 100) {
      $('.headline-3, #carousel-img').fadeIn(1000);
    } else {
      $('.headline-3, #carousel-img').fadeOut(500);
    }
  });


$(document).ready(function() {
    var imageUrls = [
      "img/1.png",
      "img/2.png",
      "img/3.png",
      "img/4.png",
      "img/5.png",
      "img/6.png"
    ];
  
    var imgElement = document.getElementById("carousel-img");
    var currentImageIndex = 0;
  
    function changeImage() {
      currentImageIndex++;
      if (currentImageIndex >= imageUrls.length) {
        currentImageIndex = 0;
      }
      imgElement.src = imageUrls[currentImageIndex];
    }
  
    setInterval(changeImage, 1500);
});