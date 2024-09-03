///////////// Certificate
$('.wt-certificate-slider .wt-close-slider').on("click", function() {
    $('.wt-certificate-slider').toggleClass('wt-certificate-slider-visible');
  });
  
  $('.wt-container-certificate .certificate img').on("click", function() {
    $('.wt-certificate-slider').toggleClass('wt-certificate-slider-visible');
  });
  
  if(document.body.contains(document.querySelector('.wt-certificate-slider .wt-slider-wrap .wt-slider'))){
    $('.wt-certificate-slider .wt-slider-wrap .wt-slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      infinite: true,
      centerMode: true, 
      arrows: true,
      fade: true
    });
  }