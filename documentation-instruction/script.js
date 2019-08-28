(function($){
	$(document).ready(function(){
		// nav area
		var nav = $('#nav');
		var content = $('#content');
		
		nav.find('.main-nav-item').click(function(){
			var current = $(this).parent();

			if( current.hasClass('active') ) return;

			current.toggleClass('active');
			$(this).siblings('.sub-nav').hide().slideDown();
			current.siblings('.active').removeClass('active').children('.sub-nav').show().slideUp();
		});
		
		nav.find('.sub-nav-item').click(function(){
			nav.find('.sub-nav-item').removeClass('active');
			$(this).addClass('active');
			
			content.children($(this).attr('href')).fadeIn().siblings('.content-section').hide();
			return false;
		});
		
		$('img').each(function(){
			if( !$(this).parent().is('a') ){
				$(this).wrap('<a href="' + $(this).attr('src') + '" data-rel="fancybox" ></a>');
			}
		});
		$('a[href$=".jpg"],a[href$=".png"],a[href$=".gif"]').not('[data-rel="fancybox"]').attr("data-rel", "fancybox");
		$('[data-rel="fancybox"]').fancybox({	
		  helpers: {
		    overlay: {
		      locked: false
		    }
		  }			
		});
		
		
		// hash
		var url_hash = window.location.hash;
		nav.find('[href="' + url_hash + '"]').trigger('click')
			.parent().parent().addClass('active').siblings().removeClass('active');
	});
})(jQuery);