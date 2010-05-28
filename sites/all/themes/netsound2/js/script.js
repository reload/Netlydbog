jQuery(function(){
	
	pages = $('.top .pane-book');
	
	$('.top').after('<ul class="top-pager"></ul>');
	
	pages.each(function(i){
		if (i > 0){
			$(this).hide();
		}
		$('.top-pager').append('<li>'+$(this).children('h2.pane-title').text()+'</li>');
	});
	
	
	
	
});