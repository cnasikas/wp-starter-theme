jQuery(function($){

	var isTouch		    = Modernizr.touch,
		MOUSEOVER	    = isTouch ? 'touchstart'	: 'mouseenter',
		MOUSEOUT	    = isTouch ? 'touchend'		: 'mouseleave',
		MOUSECLICK      = isTouch ? 'click'			: 'click',
		MOUSEPRESS	    = isTouch ? 'touchstart'	: 'mousedown',
		MOUSEUP		    = isTouch ? 'touchend'		: 'mouseup',
		DRAG		    = isTouch ? 'drag'			: 'mousedown',
		DOUBLECLICK	    = isTouch ? 'doubletap'		: 'dblclick',
		ie9			    = $('html').hasClass('ie9'),
		$window			= $(window),
		$document		= $(document),
		$body			= $('body'),
		winW			= $window.width(),
		winH			= $window.height(),
		BASE_URL 		= $('base').attr('href').replace(/\/$/, "");
		CURENT_URL 		= window.location.href.replace(/\/$/, "");
		DEBUG 			= true;

	$.ajaxSetup({cache: false});

	$.app = {

		options: {},
	
		init: function(){

			$.app.done();
		},

		ajax: function(options, callback){

			var url = (typeof app_options === "undefined" || typeof app_options.ajax_url === "undefined") ? '' : app_options.ajax_url;

			var defaults = {
				type: "POST",
				url: url,
				dataType: "html",
				data: {},
				beforeSend: function(){
			  		
			   	},
			  	complete: function(){
			    	
			    }
	        };

	        var settings = $.extend({}, defaults, options);

			$.ajax(settings)
			.done(function(data) {

				if(callback && typeof callback === "function")
					callback(data);

			})
			.fail(function(jqXHR, textStatus, errorThrown) {
			    
			});

		},

		setFlexSlider: function($target, options){

			options = options || {};

			var defaults = {
				animation: "slide",
				animationLoop: false,
				slideshow: false,
				controlNav: false
	        };

	        var settings = $.extend({}, defaults, options);

			$target.flexslider(settings);

		},

		setActions: function(){

		},

		scrollTo: function($to, time){

			$('html, body').animate({scrollTop:$to.offset().top}, time);

		},

		sendGA: function(url){
			
			ga('send', 'pageview', {
				'page': url
			});
			
		},

		done: function(){
			$.app.setActions();
		},
		
		afterLoad: function(){

		},
		
		resize: function(event){

			winW = $window.width();
			winH = $window.height();
			
		}
		

	}; //end of app object

	$window.on('debouncedresize', function(event){ $.app.resize(event); });
	//$window.resize(function(event) {$.app.resize(event);});
	
	$window.load(function() {$.app.afterLoad();});
	
	$.app.init();

});