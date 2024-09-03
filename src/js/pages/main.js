///////////////// main-accordion
function toggleFunc(e, background){

    let li = document.querySelectorAll('.wt-flex-col2 li');
    let allBack = document.querySelectorAll('.wt-img-block-ac .wt-background');
    let back = document.querySelector(background);

    for (var i = 0; i < li.length; i++) {
      li[i].classList.remove('active');
      allBack[i].classList.remove('active');
    }
    e.classList.add('active');
    back.classList.add('active');
};

///////////////// main-slider
function detect_active(){
    var get_active = $("#dp-slider .dp_item:first-child").data("class");
    $("#dp-dots li").removeClass("active");
    $("#dp-dots li[data-class="+ get_active +"]").addClass("active");
  }
  $("#dp-next").click(function(){
    var total = $(".dp_item").length;
    $("#dp-slider .dp_item:first-child").hide().appendTo("#dp-slider").fadeIn();
    $.each($('.dp_item'), function (index, dp_item) {
      $(dp_item).attr('data-position', index + 1);
    });
    detect_active();

  });

  $("#dp-prev").click(function(){
    var total = $(".dp_item").length;
    $("#dp-slider .dp_item:last-child").hide().prependTo("#dp-slider").fadeIn();
    $.each($('.dp_item'), function (index, dp_item) {
      $(dp_item).attr('data-position', index + 1);
    });

    detect_active();
  });

  $("#dp-dots li").click(function(){
    $("#dp-dots li").removeClass("active");
    $(this).addClass("active");
    var get_slide = $(this).attr('data-class');
    $("#dp-slider .dp_item[data-class=" + get_slide + "]").hide().prependTo("#dp-slider").fadeIn();
    $.each($('.dp_item'), function (index, dp_item) {
      $(dp_item).attr('data-position', index + 1);
    });
  });


  $("body").on("click", "#dp-slider .dp_item:not(:first-child)", function(){
    var get_slide = $(this).attr('data-class');
    $("#dp-slider .dp_item[data-class=" + get_slide + "]").hide().prependTo("#dp-slider").fadeIn();
    $.each($('.dp_item'), function (index, dp_item) {
      $(dp_item).attr('data-position', index + 1);
    });

    detect_active();
  });

