////////// slider/tab service
if(document.body.contains(document.querySelector('.wt-information-service-container'))){
    $('.wt-information-service-container').slick({
      lazyLoad: 'ondemand',
    
      responsive: [
        {
          breakpoint: 9999,
          settings: "unslick"
        },
        {
          breakpoint: 767,
          settings: {
            arrows:false,
            infinite:true,
            slidesToShow: 1,
            slidesToScroll:1,
            fade:true,
            adaptiveHeight: true
          }
        }
      ]
    });
    $('.wt-services-tabs-buttons').slick({
      lazyLoad: 'ondemand',
    
      asNavFor:".wt-information-service-container",
    
        responsive: [
          {
              breakpoint: 9999,
              settings: "unslick"
          },
          {
            breakpoint: 767,
            settings: {
            infinite:true,
            arrows:true,
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    
    });  
}

$('.wt-service-tab ').on("click", function() {
    $(".wt-service-tab").removeClass("wt-selected-tab");
    $(this).addClass('wt-selected-tab');
    var atr;
    atr = $(this).attr('href')
    
    $('.wt-services-tab-content').removeClass('wt-selected-tab');
    $('.'+atr).addClass('wt-selected-tab');
    
});