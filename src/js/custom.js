////////////// share button for mobile
function shareButton(e) {
  if(navigator.share) {
    navigator.share({
      title: 'wood-trade',
      text: 'wood-trade share',
      url: e.getAttribute('data-href')
    }).then(() => {
    }).catch(console.error);
  }
}

/////////////// mobile menu script
$('.wt-burger').click(function(){
    $('#top_menu').toggleClass('wt-mobile-menu');
});


$('.wt-lenguage').click(function(){
    if ( $('.wt-dropdown').css('display') == 'none' )
    {
        $('.wt-item').removeClass('opened');
        $('.wt-dropdown').css('display','block');
        $('.wt-dropdown').css('opacity','1');
        $('.wt-lenguage').addClass('opened');
    }
    else
        {$('.wt-dropdown').css('opacity','0');
        $('.wt-lenguage').removeClass('opened');
        setTimeout(function(){
            $('.wt-dropdown').css('display','none');
        }, 200);
    }
});

function changeLang(lang){
  window.location.href;
}

function menu (dropid) {
    $('.wt-dropdown').css('opacity','0');
    $('.wt-lenguage').removeClass('opened');
    setTimeout(function(){
        $('.wt-dropdown').css('display','none');
    }, 200)

    $(dropid).toggleClass('opened');
    $(".wt-item").not(dropid).removeClass("opened");
}


$(function($){
    $(document).mouseup(function (e){ // событие клика по веб-документу
        var div2 =  $(".wt-lenguage");
        var div = $(".wt-item"); // тут указываем ID элемента
        if ((!div.is(e.target)&& div.has(e.target).length === 0)&&(!div2.is(e.target)&& div2.has(e.target).length === 0)) { // и не по его дочерним элементам
            $(".wt-item").removeClass("opened");
            $('.wt-dropdown').css('opacity','0');
            $('.wt-lenguage').removeClass('opened');
            setTimeout(function(){
                $('.wt-dropdown').css('display','none');
            }, 200);
        }
    });
});


$('.wt-item-menu').click(function() {
    $(this).toggleClass('opened');
});
///////////////mobile filters
$('.filters-mobile-open').click("click", function() {
    $('.wt-mobile-filters').toggle();
    setTimeout(function(){
        $('.wt-mobile-filters').toggleClass('wt-opened-mobile-filters')
    }, 0);
    
});
$('#filters_mobile_close').on("click", function() {
    $('.wt-mobile-filters').toggleClass('wt-opened-mobile-filters')
    setTimeout(function(){
        $('.wt-mobile-filters').toggle();
    }, 200);
});

$('.wt-item-filters').click(function() {
    $(this).toggleClass('wt-ul-opened');
});

////////// footer contact form CUSTOM
document.querySelector('.wtFooterContactFormInput').addEventListener('input', function(e){
  var t = e.target.value.replace(/\D/g, "").match(/(\d{0,3})(\d{0,3})(\d{0,3})(\d{0,3})/);
  e.target.value = "+" + (t[2] ? t[1] + "-" + t[2] + (t[3] ? "-" + t[3] + (t[4] ? "-" + t[4] : "") : "") : t[1]);
});


function footerContactForm(){
  
  let phone = document.querySelector('.wtFooterContactFormInput').value;
  phone = String(phone);

  

  let formData = new FormData();
  formData.append('phoneNumber', phone);
  
  $.ajax({
    url: "/footer_contact_sand",
    type: "post",
    contentType: false,
    processData: false,
    cache: false,
    data: formData,
    success: function (response) {
      response = JSON.parse(response);
        if(response['status']){
          $('.wtFooterContactFormInput').css('background-color', '#d2e6d1').val('').attr("placeholder", response['true']);
          heap.identify(phone);
          heap.addUserProperties({
            'Account Name': '',
            'Account Email': '',
            'Account Phone': phone
          });
          heap.track('BuyByPhone');
        }
        else {
          $('.wtFooterContactFormInput').css('background-color', '#ff796f').val('').attr("placeholder", response['false']);
        }
      },
    error: function(jqXHR, textStatus, errorThrown) {
        
    }
  });
}