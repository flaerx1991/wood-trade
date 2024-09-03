///////////////card slider
if(document.body.contains(document.querySelector('.wt-item-slider'))){
    $('.wt-item-slider').slick({
      lazyLoad: 'ondemand',
      arrows: true,
      fade: true,
    });
    
    $('.wt-slider-dots').slick({
      lazyLoad: 'ondemand',
      // infinite: true,
      swipeToSlide: false,
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.wt-item-slider',
      centerMode: false,
      focusOnSelect: true
    });
}

///////////////tabs
$('.wt-tab-button').on("click", function() {
    $(".wt-tab-button").removeClass("wt-selected");
    $(this).addClass('wt-selected');

    var attr;
    attr = $(this).attr('href')
    $('.tab-content').removeClass('wt-selected');
    $('.'+attr).addClass('wt-selected');
});

///////////// Buy form
function openCloseBuyForm() {
    let name = $('.wt-buy-form .input-name').val('');
    let tel = $('.wt-buy-form .input-tel').val('');
    let email = $('.wt-buy-form .input-email').val('');
  
    if($('.wt-buy-form .wt-message').css('display') == 'block') {
      $('.wt-buy-form .wt-message').slideToggle(400);
    }
  
    $('.wt-buy-form-section').fadeToggle();
}

let buyFormTelInput = document.getElementById('buyFormTelInput');
if(document.body.contains(buyFormTelInput)) {
  buyFormTelInput.addEventListener('input', function(e){
    var t = e.target.value.replace(/\D/g, "").match(/(\d{0,3})(\d{0,3})(\d{0,3})(\d{0,3})/);
    e.target.value = "+" + (t[2] ? t[1] + "-" + t[2] + (t[3] ? "-" + t[3] + (t[4] ? "-" + t[4] : "") : "") : t[1]);
  })
}

$('.wt-input-file').on('change', function(){
  let attachedFile = $(this).get(0).files[0];

  if(typeof attachedFile !== "undefined"){
    $(this).siblings('.wt-input-file-label').html(attachedFile.name);
  }
  else{
    $(this).siblings('.wt-input-file-label').html($(this).siblings('.wt-input-file-label').attr('data-text'));
  }
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
  let inputMessage = $('.wt-buy-form .input-message').val();
  let attachedFile = $('#input_client_file').get(0).files[0];

  let formData = new FormData(); 
  formData.append('name', name);
  formData.append('phone', tel);
  formData.append('email', email);
  formData.append('message', inputMessage);

  if(typeof attachedFile !== "undefined"){
    formData.append('file', attachedFile);
  }

  $.ajax({
    url: "/submit-form",
    type: "post",
    contentType: false,
    processData: false,
    cache: false,
    data: formData,
    success: function (response) {
      // console.log(response);
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