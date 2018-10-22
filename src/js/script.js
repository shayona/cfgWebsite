var shown = 0;

function toggleMenu(s) {
  if (s) {
    $("body").removeClass('menu_open');
    shown = 0;
  } else {
    $("body").addClass('menu_open');
    shown = 1;
  }
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

  $('.app').load(`${name} .app-container`, function() {
    $("title").html($('.app-container').data('title'));
    document.title = $('.app-container').data('title');
    document.body.scrollTop = document.documentElement.scrollTop = 0;

    if (name == "/contact") {
      $(".section").append("<!-- www.123formbuilder.com script begins here --><script type='text/javascript' defer src='//www.123formbuilder.com/embed/3457084.js' data-role='form' data-default-width='650px'></script><!-- www.123formbuilder.com script ends here -->");
    }

    $(".header__ham").removeClass('open');
    toggleMenu(1);

    Pace.stop;
  });
}

$(function() {

  $('.no-fouc').fadeIn();

  $('body').on('click', '.header__ham', function() {
    toggleMenu(shown);
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