jQuery(function ($) { // eslint-disable-line
  let isTouch = Modernizr.touch, // eslint-disable-line
    MOUSEOVER = isTouch ? 'touchstart' : 'mouseenter', // eslint-disable-line
    MOUSEOUT = isTouch ? 'touchend' : 'mouseleave', // eslint-disable-line
    MOUSECLICK = isTouch ? 'click' : 'click', // eslint-disable-line
    MOUSEPRESS = isTouch ? 'touchstart' : 'mousedown', // eslint-disable-line
    MOUSEUP = isTouch ? 'touchend' : 'mouseup', // eslint-disable-line
    DRAG = isTouch ? 'drag' : 'mousedown', // eslint-disable-line
    DOUBLECLICK = isTouch ? 'doubletap' : 'dblclick', // eslint-disable-line
    ie9 = $('html').hasClass('ie9'), // eslint-disable-line
    $window = $(window), // eslint-disable-line
    $document = $(document), // eslint-disable-line
    $body = $('body'), // eslint-disable-line
    winW = $window.width(), // eslint-disable-line
    winH = $window.height(), // eslint-disable-line
    BASE_URL = $('base').attr('href').replace(/\/$/, ''), // eslint-disable-line
    CURENT_URL = window.location.href.replace(/\/$/, ''), // eslint-disable-line
    DEBUG = true // eslint-disable-line

  $.ajaxSetup({cache: false})

  $.app = {

    options: {},

    init: function () {
      $.app.done()
    },

    ajax: function (options, callback) {
      // eslint-disable-next-line
      var url = (typeof app_options === 'undefined' || typeof app_options.ajax_url === 'undefined') ? '' : app_options.ajax_url

      var defaults = {
        type: 'POST',
        url: url,
        dataType: 'html',
        data: {},
        beforeSend: function () {
        },
        complete: function () {
        }
      }

      var settings = $.extend({}, defaults, options)

      $.ajax(settings)
      .done(function (data) {
        if (callback && typeof callback === 'function') {
          callback(data)
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {

      })
    },

    setFlexSlider: function ($target, options) {
      options = options || {}

      var defaults = {
        animation: 'slide',
        animationLoop: false,
        slideshow: false,
        controlNav: false
      }

      var settings = $.extend({}, defaults, options)

      $target.flexslider(settings)
    },

    setActions: function () {

    },

    scrollTo: function ($to, time) {
      $('html, body').animate({scrollTop: $to.offset().top}, time)
    },

    sendGA: function (url) {
      // eslint-disable-next-line
      ga('send', 'pageview', {
        'page': url
      })
    },

    done: function () {
      $.app.setActions()
    },

    afterLoad: function () {

    },

    resize: function (event) {
      winW = $window.width()
      winH = $window.height()
    }

  } // end of app object

  $window.on('debouncedresize', function (event) { $.app.resize(event) })
  // $window.resize(function(event) {$.app.resize(event);});

  $window.load(function () { $.app.afterLoad() })

  $.app.init()
})
