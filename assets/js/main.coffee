$ -> 

  isTouch       = Modernizr.touch
  MOUSEOVER     = if isTouch then 'touchstart'  else 'mouseenter'
  MOUSEOUT      = if isTouch then 'touchend'    else 'mouseleave'
  MOUSECLICK    = if isTouch then 'click'       else 'click'
  MOUSEPRESS    = if isTouch then 'touchstart'  else 'mousedown'
  MOUSEUP       = if isTouch then 'touchend'    else 'mouseup'
  DRAG          = if isTouch then 'drag'        else 'mousedown'
  DOUBLECLICK   = if isTouch then 'doubletap'   else 'dblclick'
  ie9           = $('html').hasClass('ie9')
  $window       = $(window)
  $document     = $(document)
  $body         = $('body')
  winW          = $window.width()
  winH          = $window.height()
  BASE_URL      = $('base').attr('href').replace(/\/$/, "");
  CURENT_URL    = window.location.href.replace(/\/$/, "");
  DEBUG         = true;

  $.ajaxSetup({cache: false});

  $.app = 

    options: {}

    init: () -> 
      $.app.done()

    setFlexSlider: ($target, options) ->

      options = options or {};

      defaults =
        animation: "slide",
        animationLoop: false,
        slideshow: false,
        controlNav: false

      settings = $.extend {}, defaults, options

      $target.flexslider settings;

    setActions: () ->

    scrollTo: ($to, time) ->
      $('html, body').animate({scrollTop:$to.offset().top}, time);

    sendGA: (url) ->

      ga('send', 'pageview', {
        'page': url
      });

    done: () -> $.app.setActions()

    afterLoad: () ->

    resize: (event) ->
      winW = $window.width()
      winH = $window.height()

  $window.on 'debouncedresize', (event) -> $.app.resize event
  //$window.resize $.app.resize

  $window.load $.app.afterLoad

  $.app.init()