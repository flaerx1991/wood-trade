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

function buyFormSubmit(){
  let message = $('.wt-buy-form .wt-message');

  if(message.css('display') == 'block') {
    $('.wt-buy-form .wt-message').slideToggle(70);
  }

  // let data = [];

  let name = $('.wt-buy-form .input-name').val();
  let tel = $('.wt-buy-form .input-tel').val();
  let email = $('.wt-buy-form .input-email').val();

  let formData = new FormData(); 
  formData.append('name', name);
  formData.append('phone', tel);
  formData.append('email', email);

  $.ajax({
    url: "/submit-form",
    type: "post",
    contentType: false,
    processData: false,
    cache: false,
    data: formData,
    success: function (response) {
      response = JSON.parse(response);

      if(response['status']){
        $('.wt-buy-form .wt-message').html(response['true']).css('background-color', '#d2e6d1').slideToggle(400);
        heap.identify(email);
        heap.addUserProperties({
          'Account Name': name,
          'Account Email': email,
          'Account Phone': tel
        });
        heap.track('BuyByEmail');
      }
      else {
        $('.wt-buy-form .wt-message').css('background-color', '#ff796f').slideToggle(400).html(response['false']);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        
    }
  });
}