var shown = 0,
  page;

function toggleMenu(s) {
  (s) ? $("body").removeClass('menu_open'): $("body").addClass('menu_open');
  return (s) ? 0 : 1;
}

function init() {
  Pace.on('done', function() {
    setTimeout(function() {
      $(".app").animate({
        "opacity": 1
      }, 300, function() {
        page = $(".app-container").data("page");
        $(`.header__links-item`).removeClass('s');
        $(`.header__links-item.${page}`).addClass('s');
      });
    }, 100);
  });
}

function load(name, skipPushState) {
  if (!skipPushState) {
    var state = {
      name: name,
      page: "Coding For Good"
    };
    window.history.pushState(state, "Coding For Good", name);
  }

  Pace.restart();

  $(".header__ham").removeClass('open');
  shown = toggleMenu(1);

  $(this).scrollTop(0);

  $(".app").animate({
    "opacity": 0
  }, 300, function() {
    $('.app').load(`${name} .app-container`, function() {
      $("title").html(`Coding For Good | ${$('.app-container').data('title')}`);
      document.title = `Coding For Good | ${$('.app-container').data('title')}`;
      document.body.scrollTop = document.documentElement.scrollTop = 0;

      init();

      Pace.stop;
    });
  });

}

$(function() {

  $('.no-fouc').fadeIn();

  init();

  $('body').on('click', '.header__ham', function() {
    shown = toggleMenu(shown);
  });

  $("body").on('click', 'a:not(.no_pace)', function(e) {
    e.preventDefault();
    $href = $(this).attr('href');
    load($href);
  });

  $(window).on("popstate", function() {
    load(location.href, true);
  });

});